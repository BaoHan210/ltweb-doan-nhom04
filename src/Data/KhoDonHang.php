<?php
declare(strict_types=1);

namespace App\Data;

use DomainException;
use PDO;
use RuntimeException;
use Throwable;

final class KhoDonHang
{
    public function __construct(private PDO $db) {}

    /**
     * @param array<string,int> $soLuongTheoSlug
     * @return int ID đơn hàng mới
     */
    public function datHang(int $nguoiDungId, array $soLuongTheoSlug): int
    {
        if ($nguoiDungId < 1 || !$soLuongTheoSlug) {
            throw new DomainException('Bạn cần đăng nhập và chọn ít nhất một món.');
        }
        if (count($soLuongTheoSlug) > 100) {
            throw new DomainException('Danh sách đặt hàng quá lớn.');
        }
        foreach ($soLuongTheoSlug as $slug => $soLuong) {
            if (!is_string($slug) || $slug === '' || !preg_match('/^[a-z0-9-]+$/', $slug)
                || !is_int($soLuong) || $soLuong < 1 || $soLuong > 10) {
                throw new DomainException('Dữ liệu món ăn hoặc số lượng không hợp lệ.');
            }
        }

        $this->db->beginTransaction();
        try {
            $slugs = array_keys($soLuongTheoSlug);
            $dauHoi = implode(',', array_fill(0, count($slugs), '?'));
            $stmt = $this->db->prepare(
                "SELECT id, slug, ten, ngan_sach, ton_kho
                   FROM mon_an WHERE slug IN ($dauHoi)"
            );
            $stmt->execute($slugs);
            $monTheoSlug = [];
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $mon) {
                $monTheoSlug[(string) $mon['slug']] = $mon;
            }
            if (count($monTheoSlug) !== count($slugs)) {
                throw new DomainException('Có món không còn tồn tại. Hãy kiểm tra danh sách.');
            }

            $taoDon = $this->db->prepare(
                "INSERT INTO don_hang (nguoi_dung_id, trang_thai)
                 VALUES (:uid, 'cho_xac_nhan')"
            );
            $taoDon->execute(['uid' => $nguoiDungId]);
            $donHangId = (int) $this->db->lastInsertId();

            $truKho = $this->db->prepare(
                'UPDATE mon_an SET ton_kho = ton_kho - :sl
                 WHERE id = :id AND ton_kho >= :dieu_kien'
            );
            $themDong = $this->db->prepare(
                'INSERT INTO chi_tiet_don (don_hang_id, mon_an_id, so_luong, don_gia)
                 VALUES (:don_hang_id, :mon_an_id, :so_luong, :don_gia)'
            );
            foreach ($soLuongTheoSlug as $slug => $soLuong) {
                $mon = $monTheoSlug[$slug];
                $truKho->execute([
                    'sl' => $soLuong,
                    'id' => (int) $mon['id'],
                    'dieu_kien' => $soLuong,
                ]);
                if ($truKho->rowCount() !== 1) {
                    throw new DomainException(
                        'Món "' . $mon['ten'] . '" không đủ tồn kho để đặt ' . $soLuong . ' phần.'
                    );
                }
                $themDong->execute([
                    'don_hang_id' => $donHangId,
                    'mon_an_id' => (int) $mon['id'],
                    'so_luong' => $soLuong,
                    'don_gia' => (int) $mon['ngan_sach'],
                ]);
            }
            $this->db->commit();
            return $donHangId;
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }
    }

    /** Chỉ lấy các đơn thuộc tài khoản đang đăng nhập. */
    public function layCuaNguoiDung(int $nguoiDungId): array
    {
        $stmt = $this->db->prepare(
            'SELECT d.id, d.trang_thai, d.ngay_dat,
                    COALESCE(SUM(ct.so_luong * ct.don_gia), 0) AS tong_tien,
                    COALESCE(SUM(ct.so_luong), 0) AS tong_so_phan
             FROM don_hang d
             LEFT JOIN chi_tiet_don ct ON ct.don_hang_id = d.id
             WHERE d.nguoi_dung_id = :uid
             GROUP BY d.id, d.trang_thai, d.ngay_dat
             ORDER BY d.id DESC'
        );
        $stmt->execute(['uid' => $nguoiDungId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function layChiTietCuaNguoiDung(int $donHangId, int $nguoiDungId): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT id, trang_thai, ngay_dat FROM don_hang
             WHERE id = :id AND nguoi_dung_id = :uid LIMIT 1'
        );
        $stmt->execute(['id' => $donHangId, 'uid' => $nguoiDungId]);
        $don = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$don) {
            return null;
        }
        $chiTiet = $this->db->prepare(
            'SELECT ct.mon_an_id, m.slug, m.ten, ct.so_luong, ct.don_gia,
                    ct.so_luong * ct.don_gia AS thanh_tien
             FROM chi_tiet_don ct
             INNER JOIN mon_an m ON m.id = ct.mon_an_id
             WHERE ct.don_hang_id = :id
             ORDER BY ct.mon_an_id'
        );
        $chiTiet->execute(['id' => $donHangId]);
        $don['cac_mon'] = $chiTiet->fetchAll(PDO::FETCH_ASSOC);
        return $don;
    }

    /** Danh sách tất cả đơn hàng cho quản trị viên. */
    public function layDanhSachQuanTri(int $gioiHan = 100): array
    {
        $gioiHan = max(1, min(200, $gioiHan));
        $stmt = $this->db->prepare(
            'SELECT d.id, d.nguoi_dung_id, u.ho_ten, u.email, d.trang_thai, d.ngay_dat,
                    COALESCE(SUM(ct.so_luong * ct.don_gia), 0) AS tong_tien,
                    COALESCE(SUM(ct.so_luong), 0) AS tong_so_phan
             FROM don_hang d
             INNER JOIN nguoi_dung u ON u.id = d.nguoi_dung_id
             LEFT JOIN chi_tiet_don ct ON ct.don_hang_id = d.id
             GROUP BY d.id, d.nguoi_dung_id, u.ho_ten, u.email, d.trang_thai, d.ngay_dat
             ORDER BY d.id DESC LIMIT :gioi_han'
        );
        $stmt->bindValue(':gioi_han', $gioiHan, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Chỉ cho phép chuyển trạng thái hợp lệ.
     * Hủy sẽ hoàn kho đúng một lần, trong cùng transaction.
     */
    public function capNhatTrangThai(int $idDon, string $trangThaiMoi): void
    {
        if ($idDon < 1) {
            throw new DomainException('Mã đơn không hợp lệ.');
        }
        $chuyenHopLe = [
            'cho_xac_nhan' => ['da_xac_nhan', 'da_huy'],
            'da_xac_nhan' => ['hoan_thanh', 'da_huy'],
            'da_huy' => [],
            'hoan_thanh' => [],
        ];
        if (!in_array($trangThaiMoi, ['da_xac_nhan', 'da_huy', 'hoan_thanh'], true)) {
            throw new DomainException('Trạng thái được chọn không hợp lệ.');
        }

        $this->db->beginTransaction();
        try {
            // Khóa dòng đơn: hai yêu cầu hủy cùng lúc không thể hoàn kho hai lần.
            $stmt = $this->db->prepare(
                'SELECT trang_thai FROM don_hang WHERE id = :id FOR UPDATE'
            );
            $stmt->execute(['id' => $idDon]);
            $trangThaiCu = $stmt->fetchColumn();
            if ($trangThaiCu === false) {
                throw new DomainException('Đơn hàng không tồn tại.');
            }
            if (!in_array($trangThaiMoi, $chuyenHopLe[$trangThaiCu] ?? [], true)) {
                throw new DomainException('Không thể chuyển trạng thái đơn hàng từ '
                    . $trangThaiCu . ' sang ' . $trangThaiMoi . '.');
            }

            if ($trangThaiMoi === 'da_huy') {
                $layChiTiet = $this->db->prepare(
                    'SELECT mon_an_id, so_luong FROM chi_tiet_don WHERE don_hang_id = :id'
                );
                $layChiTiet->execute(['id' => $idDon]);
                $hoanKho = $this->db->prepare(
                    'UPDATE mon_an SET ton_kho = ton_kho + :so_luong WHERE id = :id'
                );
                foreach ($layChiTiet->fetchAll(PDO::FETCH_ASSOC) as $dong) {
                    $hoanKho->execute([
                        'so_luong' => (int) $dong['so_luong'],
                        'id' => (int) $dong['mon_an_id'],
                    ]);
                    if ($hoanKho->rowCount() !== 1) {
                        throw new RuntimeException('Không hoàn được tồn kho vì món ăn không tồn tại.');
                    }
                }
            }

            $doiTrangThai = $this->db->prepare(
                'UPDATE don_hang SET trang_thai = :trang_thai WHERE id = :id'
            );
            $doiTrangThai->execute(['trang_thai' => $trangThaiMoi, 'id' => $idDon]);
            if ($doiTrangThai->rowCount() !== 1) {
                throw new RuntimeException('Không cập nhật được trạng thái đơn hàng.');
            }
            $this->db->commit();
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }
    }
}
