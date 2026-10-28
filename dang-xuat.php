<?php
/** Cook with me – đăng xuất, hủy toàn bộ phiên đăng nhập. */
declare(strict_types=1);
require_once __DIR__ . '/inc/config.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    exit('Chỉ chấp nhận POST.');
}
$token = $_POST['csrf_token'] ?? null;
if (!is_string($token) || !isset($_SESSION['csrf_dang_xuat'])
    || !hash_equals((string) $_SESSION['csrf_dang_xuat'], $token)) {
    http_response_code(403);
    exit('Yêu cầu đăng xuất không hợp lệ.');
}


// Xóa mọi dữ liệu phiên, gồm uid và session tương thích cũ.
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', [
        'expires' => time() - 3600,
        'path' => $p['path'],
        'domain' => $p['domain'],
        'secure' => $p['secure'],
        'httponly' => $p['httponly'],
        'samesite' => $p['samesite'] ?? 'Lax',
    ]);
}
session_destroy();
session_start();
session_regenerate_id(true);
gan_thong_bao('success', 'Bạn đã đăng xuất khỏi hệ thống thành công.');
chuyen_huong('dang-nhap.php');
exit;
