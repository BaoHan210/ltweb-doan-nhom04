<?php
/** Cook with me – kiểm tra phiên và phân quyền tập trung. */
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

use App\Data\KhoNguoiDung;

/** Lấy ID người dùng từ phiên; thông tin quyền KHÔNG lấy từ session. */
function idNguoiDungHienTai(): int
{
    // Chỉ sử dụng định danh đăng nhập đã xác thực.
    $id = $_SESSION['uid'] ?? 0;
    return filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: 0;
}

/** Trả về thông tin tài khoản lấy mới từ MySQL, hoặc null. */
function nguoiDungHienTai(): ?array
{
    $id = idNguoiDungHienTai();
    if ($id < 1) {
        return null;
    }
    $nguoiDung = (new KhoNguoiDung(db()))->timTheoId($id);
    if ($nguoiDung === null) {
        // Tài khoản đã bị xóa/không còn hợp lệ.
        unset($_SESSION['uid'], $_SESSION['user'], $_SESSION['nguoi_dung']);
        return null;
    }
    return $nguoiDung;
}

/** Khách chưa đăng nhập: chuyển về đăng nhập; tài khoản không đủ quyền: HTTP 403. */
function yeuCauDangNhap(): array
{
    $nguoiDung = nguoiDungHienTai();
    if ($nguoiDung === null) {
        gan_thong_bao('error', 'Vui lòng đăng nhập để tiếp tục.');
        chuyen_huong('dang-nhap.php');
        exit;
    }
    return $nguoiDung;
}

function yeuCauQuyen(string $vaiTro): array
{
    $nguoiDung = yeuCauDangNhap();
    if (($nguoiDung['vai_tro'] ?? '') !== $vaiTro) {
        http_response_code(403);
        header('Content-Type: text/plain; charset=UTF-8');
        exit('403 - Bạn không có quyền truy cập chức năng này.');
    }
    return $nguoiDung;
}
