<?php
require_once __DIR__ . '/inc/config.php';
http_response_code(404);
$tieuDe = '404 - Không tìm thấy trang';
require_once __DIR__ . '/inc/header.php';
?>
<main class="khung-chinh">
    <h1>404 - Trang không tồn tại</h1>
    <p>Món ăn hoặc trang bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.</p>
    <a href="index.php" class="nut-chinh">Quay về trang chủ</a>
</main>
<?php require_once __DIR__ . '/inc/footer.php'; ?>