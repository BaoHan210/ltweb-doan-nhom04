<?php
/**
 * Tệp: sua-mon-an.php
 * Mục đích: Sửa thông tin món ăn (chỉ quản trị viên).
 * Bài thực hành 6 – Chức năng 3.
 */

declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/xac-thuc.php';
require_once __DIR__ . '/inc/kiem-tra-mon-an.php';

use App\Data\KhoMonAn;

// 1. Kiểm tra quyền bằng dữ liệu MySQL: chưa đăng nhập → dang-nhap.php, khách → 403
yeuCauQuyen('quan_tri');

// 2. Lấy món cần sửa: slug (ví dụ chef-special-test) hoặc ID số (đường dẫn cũ)
$maMon = lay_chuoi($_GET, 'id', 190);
$kho   = new KhoMonAn(db());

if ($maMon !== '' && ctype_digit($maMon)) {
    $monCu = $kho->layDongQuanTriTheoId((int) $maMon);
} elseif ($maMon !== '' && preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $maMon)) {
    $monCu = $kho->layDongQuanTriTheoSlug($maMon);
} else {
    $monCu = null;
}

if ($monCu === null) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$id        = (int) $monCu['id'];          // UPDATE luôn dùng khóa chính số
$dsDanhMuc = $kho->layDanhMucQuanTri();
$anhCu     = (string) ($monCu['hinh_anh'] ?? '');

if (empty($_SESSION['csrf_sua_mon_an'])) {
    $_SESSION['csrf_sua_mon_an'] = bin2hex(random_bytes(32));
}

$cacTruong = [
    'ten', 'slug', 'danh_muc_id', 'thoi_gian', 'khau_phan',
    'do_kho', 'ngan_sach', 'ton_kho', 'mo_ta', 'video',
];

// Điền sẵn dữ liệu cũ vào biểu mẫu
$duLieu = [];
foreach ($cacTruong as $cot) {
    $duLieu[$cot] = (string) ($monCu[$cot] ?? '');
}
$loi = [];

// 3. Xử lý gửi biểu mẫu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals((string) $_SESSION['csrf_sua_mon_an'], lay_chuoi($_POST, 'csrf_token', 128))) {
        http_response_code(403);
        require __DIR__ . '/403.php';
        exit;
    }

    foreach ($cacTruong as $cot) {
        $duLieu[$cot] = lay_chuoi($_POST, $cot, $cot === 'mo_ta' ? 10001 : 255);
    }

    $loi = kiemTraDuLieuMonAn($duLieu, $dsDanhMuc);

    $anhMoi     = $_FILES['hinh_anh'] ?? null;
    $kiemTraAnh = kiemTraAnhMonAn(is_array($anhMoi) ? $anhMoi : null, false);
    if ($kiemTraAnh['loi'] !== null) {
        $loi['hinh_anh'] = $kiemTraAnh['loi'];
    }

    $duLieu['hinh_anh'] = $anhCu;
    $duongDanMoi = null;

    // Chỉ lưu ảnh mới khi dữ liệu đã hợp lệ, tránh tạo tệp rác
    if ($loi === [] && $kiemTraAnh['duoi'] !== null) {
        $thuMuc = __DIR__ . '/uploads';
        if (!is_dir($thuMuc) && !mkdir($thuMuc, 0755, true) && !is_dir($thuMuc)) {
            $loi['hinh_anh'] = 'Không tạo được thư mục uploads.';
        } else {
            $tenAnh      = bin2hex(random_bytes(16)) . '.' . $kiemTraAnh['duoi'];
            $duongDanMoi = $thuMuc . '/' . $tenAnh;

            if (move_uploaded_file((string) $anhMoi['tmp_name'], $duongDanMoi)) {
                $duLieu['hinh_anh'] = 'uploads/' . $tenAnh;
            } else {
                $loi['hinh_anh'] = 'Không lưu được ảnh lên máy chủ.';
                $duongDanMoi     = null;
            }
        }
    }

    if ($loi === []) {
        try {
            $kho->capNhatMonAn($id, $duLieu);

            // Xóa ảnh cũ do hệ thống tải lên (chỉ trong uploads/, không xóa ảnh mẫu)
            if ($duongDanMoi !== null && str_starts_with($anhCu, 'uploads/')) {
                @unlink(__DIR__ . '/uploads/' . basename($anhCu));
            }

            unset($_SESSION['csrf_sua_mon_an']);
            gan_thong_bao('success', 'Đã cập nhật món ăn #' . $id . ' thành công.');
            header('Location: quan-tri.php', true, 303); // PRG
            exit;
        } catch (PDOException $e) {
            // Ghi CSDL thất bại: xóa ảnh vừa tải lên để không để lại tệp rác
            if ($duongDanMoi !== null) {
                @unlink($duongDanMoi);
            }
            if ((int) ($e->errorInfo[1] ?? 0) !== 1062) {
                throw $e;
            }
            $loi['slug'] = 'Slug này đã tồn tại, hãy nhập slug khác.';
        }
    } elseif ($duongDanMoi !== null) {
        @unlink($duongDanMoi);
    }
}

