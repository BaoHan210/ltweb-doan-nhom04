<?php

namespace App\Data;

use App\Models\MonAn;
use PDO;

class KhoMonAn
{
    public function __construct(private PDO $db)
    {
    }

    /** Chuyển bản ghi MySQL thành đối tượng món ăn. */
    private function chuyenMonAn(array $dong): MonAn
    {
        return MonAn::tuMang([
            'id' => $dong['slug'],
            'ten' => $dong['ten'],
            'danhMuc' => $dong['danh_muc'],
            'thoiGian' => $dong['thoi_gian'],
            'khauPhan' => $dong['khau_phan'],
            'doKho' => $dong['do_kho'],
            'nganSach' => $dong['ngan_sach'],
            'hinhAnh' => $dong['hinh_anh'] ?? '',
            'danhGia' => $dong['danh_gia'] ?? 0,
            'soLuotDanhGia' => $dong['so_luot_danh_gia'] ?? 0,
            'moTa' => $dong['mo_ta'] ?? '',
            'nguyenLieu' => [],
            'cacBuoc' => [],
            'video' => $dong['video'] ?? ''
        ]);
    }

    /**
     * Nạp nguyên liệu và các bước nấu theo nhóm ID, tránh N+1 queries.
     * @return MonAn[]
     */
    private function taoDanhSach(array $cacDong): array
    {
        if ($cacDong === []) {
            return [];
        }

        $danhSach = [];
        $monTheoId = [];

        foreach ($cacDong as $dong) {
            $mon = $this->chuyenMonAn($dong);
            $danhSach[] = $mon;
            $monTheoId[(int) $dong['id']] = $mon;
        }

        $cacId = array_keys($monTheoId);
        $dauHoi = implode(', ', array_fill(0, count($cacId), '?'));

        $sqlNguyenLieu = "
            SELECT mnl.mon_an_id, nl.ten AS ten_nguyen_lieu, mnl.so_luong
            FROM mon_an_nguyen_lieu AS mnl
            INNER JOIN nguyen_lieu AS nl ON nl.id = mnl.nguyen_lieu_id
            WHERE mnl.mon_an_id IN ($dauHoi)
            ORDER BY mnl.mon_an_id, mnl.nguyen_lieu_id
        ";

        $stmt = $this->db->prepare($sqlNguyenLieu);
        $stmt->execute($cacId);

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $dong) {
            $idMon = (int) $dong['mon_an_id'];
            if (!isset($monTheoId[$idMon])) {
                continue;
            }
            $monTheoId[$idMon]->nguyenLieu[] = [
                'ten' => (string) $dong['ten_nguyen_lieu'],
                'soLuong' => (string) ($dong['so_luong'] ?? '')
            ];
        }

        $sqlBuocNau = "
            SELECT mon_an_id, thu_tu, noi_dung
            FROM buoc_nau
            WHERE mon_an_id IN ($dauHoi)
            ORDER BY mon_an_id, thu_tu
        ";

