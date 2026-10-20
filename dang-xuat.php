<?php
require_once __DIR__ . '/inc/config.php';
unset($_SESSION['user']);
session_destroy();
session_start();
gan_thong_bao('success', 'Bạn đã đăng xuất khỏi hệ thống thành công.');
chuyen_huong('dang-nhap.php');