// 4. Hiển thị biểu mẫu
$tieuDe = 'Sửa món ăn - Cook with me';
$trang  = 'quan-tri';

$hienLoi = static function (string $cot) use ($loi): void {
    if (isset($loi[$cot])) {
        echo '<p class="thong-bao-loi-truong" role="alert">' . e($loi[$cot]) . '</p>';
    }
};

$truongChu = [
    'ten'  => ['Tên món ăn', 200],
    'slug' => ['Slug (ví dụ: ca-kho-to)', 190],
];

$truongSo = [
    'thoi_gian' => ['Thời gian (phút)', 1],
    'khau_phan' => ['Khẩu phần (người)', 1],
    'ngan_sach' => ['Ngân sách (đồng)', 1000],
    'ton_kho'   => ['Tồn kho (phần)', 0],
];

$doKhoHopLe = ['Dễ', 'Trung bình', 'Khó'];

require __DIR__ . '/inc/header.php';
?>
<main class="noi-dung-trang" style="max-width:920px;margin:24px auto;padding:20px">
    <p><a href="quan-tri.php">← Quay lại quản trị</a></p>
    <h1>Sửa món ăn #<?= $id ?></h1>
    <p>Chỉnh sửa thông tin món ăn. Để trống phần chọn ảnh nếu muốn giữ ảnh hiện tại.</p>

    <form action="sua-mon-an.php?id=<?= $id ?>" method="post" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_sua_mon_an']) ?>">

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:14px">

            <?php foreach ($truongChu as $cot => [$nhan, $doDaiToiDa]): ?>
                <div>
                    <label for="<?= e($cot) ?>"><?= e($nhan) ?> *</label><br>
                    <input type="text" id="<?= e($cot) ?>" name="<?= e($cot) ?>" required
                        maxlength="<?= $doDaiToiDa ?>"
                        <?= $cot === 'slug' ? 'pattern="[a-z0-9]+(-[a-z0-9]+)*"' : '' ?>
                        value="<?= e($duLieu[$cot]) ?>" style="width:100%;padding:10px">
                    <?php $hienLoi($cot); ?>
                </div>
            <?php endforeach; ?>

            <div>
                <label for="danh_muc_id">Danh mục *</label><br>
                <select id="danh_muc_id" name="danh_muc_id" required style="width:100%;padding:10px">
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($dsDanhMuc as $dm): ?>
                        <option value="<?= (int) $dm['id'] ?>"
                            <?= (string) $dm['id'] === $duLieu['danh_muc_id'] ? 'selected' : '' ?>>
                            <?= e($dm['ten']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php $hienLoi('danh_muc_id'); ?>
            </div>

            <?php foreach ($truongSo as $cot => [$nhan, $min]): ?>
                <div>
                    <label for="<?= e($cot) ?>"><?= e($nhan) ?> *</label><br>
                    <input type="number" id="<?= e($cot) ?>" name="<?= e($cot) ?>" required
                        min="<?= $min ?>" step="1" value="<?= e($duLieu[$cot]) ?>"
                        style="width:100%;padding:10px">
                    <?php $hienLoi($cot); ?>
                </div>
            <?php endforeach; ?>

            <div>
                <label for="do_kho">Độ khó *</label><br>
                <select id="do_kho" name="do_kho" required style="width:100%;padding:10px">
                    <?php foreach ($doKhoHopLe as $muc): ?>
                        <option value="<?= e($muc) ?>" <?= $muc === $duLieu['do_kho'] ? 'selected' : '' ?>>
                            <?= e($muc) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php $hienLoi('do_kho'); ?>
            </div>

            <div>
                <label for="hinh_anh">Ảnh mới (không bắt buộc; JPG, PNG hoặc WebP, tối đa 3 MB)</label><br>
                <?php if ($anhCu !== ''): ?>
                    <p><img src="<?= e($anhCu) ?>" alt="Ảnh hiện tại của món ăn"
                            style="max-width:180px;max-height:130px;object-fit:cover"></p>
                <?php endif; ?>
                <input type="file" id="hinh_anh" name="hinh_anh"
                    accept="image/jpeg,image/png,image/webp">
                <?php $hienLoi('hinh_anh'); ?>
            </div>

        </div>

        <p>
            <label for="mo_ta">Mô tả</label><br>
            <textarea id="mo_ta" name="mo_ta" rows="5" style="width:100%;padding:10px"><?= e($duLieu['mo_ta']) ?></textarea>
            <?php $hienLoi('mo_ta'); ?>
        </p>

        <p>
            <label for="video">Đường dẫn video (nếu có)</label><br>
            <input type="text" id="video" name="video" maxlength="255"
                value="<?= e($duLieu['video']) ?>" style="width:100%;padding:10px">
            <?php $hienLoi('video'); ?>
        </p>

        <button class="nut nut-chinh" type="submit">Lưu thay đổi</button>
        <a class="nut" href="quan-tri.php">Hủy</a>
    </form>
</main>
<?php require __DIR__ . '/inc/footer.php'; ?>