<?php
// 1. PHẦN XỬ LÝ LÝ THUYẾT / LOGIC (Không echo)
require __DIR__ . '/inc/config.php';

use App\Data\KhoMonAn; // (Nếu trang cần lấy dữ liệu món ăn)

// Thực hiện khai báo dữ liệu, lấy danh sách từ JSON
$kho      = new KhoMonAn(__DIR__ . '/data/mon-an.json');
$danhSach = $kho->tatCa(); 

// Thiết lập thông số header
$tieuDe   = 'Trang cá nhân'; 
$trang    = 'ca-nhan'; // Đánh dấu class active trên Menu (ví dụ: 'index', 'danh-sach', 'lien-he'...)
$customJS = 'js/trang-ca-nhan.js'; // Nạp JS riêng (nếu có)

// Nhúng Header (đã bao gồm Nav)
require __DIR__ . '/inc/header.php';
?>

  <main class="ca-nhan-trang">

<section class="khung-ca-nhan">

  <!-- Ảnh bìa -->
  <div class="anh-bia-ca-nhan">

    <img
      src="images/cao-lau.jpg"
      alt="Ảnh bìa trang cá nhân"
    >

  </div>


  <!-- Thông tin cá nhân -->
  <section class="thong-tin-ca-nhan">

    <div class="anh-dai-dien-ca-nhan">

      <span class="chu-cai-dai-dien">
        U
      </span>

    </div>


    <div class="noi-dung-ca-nhan">

      <h1 class="ten-nguoi-dung">
        Người dùng
      </h1>

      <p class="email-nguoi-dung">
        email@example.com
      </p>

      <p class="mo-ta-nguoi-dung">
        Người yêu thích nấu ăn
      </p>

    </div>


    <a
      href="cai-dat.php"
      class="nut nut-chinh-sua-ca-nhan"
    >
      Chỉnh sửa
    </a>

  </section>


  <!-- Thống kê -->
  <section class="thong-ke-ca-nhan">

    <div class="thong-ke-item">

      <strong class="so-bai-dang">
        0
      </strong>

      <span>
        Bài đăng
      </span>

    </div>


    <div class="thong-ke-item">

      <strong>
        128
      </strong>

      <span>
        Theo dõi
      </span>

    </div>


    <div class="thong-ke-item">

      <strong>
        96
      </strong>

      <span>
        Đang theo dõi
      </span>

    </div>

  </section>


  <!-- Các tab -->
  <div class="cac-tab-ca-nhan">

    <button
      type="button"
      class="tab-ca-nhan dang-chon"
    >
      Công thức của tôi
    </button>

    <button
      type="button"
      class="tab-ca-nhan"
    >
      Món đã lưu
    </button>

  </div>


  <!-- Công thức của tôi -->
  <section class="khu-vuc-cong-thuc-ca-nhan">

    <div class="tieu-de-cong-thuc-ca-nhan">

      <h2>
        Công thức của tôi
      </h2>

      <a
        href="dang-bai-viet.php"
        class="nut nut-dang-bai"
      >
        Đăng bài viết
      </a>

    </div>


    <div class="danh-sach-bai-viet-cua-toi"></div>

  </section>


  <!-- Món đã lưu -->
  <section
    class="khu-vuc-mon-da-luu"
    hidden
  >

    <h2>
      Món đã lưu
    </h2>

    <p class="thong-bao-mon-da-luu">
      Các món ăn bạn đã lưu sẽ được hiển thị ở đây.
    </p>

  </section>

</section>

  </main>

  <footer>

<p>
  &copy; 2026 Cook with me - Nhóm 04
</p>


<nav aria-label="Điều hướng phụ">

  <ul class="menu">

    <li>
      <a href="gioi-thieu.php">
        Giới thiệu
      </a>
    </li>

    <li>
      <a href="lien-he.php">
        Liên hệ
      </a>
    </li>

  </ul>

</nav>

  <?php
// 4. Nhúng Footer từ thư mục includes/
require_once 'inc/footer.php';
?>