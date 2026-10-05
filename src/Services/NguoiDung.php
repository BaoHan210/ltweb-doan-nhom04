<?php
namespace App\Models;

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