<?php
// inc/config.php - Khởi tạo cấu hình và xử lý lỗi hệ thống

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/ham.php';

// Nạp biến môi trường từ tệp .env tại thư mục gốc.
$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

// Kiểm tra các biến cấu hình CSDL bắt buộc.
$dotenv->required([
    'DB_HOST',
    'DB_PORT',
    'DB_DATABASE',
    'DB_USERNAME'
])->notEmpty();

// DB_PASSWORD được phép để trống khi dùng MySQL root trên XAMPP.
if (!array_key_exists('DB_PASSWORD', $_ENV)) {
    throw new RuntimeException('Thiếu biến môi trường DB_PASSWORD.');
}

// APP_DEBUG mặc định tắt nếu không được khai báo.
$batLoiChiTiet = filter_var(
    $_ENV['APP_DEBUG'] ?? 'false',
    FILTER_VALIDATE_BOOLEAN
);

define('MOI_TRUONG', $batLoiChiTiet ? 'dev' : 'production');

// Cấu hình xử lý lỗi.
error_reporting(E_ALL);
ini_set('display_errors', MOI_TRUONG === 'dev' ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../logs/php-error.log');

// Gia cố cấu hình session trước khi khởi tạo phiên.
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_trans_sid', '0');
    ini_set('session.gc_maxlifetime', '1800');

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => (
            !empty($_SERVER['HTTPS'])
            && strtolower((string) $_SERVER['HTTPS']) !== 'off'
        ),
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();

    // Tự động hết hạn phiên sau 30 phút không hoạt động.
    $thoiGianHienTai = time();
    $thoiGianHetHan = 1800;

    if (
        isset($_SESSION['last_activity'])
        && ($thoiGianHienTai - (int) $_SESSION['last_activity']) > $thoiGianHetHan
    ) {
        // Xóa dữ liệu phiên cũ và đổi session ID.
        $_SESSION = [];
        session_regenerate_id(true);
    }

    // Cập nhật thời điểm hoạt động gần nhất.
    $_SESSION['last_activity'] = $thoiGianHienTai;
}

// Thiết lập HTTP security headers.
if (!headers_sent()) {
    // Xóa thông tin phiên bản PHP khỏi response header.
    header_remove('X-Powered-By');

    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');

    // CSP ở chế độ báo cáo: chỉ ghi nhận vi phạm, chưa chặn tài nguyên.
    $csp = implode('; ', [
        "default-src 'self'",
        "base-uri 'self'",
        "object-src 'none'",
        "frame-ancestors 'self'",
        "form-action 'self'",
        "script-src 'self'",
        "style-src 'self'",
        "img-src 'self' data: https://www.themealdb.com",
        "connect-src 'self' https://api.quotable.io https://www.themealdb.com",
        "font-src 'self'"
    ]);

    header('Content-Security-Policy: ' . $csp);

    // HSTS chỉ áp dụng khi website đang chạy HTTPS.
    if (
        !empty($_SERVER['HTTPS'])
        && strtolower((string) $_SERVER['HTTPS']) !== 'off'
    ) {
        header('Strict-Transport-Security: max-age=31536000');
    }
}

require_once __DIR__ . '/csrf.php';

// API danh sách món ăn chỉ hỗ trợ GET, tự xử lý phương thức không hợp lệ.
$laApiMonAnChiDoc = str_ends_with(
    str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? '')),
    '/api/mon-an.php'
);

// Kiểm tra CSRF tập trung đối với mọi yêu cầu POST,
// ngoại trừ API chỉ đọc đã có kiểm tra phương thức riêng.
if (
    ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'
    && !$laApiMonAnChiDoc
    && !csrfHopLe()
) {
    http_response_code(403);

    // Xác định yêu cầu cần nhận phản hồi JSON.
    $contentType = strtolower((string) ($_SERVER['CONTENT_TYPE'] ?? ''));
    $accept = strtolower((string) ($_SERVER['HTTP_ACCEPT'] ?? ''));

    $laYeuCauJson = (
        str_contains($contentType, 'application/json')
        || str_contains($accept, 'application/json')
    );

    if ($laYeuCauJson) {
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');

        echo json_encode(
            [
                'success' => false,
                'loi' => 'Yêu cầu không hợp lệ. Vui lòng tải lại trang.'
            ],
            JSON_UNESCAPED_UNICODE
            | JSON_UNESCAPED_SLASHES
            | JSON_INVALID_UTF8_SUBSTITUTE
        );
    } else {
        header('Content-Type: text/html; charset=utf-8');

        echo '<!DOCTYPE html>';
        echo '<html lang="vi">';
        echo '<head><meta charset="UTF-8"><title>Yêu cầu không hợp lệ</title></head>';
        echo '<body>';
        echo '<h1>403 - Yêu cầu không hợp lệ</h1>';
        echo '<p>Mã bảo vệ CSRF không hợp lệ hoặc đã hết hạn. Vui lòng tải lại trang.</p>';
        echo '</body></html>';
    }
    ghiLogBaoMat('csrf_sai');
    exit;
}

// Xác định URL gốc của website.
if (!defined('URL_GOC')) {
    // Tự động lấy thư mục gốc khi chạy trên XAMPP/Laragon.
    $thuMucGoc = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    define('URL_GOC', $thuMucGoc !== '' ? $thuMucGoc . '/' : '/');
}

// Xử lý ngoại lệ chung của hệ thống.
set_exception_handler(function (Throwable $e) {
    error_log((string) $e);
    http_response_code(500);

    if (MOI_TRUONG === 'dev') {
        echo '<pre>' . htmlspecialchars((string) $e) . '</pre>';
    } else {
        require __DIR__ . '/../500.php';
    }
});

// Đăng ký handler riêng cho API.
// Lỗi không bắt được sẽ trả JSON 500 thay vì HTML.
function dangKyHandlerApi(): void
{
    set_exception_handler(function (Throwable $e) {
        error_log((string) $e);

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode(
            ['loi' => 'Lỗi máy chủ'],
            JSON_UNESCAPED_UNICODE
        );
    });
}
