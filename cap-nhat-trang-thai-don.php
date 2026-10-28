<?php
/** Chỉ quản trị viên được đổi trạng thái đơn hàng qua POST. */
declare(strict_types=1);
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/xac-thuc.php';
require_once __DIR__ . '/src/Data/KhoDonHang.php';

use App\Data\KhoDonHang;

yeuCauQuyen('quan_tri');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    exit('Chỉ chấp nhận POST.');
}
$csrf = $_POST['csrf_token'] ?? '';
if (!is_string($csrf) || !isset($_SESSION['csrf_trang_thai_don'])
    || !hash_equals((string) $_SESSION['csrf_trang_thai_don'], $csrf)) {
    http_response_code(403);
    exit('CSRF không hợp lệ. Vui lòng tải lại trang.');
}
$id = filter_var($_POST['don_hang_id'] ?? null, FILTER_VALIDATE_INT);
$trangThaiMoi = $_POST['trang_thai_moi'] ?? '';
if ($id === false || $id === null || $id < 1 || !is_string($trangThaiMoi)) {
    gan_thong_bao('error', 'Mã đơn hoặc trạng thái không hợp lệ.');
} else {
    try {
        (new KhoDonHang(db()))->capNhatTrangThai($id, $trangThaiMoi);
        gan_thong_bao('success', 'Đã cập nhật đơn hàng #' . $id . ' thành công.');
    } catch (DomainException $e) {
        gan_thong_bao('error', $e->getMessage());
    } catch (Throwable $e) {
        error_log('Loi cap nhat don hang: ' . $e->getMessage());
        gan_thong_bao('error', 'Không thể cập nhật trạng thái đơn hàng.');
    }
}
header('Location: quan-tri.php#quan-ly-don-hang', true, 303);
exit;
