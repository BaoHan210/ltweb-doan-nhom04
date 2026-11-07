<?php
/**
 * Tệp: src/Data/KhoLanDiCho.php
 * Mục đích: Chốt danh sách đi chợ thành một lần đi chợ (giao dịch), xem lịch sử,
 * và quản trị trạng thái. Thay thế KhoDonHang (chức năng 5).
 */
declare(strict_types=1);

namespace App\Data;

use DomainException;
use PDO;
use RuntimeException;
use Throwable;

final class KhoLanDiCho
{
    /** Bước chuyển trạng thái hợp lệ: trạng thái cũ => các trạng thái mới được phép. */
    private const CHUYEN_HOP_LE = [
        'moi'       => ['da_di_cho', 'da_huy'],
        'da_di_cho' => [],
        'da_huy'    => [],
    ];

    public function __construct(private PDO $db)
    {
    }

    /**
     * Chốt danh sách đi chợ hiện tại của người dùng thành một lần đi chợ.
     * Các bước (ghi lần, chép món, xóa danh sách) cùng thành công hoặc cùng bị hủy.
     *
     * @return int id lần đi chợ vừa tạo
     */
    public function chot(int $nguoiDungId): int
    {
        if ($nguoiDungId < 1) {
            throw new DomainException('Bạn cần đăng nhập để chốt danh sách.');
        }

        $this->db->beginTransaction();
        try {
            // Khóa dòng danh sách của người dùng: hai lần chốt đồng thời không chồng nhau.
            $st = $this->db->prepare(
                'SELECT id FROM danh_sach_di_cho WHERE nguoi_dung_id = ? FOR UPDATE'
            );
            $st->execute([$nguoiDungId]);
            $idDanhSach = $st->fetchColumn();
            if ($idDanhSach === false) {
                throw new DomainException('Danh sách đi chợ đang trống.');
            }

            $dem = $this->db->prepare(
                'SELECT COUNT(*) FROM chi_tiet_di_cho WHERE danh_sach_id = ?'
            );
            $dem->execute([$idDanhSach]);
            if ((int) $dem->fetchColumn() === 0) {
                throw new DomainException('Danh sách đi chợ đang trống.');
            }

            $this->db->prepare('INSERT INTO lan_di_cho (nguoi_dung_id) VALUES (?)')
                ->execute([$nguoiDungId]);
            $idLan = (int) $this->db->lastInsertId();

            // Chép bản chụp: tên món và ngân sách lấy tại thời điểm chốt.
            $this->db->prepare(
                'INSERT INTO chi_tiet_lan_di_cho
                    (lan_id, mon_an_id, ten_mon, so_suat, ngan_sach_tham_khao)
                 SELECT ?, ct.mon_an_id, m.ten, ct.so_suat, m.ngan_sach
                 FROM chi_tiet_di_cho ct
                 INNER JOIN mon_an m ON m.id = ct.mon_an_id
                 WHERE ct.danh_sach_id = ?'
            )->execute([$idLan, $idDanhSach]);

            // Làm trống danh sách đang dùng.
            $this->db->prepare('DELETE FROM chi_tiet_di_cho WHERE danh_sach_id = ?')
                ->execute([$idDanhSach]);

            $this->db->commit();
            return $idLan;
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }
    }

    /**
     * Lịch sử đi chợ của một người dùng, mới nhất trước.
     * Mỗi dòng có số món, tổng số suất và tổng ngân sách tham khảo.
     */
    public function lichSu(int $nguoiDungId): array
    {
        $st = $this->db->prepare(
            'SELECT l.id, l.ngay_chot, l.trang_thai,
                    COUNT(c.mon_an_id) AS so_mon,
                    COALESCE(SUM(c.so_suat), 0) AS tong_so_suat,
                    COALESCE(SUM(c.so_suat * c.ngan_sach_tham_khao), 0) AS tong_ngan_sach
             FROM lan_di_cho l
             LEFT JOIN chi_tiet_lan_di_cho c ON c.lan_id = l.id
             WHERE l.nguoi_dung_id = ?
             GROUP BY l.id, l.ngay_chot, l.trang_thai
             ORDER BY l.id DESC'
        );
        $st->execute([$nguoiDungId]);
        return $st->fetchAll();
    }

