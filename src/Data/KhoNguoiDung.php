<?php

declare(strict_types=1);

namespace App\Data;

use PDO;

class KhoNguoiDung
{
    public function __construct(private PDO $db)
    {
    }

    private function chuanHoaEmail(string $email): string
    {
        return mb_strtolower(trim($email), 'UTF-8');
    }

    public function timTheoEmail(string $email): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT id, ho_ten, email, mat_khau, vai_tro, ngay_tao
             FROM nguoi_dung WHERE email = :email LIMIT 1'
        );
        $stmt->execute(['email' => $this->chuanHoaEmail($email)]);
        $nguoiDung = $stmt->fetch(PDO::FETCH_ASSOC);
        return $nguoiDung ?: null;
    }

    public function timTheoId(int $id): ?array
    {
        if ($id <= 0) {
            return null;
        }
        $stmt = $this->db->prepare(
            'SELECT id, ho_ten, email, vai_tro, ngay_tao
             FROM nguoi_dung WHERE id = :id LIMIT 1'
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $nguoiDung = $stmt->fetch(PDO::FETCH_ASSOC);
        return $nguoiDung ?: null;
    }

    public function emailDaTonTai(string $email): bool
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) FROM nguoi_dung WHERE email = :email'
        );
        $stmt->execute(['email' => $this->chuanHoaEmail($email)]);
        return (int) $stmt->fetchColumn() > 0;
    }

    /**
     * Vai trò luôn được gán phía máy chủ; không nhận từ biểu mẫu đăng ký.
     * MySQL cần có UNIQUE INDEX trên nguoi_dung.email để chống đăng ký trùng đồng thời.
     */
    public function taoTaiKhoan(string $hoTen, string $email, string $matKhau): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO nguoi_dung (ho_ten, email, mat_khau, vai_tro)
             VALUES (:ho_ten, :email, :mat_khau, :vai_tro)'
        );
        return $stmt->execute([
            'ho_ten' => trim($hoTen),
            'email' => $this->chuanHoaEmail($email),
            'mat_khau' => password_hash($matKhau, PASSWORD_DEFAULT),
            'vai_tro' => 'khach_hang',
        ]);
    }

    /**
     * Chỉ sử dụng từ chức năng đăng nhập sau khi password_verify() thành công.
     * Không truyền mật khẩu thô vào phương thức này.
     */
    public function capNhatMatKhauDaBam(int $id, string $matKhauDaBam): bool
    {
        if ($id <= 0 || $matKhauDaBam === '') {
            return false;
        }
        $stmt = $this->db->prepare(
            'UPDATE nguoi_dung SET mat_khau = :mat_khau WHERE id = :id'
        );
        $stmt->bindValue(':mat_khau', $matKhauDaBam, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Giữ lại để tương thích chương trình nhập dữ liệu quản trị nội bộ.
     * Không gọi phương thức này từ trang công khai.
     */
    public function themQuanTriNhom(string $hoTen, string $email, string $matKhau): bool
    {
        $hoTen = trim($hoTen);
        $email = $this->chuanHoaEmail($email);
        if ($hoTen === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)
            || $matKhau === '' || $this->emailDaTonTai($email)) {
            return false;
        }
        $stmt = $this->db->prepare(
            'INSERT INTO nguoi_dung (ho_ten, email, mat_khau, vai_tro)
             VALUES (:ho_ten, :email, :mat_khau, :vai_tro)'
        );
        return $stmt->execute([
            'ho_ten' => $hoTen,
            'email' => $email,
            'mat_khau' => password_hash($matKhau, PASSWORD_DEFAULT),
            'vai_tro' => 'quan_tri',
        ]);
    }
}
