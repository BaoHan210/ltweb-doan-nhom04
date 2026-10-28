<?php
/** Bài thực hành 6 – Chức năng 3: Sửa món ăn. */
declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/inc/kiem-tra-mon-an.php';

use App\Data\KhoMonAn;
use App\Data\KhoNguoiDung;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra quyền quản trị trực tiếp từ MySQL.
require_once __DIR__ . '/inc/xac-thuc.php';
$nguoiDung = yeuCauQuyen('quan_tri');

// Trang quản trị truyền slug (ví dụ chef-special-test), không phải ID số.
// Vẫn hỗ trợ ID số để không phá các đường dẫn cũ.
$maMon = trim((string) ($_GET['id'] ?? ''));
$kho = new KhoMonAn(db());
if ($maMon !== '' && ctype_digit($maMon) && (int) $maMon > 0) {
    $monCu = $kho->layDongQuanTriTheoId((int) $maMon);
} elseif ($maMon !== '' && strlen($maMon) <= 190
    && preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $maMon)) {
    $monCu = $kho->layDongQuanTriTheoSlug($maMon);
} else {
    $monCu = null;
}
if ($monCu === null) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}
$id = (int) $monCu['id']; // UPDATE luôn sử dụng khóa chính số trong MySQL.
$dsDanhMuc = $kho->layDanhMucQuanTri();

if (empty($_SESSION['csrf_sua_mon_an'])) {
    $_SESSION['csrf_sua_mon_an'] = bin2hex(random_bytes(32));
}

$cacTruong = ['ten', 'slug', 'danh_muc_id', 'thoi_gian', 'khau_phan',
              'do_kho', 'ngan_sach', 'mo_ta', 'video'];
