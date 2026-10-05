<?php
/**
 * Tệp: src/Models/MonAn.php
 * Chức năng: Biểu diễn đối tượng thực thể Món ăn (Model) với các thuộc tính chỉ đọc (readonly)
 *            và phương thức tĩnh hỗ trợ chuyển đổi dữ liệu từ mảng JSON thành đối tượng.
 */

namespace App\Models;

class MonAn
{
    public function __construct(
        public readonly int $id,
        public readonly string $ten,
        public readonly string $danhMuc,
        public readonly int $thoiGian,
        public readonly string $khauPhan,
        public readonly string $hinhAnh,
        public readonly array $nguyenLieu,
        public readonly array $cacBuoc
    ) {}

    /**
     * Phương thức tĩnh khởi tạo đối tượng MonAn từ mảng dữ liệu JSON
     */
    public static function tuMang(array $d): self
    {
        return new self(
            id: (int) ($d['id'] ?? 0),
            ten: (string) ($d['ten'] ?? ''),
            danhMuc: (string) ($d['danhMuc'] ?? 'Khác'),
            thoiGian: (int) ($d['thoiGian'] ?? 0),
            khauPhan: (string) ($d['khauPhan'] ?? '1 người'),
            hinhAnh: (string) ($d['hinhAnh'] ?? 'default.jpg'),
            nguyenLieu: (array) ($d['nguyenLieu'] ?? []),
            cacBuoc: (array) ($d['cacBuoc'] ?? [])
        );
    }
}