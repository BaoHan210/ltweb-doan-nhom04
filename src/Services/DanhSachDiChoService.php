<?php
/** Danh sách đi chợ lưu MySQL riêng theo UID, mỗi tài khoản có nhiều món. */
declare(strict_types=1);
namespace App\Services;

use App\Data\KhoMonAn;
use DomainException;
use PDO;
use Throwable;

final class DanhSachDiChoService
{
    public const SO_SUAT_TOI_DA = 10;
    public function __construct(private PDO $db, private int $uid)
    {
        if ($uid < 1) { throw new DomainException('Bạn cần đăng nhập.'); }
    }
    private function kiemTraSlug(string $slug): void
    {
        if (!preg_match('/^[a-z0-9-]{1,150}$/D', $slug)) {
            throw new DomainException('Mã món ăn không hợp lệ.');
        }
    }
    private function maMon(string $slug): int
    {
        $st = $this->db->prepare('SELECT id FROM mon_an WHERE slug = ? LIMIT 1');
        $st->execute([$slug]);
        $id = $st->fetchColumn();
        if ($id === false) { throw new DomainException('Món ăn không còn tồn tại.'); }
        return (int)$id;
    }
    /** Lấy hoặc tạo một danh sách cá nhân, tránh tình trạng tạo trùng khi gửi 2 POST. */
    private function maDanhSach(): int
    {
        $st = $this->db->prepare('INSERT INTO danh_sach_di_cho (nguoi_dung_id) VALUES (?) ON DUPLICATE KEY UPDATE id = LAST_INSERT_ID(id)');
        $st->execute([$this->uid]);
        return (int)$this->db->lastInsertId();
    }
    public function them(string $slug, int $soSuat = 1): void
    {
        $this->kiemTraSlug($slug);
        if ($soSuat < 1 || $soSuat > self::SO_SUAT_TOI_DA) { throw new DomainException('Số suất không hợp lệ.'); }
        $this->db->beginTransaction();
        try {
            $idMon = $this->maMon($slug);
            $idDS = $this->maDanhSach();
            $st = $this->db->prepare('INSERT INTO chi_tiet_di_cho (danh_sach_id, mon_an_id, so_suat) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE so_suat = LEAST(10, so_suat + VALUES(so_suat))');
            $st->execute([$idDS, $idMon, $soSuat]);
            $this->db->commit();
        } catch (Throwable $e) { if ($this->db->inTransaction()) $this->db->rollBack(); throw $e; }
    }
    public function capNhatSoLuong(string $slug, int $soSuat): bool
    {
        $this->kiemTraSlug($slug);
        if ($soSuat < 1 || $soSuat > self::SO_SUAT_TOI_DA) { return false; }
        $st = $this->db->prepare('UPDATE chi_tiet_di_cho ct INNER JOIN danh_sach_di_cho ds ON ds.id = ct.danh_sach_id INNER JOIN mon_an m ON m.id = ct.mon_an_id SET ct.so_suat = :so_suat WHERE ds.nguoi_dung_id = :uid AND m.slug = :slug');
        $st->execute(['so_suat'=>$soSuat,'uid'=>$this->uid,'slug'=>$slug]);
        // rowCount() = 0 cả khi giá trị không đổi; kiểm tra lại sự tồn tại.
        $q = $this->db->prepare('SELECT 1 FROM chi_tiet_di_cho ct INNER JOIN danh_sach_di_cho ds ON ds.id=ct.danh_sach_id INNER JOIN mon_an m ON m.id=ct.mon_an_id WHERE ds.nguoi_dung_id=? AND m.slug=? LIMIT 1');
        $q->execute([$this->uid, $slug]);
        return $q->fetchColumn() !== false;
    }
    public function xoa(string $slug): void
    {
        $this->kiemTraSlug($slug);
        $st = $this->db->prepare('DELETE ct FROM chi_tiet_di_cho ct INNER JOIN danh_sach_di_cho ds ON ds.id = ct.danh_sach_id INNER JOIN mon_an m ON m.id = ct.mon_an_id WHERE ds.nguoi_dung_id = ? AND m.slug = ?');
        $st->execute([$this->uid,$slug]);
    }
    public function xoaHet(): void
    {
        $st = $this->db->prepare('DELETE ct FROM chi_tiet_di_cho ct INNER JOIN danh_sach_di_cho ds ON ds.id = ct.danh_sach_id WHERE ds.nguoi_dung_id = ?');
        $st->execute([$this->uid]);
    }
    public function soLuong(): int
    {
        $st=$this->db->prepare('SELECT COUNT(*) FROM chi_tiet_di_cho ct INNER JOIN danh_sach_di_cho ds ON ds.id=ct.danh_sach_id WHERE ds.nguoi_dung_id=?');
        $st->execute([$this->uid]); return (int)$st->fetchColumn();
    }
    /** Lấy một câu SELECT và một WHERE IN cho thông tin món + nguyên liệu, không N+1. */
    public function layDanhSach(KhoMonAn $kho): array
    {
        $st=$this->db->prepare('SELECT m.slug, ct.so_suat FROM chi_tiet_di_cho ct INNER JOIN danh_sach_di_cho ds ON ds.id=ct.danh_sach_id INNER JOIN mon_an m ON m.id=ct.mon_an_id WHERE ds.nguoi_dung_id=? ORDER BY ct.mon_an_id DESC');
        $st->execute([$this->uid]); $dong=$st->fetchAll(PDO::FETCH_ASSOC);
        if (!$dong) return [];
        $monTheoSlug=[];
        foreach ($kho->timNhieuTheoSlug(array_column($dong,'slug')) as $mon) { $monTheoSlug[$mon->id]=$mon; }
        $ketQua=[];
        foreach ($dong as $d) { if(isset($monTheoSlug[$d['slug']])) $ketQua[]=['monAn'=>$monTheoSlug[$d['slug']], 'soLuong'=>(int)$d['so_suat']]; }
        return $ketQua;
    }
}
