<?php
/**
 * Tệp: inc/nav-quan-tri.php
 * Mục đích: Menu điều hướng của khu vực quản trị, nằm trong sidebar của quan-tri.php.
 * Dùng bởi: quan-tri.php
 * Biến đầu vào: $mucQuanTri (string): khóa của mục đang mở, mặc định 'tong-quan'.
 * Ghi chú: Mục có href '#' là chỗ giữ chỗ, chưa có trang thật.
 */

declare(strict_types=1);

$mucQuanTri ??= 'tong-quan';

$menuQuanTri = [
    'tong-quan'  => ['quan-tri.php', '🏠', 'Tổng quan'],
    'nguoi-dung' => ['#', '👥', 'Quản lý người dùng'],
    'mon-an'     => ['#', '🍲', 'Quản lý món ăn'],
    'danh-muc'   => ['#', '📋', 'Quản lý danh mục'],
    'binh-luan'  => ['#', '📝', 'Quản lý bình luận'],
    'thong-ke'   => ['#thong-ke-hoat-dong', '🔍', 'Thống kê'],
    'cai-dat'    => ['cai-dat.php', '⚙️', 'Cài đặt'],
    'trang-chu'  => ['index.php', '🌐', 'Về trang chủ'],
    'dang-xuat'  => ['dang-xuat.php', '⎋', 'Đăng xuất'],
];
?>
<nav class="menu-dieu-huong-quan-tri" aria-label="Điều hướng quản trị">
    <?php foreach ($menuQuanTri as $ma => [$href, $bieuTuong, $nhan]): ?>
        <?php $dangChon = ($ma === $mucQuanTri); ?>
        <?php if ($ma === 'dang-xuat'): ?>
        <button type="submit" form="form-dang-xuat-toan-cuc" class="item-menu-qt">
            <span aria-hidden="true"><?= e($bieuTuong) ?></span><?= e($nhan) ?>
        </button>
        <?php else: ?>
        <a
            href="<?= e($href) ?>"
            class="item-menu-qt<?= $dangChon ? ' active' : '' ?>"
            <?= $dangChon ? 'aria-current="page"' : '' ?>
        >
            <span aria-hidden="true"><?= e($bieuTuong) ?></span>
            <?= e($nhan) ?>
        </a>
        <?php endif; ?>
    <?php endforeach; ?>
</nav>