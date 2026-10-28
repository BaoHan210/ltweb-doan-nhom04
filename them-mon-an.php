<?php
/** Bài thực hành 6 – Chức năng 3: Thêm món ăn. */
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

$kho = new KhoMonAn(db());
$dsDanhMuc = $kho->layDanhMucQuanTri();
$idDanhMucHopLe = array_map('intval', array_column($dsDanhMuc, 'id'));

if (empty($_SESSION['csrf_them_mon_an'])) {
    $_SESSION['csrf_them_mon_an'] = bin2hex(random_bytes(32));
}

$duLieu = [
    'ten' => '', 'slug' => '', 'danh_muc_id' => '', 'thoi_gian' => '30',
    'khau_phan' => '2', 'do_kho' => 'Dễ', 'ngan_sach' => '50000',
    'mo_ta' => '', 'video' => ''
];
$loi = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = (string) ($_POST['csrf_token'] ?? '');
    if (!hash_equals((string) $_SESSION['csrf_them_mon_an'], $token)) {
        http_response_code(403);
        exit('Yêu cầu không hợp lệ. Hãy tải lại trang và thử lại.');
    }
    foreach (array_keys($duLieu) as $cot) {
        $duLieu[$cot] = trim((string) ($_POST[$cot] ?? ''));
    }

    // Kiểm tra dùng chung với trang Sửa món ăn.
    $loi = kiemTraDuLieuMonAn($duLieu, $dsDanhMuc);
    $anh = $_FILES['hinh_anh'] ?? null;
    $kiemTraAnh = kiemTraAnhMonAn(is_array($anh) ? $anh : null, true);
    if ($kiemTraAnh['loi'] !== null) {
        $loi['hinh_anh'] = $kiemTraAnh['loi'];
    }
    $duoiAnh = $kiemTraAnh['duoi'];

    if ($loi === []) {
        $thuMuc = __DIR__ . '/uploads';
        if (!is_dir($thuMuc) && !mkdir($thuMuc, 0755, true) && !is_dir($thuMuc)) {
            $loi['hinh_anh'] = 'Không tạo được thư mục uploads.';
        } else {
            $tenAnh = bin2hex(random_bytes(16)) . '.' . $duoiAnh;
            $duongDan = $thuMuc . '/' . $tenAnh;
            if (!move_uploaded_file((string) $anh['tmp_name'], $duongDan)) {
                $loi['hinh_anh'] = 'Không lưu được ảnh lên máy chủ.';
            } else {
                try {
                    // Giá trị hinh_anh tương thích với giao diện: src="uploads/xxx.jpg".
                    $duLieu['hinh_anh'] = 'uploads/' . $tenAnh;
                    $idMoi = $kho->themMonAn($duLieu);
                    unset($_SESSION['csrf_them_mon_an']);
                    gan_thong_bao('success', 'Đã thêm món ăn #' . $idMoi . ' thành công.');
                    header('Location: quan-tri.php', true, 303);
                    exit;
                } catch (PDOException $e) {
                    @unlink($duongDan);
                    if ((int) ($e->errorInfo[1] ?? 0) === 1062) {
                        $loi['slug'] = 'Slug này đã tồn tại, hãy nhập slug khác.';
                    } else {
                        throw $e;
                    }
                }
            }
        }
    }
}

