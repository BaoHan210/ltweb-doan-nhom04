<?php
/**
 * Tệp: src/Models/MonAn.php
 * Mục đích: Đối tượng món ăn, tạo từ mảng dữ liệu của KhoMonAn.
 */

namespace App\Models;

class MonAn implements \JsonSerializable
{
    public function __construct(
        public string $id = '',
        public string $ten = '',
        public string $danhMuc = '',
        public int $thoiGian = 0,
        public int $khauPhan = 0,
        public string $doKho = 'Dễ',
        public int $nganSach = 0,
        public string $hinhAnh = '',
        public float $danhGia = 0.0,
        public int $soLuotDanhGia = 0,
        public string $moTa = '',
        public array $nguyenLieu = [],
        public array $cacBuoc = [],
        public string $video = '',
        public int $tonKho = 0
    ) {}

    public static function tuMang(array $data): self
    {
        return new self(
            id: (string)($data['id'] ?? $data['maMon'] ?? ''),
            ten: (string)($data['ten'] ?? ''),
            danhMuc: (string)($data['danhMuc'] ?? ''),
            thoiGian: (int)($data['thoiGian'] ?? 0),
            khauPhan: (int)($data['khauPhan'] ?? 0),
            doKho: (string)($data['doKho'] ?? 'Dễ'),
            nganSach: (int)($data['nganSach'] ?? $data['gia'] ?? 0),
            hinhAnh: (string)($data['hinhAnh'] ?? ''),
            danhGia: (float)($data['danhGia'] ?? 0),
            soLuotDanhGia: (int)($data['soLuotDanhGia'] ?? 0),
            moTa: (string)($data['moTa'] ?? ''),
            nguyenLieu: (array)($data['nguyenLieu'] ?? []),
            cacBuoc: (array)($data['cacBuoc'] ?? []),
            video: (string)($data['video'] ?? ''),
            tonKho: (int)($data['tonKho'] ?? 0)
        );
    }

    /**
     * Chuyển đối tượng món ăn thành dữ liệu JSON.
     * Chỉ công khai những thuộc tính cần thiết cho phía giao diện.
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'ten' => $this->ten,
            'danh_muc' => $this->danhMuc,
            'thoi_gian' => $this->thoiGian,
            'khau_phan' => $this->khauPhan,
            'do_kho' => $this->doKho,
            'ngan_sach' => $this->nganSach,
            'hinh_anh' => $this->hinhAnh,
            'danh_gia' => $this->danhGia,
            'so_luot_danh_gia' => $this->soLuotDanhGia,
            'mo_ta' => $this->moTa,
            'nguyen_lieu' => $this->nguyenLieu,
            'cac_buoc' => $this->cacBuoc,
            'video' => $this->video,
        ];
    }
}