<?php
/**
 * Bảo vệ CSRF dùng chung cho website Cook with me.
 */

/**
 * Tạo hoặc lấy CSRF token dùng chung cho phiên.
 */
function csrfToken(): string
{
    if (
        !isset($_SESSION['csrf'])
        || !is_string($_SESSION['csrf'])
        || $_SESSION['csrf'] === ''
    ) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf'];
}

/**
 * Sinh trường hidden chứa CSRF token dùng chung.
 */
function csrfField(): string
{
    return '<input type="hidden" name="csrf" value="'
        . htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8')
        . '">';
}

/**
 * Kiểm tra CSRF token từ biểu mẫu, HTTP header hoặc JSON request.
 *
 * Hỗ trợ các token riêng cũ trong giai đoạn chuyển đổi để
 * không làm gián đoạn những biểu mẫu đã triển khai.
 */
function csrfHopLe(): bool
{
    $token = $_POST['csrf'] ?? $_POST['csrf_token'] ?? null;

    if (
        (!is_string($token) || $token === '')
        && isset($_SERVER['HTTP_X_CSRF_TOKEN'])
    ) {
        $token = $_SERVER['HTTP_X_CSRF_TOKEN'];
    }

    // Hỗ trợ các yêu cầu gửi dữ liệu JSON.
    if (!is_string($token) || $token === '') {
        $noiDung = file_get_contents('php://input');

        if (is_string($noiDung) && $noiDung !== '') {
            $duLieuJson = json_decode($noiDung, true);

            if (is_array($duLieuJson)) {
                $token = $duLieuJson['csrf'] ?? $duLieuJson['csrf_token'] ?? null;
            }
        }
    }

    if (!is_string($token) || $token === '') {
        return false;
    }

    // Kiểm tra token dùng chung.
    if (
        isset($_SESSION['csrf'])
        && is_string($_SESSION['csrf'])
        && hash_equals($_SESSION['csrf'], $token)
    ) {
        return true;
    }

    return false;
}
