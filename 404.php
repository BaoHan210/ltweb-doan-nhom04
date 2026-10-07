<?php
// Thiết lập mã phản hồi HTTP 404
http_response_code(404);

$tieuDe = '404 - Không tìm thấy trang';
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/header.php';
?>

<main class="noi-dung-chinh container my-5 text-center" style="padding: 50px 20px; text-align: center;">
    <h1 style="font-size: 80px; color: #e74c3c; margin-bottom: 10px;">404</h1>
    <h2>Không tìm thấy trang yêu cầu</h2>
    <p style="margin: 20px 0; color: #666;">
        Trang bạn đang tìm kiếm không tồn tại, đã bị xóa hoặc đường dẫn bị thay đổi.
    </p>
    <a href="<?= URL_GOC ?>index.php" class="nut" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">
        Trở về Trang chủ
    </a>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>