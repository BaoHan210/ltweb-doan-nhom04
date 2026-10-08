<?php
// 1. Tự động kiểm tra và khởi tạo Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../src/Services/YeuThichService.php';

use App\Services\YeuThichService;

$yeuThichService = new YeuThichService();

$goc   = $goc ?? (defined('URL_GOC') ? URL_GOC : '');
$trang ??= '';

$menu = [
    'index'         => 'Trang chủ',
    'danh-sach'     => 'Khám phá',
    'goi-y-mon-an'  => 'Gợi ý món ăn',
    'cai-dat'       => 'Cài đặt',
    'gioi-thieu'    => 'Giới thiệu',
    'lien-he'       => 'Liên hệ'
];

$mapClass = [
    'index'        => 'trang-trang-chu',
    'danh-sach'    => 'trang-kham-pha',
    'chi-tiet'     => 'trang-chi-tiet',
    'goi-y-mon-an' => 'trang-goi-y',
    'cai-dat'      => 'cai-dat-trang',
    'gioi-thieu'   => 'trang-gioi-thieu',
    'lien-he'      => 'lien-he-trang',
    'quan-tri'     => 'trang-quan-tri'
];
$bodyClass = $mapClass[$trang ?? ''] ?? ('trang-' . ($trang ?? ''));

// 2. LẤY SESSION NGƯỜI DÙNG ĐÃ ĐĂNG NHẬP
$userHeader = $_SESSION['user'] 
           ?? $_SESSION['nguoi_dung'] 
           ?? $_SESSION['account'] 
           ?? $_SESSION['auth'] 
           ?? null;

// Kiểm tra trạng thái đăng nhập
$isLoggedIn = !empty($userHeader);

// Đường dẫn Avatar an toàn
$duongDanAvatar = $goc . 'images/icons/avt-default.svg';
if (is_array($userHeader) && !empty($userHeader['avatar'])) {
    if (strpos($userHeader['avatar'], 'http') === 0) {
        $duongDanAvatar = $userHeader['avatar'];
    } else {
        $duongDanAvatar = $goc . ltrim($userHeader['avatar'], '/');
    }
}
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
<body class="trang <?= $bodyClass ?>">

  <header class="dau-trang">
    <p class="thuong-hieu">
      <a href="<?= $goc ?>index.php" class="lien-ket-logo">
        <img src="<?= $goc ?>images/icons/chef.svg" alt="Cook with me" class="logo-icon">
        <span class="khoi-chu-logo">
          <span class="ten-website">Cook with me</span>
          <span class="slogan">Khơi nguồn cảm hứng vào bếp</span>
        </span>
      </a>
    </p>

    <form class="o-tim-kiem" action="<?= $goc ?>danh-sach.php" method="get">
      <label for="search">Tìm kiếm</label>
      <input type="search" id="search" name="keyword" placeholder="Tìm kiếm món ăn..." autocomplete="off">
      <button class="nut" type="submit">Tìm kiếm</button>
    </form>

    <div class="khu-vuc-tai-khoan">
      <?php if ($isLoggedIn): ?>
        <!-- ĐÃ ĐĂNG NHẬP: Hiển thị Chuông + Avatar + Menu sổ xuống -->
        <div class="khu-vuc-nguoi-dung-logged">
          
          <!-- Khối Chuông Thông Báo Dropdown -->
          <div class="khoi-thong-bao-header">
            <button type="button" class="nut-thong-bao" id="nut-thong-bao-header" aria-label="Thông báo">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2e6230" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
              </svg>
              <span class="cham-thong-bao"></span>
            </button>

            <!-- Bảng thông báo thả xuống -->
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
                <a href="<?= $goc ?>thong-bao.php" class="link-xem-tat-ca-tb">Xem tất cả thông báo</a>
              </div>
            </div>
          </div>

          <!-- Khối Avatar + Menu -->
          <div class="khoi-avatar-header">
            <img src="<?= e($duongDanAvatar) ?>" alt="Avatar" class="avatar-header" onerror="this.onerror=null; this.src='<?= $goc ?>images/icons/avt-default.svg';">
            
            <svg class="mui-ten-down-svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#4A5568" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="6 9 12 15 18 9"></polyline>
            </svg>

            <!-- Menu sổ xuống -->
            <div class="menu-drop-tai-khoan">
              <a href="<?= $goc ?>ca-nhan.php" class="item-menu-drop">Trang cá nhân</a>
              <a href="<?= $goc ?>quan-tri.php" class="item-menu-drop">Trang quản trị</a>
              <a href="<?= $goc ?>cai-dat.php" class="item-menu-drop">Cài đặt</a>
              <a href="<?= $goc ?>dang-xuat.php" class="item-menu-drop nut-dang-xuat-drop">Đăng xuất</a>
            </div>
          </div>

        </div>
      <?php else: ?>
        <!-- CHƯA ĐĂNG NHẬP -->
        <a href="<?= $goc ?>dang-ky.php" class="nut nut-phu">Đăng ký</a>
        <a href="<?= $goc ?>dang-nhap.php" class="nut">Đăng nhập</a>
      <?php endif; ?>
    </div>
  </header>

  <!-- Thanh điều hướng ngang -->
  <nav class="thanh-dieu-huong" aria-label="Điều hướng chính">
    <ul class="menu">
      <?php foreach ($menu as $tep => $nhan): ?>
        <li>
          <a 
            href="<?= $goc . $tep ?>.php" 
            class="icon-<?= $tep ?> <?= $tep === 'chi-tiet' ? 'menu-chi-tiet icon-chi-tiet' : '' ?> <?= $tep === $trang ? 'dang-chon' : '' ?>"
            <?= $tep === $trang ? 'aria-current="page"' : '' ?>
          >
            <?= e($nhan) ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="khu-vuc-yeu-thich">
  <a href="<?= $goc ?>yeu-thich.php" class="nhan-yeu-thich">
    Yêu thích
  </a>

  <span class="so-luong-yeu-thich" role="status" aria-label="Số món ăn yêu thích">
    <?= $yeuThichService->soLuong() ?>
</span>
</div>
  </nav>