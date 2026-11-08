<?php
/**
 * Tệp: danh-sach-di-cho.php
 * Mục đích: Chuyển hướng đến trang quản lý đi chợ hợp nhất.
 */
declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/xac-thuc.php';

yeuCauDangNhap();

header('Location: di-cho-cua-toi.php?tab=hien-tai', true, 303);
exit;