<?php
require_once __DIR__ . '/inc/config.php';

$tieuDe   = 'Món ăn yêu thích';
$trang    = 'yeu-thich';
$customJS = 'js/yeu-thich.js'; // Nhúng file JS xử lý render từ localStorage

require_once __DIR__ . '/inc/header.php';
?>

<main class="trang-yeu-thich container my-4">
    <h1 class="tieu-de-trang mb-4">Món ăn yêu thích của bạn</h1>
    
    <!-- Khu vực để file yeu-thich.js đổ danh sách món ăn từ localStorage vào -->
    <div id="danh-sach-yeu-thich" class="luoi-mon-an">
        <!-- JS sẽ render HTML các thẻ món ăn vào đây -->
    </div>

    <!-- Thông báo khi chưa có món yêu thích -->
    <div id="yeu-thich-trong" class="thong-bao-trong d-none">
        <p>Bạn chưa thêm món ăn nào vào danh sách yêu thích!</p>
        <a href="danh-sach.php" class="btn btn-primary">Khám phá món ăn ngay</a>
    </div>
</main>

<?php
require_once __DIR__ . '/inc/footer.php';
?>
