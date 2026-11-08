<?php

/**
 * Tệp: 404.php
 * Mục đích: Trang lỗi 404, đặt mã HTTP 404
 * Dùng bởi: chi-tiet.php
 */

declare(strict_types=1);

http_response_code(404);

$cssRieng = 'css/06-trang-loi.css';
$tieuDe = '404 - Không tìm thấy trang';
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/header.php';
?>

<main class="noi-dung-chinh container my-5 text-center trang-loi-404">
    <h1 class="ma">404</h1>
    <h2>Không tìm thấy trang yêu cầu</h2>
    <p>
        Trang bạn đang tìm kiếm không tồn tại, đã bị xóa hoặc đường dẫn bị thay đổi.
    </p>
    <a href="<?= URL_GOC ?>index.php" class="nut nut-trang-chu">
        Trở về Trang chủ
    </a>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>