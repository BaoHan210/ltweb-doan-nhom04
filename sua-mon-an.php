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

$id        = (int) $monCu['id'];
$dsDanhMuc = $kho->layDanhMucQuanTri();
$anhCu     = (string) ($monCu['hinh_anh'] ?? '');

// Lấy danh sách nguyên liệu hiện tại của món ăn
$danhSachNguyenLieu = $kho->layNguyenLieuQuanTri($id);

if ($danhSachNguyenLieu === []) {
    $danhSachNguyenLieu = [
        ['ten' => '', 'soLuong' => ''],
    ];
}

$cacTruong = [
    'ten', 'slug', 'danh_muc_id', 'thoi_gian', 'khau_phan',
    'do_kho', 'ngan_sach', 'mo_ta', 'video',
];

// Điền sẵn dữ liệu cũ vào biểu mẫu
$duLieu = [];
foreach ($cacTruong as $cot) {
    $duLieu[$cot] = (string) ($monCu[$cot] ?? '');
}
$loi = [];

// 3. Xử lý gửi biểu mẫu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    foreach ($cacTruong as $cot) {
        $duLieu[$cot] = lay_chuoi($_POST, $cot, $cot === 'mo_ta' ? 10001 : 255);
    }

    $loi = kiemTraDuLieuMonAn($duLieu, $dsDanhMuc);

    // Tiếp nhận danh sách nguyên liệu từ biểu mẫu
    $tenNguyenLieu = $_POST['nguyen_lieu_ten'] ?? [];
    $soLuongNguyenLieu = $_POST['nguyen_lieu_so_luong'] ?? [];

    if (!is_array($tenNguyenLieu) || !is_array($soLuongNguyenLieu)) {
        $loi['nguyen_lieu'] = 'Dữ liệu nguyên liệu không hợp lệ.';
    } elseif (
        count($tenNguyenLieu) > 50 ||
        count($soLuongNguyenLieu) > 50 ||
        array_keys($tenNguyenLieu) !== array_keys($soLuongNguyenLieu)
    ) {
        $loi['nguyen_lieu'] = 'Danh sách nguyên liệu không hợp lệ hoặc vượt quá 50 dòng.';
    } else {
        $danhSachNguyenLieu = [];

        foreach ($tenNguyenLieu as $i => $ten) {
            $soLuong = $soLuongNguyenLieu[$i] ?? null;

            if (!is_string($ten) || !is_string($soLuong)) {
                $loi['nguyen_lieu'] = 'Dữ liệu tên hoặc số lượng nguyên liệu không hợp lệ.';
                break;
            }

            $ten = trim($ten);
            $soLuong = trim($soLuong);

            if ($ten === '' && $soLuong === '') {
                continue;
            }

            if ($ten === '' || $soLuong === '') {
                $loi['nguyen_lieu'] = 'Vui lòng nhập đầy đủ tên và số lượng cho từng nguyên liệu.';
                break;
            }

            if (mb_strlen($ten, 'UTF-8') > 150 || mb_strlen($soLuong, 'UTF-8') > 100) {
                $loi['nguyen_lieu'] = 'Tên nguyên liệu tối đa 150 ký tự và số lượng tối đa 100 ký tự.';
                break;
            }

            $danhSachNguyenLieu[] = [
                'ten' => $ten,
                'soLuong' => $soLuong,
            ];
        }

        if ($danhSachNguyenLieu === []) {
            $danhSachNguyenLieu = [
                ['ten' => '', 'soLuong' => ''],
            ];
        }
    }

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
            $kho->capNhatMonAn($id, $duLieu, $danhSachNguyenLieu);

            // Xóa ảnh cũ do hệ thống tải lên (chỉ trong uploads/, không xóa ảnh mẫu)
            if ($duongDanMoi !== null && str_starts_with($anhCu, 'uploads/')) {
                @unlink(__DIR__ . '/uploads/' . basename($anhCu));
            }

            gan_thong_bao('success', 'Đã cập nhật món ăn #' . $id . ' thành công.');
            header('Location: quan-tri.php', true, 303); // PRG
            exit;
        } catch (Throwable $e) {
            // Có lỗi khi cập nhật: xóa ảnh mới để không để lại tệp rác.
            if ($duongDanMoi !== null) {
                @unlink($duongDanMoi);
            }

            // Chỉ chuyển lỗi trùng khóa PDO thành thông báo tại trường slug.
            if (!$e instanceof PDOException || (int) ($e->errorInfo[1] ?? 0) !== 1062) {
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
];

$doKhoHopLe = ['Dễ', 'Trung bình', 'Khó'];

$cssRieng = 'css/12-form-quan-ly-mon-an.css';
$customJS = 'js/trang-them-mon-an.js';

require __DIR__ . '/inc/header.php';
?>
<main class="noi-dung-trang form-mon-an-trang">
    <p><a href="quan-tri.php">← Quay lại quản trị</a></p>
    <h1>Sửa món ăn #<?= $id ?></h1>
    <p>Chỉnh sửa thông tin món ăn. Để trống phần chọn ảnh nếu muốn giữ ảnh hiện tại.</p>

    <form action="sua-mon-an.php?id=<?= $id ?>" method="post" enctype="multipart/form-data" novalidate>
        <?= csrfField() ?>

        <div class="form-mon-an-luoi">

            <?php foreach ($truongChu as $cot => [$nhan, $doDaiToiDa]): ?>
                <div>
                    <label for="<?= e($cot) ?>"><?= e($nhan) ?> *</label><br>
                    <input type="text" id="<?= e($cot) ?>" name="<?= e($cot) ?>" required
                        maxlength="<?= $doDaiToiDa ?>"
                        <?= $cot === 'slug' ? 'pattern="[a-z0-9]+(-[a-z0-9]+)*"' : '' ?>
                        value="<?= e($duLieu[$cot]) ?>"
                        class="o-nhap-mon-an">
                    <?php $hienLoi($cot); ?>
                </div>
            <?php endforeach; ?>

            <div>
                <label for="danh_muc_id">Danh mục *</label><br>
                <select id="danh_muc_id" name="danh_muc_id" required class="o-nhap-mon-an">
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
                        class="o-nhap-mon-an">
                    <?php $hienLoi($cot); ?>
                </div>
            <?php endforeach; ?>

            <div>
                <label for="do_kho">Độ khó *</label><br>
                <select id="do_kho" name="do_kho" required class="o-nhap-mon-an">
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
                    <p>
                        <img
                            src="<?= e($anhCu) ?>"
                            alt="Ảnh hiện tại của món ăn"
                            class="anh-hien-tai-mon-an"
                        >
                    </p>
                <?php endif; ?>
                <input type="file" id="hinh_anh" name="hinh_anh"
                    accept="image/jpeg,image/png,image/webp">
                <?php $hienLoi('hinh_anh'); ?>
            </div>

        </div>

        <section class="khu-vuc-nguyen-lieu">
            <h2>Nguyên liệu</h2>
            <p>Nhập tên và số lượng riêng cho từng nguyên liệu.</p>

            <?php $hienLoi('nguyen_lieu'); ?>

            <div id="danh-sach-nguyen-lieu" class="danh-sach-nguyen-lieu">
                <?php foreach ($danhSachNguyenLieu as $nguyenLieu): ?>
                    <div class="dong-nguyen-lieu">
                        <div>
                            <label>Tên nguyên liệu</label>
                            <input
                                type="text"
                                name="nguyen_lieu_ten[]"
                                maxlength="150"
                                class="o-nhap-mon-an"
                                placeholder="Ví dụ: Thịt bò"
                                value="<?= e($nguyenLieu['ten']) ?>"
                            >
                        </div>

                        <div>
                            <label>Số lượng</label>
                            <input
                                type="text"
                                name="nguyen_lieu_so_luong[]"
                                maxlength="100"
                                class="o-nhap-mon-an"
                                placeholder="Ví dụ: 200 g"
                                value="<?= e($nguyenLieu['soLuong']) ?>"
                            >
                        </div>

                        <button
                            type="button"
                            class="nut nut-xoa-nguyen-lieu"
                            data-hanh-dong="xoa-nguyen-lieu"
                        >
                            Xóa
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>

            <button
                type="button"
                id="nut-them-nguyen-lieu"
                class="nut nut-them-nguyen-lieu"
            >
                + Thêm nguyên liệu
            </button>
        </section>

        <p>
            <label for="mo_ta">Mô tả</label><br>
            <textarea id="mo_ta" name="mo_ta" rows="5" class="o-nhap-mon-an"><?= e($duLieu['mo_ta']) ?></textarea>
            <?php $hienLoi('mo_ta'); ?>
        </p>

        <p>
            <label for="video">Đường dẫn video (nếu có)</label><br>
            <input type="text" id="video" name="video" maxlength="255"
                value="<?= e($duLieu['video']) ?>"
                class="o-nhap-mon-an">
            <?php $hienLoi('video'); ?>
        </p>

        <button class="nut nut-chinh" type="submit">Lưu thay đổi</button>
        <a class="nut" href="quan-tri.php">Hủy</a>
    </form>
</main>
<?php require __DIR__ . '/inc/footer.php'; ?>
