<?php
/**
 * Tệp: inc/nav.php
 * Mục đích: Thanh điều hướng chính dùng chung cho các trang công khai.
 * Dùng bởi: inc/header.php
 * Biến đầu vào: $goc (string), $trang (string), $yeuThichService (YeuThichService|null)
 */

declare(strict_types=1);

// Gán giá trị mặc định để file không lỗi khi thiếu biến đầu vào
$goc   ??= '';
$trang ??= '';

/** @var \App\Services\YeuThichService|null $yeuThichService */
$yeuThichService ??= null;

// Tránh gọi phương thức trên null khi service chưa được truyền vào
$soYeuThich = $yeuThichService?->soLuong() ?? 0;

$menuChinh = [
    'index'        => 'Trang chủ',
    'danh-sach'    => 'Khám phá',
    'goi-y-mon-an' => 'Gợi ý món ăn',
    'cai-dat'      => 'Cài đặt',
    'gioi-thieu'   => 'Giới thiệu',
    'lien-he'      => 'Liên hệ',
];
?>
<nav class="thanh-dieu-huong" aria-label="Điều hướng chính">
    <ul class="menu">
        <?php foreach ($menuChinh as $tep => $nhan): ?>
            <?php $dangChon = ($tep === $trang); ?>
            <li>
                <a
                    href="<?= e($goc . $tep . '.php') ?>"
                    class="icon-<?= e($tep) ?><?= $dangChon ? ' dang-chon' : '' ?>"
                    <?= $dangChon ? 'aria-current="page"' : '' ?>
                ><?= e($nhan) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="khu-vuc-yeu-thich">
        <a href="<?= e($goc) ?>yeu-thich.php" class="nhan-yeu-thich">Yêu thích</a>
        <span class="so-luong-yeu-thich" role="status" aria-label="Số món ăn yêu thích">
            <?= $soYeuThich ?>
        </span>
    </div>
</nav>