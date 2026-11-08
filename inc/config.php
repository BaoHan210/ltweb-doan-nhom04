<?php
// inc/config.php - Khởi tạo cấu hình và xử lý lỗi hệ thống

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/ham.php';

const MOI_TRUONG = 'dev'; // Giữ 'dev' khi nộp bài

error_reporting(E_ALL);
ini_set('display_errors', MOI_TRUONG === 'dev' ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../logs/php-error.log');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/csrf.php';

// Kiểm tra CSRF tập trung đối với mọi yêu cầu POST.
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && !csrfHopLe()) {
    http_response_code(403);

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

    exit;
}

if (!defined('URL_GOC')) {
    // Tự động lấy thư mục gốc linh hoạt dù chạy trên XAMPP/Laragon hay bất kỳ máy nào
    $thuMucGoc = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    define('URL_GOC', $thuMucGoc !== '' ? $thuMucGoc . '/' : '/');
}

set_exception_handler(function (Throwable $e) {
    error_log((string) $e);
    http_response_code(500);

    if (MOI_TRUONG === 'dev') {
        echo '<pre>' . htmlspecialchars((string) $e) . '</pre>';
    } else {
        require __DIR__ . '/../500.php';
    }
});

// Dùng cho các file trong api/: lỗi không bắt được sẽ trả JSON 500 thay vì HTML
function dangKyHandlerApi(): void
{
    set_exception_handler(function (Throwable $e) {
        error_log((string) $e);
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['loi' => 'Lỗi máy chủ'], JSON_UNESCAPED_UNICODE);
    });
}