<?php
/**
 * Tệp: chot-di-cho.php
 * Mục đích: Chốt danh sách đi chợ hiện tại thành một lần đi chợ (chức năng 5).
 * Chỉ nhận POST, có CSRF, phải đăng nhập. Dùng PRG.
 */
declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/xac-thuc.php';
require_once __DIR__ . '/src/Data/KhoLanDiCho.php';

use App\Data\KhoLanDiCho;

$nguoiDung = yeuCauDangNhap();

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    exit('Chỉ chấp nhận POST.');
}

try {
    $idLan = (new KhoLanDiCho(db()))->chot((int) $nguoiDung['id']);
    gan_thong_bao('success', 'Đã chốt danh sách đi chợ (lần #' . $idLan . ').');
    header('Location: di-cho-cua-toi.php?tab=lich-su&id=' . $idLan, true, 303);
    exit;
} catch (DomainException $e) {
    gan_thong_bao('error', $e->getMessage());
} catch (Throwable $e) {
    error_log('Loi chot di cho: ' . $e->getMessage());
    gan_thong_bao('error', 'Không thể chốt danh sách đi chợ. Vui lòng thử lại.');
}

header('Location: goi-y-mon-an.php', true, 303);
exit;
