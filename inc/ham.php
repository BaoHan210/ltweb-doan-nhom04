<?php
// inc/ham.php - Tập hợp các hàm tiện ích dùng chung cho toàn hệ thống

if (!function_exists('e')) {
    /**
     * Hàm an toàn hóa chuỗi đầu ra chống tấn công XSS (Cross-Site Scripting)
     * Thay thế cho htmlspecialchars() ngắn gọn hơn trong giao diện HTML
     */
    function e(?string $chuoi): string
    {
        return htmlspecialchars($chuoi ?? '', ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('vnd')) {
    /**
     * Định dạng số thành chuỗi tiền tệ Việt Nam Đồng (VND)
     */
    function vnd(int|float $so): string
    {
        return number_format($so, 0, ',', '.') . ' ₫';
    }
}

if (!function_exists('chuyen_huong')) {
    /**
     * Chuyển hướng trình duyệt đến một URL chỉ định và dừng thực thi script
     */
    function chuyen_huong(string $url): void
    {
        header("Location: {$url}");
        exit();
    }
}

if (!function_exists('gan_thong_bao')) {
    /**
     * Lưu thông báo phản hồi (thành công/lỗi) vào Session
     */
    function gan_thong_bao(string $loai, string $noiDung): void
    {
        $_SESSION['flash_message'] = [
            'loai' => $loai, // 'success' hoặc 'error'
            'noi_dung' => $noiDung
        ];
    }
}

if (!function_exists('hien_thi_thong_bao')) {
    /**
     * Hiển thị và xóa thông báo phản hồi từ Session (Flash Message)
     */
    function hien_thi_thong_bao(): string
    {
        if (isset($_SESSION['flash_message'])) {
            $msg = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            $loaiCss = $msg['loai'] === 'error' ? 'thong-bao-loi' : 'thong-bao-thanh-cong';
            return sprintf(
                '<div class="thong-bao %s">%s</div>',
                $loaiCss,
                e($msg['noi_dung'])
            );
        }
        return '';
    }
}