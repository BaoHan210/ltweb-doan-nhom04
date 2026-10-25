
<?php
// Cong cu tam de chuyen mon-an.json thanh SQL.
// Chay bang PHP CLI, khong dung tren website cong khai.

$duongDan = __DIR__ . '/../data/mon-an.json';

$noiDung = file_get_contents($duongDan);
$dsMon = json_decode($noiDung, true, 512, JSON_THROW_ON_ERROR);

function sqlChuoi(string $giaTri): string
{
    return "'" . str_replace("'", "''", $giaTri) . "'";
}

$sql = "-- Du lieu mon an tu mon-an.json\n";
$sql .= "SET NAMES utf8mb4;\n";
$sql .= "USE ltweb_nhom04;\n\n";

$stt = 1;

foreach ($dsMon as $mon) {
    $ten = sqlChuoi((string) $mon['ten']);
    $slug = sqlChuoi((string) $mon['id']);
    $danhMuc = sqlChuoi((string) $mon['danhMuc']);

    $thoiGian = (int) $mon['thoiGian'];
    $khauPhan = (int) $mon['khauPhan'];
    $doKho = sqlChuoi((string) $mon['doKho']);
    $nganSach = (int) $mon['nganSach'];
    $hinhAnh = sqlChuoi((string) $mon['hinhAnh']);
    $moTa = sqlChuoi((string) ($mon['moTa'] ?? ''));

    $sql .= "INSERT INTO mon_an
        (id, slug, danh_muc_id, ten, thoi_gian,
         khau_phan, do_kho, ngan_sach, ton_kho,
         hinh_anh, mo_ta)
        VALUES (
          $stt,
          $slug,
          (SELECT id FROM danh_muc WHERE ten = $danhMuc),
          $ten,
          $thoiGian,
          $khauPhan,
          $doKho,
          $nganSach,
          10,
          $hinhAnh,
          $moTa
        );\n\n";

    $stt++;
}

file_put_contents(__DIR__ . '/mon-an-seed.sql', $sql);

echo "Da tao SQL cho " . count($dsMon) . " mon an.\n";
