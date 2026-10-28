<?php
/**
 * Tệp: src/Services/YeuThichService.php
 * Mục đích: Quản lý danh sách món yêu thích trong session, dạng [id_mon => so_luong].
 *           Đóng vai trò giỏ hàng: tính thành tiền và tổng tiền khi hiển thị.
 * Dùng bởi: inc/nav.php, danh-sach.php, chi-tiet.php, yeu-thich.php
 */

declare(strict_types=1);

namespace App\Services;

use App\Data\KhoMonAn;

class YeuThichService
{
    private const KEY = 'yeu_thich';

    public const SO_LUONG_TOI_THIEU = 1;
    public const SO_LUONG_TOI_DA    = 10;

    public function __construct()
    {
        if (!isset($_SESSION[self::KEY]) || !is_array($_SESSION[self::KEY])) {
            $_SESSION[self::KEY] = [];
        }

        // Phiên cũ dạng list ['cao-lau', 'banh-xeo'] -> ['cao-lau' => 1, 'banh-xeo' => 1]
        if (array_is_list($_SESSION[self::KEY])) {
            $cu = $_SESSION[self::KEY];
            $_SESSION[self::KEY] = [];

            foreach ($cu as $id) {
                $_SESSION[self::KEY][(string) $id] = self::SO_LUONG_TOI_THIEU;
            }
        }
    }

    /** Thêm món với số lượng 1. Nếu đã có thì giữ nguyên số lượng. */
    public function them(string $id): void
    {
        if (!isset($_SESSION[self::KEY][$id])) {
            $_SESSION[self::KEY][$id] = self::SO_LUONG_TOI_THIEU;
        }
    }

    /**
     * Đặt số lượng mới.
     * Trả về false nếu món chưa có trong danh sách hoặc số lượng ngoài khoảng cho phép.
     */
    public function capNhatSoLuong(string $id, int $soLuong): bool
    {
        if (!isset($_SESSION[self::KEY][$id])) {
            return false;
        }

        if ($soLuong < self::SO_LUONG_TOI_THIEU || $soLuong > self::SO_LUONG_TOI_DA) {
            return false;
        }

        $_SESSION[self::KEY][$id] = $soLuong;
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

    /** Kiểm tra món đã có trong danh sách yêu thích chưa. */
    public function co(string $id): bool
    {
        return isset($_SESSION[self::KEY][$id]);
    }

    /**
     * Xóa khỏi session các món không còn tồn tại trong dữ liệu.
     * Gọi ở đầu yeu-thich.php để số liệu trên trang khớp với badge trên header.
     */
    public function loaiBoMonKhongCon(KhoMonAn $kho): void
    {
        foreach (array_keys($_SESSION[self::KEY]) as $id) {
            if ($kho->timTheoId((string) $id) === null) {
                unset($_SESSION[self::KEY][$id]);
            }
        }
    }

    /** Số món khác nhau. Dùng cho biểu tượng trên header. */
    public function soLuong(): int
    {
        return count($_SESSION[self::KEY]);
    }

    /** Tổng số phần của tất cả các món. */
    public function tongSoPhan(): int
    {
        return array_sum($_SESSION[self::KEY]);
    }

    /**
     * Trả về ['mon' => [...], 'tongTien' => int].
     * Mỗi dòng gồm: monAn, soLuong, donGia, thanhTien.
     */
   
    /**
     * Lấy giỏ hàng bằng truy vấn nhóm WHERE IN.
     * Không truy vấn MySQL trong vòng lặp.
     */
    public function layGioHang(KhoMonAn $kho): array
    {
        $cacMon = [];
        $tongTien = 0;

        // Lấy các slug món từ session
        $cacSlug = array_keys($_SESSION[self::KEY]);

        // Truy vấn các món trong một lần gọi lớp dữ liệu
        $danhSachMon = $kho->timNhieuTheoSlug($cacSlug);

        foreach ($danhSachMon as $monAn) {
            $slug = (string) $monAn->id;

            $soLuong = (int) (
                $_SESSION[self::KEY][$slug] ?? 0
            );

            if (
                $soLuong < self::SO_LUONG_TOI_THIEU ||
                $soLuong > self::SO_LUONG_TOI_DA
            ) {
                continue;
            }

            $donGia = (int) $monAn->nganSach;
            $thanhTien = $donGia * $soLuong;
            $tongTien += $thanhTien;

            $cacMon[] = [
                'monAn' => $monAn,
                'soLuong' => $soLuong,
                'donGia' => $donGia,
                'thanhTien' => $thanhTien,
            ];
        }

        return [
            'mon' => $cacMon,
            'tongTien' => $tongTien,
        ];
    }

}