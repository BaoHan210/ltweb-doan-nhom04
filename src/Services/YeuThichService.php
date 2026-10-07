<?php
/**
 * Tệp: src/Services/YeuThichService.php
 * Chức năng: Lớp dịch vụ bọc và quản lý trạng thái danh sách món ăn yêu thích
 *            của người dùng thông qua biến toàn cục $_SESSION['yeu_thich'].
 */

namespace App\Services;

use App\Data\KhoMonAn;

class YeuThichService
{
    private const KEY = 'yeu_thich';

    public function __construct()
    {
        if (!isset($_SESSION[self::KEY])) {
            $_SESSION[self::KEY] = [];
        }
    }

    public function them(int $id): void
    {
        if (!in_array($id, $_SESSION[self::KEY], true)) {
            $_SESSION[self::KEY][] = $id;
        }
    }

    public function xoa(int $id): void
    {
        $_SESSION[self::KEY] = array_values(
            array_filter($_SESSION[self::KEY], fn($itemId) => $itemId !== $id)
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
        foreach ($_SESSION[self::KEY] as $id) {
            $monAn = $kho->timTheoId($id);
            if ($monAn !== null) {
                $danhSach[] = $monAn;
            }
        }
        return $danhSach;
    }
}
