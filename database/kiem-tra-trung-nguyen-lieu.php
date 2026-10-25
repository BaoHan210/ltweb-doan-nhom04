
<?php

require_once __DIR__ . '/tao-nguyen-lieu.php';

$dsTrung = [];
$tongTrung = 0;

foreach ($dsMon as $i => $mon) {
    $daCo = [];

    foreach ($mon['nguyenLieu'] ?? [] as $nl) {
        $chuoi = trim((string) ($nl['ten'] ?? ''));

        if ($chuoi === '') {
            continue;
        }

        [$ten, $soLuong] = tachNguyenLieu($chuoi);

        $khoa = mb_strtolower($ten, 'UTF-8');

        if (isset($daCo[$khoa])) {
            $tongTrung++;

            $dsTrung[] = [
                'mon' => $mon['ten'] ?? ('Mon ' . ($i + 1)),
                'nguyen_lieu' => $ten,
                'so_luong' => $soLuong
            ];
        } else {
            $daCo[$khoa] = true;
        }
    }
}

echo "So nguyen lieu trung trong cung mon: $tongTrung\n";

foreach ($dsTrung as $item) {
    echo $item['mon'] . ' | '
       . $item['nguyen_lieu'] . ' | '
       . $item['so_luong'] . "\n";
}
