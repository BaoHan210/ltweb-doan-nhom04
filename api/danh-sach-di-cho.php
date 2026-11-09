<?php
/**
 * Tệp: api/danh-sach-di-cho.php
 * Website: Cook with me - Nhóm 04
 *
 * Chức năng:
 * - GET: Lấy danh sách đi chợ của người dùng.
 * - POST: Thêm, cập nhật, xóa món hoặc xóa toàn bộ danh sách.
 * - Dữ liệu được lưu trong MySQL theo tài khoản đăng nhập.
 */

declare(strict_types=1);

use App\Data\KhoMonAn;
use App\Services\DanhSachDiChoService;

require_once __DIR__ . '/../inc/config.php';

dangKyHandlerApi();

require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/xac-thuc.php';
require_once __DIR__ . '/../src/Data/KhoMonAn.php';
require_once __DIR__ . '/../src/Services/DanhSachDiChoService.php';

/**
 * Trả dữ liệu JSON và kết thúc yêu cầu.
 */
function traJsonDanhSachDiCho(int $maHttp, array $duLieu): void
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
 * Chuẩn hóa danh sách đi chợ thành dữ liệu JSON.
 */
function duLieuDanhSachDiCho(
    DanhSachDiChoService $service,
    KhoMonAn $kho
): array {
    $danhSach = $service->layDanhSach($kho);

    $cacMon = [];
    $tongSoSuat = 0;
    $tongNganSach = 0;

    foreach ($danhSach as $dong) {
        $mon = $dong['monAn'];
        $soLuong = (int) $dong['soLuong'];
        $nganSach = (int) $mon->nganSach;

        $thanhTien = $nganSach * $soLuong;

        $cacMon[] = [
            'id' => (string) $mon->id,
            'ten' => (string) $mon->ten,
            'so_luong' => $soLuong,
            'ngan_sach' => $nganSach,
            'thanh_tien' => $thanhTien,
            'hinh_anh' => (string) $mon->hinhAnh,
        ];

        $tongSoSuat += $soLuong;
        $tongNganSach += $thanhTien;
    }

    return [
        'mon' => $cacMon,
        'tong_so_mon' => count($cacMon),
        'tong_so_suat' => $tongSoSuat,
        'tong_ngan_sach' => $tongNganSach,
    ];
}

// Chỉ hỗ trợ GET và POST.
$phuongThuc = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if (!in_array($phuongThuc, ['GET', 'POST'], true)) {
    header('Allow: GET, POST');

    traJsonDanhSachDiCho(405, [
        'success' => false,
        'loi' => 'Phương thức không được hỗ trợ.',
    ]);
}

// Kiểm tra đăng nhập.
$nguoiDung = nguoiDungHienTai();

if ($nguoiDung === null) {
    traJsonDanhSachDiCho(401, [
        'success' => false,
        'loi' => 'Vui lòng đăng nhập để sử dụng danh sách đi chợ.',
    ]);
}

// Khởi tạo các đối tượng nghiệp vụ.
$kho = new KhoMonAn(db());

$service = new DanhSachDiChoService(
    db(),
    (int) $nguoiDung['id']
);

// GET: Lấy danh sách đi chợ.
if ($phuongThuc === 'GET') {
    traJsonDanhSachDiCho(200, [
        'success' => true,
        'csrf_token' => csrfToken(),
        'data' => duLieuDanhSachDiCho($service, $kho),
    ]);
}

// POST: Chỉ tiếp nhận JSON.
$contentType = strtolower(
    trim(explode(';', (string) ($_SERVER['CONTENT_TYPE'] ?? ''))[0])
);

if ($contentType !== 'application/json') {
    traJsonDanhSachDiCho(400, [
        'success' => false,
        'loi' => 'Content-Type phải là application/json.',
    ]);
}

// Đọc và kiểm tra dữ liệu JSON.
$noiDung = file_get_contents('php://input');
$duLieuGoc = json_decode((string) $noiDung);

if (
    json_last_error() !== JSON_ERROR_NONE
    || !($duLieuGoc instanceof stdClass)
) {
    traJsonDanhSachDiCho(400, [
        'success' => false,
        'loi' => 'Dữ liệu JSON không hợp lệ.',
    ]);
}

$duLieu = json_decode((string) $noiDung, true);

// Kiểm tra hành động.
$hanhDong = $duLieu['hanh_dong'] ?? '';

$cacHanhDong = [
    'them',
    'cap_nhat',
    'xoa',
    'xoa_het',
];

if (
    !is_string($hanhDong)
    || !in_array($hanhDong, $cacHanhDong, true)
) {
    traJsonDanhSachDiCho(422, [
        'success' => false,
        'loi' => 'Hành động không hợp lệ.',
    ]);
}

try {
    switch ($hanhDong) {
        case 'them':
            $idMon = $duLieu['id_mon'] ?? '';

            if (!is_string($idMon)) {
                throw new DomainException('Mã món ăn không hợp lệ.');
            }

            $soLuong = filter_var(
                $duLieu['so_luong'] ?? 1,
                FILTER_VALIDATE_INT
            );

            if (
                $soLuong === false
                || $soLuong < 1
                || $soLuong > DanhSachDiChoService::SO_SUAT_TOI_DA
            ) {
                throw new DomainException('Số suất phải từ 1 đến 10.');
            }

            $service->them($idMon, $soLuong);
            break;

        case 'cap_nhat':
            $idMon = $duLieu['id_mon'] ?? '';

            $soLuong = filter_var(
                $duLieu['so_luong'] ?? null,
                FILTER_VALIDATE_INT
            );

            if (
                !is_string($idMon)
                || $soLuong === false
                || $soLuong === null
                || $soLuong < 1
                || $soLuong > DanhSachDiChoService::SO_SUAT_TOI_DA
            ) {
                throw new DomainException('Thông tin cập nhật không hợp lệ.');
            }

            if (!$service->capNhatSoLuong($idMon, $soLuong)) {
                traJsonDanhSachDiCho(404, [
                    'success' => false,
                    'loi' => 'Không tìm thấy món ăn trong danh sách.',
                ]);
            }
            break;

        case 'xoa':
            $idMon = $duLieu['id_mon'] ?? '';

            if (!is_string($idMon)) {
                throw new DomainException('Mã món ăn không hợp lệ.');
            }

            $service->xoa($idMon);
            break;

        case 'xoa_het':
            $service->xoaHet();
            break;
    }

    traJsonDanhSachDiCho(200, [
        'success' => true,
        'csrf_token' => csrfToken(),
        'data' => duLieuDanhSachDiCho($service, $kho),
    ]);

} catch (DomainException $e) {
    traJsonDanhSachDiCho(422, [
        'success' => false,
        'loi' => $e->getMessage(),
    ]);

} catch (Throwable $e) {
    error_log('Loi API danh sach di cho: ' . $e->getMessage());

    traJsonDanhSachDiCho(500, [
        'success' => false,
        'loi' => 'Không thể xử lý danh sách đi chợ. Vui lòng thử lại.',
    ]);
}
