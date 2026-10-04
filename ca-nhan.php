<?php
// 1. Khai báo tiêu đề trang và CSS riêng (nếu có)
$pageTitle = "Trang cá nhân | Cook with me";

// 2. Nhúng Header và Nav từ thư mục includes/
require_once 'includes/header.php';
require_once 'includes/nav.php';

// 3. (Tùy chọn) Kiểm tra đăng nhập ở Server-side:
// Nếu người dùng chưa đăng nhập thì chuyển hướng về trang đăng nhập
if (!isset($_SESSION['user'])) {
    // Để phục vụ test giao diện, bạn có thể tạm comment dòng header redirect này
    // header('Location: dang-nhap.php');
    // exit;
}
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
// 4. Khai báo JS riêng cho trang cá nhân (nằm trong mục js/trang-ca-nhan.js)
$customJS = 'js/trang-ca-nhan.js';

// 5. Nhúng Footer từ thư mục includes/
require_once 'includes/footer.php';
?>