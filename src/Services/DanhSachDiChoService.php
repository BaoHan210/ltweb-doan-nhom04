<?php

namespace App\Services;

use App\Data\KhoMonAn;

class DanhSachDiChoService
{
    private const KEY = 'danh_sach_di_cho';

    public function __construct()
    {
        if (!isset($_SESSION[self::KEY])) {
            $_SESSION[self::KEY] = [];
        }
    }

    public function them(string $id, array $nguyenLieuConThieu = []): void
    {
        foreach ($_SESSION[self::KEY] as $item) {
            if (($item['id'] ?? '') === $id) {
                return;
            }
        }

        $_SESSION[self::KEY][] = [
            'id' => $id,
            'nguyenLieuConThieu' => $nguyenLieuConThieu
        ];
    }

    public function xoa(string $id): void
    {
        $_SESSION[self::KEY] = array_values(
            array_filter(
                $_SESSION[self::KEY],
                fn($item) => ($item['id'] ?? '') !== $id
            )
        );
    }

    public function xoaHet(): void
    {
        $_SESSION[self::KEY] = [];
    }

    public function soLuong(): int
    {
        return count($_SESSION[self::KEY]);
    }

    public function danhSachMonAn(KhoMonAn $kho): array
    {
        $danhSach = [];

        foreach ($_SESSION[self::KEY] as $item) {
            $id = $item['id'] ?? '';
            $monAn = $kho->timTheoId($id);

            if ($monAn !== null) {
                $danhSach[] = [
                    'monAn' => $monAn,
                    'nguyenLieuConThieu' => $item['nguyenLieuConThieu'] ?? []
                ];
            }
        }

        return $danhSach;
    }
}