$tieuDe = 'Thêm món ăn - Cook with me';
$trang = 'quan-tri';
require __DIR__ . '/inc/header.php';
?>
<main class="noi-dung-trang" style="max-width:920px;margin:24px auto;padding:20px">
    <p><a href="quan-tri.php">← Quay lại quản trị</a></p>
    <h1>Thêm món ăn</h1>
    <p>Điền thông tin món ăn và chọn ảnh đại diện. Các mục có dấu * là bắt buộc.</p>

    <form action="them-mon-an.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_them_mon_an']) ?>">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:14px">
            <div>
                <label for="ten">Tên món ăn *</label><br>
                <input id="ten" name="ten" required maxlength="200" value="<?= e($duLieu['ten']) ?>" style="width:100%;padding:10px">
                <?php if (isset($loi['ten'])): ?><p style="color:#b42318"><?= e($loi['ten']) ?></p><?php endif; ?>
            </div>
            <div>
                <label for="slug">Slug (ví dụ: ca-kho-to) *</label><br>
                <input id="slug" name="slug" required maxlength="190" pattern="[a-z0-9]+(-[a-z0-9]+)*" value="<?= e($duLieu['slug']) ?>" style="width:100%;padding:10px">
                <?php if (isset($loi['slug'])): ?><p style="color:#b42318"><?= e($loi['slug']) ?></p><?php endif; ?>
            </div>
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
            <div>
                <label for="thoi_gian">Thời gian (phút) *</label><br>
                <input type="number" id="thoi_gian" name="thoi_gian" min="1" required value="<?= e($duLieu['thoi_gian']) ?>" style="width:100%;padding:10px">
                <?php if (isset($loi['thoi_gian'])): ?><p style="color:#b42318"><?= e($loi['thoi_gian']) ?></p><?php endif; ?>
            </div>
            <div>
                <label for="khau_phan">Khẩu phần (người) *</label><br>
                <input type="number" id="khau_phan" name="khau_phan" min="1" required value="<?= e($duLieu['khau_phan']) ?>" style="width:100%;padding:10px">
                <?php if (isset($loi['khau_phan'])): ?><p style="color:#b42318"><?= e($loi['khau_phan']) ?></p><?php endif; ?>
            </div>
            <div>
                <label for="do_kho">Độ khó *</label><br>
                <select id="do_kho" name="do_kho" style="width:100%;padding:10px">
                    <?php foreach (['Dễ', 'Trung bình', 'Khó'] as $muc): ?>
                        <option value="<?= e($muc) ?>" <?= $muc === $duLieu['do_kho'] ? 'selected' : '' ?>><?= e($muc) ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($loi['do_kho'])): ?><p style="color:#b42318"><?= e($loi['do_kho']) ?></p><?php endif; ?>
            </div>
            <div>
                <label for="ngan_sach">Ngân sách dự kiến (đồng) *</label><br>
                <input type="number" id="ngan_sach" name="ngan_sach" min="0" required value="<?= e($duLieu['ngan_sach']) ?>" style="width:100%;padding:10px">
                <?php if (isset($loi['ngan_sach'])): ?><p style="color:#b42318"><?= e($loi['ngan_sach']) ?></p><?php endif; ?>
            </div>
            <div>
                <label for="hinh_anh">Ảnh đại diện * (JPG/PNG/WebP, tối đa 3 MB)</label><br>
                <input type="file" id="hinh_anh" name="hinh_anh" accept="image/jpeg,image/png,image/webp" required>
                <?php if (isset($loi['hinh_anh'])): ?><p style="color:#b42318"><?= e($loi['hinh_anh']) ?></p><?php endif; ?>
            </div>
        </div>
        <p><label for="mo_ta">Mô tả</label><br>
        <textarea id="mo_ta" name="mo_ta" rows="5" style="width:100%;padding:10px"><?= e($duLieu['mo_ta']) ?></textarea>
        <?php if (isset($loi['mo_ta'])): ?><span style="color:#b42318"><?= e($loi['mo_ta']) ?></span><?php endif; ?></p>
        <p><label for="video">Đường dẫn video (nếu có)</label><br>
        <input type="text" id="video" name="video" maxlength="255" value="<?= e($duLieu['video']) ?>" style="width:100%;padding:10px"></p>
        <button class="nut nut-chinh" type="submit">Thêm món ăn</button>
        <a class="nut" href="quan-tri.php">Hủy</a>
    </form>
</main>
<?php require __DIR__ . '/inc/footer.php'; ?>
