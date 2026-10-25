<?php

namespace App\Data;

use App\Models\MonAn;
use PDO;

class KhoMonAn
{
    public function __construct(private PDO $db)
    {
    }

    /**
     * Chuyển một bản ghi món ăn sang đối tượng MonAn.
     */
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
     * Nạp nguyên liệu và bước nấu cho danh sách món.
     * Dùng truy vấn theo nhóm, tránh N+1 queries.
     *
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

            // ID số trong MySQL dùng để JOIN.
            // Slug vẫn là ID ngoài giao diện.
            $monTheoId[(int)$dong['id']] = $mon;
        }

        $cacId = array_keys($monTheoId);

        $dauHoi = implode(
            ', ',
            array_fill(0, count($cacId), '?')
        );

        // =====================================
        // 1. TRUY VẤN NGUYÊN LIỆU
        // =====================================

        $sqlNguyenLieu = "
            SELECT
                mnl.mon_an_id,
                nl.ten AS ten_nguyen_lieu,
                mnl.so_luong
            FROM mon_an_nguyen_lieu AS mnl
            INNER JOIN nguyen_lieu AS nl
                ON nl.id = mnl.nguyen_lieu_id
            WHERE mnl.mon_an_id IN ($dauHoi)
            ORDER BY mnl.mon_an_id, mnl.nguyen_lieu_id
        ";

        $stmt = $this->db->prepare($sqlNguyenLieu);
        $stmt->execute($cacId);

        $cacNguyenLieu = $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );

        foreach ($cacNguyenLieu as $dong) {
            $idMon = (int)$dong['mon_an_id'];

            if (!isset($monTheoId[$idMon])) {
                continue;
            }

            $monTheoId[$idMon]->nguyenLieu[] = [
                'ten' => (string)$dong['ten_nguyen_lieu'],
                'soLuong' => (string)($dong['so_luong'] ?? '')
            ];
        }

        // =====================================
        // 2. TRUY VẤN CÁC BƯỚC NẤU
        // =====================================

        $sqlBuocNau = "
            SELECT
                mon_an_id,
                thu_tu,
                noi_dung
            FROM buoc_nau
            WHERE mon_an_id IN ($dauHoi)
            ORDER BY mon_an_id, thu_tu
        ";

        $stmt = $this->db->prepare($sqlBuocNau);
        $stmt->execute($cacId);

        $cacBuoc = $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );

        foreach ($cacBuoc as $dong) {
            $idMon = (int)$dong['mon_an_id'];

            if (!isset($monTheoId[$idMon])) {
                continue;
            }

            $monTheoId[$idMon]->cacBuoc[] =
                (string)$dong['noi_dung'];
        }

        return $danhSach;
    }

    /**
     * Lấy toàn bộ món ăn.
     *
     * @return MonAn[]
     */
    public function layTatCa(): array
    {
        $sql = "
            SELECT
                m.*,
                d.ten AS danh_muc
            FROM mon_an AS m
            INNER JOIN danh_muc AS d
                ON d.id = m.danh_muc_id
            ORDER BY m.id
        ";

        $stmt = $this->db->query($sql);

        return $this->taoDanhSach(
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    /**
     * Tìm kiếm theo từ khóa và danh mục.
     *
     * @return MonAn[]
     */
    public function timKiem(
        string $tuKhoa = '',
        string $danhMuc = ''
    ): array {
        $sql = "
            SELECT
                m.*,
                d.ten AS danh_muc
            FROM mon_an AS m
            INNER JOIN danh_muc AS d
                ON d.id = m.danh_muc_id
            WHERE 1 = 1
        ";

        $params = [];

        if (trim($tuKhoa) !== '') {
            $sql .= "
                AND (
                    m.ten LIKE :ten
                    OR m.mo_ta LIKE :mo_ta
                )
            ";

            $params['ten'] = '%' . trim($tuKhoa) . '%';
            $params['mo_ta'] = '%' . trim($tuKhoa) . '%';
        }

        if ($danhMuc !== '') {
            $sql .= " AND d.ten = :danh_muc";
            $params['danh_muc'] = $danhMuc;
        }

        $sql .= " ORDER BY m.id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $this->taoDanhSach(
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    /**
     * Tìm một món ăn theo slug.
     */
    public function timTheoId(string $id): ?MonAn
    {
        $sql = "
            SELECT
                m.*,
                d.ten AS danh_muc
            FROM mon_an AS m
            INNER JOIN danh_muc AS d
                ON d.id = m.danh_muc_id
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
}
