<?php
/** Cook with me - Bài thực hành 6, Chức năng 3: Xóa món ăn an toàn. */
declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/vendor/autoload.php';

use App\Data\KhoMonAn;
use App\Data\KhoNguoiDung;

// Không cho xóa bằng GET hoặc liên kết trực tiếp.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    exit('Chức năng xóa chỉ chấp nhận yêu cầu POST.');
}

// Kiểm tra quyền quản trị trực tiếp từ MySQL.
require_once __DIR__ . '/inc/xac-thuc.php';
$nguoiDung = yeuCauQuyen('quan_tri');

// Trong giao diện Cook with me, MonAn->id là slug, không phải ID số nguyên.
$slug = lay_chuoi($_POST, 'id', 190);
if ($slug === '' || strlen($slug) > 190 || !preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug)) {
    http_response_code(400);
    exit('Mã món ăn không hợp lệ.');
}

$kho = new KhoMonAn(db());
$mon = $kho->timTheoId($slug);
if ($mon === null) {
    gan_thong_bao('error', 'Món ăn không tồn tại hoặc đã bị xóa.');
    header('Location: quan-tri.php', true, 303);
    exit;
}

// Khi JavaScript tắt, vẫn có trang xác nhận riêng bằng PHP.
if (lay_chuoi($_POST, 'xac_nhan', 1) !== '1') {
    $tieuDe = 'Xác nhận xóa món ăn - Cook with me';
    $trang = 'quan-tri';
    $cssRieng = 'css/12-form-quan-ly-mon-an.css';

    require __DIR__ . '/inc/header.php';
    ?>
    <main class="noi-dung-trang xac-nhan-xoa-mon-an">
        <h1>Xác nhận xóa món ăn</h1>
        <p>Bạn có chắc chắn muốn xóa món <strong><?= e($mon->ten) ?></strong>?</p>
        <p>Thao tác này không thể hoàn tác. Nếu món ăn đã có dữ liệu liên quan được bảo vệ bằng khóa ngoại, hệ thống sẽ từ chối xóa.</p>

        <form method="post" action="xoa-mon-an.php">
            <?= csrfField() ?>
            <input type="hidden" name="id" value="<?= e($slug) ?>">
            <input type="hidden" name="xac_nhan" value="1">

            <button class="nut nut-chinh" type="submit">Xác nhận xóa</button>
            <a class="nut" href="quan-tri.php">Hủy, quay lại quản trị</a>
        </form>
    </main>
    <?php
    require __DIR__ . '/inc/footer.php';
    exit;
}

if (!csrfHopLe()) {
    http_response_code(403);
    exit('Yêu cầu không hợp lệ.');
}

try {
    $daXoa = $kho->xoaMonAnTheoSlug($slug);
    if ($daXoa) {
        gan_thong_bao('success', 'Đã xóa món ăn "' . $mon->ten . '" thành công.');
    } else {
        gan_thong_bao('error', 'Không xóa được: món ăn có thể đã bị xóa trước đó.');
    }
} catch (PDOException $e) {
    if ((int) ($e->errorInfo[1] ?? 0) === 1451) {
        gan_thong_bao('error', 'Không thể xóa vì món ăn đang được dữ liệu khác tham chiếu (khóa ngoại).');
    } else {
        error_log('Lỗi xóa món ăn: ' . $e->getMessage());
        gan_thong_bao('error', 'Không thể xóa món ăn do lỗi cơ sở dữ liệu.');
    }
}

// PRG: F5 không gửi lại thao tác xóa.
header('Location: quan-tri.php', true, 303);
exit;
