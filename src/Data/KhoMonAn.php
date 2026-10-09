<?php

namespace App\Data;

use App\Models\MonAn;
use RuntimeException;

class KhoMonAn
{
    /** @var MonAn[] */
    private array $danhSach = [];

    public function __construct(string $duongDanJson)
    {
        if (!file_exists($duongDanJson)) {
            throw new RuntimeException("Tệp dữ liệu không tồn tại: {$duongDanJson}");
        }

        $noiDung = file_get_contents($duongDanJson);
        $data = json_decode($noiDung, true);

        if (!is_array($data)) {
            $this->danhSach = [];
            return;
        }

        foreach ($data as $item) {
            if (is_array($item)) {
                $this->danhSach[] = MonAn::tuMang($item);
            }
        }
    }

    public function layTatCa(): array
    {
        return $this->danhSach;
    }

    public function timKiem(string $tuKhoa = '', string $danhMuc = ''): array
    {
        $ketQua = $this->danhSach;

        if ($danhMuc !== '') {
            $ketQua = array_filter($ketQua, function (MonAn $m) use ($danhMuc) {
                return mb_strtolower($m->danhMuc) === mb_strtolower($danhMuc);
            });
        }

        if ($tuKhoa !== '') {
            $tuKhoaThuong = mb_strtolower($tuKhoa);
            $ketQua = array_filter($ketQua, function (MonAn $m) use ($tuKhoaThuong) {
                return str_contains(mb_strtolower($m->ten), $tuKhoaThuong)
                    || str_contains(mb_strtolower($m->moTa), $tuKhoaThuong);
            });
        }

        return array_values($ketQua);
    }
    public function timTheoId(string $id): ?MonAn
    {
        foreach ($this->danhSach as $mon) {
            if ($mon->id === $id) {
                return $mon;
            }
        }

        return null;
    }
}