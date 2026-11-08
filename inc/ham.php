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

if (!function_exists('lam_sach_chuoi')) {
    /**
     * Làm sạch chuỗi đầu vào (Trim khoảng trắng)
     */
    function lam_sach_chuoi(?string $chuoi): string
    {
        return trim($chuoi ?? '');
    }
}

if (!function_exists('tao_ten_file_ngau_nhien')) {
    /**
     * Tạo tên file ngẫu nhiên bằng chuỗi Hex an toàn để lưu vào thư mục uploads/
     */
    function tao_ten_file_ngau_nhien(string $tenGoc): string
    {
        $ext = pathinfo($tenGoc, PATHINFO_EXTENSION);
        return bin2hex(random_bytes(16)) . '.' . strtolower($ext);
    }
}

if (!function_exists('lay_chuoi')) {
    /** Lấy chuỗi từ $_GET/$_POST: không phải chuỗi (mảng, số…) → ''. Cắt độ dài tối đa. */
    function lay_chuoi(array $nguon, string $khoa, int $doDaiToiDa = 255): string
    {
        $giaTri = $nguon[$khoa] ?? '';
        if (!is_string($giaTri)) {
            return '';
        }
        return mb_substr(trim($giaTri), 0, $doDaiToiDa, 'UTF-8');
    }
}

if (!function_exists('ghiLogBaoMat')) {
    /**
     * Ghi nhật ký sự kiện bảo mật.
     * Không lưu mật khẩu, session ID hoặc CSRF token.
     */
    function ghiLogBaoMat(string $suKien, array $chiTiet = []): void
    {
        $cacSuKienChoPhep = [
            'csrf_sai',
            'cam_truy_cap',
            'dang_nhap_sai'
        ];

        if (!in_array($suKien, $cacSuKienChoPhep, true)) {
            return;
        }

        $duongDanLog = dirname(__DIR__) . '/logs/bao-mat.log';

        $duLieu = [
            'thoi_gian' => date('Y-m-d H:i:s'),
            'su_kien' => $suKien,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'duong_dan' => parse_url(
                $_SERVER['REQUEST_URI'] ?? '/',
                PHP_URL_PATH
            )
        ];

        // Chỉ cho phép ghi các trường thông tin đã xác định.
        foreach (['email_hash', 'so_lan', 'ly_do'] as $khoa) {
            if (isset($chiTiet[$khoa])) {
                $duLieu[$khoa] = is_scalar($chiTiet[$khoa])
                    ? (string) $chiTiet[$khoa]
                    : '';
            }
        }

        $dongLog = json_encode(
            $duLieu,
            JSON_UNESCAPED_UNICODE
            | JSON_UNESCAPED_SLASHES
            | JSON_INVALID_UTF8_SUBSTITUTE
        );

        if ($dongLog === false) {
            return;
        }

        file_put_contents(
            $duongDanLog,
            $dongLog . PHP_EOL,
            FILE_APPEND | LOCK_EX
        );
    }
}