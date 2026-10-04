<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta
    name="description"
    content="Cook with me là mạng xã hội chia sẻ và khám phá công thức nấu ăn dành cho những người yêu thích ẩm thực."
  >

  <!-- Đổi tiêu đề động theo từng trang -->
  <title><?php echo isset($pageTitle) ? $pageTitle : 'Cook with me'; ?></title>

  <link rel="stylesheet" href="css/01-bien.css">
  <link rel="stylesheet" href="css/02-chuan-hoa.css">
  <link rel="stylesheet" href="css/03-bo-cuc.css">
  <link rel="stylesheet" href="css/04-thanh-phan.css">
  <link rel="stylesheet" href="css/05-tien-ich.css">

  <?php if (isset($customCSS)): ?>
    <link rel="stylesheet" href="<?php echo $customCSS; ?>">
  <?php endif; ?>
</head>

<body class="trang <?php echo isset($bodyClass) ? $bodyClass : ''; ?>">

  <header class="dau-trang">

    <p class="thuong-hieu">
      <!-- Icon mũ đầu bếp bên trái -->
      <img src="images/icons/chef.svg" alt="Cook with me" class="logo-icon">

      <!-- Khối chữ bên phải -->
      <span class="khoi-chu-logo">
        <span class="ten-website">Cook with me</span>
        <span class="slogan">Khơi nguồn cảm hứng vào bếp</span>
      </span>
    </p>

    <!-- Đã sửa action sang danh-sach.php -->
    <form class="o-tim-kiem" action="danh-sach.php" method="get">
      <label for="search">Tìm kiếm</label>
      <input type="search" id="search" name="keyword" placeholder="Tìm kiếm món ăn, công thức..." autocomplete="off">
      <button class="nut" type="submit">Tìm kiếm</button>
    </form>

    <div class="khu-vuc-tai-khoan">
      <?php if (isset($_SESSION['user'])): ?>
        <a href="ca-nhan.php" class="lien-ket-ca-nhan">
          Xin chào, <strong><?php echo htmlspecialchars($_SESSION['user']['hoTen']); ?></strong>
        </a>
        <a href="dang-xuat.php" class="nut nut-dang-xuat">Đăng xuất</a>
      <?php else: ?>
        <a href="dang-nhap.php" class="nut nut-dang-nhap">Đăng nhập / Đăng ký</a>
      <?php endif; ?>
    </div>

  </header>