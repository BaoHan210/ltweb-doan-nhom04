<?php
/**
 * Tệp: inc/header.php
 * Mục đích: Phần đầu trang dùng chung: logo, tìm kiếm, khu vực tài khoản và thanh điều hướng.
 *           Trên trang quản trị, thanh điều hướng công khai được ẩn vì sidebar quản trị thay vị trí.
 * Dùng bởi: các trang công khai, trang quản trị và trang cá nhân thành viên.
 * Biến đầu vào: $tieuDe (string), $trang (string), $goc (string, tùy chọn), $cssRieng (string, tùy chọn)
 */

declare(strict_types=1);

require_once __DIR__ . '/../src/Services/YeuThichService.php';

use App\Services\YeuThichService;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$yeuThichService = new YeuThichService();

$goc   = $goc ?? (defined('URL_GOC') ? URL_GOC : '');
$trang ??= '';

// Class cho <body>, gắn theo từng trang
$mapClass = [
    'index'        => 'trang-trang-chu',
    'danh-sach'    => 'trang-kham-pha',
    'chi-tiet'     => 'trang-chi-tiet',
    'goi-y-mon-an' => 'trang-goi-y',
    'cai-dat'      => 'cai-dat-trang',
    'gioi-thieu'   => 'trang-gioi-thieu',
    'lien-he'      => 'lien-he-trang',
    'quan-tri'     => 'trang-quan-tri',
];
$bodyClass = $mapClass[$trang] ?? ('trang-' . $trang);

// Người dùng đăng nhập
$userHeader = $_SESSION['user']
    ?? $_SESSION['nguoi_dung']
    ?? $_SESSION['account']
    ?? $_SESSION['auth']
    ?? null;

$isLoggedIn = !empty($userHeader);

// Đường dẫn avatar
$duongDanAvatar = $goc . 'images/icons/avt-default.svg';

if (is_array($userHeader) && !empty($userHeader['avatar'])) {
    $avatar         = (string) $userHeader['avatar'];
    $duongDanAvatar = str_starts_with($avatar, 'http')
        ? $avatar
        : $goc . ltrim($avatar, '/');
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($tieuDe ?? 'Cook with me') ?> | Cook with me</title>

  <link rel="stylesheet" href="<?= e($goc) ?>css/01-bien.css">
  <link rel="stylesheet" href="<?= e($goc) ?>css/02-chuan-hoa.css">
  <link rel="stylesheet" href="<?= e($goc) ?>css/03-bo-cuc.css">
  <link rel="stylesheet" href="<?= e($goc) ?>css/04-thanh-phan.css">
  <link rel="stylesheet" href="<?= e($goc) ?>css/05-tien-ich.css">

  <?php if (!empty($cssRieng)): ?>
    <link rel="stylesheet" href="<?= e((string) $cssRieng) ?>">
  <?php endif; ?>
</head>

<body class="trang <?= e($bodyClass) ?><?= $trang === 'quan-tri' ? ' trang-quan-tri-body' : '' ?>">

  <header class="dau-trang">
    <p class="thuong-hieu">
      <a href="<?= e($goc) ?>index.php" class="lien-ket-logo">
        <img src="<?= e($goc) ?>images/icons/chef.svg" alt="Cook with me" class="logo-icon">
        <span class="khoi-chu-logo">
          <span class="ten-website">Cook with me</span>
          <span class="slogan">Khơi nguồn cảm hứng vào bếp</span>
        </span>
      </a>
    </p>

    <form class="o-tim-kiem" action="<?= e($goc) ?>danh-sach.php" method="get">
      <label for="search">Tìm kiếm</label>
      <input type="search" id="search" name="keyword" placeholder="Tìm kiếm món ăn..." autocomplete="off">
      <button class="nut" type="submit">Tìm kiếm</button>
    </form>

    <div class="khu-vuc-tai-khoan">
      <?php if ($isLoggedIn): ?>

        <div class="khu-vuc-nguoi-dung-logged">

          <!-- Chuông thông báo -->
          <div class="khoi-thong-bao-header">
            <button type="button" class="nut-thong-bao" id="nut-thong-bao-header" aria-label="Thông báo">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2e6230" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
              </svg>
              <span class="cham-thong-bao"></span>
            </button>

            <div class="bang-thong-bao-drop" id="bang-thong-bao-drop">
              <div class="tieu-de-bang-tb">
                <strong>Thông báo</strong>
                <a href="#">Đánh dấu đã đọc</a>
              </div>
              <ul class="danh-sach-thong-bao">
                <li class="item-thong-bao chua-doc">
                  <p>Minh Anh đã thích công thức món ăn của bạn.</p>
                  <span class="thoi-gian-tb">5 phút trước</span>
                </li>
                <li class="item-thong-bao chua-doc">
                  <p>Gợi ý món ăn mới trong tuần đã được cập nhật!</p>
                  <span class="thoi-gian-tb">1 giờ trước</span>
                </li>
              </ul>
              <div class="chan-bang-tb">
                <a href="<?= e($goc) ?>thong-bao.php" class="link-xem-tat-ca-tb">Xem tất cả thông báo</a>
              </div>
            </div>
          </div>

          <!-- Avatar và menu tài khoản -->
          <div class="khoi-avatar-header">
            <img
              src="<?= e($duongDanAvatar) ?>"
              alt="Ảnh đại diện"
              class="avatar-header"
              onerror="this.onerror=null; this.src='<?= e($goc) ?>images/icons/avt-default.svg';"
            >

            <svg class="mui-ten-down-svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#4A5568" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="6 9 12 15 18 9"></polyline>
            </svg>

            <div class="menu-drop-tai-khoan">
              <a href="<?= e($goc) ?>ca-nhan.php" class="item-menu-drop">Trang cá nhân</a>
              <a href="<?= e($goc) ?>quan-tri.php" class="item-menu-drop">Trang quản trị</a>
              <a href="<?= e($goc) ?>cai-dat.php" class="item-menu-drop">Cài đặt</a>
              <a href="<?= e($goc) ?>dang-xuat.php" class="item-menu-drop nut-dang-xuat-drop">Đăng xuất</a>
            </div>
          </div>

        </div>

      <?php else: ?>

        <a href="<?= e($goc) ?>dang-ky.php" class="nut nut-phu">Đăng ký</a>
        <a href="<?= e($goc) ?>dang-nhap.php" class="nut">Đăng nhập</a>

      <?php endif; ?>
    </div>
  </header>

  <?php if ($trang !== 'quan-tri'): ?>
    <?php require __DIR__ . '/nav.php'; ?>
  <?php endif; ?>