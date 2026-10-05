<?php
// inc/bao-ve.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config.php';

if (!isset($_SESSION['user'])) {
    gan_thong_bao('error', 'Bạn cần đăng nhập để truy cập trang quản trị!');
    chuyen_huong(URL_GOC . 'dang-nhap.php'); // Dùng hằng số URL_GOC
    exit();
}
?>