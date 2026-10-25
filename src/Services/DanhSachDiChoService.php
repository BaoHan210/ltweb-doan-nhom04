<?php
/**
 * Tệp: src/Services/DanhSachDiChoService.php
 * Danh sách đi chợ lưu trong session dạng ['id_mon' => so_suat].
 */

namespace App\Services;

use App\Data\KhoMonAn;

class DanhSachDiChoService
{
    private const KEY = 'danh_sach_di_cho';

    public const SO_SUAT_TOI_DA = 10;

    public function __construct()
    {
        if (!isset($_SESSION[self::KEY]) || !is_array($_SESSION[self::KEY])) {
            $_SESSION[self::KEY] = [];
        }

        // Phiên cũ là list các mảng ['id' => ..., 'nguyenLieuConThieu' => ...]
        // không còn dùng được nên xóa đi
        if (array_is_list($_SESSION[self::KEY])) {
            $_SESSION[self::KEY] = [];
        }
    }

    /** Thêm món. Nếu đã có thì cộng dồn số suất, không vượt quá mức tối đa. */
    public function them(string $id, int $soSuat = 1): void
    {
        $hienTai = $_SESSION[self::KEY][$id] ?? 0;
        $_SESSION[self::KEY][$id] = min(self::SO_SUAT_TOI_DA, $hienTai + $soSuat);
    }

    /** Đặt lại số suất. Trả về false nếu món không có hoặc số suất không hợp lệ. */
    public function capNhatSoLuong(string $id, int $soSuat): bool
    {
        if (!isset($_SESSION[self::KEY][$id])) {
            return false;
        }

        if ($soSuat < 1 || $soSuat > self::SO_SUAT_TOI_DA) {
            return false;
        }

        $_SESSION[self::KEY][$id] = $soSuat;
        return true;
    }

    public function xoa(string $id): void
    {
        unset($_SESSION[self::KEY][$id]);
    }

    public function xoaHet(): void
    {
        $_SESSION[self::KEY] = [];
    }

    /** Số món khác nhau trong danh sách. */
    public function soLuong(): int
    {
        return count($_SESSION[self::KEY]);
    }

    /** Trả về danh sách dạng [['monAn' => MonAn, 'soLuong' => int], ...]. */
    public function layDanhSach(KhoMonAn $kho): array
    {
        $ketQua = [];

        foreach ($_SESSION[self::KEY] as $id => $soSuat) {
            $monAn = $kho->timTheoId((string) $id);

            if ($monAn === null) {
                continue;
            }

            $ketQua[] = [
                'monAn'   => $monAn,
                'soLuong' => $soSuat,
            ];
        }

        return $ketQua;
    }
}