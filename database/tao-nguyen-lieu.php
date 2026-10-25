
<?php
// Chuyen nguyen lieu tu JSON sang SQL.
// Tach ten nguyen lieu va so luong.

$path = __DIR__ . '/../data/mon-an.json';

$dsMon = json_decode(
    file_get_contents($path),
    true,
    512,
    JSON_THROW_ON_ERROR
);

// Chuyen chuoi thanh gia tri SQL
function giaTriSql(string $s): string
{
    return "'" . str_replace(
        ["\\", "'"],
        ["\\\\", "''"],
        $s
    ) . "'";
}

// Tach ten nguyen lieu va dinh luong
function tachNguyenLieu(string $chuoi): array
{
    $chuoi = trim($chuoi);

    $mau = '/^(\d+(?:[.,]\d+)?(?:\/\d+)?'
         . '(?:\s*[-–]\s*\d+(?:[.,]\d+)?)?'
         . '\s*(?:kg|g|ml|l|bát|bìa|cái|quả|trái|củ|'
         . 'tép|nhánh|con|bó|lá|miếng|viên|'
         . 'thìa(?:\s+(?:canh|cà\s+phê))?|'
         . 'muỗng(?:\s+(?:canh|cà\s+phê))?))'
         . '\s+(.+)$/ui';

    if (preg_match($mau, $chuoi, $matches)) {
        return [
            trim($matches[2]),
            trim($matches[1])
        ];
    }

    return [$chuoi, 'Không ghi rõ'];
}

// Khoi tao noi dung SQL
$sql = "-- Nguyen lieu da tach ten va so luong\n";
$sql .= "SET NAMES utf8mb4;\n";
$sql .= "USE ltweb_nhom04;\n\n";

$soLienKet = 0;
$soDaTach = 0;
$soCanKiemTra = 0;

// Duyet danh sach mon an
foreach ($dsMon as $i => $mon) {
    $monId = $i + 1;

    foreach ($mon['nguyenLieu'] ?? [] as $nl) {
        $chuoi = trim((string) ($nl['ten'] ?? ''));

        if ($chuoi === '') {
            continue;
        }

        [$ten, $soLuong] = tachNguyenLieu($chuoi);

        // Thong ke ket qua tach dinh luong
        if ($soLuong !== 'Không ghi rõ') {
            $soDaTach++;
        } elseif (preg_match('/\d/u', $chuoi)) {
            $soCanKiemTra++;
            echo "Can kiem tra: $chuoi\n";
        }

        $tenSql = giaTriSql($ten);
        $soLuongSql = giaTriSql($soLuong);

        // Them nguyen lieu neu chua ton tai
        $sql .= "INSERT IGNORE INTO nguyen_lieu (ten) "
              . "VALUES ($tenSql);\n";

        // Lien ket mon an va nguyen lieu
        $sql .= "INSERT IGNORE INTO mon_an_nguyen_lieu "
              . "(mon_an_id, nguyen_lieu_id, so_luong) "
              . "SELECT $monId, id, $soLuongSql "
              . "FROM nguyen_lieu "
              . "WHERE ten = $tenSql;\n\n";

        $soLienKet++;
    }
}

// Tao file SQL moi, khong ghi de file cu
file_put_contents(
    __DIR__ . '/nguyen-lieu-seed-moi.sql',
    $sql
);

// Hien thi ket qua
echo "\nTong nguyen lieu: $soLienKet\n";
echo "Da tach dinh luong: $soDaTach\n";
echo "Can kiem tra: $soCanKiemTra\n";
echo "Da tao nguyen-lieu-seed-moi.sql\n";
