<?php

namespace App\Services;

use PDO;
use PDOException;

class LienHeService
{
    public function __construct(private PDO $db)
    {
    }

    /**
     * Lưu phản hồi liên hệ vào MySQL bằng PDO.
     *
     * @param array<string, mixed> $data
     */
    public function guiPhanHoi(array $data): bool
    {
        $hoTen = trim((string)($data['ho_ten'] ?? ''));
        $email = trim((string)($data['email'] ?? ''));
        $noiDung = trim((string)($data['noi_dung'] ?? ''));
        $chuDe = trim((string)($data['subject'] ?? ''));

        if (
            $hoTen === '' ||
            $email === '' ||
            $noiDung === '' ||
            filter_var($email, FILTER_VALIDATE_EMAIL) === false
        ) {
            return false;
        }

        // Bảng lien_he không có cột subject.
        // Giữ chủ đề bằng cách ghép vào nội dung.
        if ($chuDe !== '') {
            $noiDung = "Chủ đề: {$chuDe}\n\n{$noiDung}";
        }

        $hinhAnh = $data['anh'] ?? null;

        if (!is_string($hinhAnh) || $hinhAnh === '') {
            $hinhAnh = null;
        }

        $sql = "
            INSERT INTO lien_he
                (nguoi_dung_id, ho_ten, email,
                 noi_dung, hinh_anh, ngay_gui)
            VALUES
                (:nguoi_dung_id, :ho_ten, :email,
                 :noi_dung, :hinh_anh, NOW())
        ";

        try {
            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                'nguoi_dung_id' => null,
                'ho_ten' => $hoTen,
                'email' => $email,
                'noi_dung' => $noiDung,
                'hinh_anh' => $hinhAnh
            ]);
        } catch (PDOException $e) {
            error_log(
                'Loi luu lien he vao MySQL: ' .
                $e->getMessage()
            );

            return false;
        }
    }
    
    /**
     * Lấy danh sách thư liên hệ mới nhất từ MySQL.
     * Dùng cho trang quản trị.
     */
    public function layDanhSach(int $gioiHan = 100): array
    {
        $gioiHan = max(1, min($gioiHan, 500));

        $sql = "
            SELECT
                id,
                ho_ten,
                email,
                noi_dung,
                hinh_anh AS anh,
                ngay_gui
            FROM lien_he
            ORDER BY ngay_gui DESC, id DESC
            LIMIT :gioi_han
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(
            ':gioi_han',
            $gioiHan,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
