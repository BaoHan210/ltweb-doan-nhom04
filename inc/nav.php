<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav class="thanh-dieu-huong" aria-label="Điều hướng chính">

    <ul class="menu">

      <li>
        <a class="icon-trang-chu <?php echo ($currentPage === 'index.php') ? 'dang-chon' : ''; ?>" href="index.php">
          Trang chủ
        </a>
      </li>

      <li>
        <a class="icon-kham-pha <?php echo ($currentPage === 'danh-sach.php') ? 'dang-chon' : ''; ?>" href="danh-sach.php">
          Khám phá
        </a>
      </li>

      <li>
        <a class="menu-chi-tiet icon-chi-tiet <?php echo ($currentPage === 'chi-tiet.php') ? 'dang-chon' : ''; ?>" href="chi-tiet.php">
          Chi tiết công thức
        </a>
      </li>

      <li>
        <a class="icon-goi-y <?php echo ($currentPage === 'goi-y-mon-an.php') ? 'dang-chon' : ''; ?>" href="goi-y-mon-an.php">
          Gợi ý món ăn
        </a>
      </li>

      <li>
        <a class="icon-cai-dat <?php echo ($currentPage === 'cai-dat.php') ? 'dang-chon' : ''; ?>" href="cai-dat.php">
          Cài đặt
        </a>
      </li>

      <li>
        <a class="icon-gioi-thieu <?php echo ($currentPage === 'gioi-thieu.php') ? 'dang-chon' : ''; ?>" href="gioi-thieu.php">
          Giới thiệu
        </a>
      </li>

      <li>
        <a class="icon-lien-he <?php echo ($currentPage === 'lien-he.php') ? 'dang-chon' : ''; ?>" href="lien-he.php">
          Liên hệ
        </a>
      </li>

    </ul>

    <div class="khu-vuc-yeu-thich">
  <a href="yeu-thich.php" class="nhan-yeu-thich">
    Yêu thích
  </a>

  <span
    class="so-luong-yeu-thich"
    role="status"
    aria-label="Số món ăn yêu thích"
  >
    0
  </span>
</div>

</nav>