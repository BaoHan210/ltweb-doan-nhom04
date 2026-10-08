<?php
require __DIR__ . '/inc/config.php';

use App\Data\KhoMonAn;

// 1. Kiểm tra nếu chưa đăng nhập -> Chuyển hướng ngay sang trang đăng nhập
if (!isset($_SESSION['user'])) {
    chuyen_huong('dang-nhap.php');
    exit;
}

// 2. Lấy ID từ URL
$id = trim($_GET['id'] ?? '');

$kho = new KhoMonAn(__DIR__ . '/data/mon-an.json');
$danhSach = $kho->tatCa();

// Tìm món ăn tương ứng với ID trong file JSON
$monAn = null;
if (!empty($id)) {
    foreach ($danhSach as $item) {
        $itemId = is_object($item) ? ($item->id ?? '') : ($item['id'] ?? '');
        if ((string)$itemId === (string)$id) {
            $monAn = $item;
            break;
        }
    }
}

// 3. XỬ LÝ CA 7: Nếu thiếu ID hoặc ID không tồn tại -> Trả về trang LỖI 404
if (empty($id) || !$monAn) {
    http_response_code(404); // Đặt mã trạng thái HTTP 404 cho tab Network

    if (file_exists(__DIR__ . '/404.php')) {
        require __DIR__ . '/404.php';
    } else {
        $tieuDe = '404 - Không tìm thấy món ăn';
        $trang  = 'chi-tiet';
        require __DIR__ . '/inc/header.php';
        ?>
        <main class="trang-loi-404" style="padding: 60px 20px; text-align: center;">
            <h1 style="font-size: 48px; color: #e74c3c; margin-bottom: 10px;">404</h1>
            <h2>Không tìm thấy món ăn</h2>
            <p style="color: #666; margin-bottom: 20px;">Món ăn bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.</p>
            <a href="danh-sach.php" class="nut" style="display: inline-block; padding: 10px 20px; background: #2E6230; color: #fff; text-decoration: none; border-radius: 8px;">Quay lại danh sách</a>
        </main>
        <?php
        require __DIR__ . '/inc/footer.php';
    }
    exit;
}

// 4. Nếu tìm thấy món ăn hợp lệ -> Hiển thị chi tiết món ăn
$tenMon = is_object($monAn) ? ($monAn->ten ?? 'Chi tiết món ăn') : ($monAn['ten'] ?? 'Chi tiết món ăn');
$tieuDe = $tenMon . ' - Cook with Me'; 
$trang  = 'chi-tiet'; 

require __DIR__ . '/inc/header.php';
?>

<main class="trang-chi-tiet-container" style="padding: 20px;">
    <h1><?= e($tenMon) ?></h1>
    
    <p>Xin chào <strong><?= e($_SESSION['user']['ho_ten'] ?? $_SESSION['user']['hoTen'] ?? $_SESSION['user']['email']) ?></strong>!</p>
    <p>Nội dung công thức nấu ăn sẽ hiển thị tại đây...</p>
</main>

<?php
require __DIR__ . '/inc/footer.php';
?>
