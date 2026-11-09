<?php
/**
 * Tệp: api/mon-an-yeu-thich.php
 * Website: Cook with me - Nhóm 04
 *
 * Chức năng:
 * - GET: Lấy danh sách món ăn yêu thích và mã CSRF.
 * - POST: Thêm, cập nhật, xóa món hoặc xóa toàn bộ danh sách yêu thích.
 * - Yêu cầu người dùng đăng nhập.
 * - Dữ liệu được quản lý bởi YeuThichService trong PHP session.
 */

declare(strict_types=1);

require_once __DIR__ . '/../inc/config.php';

dangKyHandlerApi();

require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/xac-thuc.php';

use App\Data\KhoMonAn;
use App\Services\YeuThichService;

/**
 * Trả phản hồi JSON và kết thúc yêu cầu.
 */
function traJson(int $maHttp, array $duLieu): never
{
    http_response_code($maHttp);

    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');

    echo json_encode(
        $duLieu,
        JSON_UNESCAPED_UNICODE
        | JSON_UNESCAPED_SLASHES
        | JSON_INVALID_UTF8_SUBSTITUTE
    );

    exit;
}

/**
 * Chuẩn hóa dữ liệu giỏ hàng theo hợp đồng JSON của JavaScript.
 */
function duLieuGioHang(
    YeuThichService $yeuThich,
    KhoMonAn $kho
): array {
    $gioHang = $yeuThich->layGioHang($kho);
    $cacMon = [];

    foreach ($gioHang['mon'] as $dong) {
        $mon = $dong['monAn'];

        $cacMon[] = [
            'id' => (string) $mon->id,
            'ten' => (string) $mon->ten,
            'so_luong' => (int) $dong['soLuong'],
            'don_gia' => (int) $dong['donGia'],
            'thanh_tien' => (int) $dong['thanhTien'],
        ];
    }

    return [
        'mon' => $cacMon,
        'tong_so_phan' => $yeuThich->tongSoPhan(),
        'tong_tien' => (int) $gioHang['tongTien'],
    ];
}

// Chỉ hỗ trợ GET và POST.
$phuongThuc = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if (!in_array($phuongThuc, ['GET', 'POST'], true)) {
    header('Allow: GET, POST');

    traJson(405, [
        'success' => false,
        'loi' => 'Phương thức không được hỗ trợ.',
    ]);
}

// API yêu cầu đăng nhập.
$nguoiDung = nguoiDungHienTai();

if ($nguoiDung === null) {
    traJson(401, [
        'success' => false,
        'loi' => 'Vui lòng đăng nhập để sử dụng giỏ hàng.',
    ]);
}

// Khởi tạo các đối tượng nghiệp vụ.
$kho = new KhoMonAn(db());
$yeuThich = new YeuThichService();

// GET: lấy giỏ hàng và CSRF token.
if ($phuongThuc === 'GET') {
    traJson(200, [
        'success' => true,
        'csrf_token' => csrfToken(),
        'data' => duLieuGioHang($yeuThich, $kho),
    ]);
}

// POST: chỉ tiếp nhận JSON.
$contentType = strtolower(
    trim(explode(';', (string) ($_SERVER['CONTENT_TYPE'] ?? ''))[0])
);

if ($contentType !== 'application/json') {
    traJson(400, [
        'success' => false,
        'loi' => 'Content-Type phải là application/json.',
    ]);
}

// Đọc và giải mã JSON.
$noiDung = file_get_contents('php://input');
$duLieu = json_decode((string) $noiDung, true);

if (
    json_last_error() !== JSON_ERROR_NONE
    || !is_array($duLieu)
    || array_is_list($duLieu)
) {
    traJson(400, [
        'success' => false,
        'loi' => 'Dữ liệu JSON không hợp lệ.',
    ]);
}

// Lấy hành động.
$hanhDong = $duLieu['hanh_dong'] ?? '';

if (!is_string($hanhDong)) {
    traJson(422, [
        'success' => false,
        'loi' => 'Hành động không hợp lệ.',
    ]);
}

$cacHanhDong = ['them', 'cap_nhat', 'xoa', 'xoa_het'];

if (!in_array($hanhDong, $cacHanhDong, true)) {
    traJson(422, [
        'success' => false,
        'loi' => 'Hành động không được hỗ trợ.',
    ]);
}

// Các thao tác với một món cần có mã món hợp lệ.
$idMon = '';

if ($hanhDong !== 'xoa_het') {
    $idMon = $duLieu['id_mon'] ?? '';

    if (
        !is_string($idMon)
        || !preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $idMon)
    ) {
        traJson(422, [
            'success' => false,
            'loi' => 'Mã món ăn không hợp lệ.',
        ]);
    }
}

// Xử lý nghiệp vụ.
switch ($hanhDong) {
    case 'them':
        // Không cho thêm món không tồn tại.
        if ($kho->timTheoId($idMon) === null) {
            traJson(404, [
                'success' => false,
                'loi' => 'Không tìm thấy món ăn.',
            ]);
        }

        $yeuThich->them($idMon);
        break;

    case 'cap_nhat':
        $soLuong = filter_var(
            $duLieu['so_luong'] ?? null,
            FILTER_VALIDATE_INT
        );

        if (
            $soLuong === false
            || $soLuong < YeuThichService::SO_LUONG_TOI_THIEU
            || $soLuong > YeuThichService::SO_LUONG_TOI_DA
        ) {
            traJson(422, [
                'success' => false,
                'loi' => 'Số lượng phải là số nguyên từ 1 đến 10.',
            ]);
        }

        if (!$yeuThich->capNhatSoLuong($idMon, $soLuong)) {
            traJson(404, [
                'success' => false,
                'loi' => 'Món ăn không có trong danh sách yêu thích.',
            ]);
        }
        break;

    case 'xoa':
        $yeuThich->xoa($idMon);
        break;

    case 'xoa_het':
        $yeuThich->xoaHet();
        break;
}

// Trả kết quả sau khi xử lý thành công.
traJson(200, [
    'success' => true,
    'csrf_token' => csrfToken(),
    'data' => duLieuGioHang($yeuThich, $kho),
]);
