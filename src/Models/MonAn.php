<?php

namespace App\Models;

class MonAn
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
        public string $video = ''
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
            video: (string)($data['video'] ?? '')
        );
    }
}