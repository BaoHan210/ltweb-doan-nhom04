<?php
/**
 * Tệp: cap-nhat-trang-thai-di-cho.php
 * Mục đích: Quản trị viên đổi trạng thái một lần đi chợ (moi → da_di_cho / da_huy).
 * Chỉ nhận POST, có CSRF, chỉ quản trị viên.
 */
declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/xac-thuc.php';
require_once __DIR__ . '/src/Data/KhoLanDiCho.php';

use App\Data\KhoLanDiCho;

yeuCauQuyen('quan_tri');

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    exit('Chỉ chấp nhận POST.');
}

$id = filter_var($_POST['lan_di_cho_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$trangThaiMoi = $_POST['trang_thai_moi'] ?? '';

if ($id === false || !is_string($trangThaiMoi)) {
    gan_thong_bao('error', 'Mã lần đi chợ hoặc trạng thái không hợp lệ.');
} else {
    try {
        (new KhoLanDiCho(db()))->capNhatTrangThai($id, $trangThaiMoi);
        gan_thong_bao('success', 'Đã cập nhật lần đi chợ #' . $id . '.');
    } catch (DomainException $e) {
        gan_thong_bao('error', $e->getMessage());
    } catch (Throwable $e) {
        error_log('Loi cap nhat di cho: ' . $e->getMessage());
        gan_thong_bao('error', 'Không thể cập nhật trạng thái. Vui lòng thử lại.');
    }
}

header('Location: quan-tri.php#quan-ly-di-cho', true, 303);
exit;
