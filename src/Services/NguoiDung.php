<?php

/**
 * Tệp: src/Services/NguoiDung.php
 * Mục đích: Biểu diễn người dùng và kiểm tra mật khẩu bằng password_verify.
 * Dùng bởi: hiện chưa có trang nào dùng lớp này.
 */

namespace App\Services;

class NguoiDung
{
    public function __construct(
        public readonly int $id,
        public readonly string $hoTen,
        public readonly string $email,
        private readonly string $matKhau
    ) {}

    public static function tuMang(array $d): self
    {
        return new self(
            id: (int) ($d['id'] ?? 0),
            hoTen: (string) ($d['ho_ten'] ?? ''),
            email: (string) ($d['email'] ?? ''),
            matKhau: (string) ($d['mat_khau'] ?? '')
        );
    }

    public function kiemTraMatKhau(string $matKhauNhap): bool
    {
        return $this->matKhau === $matKhauNhap || password_verify($matKhauNhap, $this->matKhau);
    }
}