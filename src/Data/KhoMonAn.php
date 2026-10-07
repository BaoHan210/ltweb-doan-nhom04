<?php
/**
 * Tệp: src/Data/KhoMonAn.php
 * Chức năng: Lớp truy cập dữ liệu (Data Access Object) - Nơi DUY NHẤT trong hệ thống
 *            tiến hành đọc và xử lý dữ liệu từ tệp JSON mon-an.json.
 */

namespace App\Data;

use App\Models\MonAn;
use RuntimeException;

class KhoMonAn
{
    private ?array $ds = null;

    public function __construct(private string $tepJson) {}

    public function tatCa(): array
    {
        if ($this->ds === null) {
            if (!is_file($this->tepJson)) {
                throw new RuntimeException("Không tìm thấy tệp dữ liệu {$this->tepJson}");
            }
            $json = file_get_contents($this->tepJson);
            $mang = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
            $this->ds = array_map(fn($d) => MonAn::tuMang($d), $mang);
        }
        return $this->ds;
    }

    public function timTheoId(int $id): ?MonAn
    {
        foreach ($this->tatCa() as $monAn) {
            if ($monAn->id === $id) {
                return $monAn;
            }
        }
        return null;
    }

    public function timKiem(string $tuKhoa = '', string $danhMuc = ''): array
    {
        $ketQua = $this->tatCa();

        if ($tuKhoa !== '') {
            $ketQua = array_filter($ketQua, fn($m) => 
                mb_strpos(mb_strtolower($m->ten), mb_strtolower($tuKhoa)) !== false
            );
        }

        if ($danhMuc !== '') {
            $ketQua = array_filter($ketQua, fn($m) => $m->danhMuc === $danhMuc);
        }

        return array_values($ketQua);
    }
}