    /**
     * Chi tiết một lần đi chợ. Điều kiện nguoi_dung_id giữ cho người khác không xem được.
     * Trả về null nếu không tìm thấy hoặc không thuộc người dùng này.
     */
    public function chiTiet(int $lanId, int $nguoiDungId): ?array
    {
        $st = $this->db->prepare(
            'SELECT id, ngay_chot, trang_thai
             FROM lan_di_cho
             WHERE id = ? AND nguoi_dung_id = ?
             LIMIT 1'
        );
        $st->execute([$lanId, $nguoiDungId]);
        $lan = $st->fetch();
        if ($lan === false) {
            return null;
        }

        $ct = $this->db->prepare(
            'SELECT mon_an_id, ten_mon, so_suat, ngan_sach_tham_khao
             FROM chi_tiet_lan_di_cho
             WHERE lan_id = ?
             ORDER BY ten_mon'
        );
        $ct->execute([$lanId]);
        $lan['cac_mon'] = $ct->fetchAll();
        return $lan;
    }

    /** Danh sách mọi lần đi chợ cho quản trị viên, mới nhất trước. */
    public function danhSachQuanTri(int $gioiHan = 100): array
    {
        $gioiHan = max(1, min(200, $gioiHan));
        $st = $this->db->prepare(
            'SELECT l.id, l.ngay_chot, l.trang_thai, u.ho_ten, u.email,
                    COUNT(c.mon_an_id) AS so_mon,
                    COALESCE(SUM(c.so_suat), 0) AS tong_so_suat,
                    COALESCE(SUM(c.so_suat * c.ngan_sach_tham_khao), 0) AS tong_ngan_sach
             FROM lan_di_cho l
             INNER JOIN nguoi_dung u ON u.id = l.nguoi_dung_id
             LEFT JOIN chi_tiet_lan_di_cho c ON c.lan_id = l.id
             GROUP BY l.id, l.ngay_chot, l.trang_thai, u.ho_ten, u.email
             ORDER BY l.id DESC
             LIMIT :gioi'
        );
        $st->bindValue(':gioi', $gioiHan, PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll();
    }

    /**
     * Đổi trạng thái theo bước hợp lệ. Dùng cả điều kiện trạng thái cũ trong UPDATE
     * và kiểm tra rowCount(), nên bấm đúp không đổi hai lần.
     */
    public function capNhatTrangThai(int $lanId, string $trangThaiMoi): void
    {
        if ($lanId < 1) {
            throw new DomainException('Mã lần đi chợ không hợp lệ.');
        }
        if (!in_array($trangThaiMoi, ['da_di_cho', 'da_huy'], true)) {
            throw new DomainException('Trạng thái được chọn không hợp lệ.');
        }

        $this->db->beginTransaction();
        try {
            $st = $this->db->prepare('SELECT trang_thai FROM lan_di_cho WHERE id = ? FOR UPDATE');
            $st->execute([$lanId]);
            $trangThaiCu = $st->fetchColumn();
            if ($trangThaiCu === false) {
                throw new DomainException('Lần đi chợ không tồn tại.');
            }
            if (!in_array($trangThaiMoi, self::CHUYEN_HOP_LE[$trangThaiCu] ?? [], true)) {
                throw new DomainException(
                    'Không thể chuyển từ "' . $trangThaiCu . '" sang "' . $trangThaiMoi . '".'
                );
            }

            $up = $this->db->prepare(
                'UPDATE lan_di_cho SET trang_thai = ? WHERE id = ? AND trang_thai = ?'
            );
            $up->execute([$trangThaiMoi, $lanId, $trangThaiCu]);
            if ($up->rowCount() !== 1) {
                throw new RuntimeException('Không cập nhật được trạng thái lần đi chợ.');
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
