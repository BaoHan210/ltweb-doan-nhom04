<?php
// Biến $goc hỗ trợ đường dẫn tương đối khi trang nằm trong thư mục con (ví dụ thanhvien/...)
$goc   ??= '';
$trang ??= '';

$menu = [
    'index'         => 'Trang chủ',
    'danh-sach'     => 'Khám phá',
    'goi-y-mon-an'  => 'Gợi ý món ăn',
    'cai-dat'       => 'Cài đặt',
    'gioi-thieu'    => 'Giới thiệu',
    'lien-he'       => 'Liên hệ'
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($tieuDe ?? 'Cook with me') ?> | Cook with me</title>
  
  <link rel="stylesheet" href="<?= $goc ?>css/01-bien.css">
  <link rel="stylesheet" href="<?= $goc ?>css/02-chuan-hoa.css">
  <link rel="stylesheet" href="<?= $goc ?>css/03-bo-cuc.css">
  <link rel="stylesheet" href="<?= $goc ?>css/04-thanh-phan.css">
  <link rel="stylesheet" href="<?= $goc ?>css/05-tien-ich.css">
</head>
<body class="trang">

  <header class="dau-trang">
    <p class="thuong-hieu">
      <img src="<?= $goc ?>images/icons/chef.svg" alt="Cook with me" class="logo-icon">
      <span class="khoi-chu-logo">
        <span class="ten-website">Cook with me</span>
        <span class="slogan">Khơi nguồn cảm hứng vào bếp</span>
      </span>
    </p>

    <form class="o-tim-kiem" action="<?= $goc ?>danh-sach.php" method="get">
      <label for="search">Tìm kiếm</label>
      <input type="search" id="search" name="keyword" placeholder="Tìm kiếm món ăn..." autocomplete="off">
      <button class="nut" type="submit">Tìm kiếm</button>
    </form>

    <div class="khu-vuc-tai-khoan">
      <?php if (isset($_SESSION['user'])): ?>
        <a href="<?= $goc ?>ca-nhan.php">Xin chào, <strong><?= e($_SESSION['user']['hoTen'] ?? $_SESSION['user']) ?></strong></a>
        <a href="<?= $goc ?>dang-xuat.php" class="nut">Đăng xuất</a>
      <?php else: ?>
        <a href="<?= $goc ?>dang-nhap.php" class="nut">Đăng nhập</a>
      <?php endif; ?>
    </div>
  </header>

  <nav class="thanh-dieu-huong" aria-label="Điều hướng chính">
    <ul class="menu">
      <?php foreach ($menu as $tep => $nhan): ?>
        <li>
          <a href="<?= $goc . $tep ?>.php" <?= $tep === $trang ? 'class="dang-chon" aria-current="page"' : '' ?>>
            <?= e($nhan) ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>