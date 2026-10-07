<?php
// inc/config.php - Khởi tạo cấu hình và xử lý lỗi hệ thống

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/ham.php';

const MOI_TRUONG = 'dev'; // Giữ 'dev' khi nộp bài

error_reporting(E_ALL);
ini_set('display_errors', MOI_TRUONG === 'dev' ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../logs/php-error.log');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('URL_GOC')) {
    define('URL_GOC', '/ltweb-doan-nhom04-main/');
}

set_exception_handler(function (Throwable $e) {
    error_log((string) $e);
    http_response_code(500);

    if (MOI_TRUONG === 'dev') {
        echo '<pre>' . htmlspecialchars((string) $e) . '</pre>';
    } else {
        require __DIR__ . '/../500.php';
    }
});