        $stmt = $this->db->prepare($sqlBuocNau);
        $stmt->execute($cacId);

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $dong) {
            $idMon = (int) $dong['mon_an_id'];
            if (!isset($monTheoId[$idMon])) {
                continue;
            }
            $monTheoId[$idMon]->cacBuoc[] = (string) $dong['noi_dung'];
        }

        return $danhSach;
    }

    /** @return MonAn[] */
    public function layTatCa(): array
    {
        $sql = "
            SELECT m.*, d.ten AS danh_muc
            FROM mon_an AS m
            INNER JOIN danh_muc AS d ON d.id = m.danh_muc_id
            ORDER BY m.id
        ";
        $stmt = $this->db->query($sql);
        return $this->taoDanhSach($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /** Phương thức cũ, giữ tương thích các trang hiện tại. @return MonAn[] */
    public function timKiem(string $tuKhoa = '', string $danhMuc = ''): array
    {
        $sql = "
            SELECT m.*, d.ten AS danh_muc
            FROM mon_an AS m
            INNER JOIN danh_muc AS d ON d.id = m.danh_muc_id
            WHERE 1 = 1
        ";
        $params = [];

        if (trim($tuKhoa) !== '') {
            $sql .= ' AND (m.ten LIKE :ten OR m.mo_ta LIKE :mo_ta)';
            // Escape ky tu dai dien LIKE de tu khoa %, _ duoc tim theo nghia den.
            $mau = '%' . addcslashes(trim($tuKhoa), '%_\\') . '%';
            $params['ten'] = $mau;
            $params['mo_ta'] = $mau;
        }
        if ($danhMuc !== '') {
            $sql .= ' AND d.ten = :danh_muc';
            $params['danh_muc'] = $danhMuc;
        }
        $sql .= ' ORDER BY m.id';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $this->taoDanhSach($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function timTheoId(string $id): ?MonAn
    {
        $sql = "
            SELECT m.*, d.ten AS danh_muc
            FROM mon_an AS m
            INNER JOIN danh_muc AS d ON d.id = m.danh_muc_id
            WHERE m.slug = :slug
            LIMIT 1
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $id]);
        $dong = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($dong === false) {
            return null;
        }
        $danhSach = $this->taoDanhSach([$dong]);
        return $danhSach[0] ?? null;
    }

    /** @return MonAn[] */
    public function layMoiNhat(int $gioiHan = 3): array
    {
        $gioiHan = max(1, min(20, $gioiHan));
        $sql = "
            SELECT m.*, d.ten AS danh_muc
            FROM mon_an AS m
            INNER JOIN danh_muc AS d ON d.id = m.danh_muc_id
            ORDER BY m.id DESC
            LIMIT :gioi_han
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':gioi_han', $gioiHan, PDO::PARAM_INT);
        $stmt->execute();
        return $this->taoDanhSach($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * Tìm nhiều món bằng một truy vấn WHERE IN theo slug.
     * @param string[] $cacSlug
     * @return MonAn[]
     */
    public function timNhieuTheoSlug(array $cacSlug): array
    {
        $cacSlug = array_values(array_unique(array_filter(
            array_map(static fn($id) => trim((string) $id), $cacSlug),
            static fn($id) => $id !== ''
        )));
        if ($cacSlug === []) {
            return [];
        }
        $dauHoi = implode(', ', array_fill(0, count($cacSlug), '?'));
        $sql = "
            SELECT m.*, d.ten AS danh_muc
            FROM mon_an AS m
            INNER JOIN danh_muc AS d ON d.id = m.danh_muc_id
            WHERE m.slug IN ($dauHoi)
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($cacSlug);
        $ketQua = $this->taoDanhSach($stmt->fetchAll(PDO::FETCH_ASSOC));
        $theoSlug = [];
        foreach ($ketQua as $mon) {
            $theoSlug[$mon->id] = $mon;
        }
        $daSapXep = [];
        foreach ($cacSlug as $slug) {
            if (isset($theoSlug[$slug])) {
                $daSapXep[] = $theoSlug[$slug];
            }
        }
        return $daSapXep;
    }

    /** @return MonAn[] */
    public function layCungDanhMuc(string $danhMuc, string $slugHienTai, int $gioiHan = 4): array
    {
        $gioiHan = max(1, min(20, $gioiHan));
        $sql = "
            SELECT m.*, d.ten AS danh_muc
            FROM mon_an AS m
            INNER JOIN danh_muc AS d ON d.id = m.danh_muc_id
            WHERE d.ten = :danh_muc AND m.slug <> :slug
            ORDER BY m.id DESC
            LIMIT :gioi_han
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':danh_muc', $danhMuc, PDO::PARAM_STR);
        $stmt->bindValue(':slug', $slugHienTai, PDO::PARAM_STR);
        $stmt->bindValue(':gioi_han', $gioiHan, PDO::PARAM_INT);
        $stmt->execute();
        return $this->taoDanhSach($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * Dựng WHERE từ các đoạn cố định và tham số rời, đúng slide 29.
     * @return array{0:string,1:array<int,int|string>}
     */
    private function boLocNangCao(string $tuKhoa, string $danhMuc, ?int $giaToiDa): array
    {
        $dieuKien = [];
        $thamSo = [];
        $tuKhoa = trim($tuKhoa);

        if ($tuKhoa !== '') {
            $mau = '%' . addcslashes($tuKhoa, '%_\\') . '%';
            $dieuKien[] = '(m.ten COLLATE utf8mb4_unicode_ci LIKE ? OR m.mo_ta COLLATE utf8mb4_unicode_ci LIKE ?)';
            $thamSo[] = $mau;
            $thamSo[] = $mau;
        }
        if ($danhMuc !== '') {
            $dieuKien[] = 'd.ten = ?';
            $thamSo[] = $danhMuc;
        }
        if ($giaToiDa !== null) {
            $dieuKien[] = 'm.ngan_sach <= ?';
            $thamSo[] = $giaToiDa;
        }

        return [$dieuKien ? ' WHERE ' . implode(' AND ', $dieuKien) : '', $thamSo];
    }

    /** Đếm số kết quả trước khi phân trang: SELECT COUNT(*). */
    public function demTimKiemNangCao(string $tuKhoa = '', string $danhMuc = '', ?int $giaToiDa = null): int
    {
        [$where, $thamSo] = $this->boLocNangCao($tuKhoa, $danhMuc, $giaToiDa);
        $sql = 'SELECT COUNT(*) FROM mon_an AS m INNER JOIN danh_muc AS d ON d.id = m.danh_muc_id' . $where;
        $stmt = $this->db->prepare($sql);
        $stmt->execute($thamSo);
        return (int) $stmt->fetchColumn();
    }

    /**
     * SQL tìm kiếm + ORDER BY an toàn + LIMIT/OFFSET, đúng slide 28–32.
     * @return MonAn[]
     */
    public function timKiemPhanTrang(
        string $tuKhoa = '',
        string $danhMuc = '',
        ?int $giaToiDa = null,
        string $sapXep = 'ten-az',
        int $trang = 1,
        int $soMonTrenTrang = 9
    ): array {
        [$where, $thamSo] = $this->boLocNangCao($tuKhoa, $danhMuc, $giaToiDa);

        $orderBy = match ($sapXep) {
            'ten-za'       => 'm.ten DESC, m.id DESC',
            'thoiGianTang' => 'm.thoi_gian ASC, m.id ASC',
            'danhGiaGiam'  => 'm.danh_gia DESC, m.id ASC',
            'nganSachTang' => 'm.ngan_sach ASC, m.id ASC',
            default        => 'm.ten ASC, m.id ASC',
        };

        $soMonTrenTrang = max(1, min(100, $soMonTrenTrang));
        $trang = max(1, $trang);
        $offset = ($trang - 1) * $soMonTrenTrang;
        $sql = 'SELECT m.*, d.ten AS danh_muc '
            . 'FROM mon_an AS m INNER JOIN danh_muc AS d ON d.id = m.danh_muc_id'
            . $where . ' ORDER BY ' . $orderBy . ' LIMIT ? OFFSET ?';

        $stmt = $this->db->prepare($sql);
        foreach ($thamSo as $viTri => $giaTri) {
            $stmt->bindValue($viTri + 1, $giaTri, is_int($giaTri) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->bindValue(count($thamSo) + 1, $soMonTrenTrang, PDO::PARAM_INT);
        $stmt->bindValue(count($thamSo) + 2, $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $this->taoDanhSach($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /** Đếm tổng số món ăn để tính số trang quản trị. */
    public function demTatCa(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM mon_an')->fetchColumn();
    }

    /** Đọc một trang món ăn (không nạp toàn bộ bảng vào PHP). @return MonAn[] */
    public function layTrangQuanTri(int $trang = 1, int $kichThuoc = 10): array
    {
        $trang = max(1, $trang);
        $kichThuoc = max(1, min(50, $kichThuoc));
        $offset = ($trang - 1) * $kichThuoc;
        $sql = 'SELECT m.*, d.ten AS danh_muc FROM mon_an m '
            . 'INNER JOIN danh_muc d ON d.id = m.danh_muc_id '
            . 'ORDER BY m.id DESC LIMIT ? OFFSET ?';
        $st = $this->db->prepare($sql);
        $st->bindValue(1, $kichThuoc, PDO::PARAM_INT);
        $st->bindValue(2, $offset, PDO::PARAM_INT);
        $st->execute();
        return $this->taoDanhSach($st->fetchAll(PDO::FETCH_ASSOC));
    }

    /** Các danh mục dùng cho biểu mẫu quản trị. */
    public function layDanhMucQuanTri(): array
    {
        return $this->db->query('SELECT id, ten FROM danh_muc ORDER BY ten')->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Thêm món ăn; trả về khóa chính vừa tạo. */
    public function themMonAn(array $duLieu): int
    {
        $sql = 'INSERT INTO mon_an
            (danh_muc_id, slug, ten, thoi_gian, khau_phan, do_kho, ngan_sach,
             hinh_anh, mo_ta, video)
            VALUES (:danh_muc_id, :slug, :ten, :thoi_gian, :khau_phan, :do_kho,
                    :ngan_sach, :hinh_anh, :mo_ta, :video)';
        $st = $this->db->prepare($sql);
        $st->execute([
            'danh_muc_id' => $duLieu['danh_muc_id'],
            'slug' => $duLieu['slug'],
            'ten' => $duLieu['ten'],
            'thoi_gian' => $duLieu['thoi_gian'],
            'khau_phan' => $duLieu['khau_phan'],
            'do_kho' => $duLieu['do_kho'],
            'ngan_sach' => $duLieu['ngan_sach'],
            'hinh_anh' => $duLieu['hinh_anh'],
            'mo_ta' => $duLieu['mo_ta'],
            'video' => $duLieu['video'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    /** Dữ liệu gốc từ MySQL để điền sẵn vào biểu mẫu sửa. */
    public function layDongQuanTriTheoId(int $id): ?array
    {
        $st = $this->db->prepare('SELECT * FROM mon_an WHERE id = ? LIMIT 1');
        $st->execute([$id]);
        $dong = $st->fetch(PDO::FETCH_ASSOC);
        return $dong === false ? null : $dong;
    }

    /** Cập nhật món ăn theo khóa chính số nguyên. */
    public function capNhatMonAn(int $id, array $d): bool
    {
        $sql = 'UPDATE mon_an SET
                    ten = :ten, slug = :slug, danh_muc_id = :danh_muc_id,
                    thoi_gian = :thoi_gian, khau_phan = :khau_phan,
                    do_kho = :do_kho, ngan_sach = :ngan_sach,
                    hinh_anh = :hinh_anh, mo_ta = :mo_ta, video = :video
                WHERE id = :id';
        $st = $this->db->prepare($sql);
        $st->execute([
            'ten' => $d['ten'], 'slug' => $d['slug'],
            'danh_muc_id' => (int) $d['danh_muc_id'],
            'thoi_gian' => (int) $d['thoi_gian'],
            'khau_phan' => (int) $d['khau_phan'],
            'do_kho' => $d['do_kho'],
            'ngan_sach' => (int) $d['ngan_sach'],
            'hinh_anh' => $d['hinh_anh'],
            'mo_ta' => $d['mo_ta'], 'video' => $d['video'],
            'id' => $id,
        ]);
        return $st->rowCount() > 0;
    }

    /** Xóa món theo slug; không truy vấn SQL trực tiếp tại trang giao diện. */
    public function xoaMonAnTheoSlug(string $slug): bool
    {
        $stmt = $this->db->prepare('DELETE FROM mon_an WHERE slug = :slug');
        $stmt->execute(['slug' => $slug]);
        return $stmt->rowCount() > 0;
    }

    /** Tìm bản ghi theo slug, dùng khi liên kết Sửa từ dashboard truyền slug. */
    public function layDongQuanTriTheoSlug(string $slug): ?array
    {
        $st = $this->db->prepare('SELECT * FROM mon_an WHERE slug = ? LIMIT 1');
        $st->execute([$slug]);
        $dong = $st->fetch(PDO::FETCH_ASSOC);
        return $dong === false ? null : $dong;
    }

}
