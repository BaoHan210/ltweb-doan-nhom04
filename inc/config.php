<?php
// Nạp Autoload của Composer và các hàm tiện ích
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/ham.php';

const MOI_TRUONG = 'dev'; // Hoặc 'prod' khi lên hosting

if (MOI_TRUONG === 'dev') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

// Khởi tạo session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// inc/config.php
$goc = '/ltweb-doan-nhom04-main/'; // Khai báo trực tiếp ở phạm vi toàn cục

// Hoặc khuyên dùng HẰNG SỐ để tránh lỗi Scope:
define('URL_GOC', '/ltweb-doan-nhom04-main/');