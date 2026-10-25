<?php

namespace App\Data;

use PDO;

class KhoNguoiDung
{
    /**
     * Nhận kết nối PDO từ hệ thống.
     */
    public function __construct(private PDO $db)
    {
    }

    /**
     * Tìm tài khoản theo email.
     * Dùng khi đăng nhập.
     */
    public function timTheoEmail(string $email): ?array
    {
        $sql = "
            SELECT
                id,
                ho_ten,
                email,
                mat_khau,
                vai_tro,
                ngay_tao
            FROM nguoi_dung
            WHERE email = :email
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'email' => trim($email)
        ]);

        $nguoiDung = $stmt->fetch(PDO::FETCH_ASSOC);

        return $nguoiDung ?: null;
    }

    /**
     * Tìm tài khoản theo ID.
     */
    public function timTheoId(int $id): ?array
    {
        $sql = "
            SELECT
                id,
                ho_ten,
                email,
                vai_tro,
                ngay_tao
            FROM nguoi_dung
            WHERE id = :id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute(['id' => $id]);

        $nguoiDung = $stmt->fetch(PDO::FETCH_ASSOC);

        return $nguoiDung ?: null;
    }

    /**
     * Kiểm tra email đã tồn tại hay chưa.
     */
    public function emailDaTonTai(string $email): bool
    {
        $sql = "
            SELECT COUNT(*)
            FROM nguoi_dung
            WHERE email = :email
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'email' => trim($email)
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }

    /**
     * Tạo tài khoản mới cho khách hàng.
     */
    public function taoTaiKhoan(
        string $hoTen,
        string $email,
        string $matKhau
    ): bool {
        $sql = "
            INSERT INTO nguoi_dung
                (ho_ten, email, mat_khau, vai_tro)
            VALUES
                (:ho_ten, :email, :mat_khau, :vai_tro)
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'ho_ten' => trim($hoTen),
            'email' => trim($email),
            'mat_khau' => password_hash(
                $matKhau,
                PASSWORD_DEFAULT
            ),
            'vai_tro' => 'khach_hang'
        ]);
    }

    /**
     * Nhập tài khoản quản trị viên khi chuyển dữ liệu Bài 5.
     * Chỉ gọi từ chương trình nhập dữ liệu nội bộ.
     */
    public function themQuanTriNhom(
        string $hoTen,
        string $email,
        string $matKhau
    ): bool {
        $hoTen = trim($hoTen);
        $email = trim($email);

        if (
            $hoTen === '' ||
            !filter_var($email, FILTER_VALIDATE_EMAIL) ||
            $matKhau === ''
        ) {
            return false;
        }

        // Tránh nhập trùng tài khoản.
        if ($this->emailDaTonTai($email)) {
            return false;
        }

        $sql = "
            INSERT INTO nguoi_dung
                (ho_ten, email, mat_khau, vai_tro)
            VALUES
                (:ho_ten, :email, :mat_khau, :vai_tro)
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'ho_ten' => $hoTen,
            'email' => $email,
            'mat_khau' => password_hash(
                $matKhau,
                PASSWORD_DEFAULT
            ),
            'vai_tro' => 'quan_tri'
        ]);
    }
}
