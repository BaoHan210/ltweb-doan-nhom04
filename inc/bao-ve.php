<?php
// inc/bao-ve.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config.php';

// Kiểm tra xem đã đăng nhập chưa
if (empty($_SESSION['user']) && empty($_SESSION['nguoi_dung'])) {
    // Nếu chưa đăng nhập mà vào trang quản trị, chuyển hướng ra trang đăng nhập
    gan_thong_bao('error', 'Bạn cần đăng nhập để truy cập trang quản trị!');
    chuyen_huong('dang-nhap.php');
}
?>