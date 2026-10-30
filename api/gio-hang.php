<?php
/**
 * Tệp: api/gio-hang.php
 * Mục đích: API giỏ hàng (Bài thực hành 6 – Chức năng 6).
 *   GET  /api/gio-hang.php                 xem giỏ hàng và csrf_token
 *   POST /api/gio-hang.php (JSON)          thêm, cập nhật, xóa, xóa hết
 *   Thân JSON: {"hanh_dong":"them|cap_nhat|xoa|xoa_het",
 *               "id_mon":"slug", "so_luong":2, "csrf_token":"..."}
 * Dùng chung session với yeu-thich.php. Không tạo đơn hàng tại đây.
 */

declare(strict_types=1);

use App\Data\KhoMonAn;
use App\Services\YeuThichService;

require_once dirname(__DIR__) . '/inc/config.php';
dangKyHandlerApi();   // lỗi không bắt được → JSON 500

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');

/** @param array<string,mixed> $body */
function guiJson(int $status, array $body): never
{
    http_response_code($status);
    echo json_encode($body, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if (!in_array($method, ['GET', 'POST'], true)) {
    header('Allow: GET, POST');
    guiJson(405, ['success' => false, 'loi' => 'Chỉ hỗ trợ GET và POST.']);
}

try {
    require_once dirname(__DIR__) . '/inc/db.php';
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    require_once dirname(__DIR__) . '/inc/xac-thuc.php';

    // API không chuyển hướng sang trang HTML khi chưa đăng nhập
    if (nguoiDungHienTai() === null) {
        guiJson(401, ['success' => false, 'loi' => 'Bạn cần đăng nhập để sử dụng giỏ hàng.']);
    }

    if (empty($_SESSION['csrf_api_gio_hang'])) {
        $_SESSION['csrf_api_gio_hang'] = bin2hex(random_bytes(32));
    }

    $kho      = new KhoMonAn(db());
    $yeuThich = new YeuThichService();

    if ($method === 'POST') {
        $contentType = (string) ($_SERVER['CONTENT_TYPE'] ?? '');
        if (stripos($contentType, 'application/json') !== 0) {
            guiJson(400, ['success' => false, 'loi' => 'Yêu cầu phải có Content-Type: application/json.']);
        }

        $raw = file_get_contents('php://input');
        if ($raw === false || strlen($raw) > 8192) {
            guiJson(400, ['success' => false, 'loi' => 'Nội dung JSON không hợp lệ hoặc quá lớn.']);
        }

        try {
            $data = json_decode($raw, true, 16, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            guiJson(400, ['success' => false, 'loi' => 'JSON không hợp lệ.']);
        }
        if (!is_array($data) || array_is_list($data)) {
            guiJson(400, ['success' => false, 'loi' => 'Nội dung phải là đối tượng JSON.']);
        }

        $csrf = $data['csrf_token'] ?? null;
        if (!is_string($csrf) || !hash_equals($_SESSION['csrf_api_gio_hang'], $csrf)) {
            guiJson(403, ['success' => false, 'loi' => 'Mã xác thực biểu mẫu không hợp lệ.']);
        }

        $hanhDong = $data['hanh_dong'] ?? null;
        if (!is_string($hanhDong) || !in_array($hanhDong, ['them', 'cap_nhat', 'xoa', 'xoa_het'], true)) {
            guiJson(422, ['success' => false, 'loi' => 'Hành động không hợp lệ.']);
        }

        // Mọi hành động trừ xoa_het đều cần mã món hợp lệ
        $idMon = '';
        if ($hanhDong !== 'xoa_het') {
            $idMon = $data['id_mon'] ?? null;
            if (!is_string($idMon) || strlen($idMon) > 150
                || !preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $idMon)) {
                guiJson(422, ['success' => false, 'loi' => 'Mã món ăn không hợp lệ.']);
            }
        }

        if ($hanhDong === 'them') {
            $mon = $kho->timTheoId($idMon);
            if ($mon === null) {
                guiJson(404, ['success' => false, 'loi' => 'Món ăn không tồn tại.']);
            }
            if ($mon->tonKho < 1) {
                guiJson(422, ['success' => false, 'loi' => 'Món đã hết hàng.']);
            }
            $yeuThich->them($idMon);

        } elseif ($hanhDong === 'cap_nhat') {
            $soLuong = $data['so_luong'] ?? null;
            if (!is_int($soLuong) || $soLuong < 1 || $soLuong > 10) {
                guiJson(422, ['success' => false, 'loi' => 'Số lượng phải là số nguyên từ 1 đến 10.']);
            }
            $mon = $kho->timTheoId($idMon);
            if ($mon === null) {
                guiJson(404, ['success' => false, 'loi' => 'Món ăn không tồn tại.']);
            }
            if ($soLuong > $mon->tonKho) {
                guiJson(422, ['success' => false, 'loi' => 'Kho chỉ còn ' . $mon->tonKho . ' phần.']);
            }
            if (!$yeuThich->capNhatSoLuong($idMon, $soLuong)) {
                guiJson(404, ['success' => false, 'loi' => 'Món này không có trong giỏ.']);
            }

        } elseif ($hanhDong === 'xoa') {
            $yeuThich->xoa($idMon);

        } else {   // xoa_het
            $yeuThich->xoaHet();
        }
    }

    // GET và POST đều trả về giỏ hàng hiện tại
    $gio    = $yeuThich->layGioHang($kho);
    $cacMon = [];
    foreach ($gio['mon'] as $dong) {
        $mon      = $dong['monAn'];
        $cacMon[] = [
            'id'         => $mon->id,
            'ten'        => $mon->ten,
            'hinh_anh'   => $mon->hinhAnh,
            'so_luong'   => (int) $dong['soLuong'],
            'don_gia'    => (int) $dong['donGia'],
            'thanh_tien' => (int) $dong['thanhTien'],
        ];
    }

    guiJson(200, [
        'success'    => true,
        'data'       => [
            'mon'          => $cacMon,
            'tong_tien'    => (int) $gio['tongTien'],
            'tong_so_phan' => $yeuThich->tongSoPhan(),
        ],
        'csrf_token' => $_SESSION['csrf_api_gio_hang'],
    ]);

} catch (Throwable $e) {
    error_log('API gio hang: ' . $e->getMessage());
    guiJson(500, ['loi' => 'Lỗi máy chủ']);
}