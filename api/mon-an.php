<?php
/**
 * Cook with me - BTN6, Chuc nang 6: REST API mon an.
 * GET /api/mon-an.php?q=...&dm=...
 * GET /api/mon-an.php?id=slug-mon-an
 */
declare(strict_types=1);
 
use App\Data\KhoMonAn;
use App\Models\MonAn;
 
// Dang ky handler JSON 500 truoc moi thu khac: loi nao khong bat duoc se tra {"loi":"Loi may chu"}.
require_once dirname(__DIR__) . '/inc/config.php';
dangKyHandlerApi();
 
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');
 
/** @param array<string,mixed> $data */
function traJson(int $status, array $data): never
{
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}
 
/** Only public-facing fields are exposed by the API. */
function monAnRaJson(MonAn $mon): array
{
    return [
        'id' => $mon->id,
        'ten' => $mon->ten,
        'danh_muc' => $mon->danhMuc,
        'thoi_gian' => $mon->thoiGian,
        'khau_phan' => $mon->khauPhan,
        'do_kho' => $mon->doKho,
        'ngan_sach' => $mon->nganSach,
        'hinh_anh' => $mon->hinhAnh,
        'danh_gia' => $mon->danhGia,
        'so_luot_danh_gia' => $mon->soLuotDanhGia,
        'mo_ta' => $mon->moTa,
        'nguyen_lieu' => $mon->nguyenLieu,
        'cac_buoc' => $mon->cacBuoc,
        'video' => $mon->video,
    ];
}
 
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Allow: GET');
    traJson(405, ['success' => false, 'error' => 'Phương thức không được hỗ trợ. Chỉ cho phép GET.']);
}
 
// Reject array-style arguments such as ?id[]=x instead of causing TypeErrors.
foreach (['id', 'q', 'keyword', 'dm'] as $key) {
    if (isset($_GET[$key]) && !is_string($_GET[$key])) {
        traJson(400, ['success' => false, 'error' => 'Tham số ' . $key . ' không hợp lệ.']);
    }
}
 
$id = trim($_GET['id'] ?? '');
$q = trim($_GET['q'] ?? $_GET['keyword'] ?? '');
$dm = trim($_GET['dm'] ?? '');
 
if (strlen($id) > 190 || strlen($q) > 200 || strlen($dm) > 100) {
    traJson(400, ['success' => false, 'error' => 'Tham số vượt quá độ dài cho phép.']);
}
if ($id !== '' && !preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $id)) {
    traJson(400, ['success' => false, 'error' => 'Mã món ăn không hợp lệ.']);
}
 
try {
    require_once dirname(__DIR__) . '/inc/db.php';
    require_once dirname(__DIR__) . '/vendor/autoload.php';
 
    $kho = new KhoMonAn(db());
    if ($id !== '') {
        $mon = $kho->timTheoId($id);
        if ($mon === null) {
            traJson(404, ['success' => false, 'error' => 'Không tìm thấy món ăn.']);
        }
        traJson(200, ['success' => true, 'data' => monAnRaJson($mon)]);
    }
 
    // timKiem() belongs to the repository, so SQL remains outside the API layer.
    $danhSach = $kho->timKiem($q, $dm);
    $ketQua = array_map('monAnRaJson', array_slice($danhSach, 0, 50));
    traJson(200, [
        'success' => true,
        'data' => $ketQua,
        'count' => count($ketQua),
        'limit' => 50,
    ]);
} catch (Throwable $e) {
    error_log('API mon an: ' . $e->getMessage());
    traJson(500, ['loi' => 'Lỗi máy chủ']);
}