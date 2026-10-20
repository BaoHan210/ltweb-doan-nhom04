<?php
// Thiết lập mã phản hồi HTTP 500 nếu trang được gọi trực tiếp
if (http_response_code() !== 500) {
    http_response_code(500);
}

$tieuDe = '500 - Lỗi hệ thống';
// Nếu chưa require config/header thì nhúng vào
if (!defined('MOI_TRUONG')) {
    require_once __DIR__ . '/inc/config.php';
}
require_once __DIR__ . '/inc/header.php';
?>

<main class="noi-dung-chinh container my-5 text-center" style="padding: 50px 20px; text-align: center;">
    <h1 style="font-size: 80px; color: #d9534f; margin-bottom: 10px;">500</h1>
    <h2>Xin lỗi, đã xảy ra lỗi máy chủ nội bộ!</h2>
    <p style="margin: 20px 0; color: #666;">
        Hệ thống đang gặp sự cố kỹ thuật tạm thời. Đội ngũ quản trị đã được ghi nhận nhật ký lỗi để khắc phục.
    </p>
    <a href="<?= URL_GOC ?>index.php" class="nut" style="display: inline-block; padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 4px;">
        Quay lại Trang chủ
    </a>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>