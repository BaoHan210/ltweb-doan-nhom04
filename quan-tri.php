<?php
require_once __DIR__ . '/inc/bao-ve.php'; // Bắt buộc phải đăng nhập

$danhSachPhanHoi = [];
$tepLog = __DIR__ . '/storage/lien-he.jsonl';

if (is_file($tepLog)) {
    $dong = file($tepLog, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($dong as $d) {
        $data = json_decode($d, true);
        if (is_array($data)) {
            array_unshift($danhSachPhanHoi, $data); // Đọc định dạng JSON (Mới nhất xếp trước)
        } else {
            // Trường hợp file log lưu bằng chuỗi text thuần
            array_unshift($danhSachPhanHoi, [
                'ngay_gui' => 'N/A',
                'ho_ten'   => 'Khách',
                'email'    => 'N/A',
                'noi_dung' => $d,
                'anh'      => ''
            ]);
        }
    }
}

$tieuDe = 'Trang quản trị liên hệ';
$trang = 'quan-tri';
require_once __DIR__ . '/inc/header.php';

// Lấy thông tin người quản trị đang đăng nhập
$tenAdmin = $_SESSION['user']['ho_ten'] ?? ($_SESSION['user'] ?? 'Quản trị viên');
?>

<main class="noi-dung-chinh container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Trang Quản trị - Danh sách Thư liên hệ đã nhận</h1>
        <p class="mb-0 text-muted">Xin chào, <strong><?= e($tenAdmin) ?></strong>!</p>
    </div>
    
    <?php if (function_exists('hien_thi_thong_bao')): ?>
        <?= hien_thi_thong_bao() ?>
    <?php endif; ?>

    <?php if (empty($danhSachPhanHoi)): ?>
        <p class="alert alert-info">Chưa có thư liên hệ nào trong hệ thống.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table border="1" cellpadding="8" cellspacing="0" style="width:100%; border-collapse:collapse; margin-top: 15px;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th style="width: 15%;">Thời gian</th>
                        <th style="width: 18%;">Họ tên</th>
                        <th style="width: 20%;">Email</th>
                        <th>Nội dung</th>
                        <th style="width: 12%;">Ảnh đính kèm</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($danhSachPhanHoi as $lh): ?>
                        <tr>
                            <td><?= e($lh['ngay_gui'] ?? 'N/A') ?></td>
                            <td><strong><?= e($lh['ho_ten'] ?? 'Chưa nhập') ?></strong></td>
                            <td><a href="mailto:<?= e($lh['email'] ?? '') ?>"><?= e($lh['email'] ?? '') ?></a></td>
                            <td>
                                <div style="white-space: pre-wrap; word-break: break-word;">
                                    <?= e($lh['noi_dung'] ?? '') ?>
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <?php if (!empty($lh['anh'])): ?>
                                    <a href="uploads/<?= e($lh['anh']) ?>" target="_blank" title="Xem ảnh gốc">
                                        <img src="uploads/<?= e($lh['anh']) ?>" alt="Ảnh đính kèm" width="80" style="border-radius: 4px; object-fit: cover;">
                                    </a>
                                <?php else: ?>
                                    <span style="color: #888;">Không có</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>