$duLieu = [];
foreach ($cacTruong as $cot) {
    $duLieu[$cot] = (string) ($monCu[$cot] ?? '');
}
$loi = [];
$anhCu = (string) ($monCu['hinh_anh'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = (string) ($_POST['csrf_token'] ?? '');
    if (!hash_equals((string) $_SESSION['csrf_sua_mon_an'], $token)) {
        http_response_code(403);
        exit('Yêu cầu không hợp lệ. Hãy tải lại trang và thử lại.');
    }

    foreach ($cacTruong as $cot) {
        $duLieu[$cot] = trim((string) ($_POST[$cot] ?? ''));
    }
    $loi = kiemTraDuLieuMonAn($duLieu, $dsDanhMuc);
    $anh = $_FILES['hinh_anh'] ?? null;
    $kiemTraAnh = kiemTraAnhMonAn(is_array($anh) ? $anh : null, false);
    if ($kiemTraAnh['loi'] !== null) {
        $loi['hinh_anh'] = $kiemTraAnh['loi'];
    }

    if ($loi === []) {
        $duLieu['hinh_anh'] = $anhCu;
        $duongDanMoi = null;
        $coAnhMoi = $kiemTraAnh['duoi'] !== null;

        if ($coAnhMoi) {
            $thuMuc = __DIR__ . '/uploads';
            if (!is_dir($thuMuc) && !mkdir($thuMuc, 0755, true) && !is_dir($thuMuc)) {
                $loi['hinh_anh'] = 'Không tạo được thư mục uploads.';
            } else {
                $tenAnh = bin2hex(random_bytes(16)) . '.' . $kiemTraAnh['duoi'];
                $duongDanMoi = $thuMuc . '/' . $tenAnh;
                if (!move_uploaded_file((string) $anh['tmp_name'], $duongDanMoi)) {
                    $loi['hinh_anh'] = 'Không lưu được ảnh lên máy chủ.';
                    $duongDanMoi = null;
                } else {
                    $duLieu['hinh_anh'] = 'uploads/' . $tenAnh;
                }
            }
        }

        if ($loi === []) {
            try {
                $kho->capNhatMonAn($id, $duLieu);
                unset($_SESSION['csrf_sua_mon_an']);
                gan_thong_bao('success', 'Đã cập nhật món ăn #' . $id . ' thành công.');
                header('Location: quan-tri.php', true, 303);
                exit;
            } catch (PDOException $e) {
                if ($duongDanMoi !== null) {
                    @unlink($duongDanMoi);
                }
                if ((int) ($e->errorInfo[1] ?? 0) === 1062) {
                    $loi['slug'] = 'Slug này đã tồn tại, hãy nhập slug khác.';
                } else {
                    throw $e;
                }
            }
        }
    }
}

$tieuDe = 'Sửa món ăn - Cook with me';
$trang = 'quan-tri';
require __DIR__ . '/inc/header.php';
?>
<main class="noi-dung-trang" style="max-width:920px;margin:24px auto;padding:20px">
    <p><a href="quan-tri.php">← Quay lại quản trị</a></p>
    <h1>Sửa món ăn #<?= (int) $id ?></h1>
    <p>Chỉnh sửa thông tin món ăn. Để trống phần chọn ảnh nếu muốn giữ ảnh hiện tại.</p>
    <form action="sua-mon-an.php?id=<?= (int) $id ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_sua_mon_an']) ?>">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:14px">
            <?php foreach (['ten' => 'Tên món ăn', 'slug' => 'Slug'] as $cot => $nhan): ?>
                <div>
                    <label for="<?= e($cot) ?>"><?= e($nhan) ?> *</label><br>
                    <input id="<?= e($cot) ?>" name="<?= e($cot) ?>" required
                        maxlength="<?= $cot === 'ten' ? 200 : 190 ?>"
                        <?= $cot === 'slug' ? 'pattern="[a-z0-9]+(-[a-z0-9]+)*"' : '' ?>
                        value="<?= e($duLieu[$cot]) ?>" style="width:100%;padding:10px">
                    <?php if (isset($loi[$cot])): ?><p style="color:#b42318"><?= e($loi[$cot]) ?></p><?php endif; ?>
                </div>
            <?php endforeach; ?>
            <div>
                <label for="danh_muc_id">Danh mục *</label><br>
                <select id="danh_muc_id" name="danh_muc_id" required style="width:100%;padding:10px">
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($dsDanhMuc as $dm): ?>
                        <option value="<?= (int) $dm['id'] ?>" <?= (string) $dm['id'] === $duLieu['danh_muc_id'] ? 'selected' : '' ?>><?= e($dm['ten']) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($loi['danh_muc_id'])): ?><p style="color:#b42318"><?= e($loi['danh_muc_id']) ?></p><?php endif; ?>
            </div>
            <?php foreach (['thoi_gian' => 'Thời gian (phút)', 'khau_phan' => 'Khẩu phần (người)', 'ngan_sach' => 'Ngân sách (đồng)'] as $cot => $nhan): ?>
                <div>
                    <label for="<?= e($cot) ?>"><?= e($nhan) ?> *</label><br>
                    <input type="number" id="<?= e($cot) ?>" name="<?= e($cot) ?>" required
                        min="<?= $cot === 'ngan_sach' ? 0 : 1 ?>" value="<?= e($duLieu[$cot]) ?>"
                        style="width:100%;padding:10px">
                    <?php if (isset($loi[$cot])): ?><p style="color:#b42318"><?= e($loi[$cot]) ?></p><?php endif; ?>
                </div>
            <?php endforeach; ?>
            <div>
                <label for="do_kho">Độ khó *</label><br>
                <select id="do_kho" name="do_kho" required style="width:100%;padding:10px">
                    <?php foreach (['Dễ', 'Trung bình', 'Khó'] as $muc): ?>
                        <option value="<?= e($muc) ?>" <?= $muc === $duLieu['do_kho'] ? 'selected' : '' ?>><?= e($muc) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($loi['do_kho'])): ?><p style="color:#b42318"><?= e($loi['do_kho']) ?></p><?php endif; ?>
            </div>
            <div>
                <label for="hinh_anh">Ảnh mới (không bắt buộc; JPG/PNG/WebP, tối đa 3 MB)</label><br>
                <?php if ($anhCu !== ''): ?>
                    <p><img src="<?= e($anhCu) ?>" alt="Ảnh món ăn hiện tại" style="max-width:180px;max-height:130px;object-fit:cover"></p>
                <?php endif; ?>
                <input type="file" id="hinh_anh" name="hinh_anh" accept="image/jpeg,image/png,image/webp">
                <?php if (isset($loi['hinh_anh'])): ?><p style="color:#b42318"><?= e($loi['hinh_anh']) ?></p><?php endif; ?>
            </div>
        </div>
        <p><label for="mo_ta">Mô tả</label><br>
            <textarea id="mo_ta" name="mo_ta" rows="5" style="width:100%;padding:10px"><?= e($duLieu['mo_ta']) ?></textarea>
            <?php if (isset($loi['mo_ta'])): ?><span style="color:#b42318"><?= e($loi['mo_ta']) ?></span><?php endif; ?>
        </p>
        <p><label for="video">Đường dẫn video (nếu có)</label><br>
            <input type="text" id="video" name="video" maxlength="255" value="<?= e($duLieu['video']) ?>" style="width:100%;padding:10px">
            <?php if (isset($loi['video'])): ?><span style="color:#b42318"><?= e($loi['video']) ?></span><?php endif; ?>
        </p>
        <button class="nut nut-chinh" type="submit">Lưu thay đổi</button>
        <a class="nut" href="quan-tri.php">Hủy</a>
    </form>
</main>
<?php require __DIR__ . '/inc/footer.php'; ?>
