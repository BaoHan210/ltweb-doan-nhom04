<?php
declare(strict_types=1);

/*
 * Import các bước nấu từ JSON sang MySQL.
 * Chỉ dùng một lần khi chuyển dữ liệu Bài 5 -> Bài 6.
 */

// Công cụ bảo trì: chỉ cho phép chạy qua PHP CLI.
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Chỉ được chạy lệnh import bằng Terminal.');
}

require_once __DIR__ . '/inc/db.php';

header('Content-Type: text/plain; charset=utf-8');

$tepJson = __DIR__ . '/data/mon-an.json';

if (!is_file($tepJson)) {
    exit("LỖI: Không tìm thấy data/mon-an.json");
}

$noiDung = file_get_contents($tepJson);
$duLieu = json_decode($noiDung, true);

if (!is_array($duLieu)) {
    exit("LỖI: File JSON không hợp lệ.");
}

$pdo = db();

$soMon = 0;
$soBuoc = 0;
$soMonBoQua = 0;

try {
    $pdo->beginTransaction();

    // Tra cứu ID số bằng slug.
    $timMon = $pdo->prepare(
        'SELECT id FROM mon_an WHERE slug = :slug LIMIT 1'
    );

    // Kiểm tra tránh nhập trùng bước nấu.
    $demBuoc = $pdo->prepare(
        'SELECT COUNT(*) FROM buoc_nau WHERE mon_an_id = :mon_id'
    );

    // Thêm bước nấu.
    $themBuoc = $pdo->prepare(
        'INSERT INTO buoc_nau (mon_an_id, thu_tu, noi_dung)
         VALUES (:mon_id, :thu_tu, :noi_dung)'
    );

    foreach ($duLieu as $mon) {
        if (!is_array($mon)) {
            continue;
        }

        $slug = $mon['id'] ?? '';
        $cacBuoc = $mon['cacBuoc'] ?? [];

        if (!is_string($slug) || $slug === '') {
            continue;
        }

        if (!is_array($cacBuoc) || $cacBuoc === []) {
            continue;
        }

        $timMon->execute(['slug' => $slug]);
        $monId = $timMon->fetchColumn();

        if ($monId === false) {
            echo "Không tìm thấy món trong MySQL: {$slug}\n";
            $soMonBoQua++;
            continue;
        }

        $demBuoc->execute(['mon_id' => $monId]);

        if ((int)$demBuoc->fetchColumn() > 0) {
            echo "Đã có bước nấu, bỏ qua: {$slug}\n";
            $soMonBoQua++;
            continue;
        }

        $thuTu = 1;

        foreach ($cacBuoc as $noiDungBuoc) {
            if (!is_string($noiDungBuoc)) {
                continue;
            }

            $noiDungBuoc = trim($noiDungBuoc);

            if ($noiDungBuoc === '') {
                continue;
            }

            $themBuoc->execute([
                'mon_id' => $monId,
                'thu_tu' => $thuTu,
                'noi_dung' => $noiDungBuoc
            ]);

            $soBuoc++;
            $thuTu++;
        }

        if ($thuTu > 1) {
            $soMon++;
        }
    }

    $pdo->commit();

    echo "\n===== KẾT QUẢ IMPORT =====\n";
    echo "Số món được nhập bước nấu: {$soMon}\n";
    echo "Số bước nấu được thêm: {$soBuoc}\n";
    echo "Số món bỏ qua: {$soMonBoQua}\n";
    echo "Hoàn thành!\n";

} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    http_response_code(500);
    echo "Import thất bại, dữ liệu đã được rollback.\n";
    echo "Lỗi: " . $e->getMessage();
}
