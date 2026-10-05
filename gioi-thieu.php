<?php
// 1. PHẦN XỬ LÝ LÝ THUYẾT / LOGIC (Không echo)
require __DIR__ . '/inc/config.php';

use App\Data\KhoMonAn; // (Nếu trang cần lấy dữ liệu món ăn)

// Thực hiện khai báo dữ liệu, lấy danh sách từ JSON
$kho      = new KhoMonAn(__DIR__ . '/data/mon-an.json');
$danhSach = $kho->tatCa(); 

// Thiết lập thông số header
$tieuDe   = 'Giới thiệu'; 
$trang    = 'gioi-thieu'; // Đánh dấu class active trên Menu (ví dụ: 'index', 'danh-sach', 'lien-he'...)

// Nhúng Header (đã bao gồm Nav)
require __DIR__ . '/inc/header.php';
?>


  <!-- NỘI DUNG CHÍNH (GIAO DIỆN MỚI CHUẨN MẪU) -->
  <main class="gioi-thieu-trang">

    <h1 class="tieu-de-gioi-thieu">
      Giới thiệu Cook with me
    </h1>

    <!-- KHỐI HERO -->
    <section class="hero-gioi-thieu-mau">
      <div class="hero-text">
        <h2 class="tieu-de-slogan">
          Cùng nhau<br>lan tỏa niềm vui nấu ăn!
        </h2>

        <p class="mo-ta-hero">
          Cook with me là nền tảng chia sẻ công thức nấu ăn, khám phá món ngon và kết nối cộng đồng những người yêu ẩm thực. Tại đây, bạn có thể tìm kiếm, học hỏi, chia sẻ và lưu giữ những công thức yêu thích của mình.
        </p>
      </div>

      <div class="hero-image-wrapper">
        <img src="images/mi-quang.jpg" alt="Món ăn ngon Cook with me" class="hero-img">
        <span class="badge-yeu-thuong">
          Nấu ăn là yêu thương ♡
        </span>
      </div>
    </section>


    <!-- HÀNG 1: MỤC ĐÍCH & TÍNH NĂNG NỔI BẬT (CHIA 2 CỘT) -->
    <div class="gioi-thieu-grid-2col">

      <section class="card-muc-dich">
        <h2 class="tieu-de-card icon-target">
          Mục đích
        </h2>

        <ul>
          <li>Giúp người dùng dễ dàng tìm kiếm và khám phá món ăn, thức uống và nguyên liệu.</li>
          <li>Cung cấp công thức nấu ăn chi tiết, dễ thực hiện.</li>
          <li>Kết nối cộng đồng những người yêu ẩm thực.</li>
          <li>Hỗ trợ người dùng với chức năng "Tủ lạnh của tôi – Hôm nay ăn gì?".</li>
        </ul>
      </section>

      <section class="card-tinh-nang">
        <h2 class="tieu-de-card icon-star">
          Tính năng nổi bật
        </h2>

        <ul>
          <li>Hệ thống phân loại món ăn, thức uống, thực phẩm.</li>
          <li>Tìm kiếm theo nguyên liệu, thời gian, ngẫu nhiên.</li>
          <li>Chia sẻ công thức, hình ảnh, video.</li>
          <li>Tương tác: like, bình luận, chia sẻ, lưu món.</li>
          <li>Cá nhân hóa theo sở thích người dùng.</li>
        </ul>
      </section>

    </div>


    <!-- HÀNG 2: ĐỘI NGŨ PHÁT TRIỂN & LIÊN HỆ (CỘT RỘNG - CỘT HẸP) -->
    <div class="gioi-thieu-grid-doi-ngu">

      <section class="card-doi-ngu">
        <h2 class="tieu-de-card icon-users">
          Đội ngũ phát triển
        </h2>

        <ul class="danh-sach-thanh-vien">
          <li class="the-thanh-vien thanh-vien-1">
            <a href="thanhvien/3120224045_baohan/gioithieu.php">
              <img src="images/avatar-baohan.jpg" alt="Phan Thị Bảo Hân" class="avatar-thanh-vien">
              <h3>Phan Thị Bảo Hân</h3>
              <p>Trưởng nhóm</p>
            </a>
          </li>

          <li class="the-thanh-vien thanh-vien-2">
            <a href="thanhvien/3120224155_trinh/gioithieu.php">
              <img src="images/avatar-trinh.jpg" alt="Nguyễn Thị Trinh" class="avatar-thanh-vien">
              <h3>Nguyễn Thị Trinh</h3>
              <p>Lập trình viên</p>
            </a>
          </li>

          <li class="the-thanh-vien thanh-vien-3">
            <a href="thanhvien/3120224013_binh/gioithieu.php">
              <img src="images/avatar-binh.jpg" alt="Nguyễn Thị Ngọc Bình" class="avatar-thanh-vien">
              <h3>Nguyễn Thị Ngọc Bình</h3>
              <p>Thiết kế giao diện</p>
            </a>
          </li>

          <li class="the-thanh-vien thanh-vien-4">
            <a href="thanhvien/3120224096_lena/gioithieu.php">
              <img src="images/avatar-lena.jpg" alt="Lê Thị A Na" class="avatar-thanh-vien">
              <h3>Lê Thị A Na</h3>
              <p>Kiểm thử</p>
            </a>
          </li>
        </ul>
      </section>

      <!-- KHỐI LIÊN HỆ -->
      <section class="card-lien-he">
        <h2 class="tieu-de-card icon-phone">
          Liên hệ
        </h2>

        <ul class="danh-sach-lien-he">
          <li>
            <img src="images/icons/email.svg" alt="Email" class="icon-contact-img">
            <strong>Email:</strong> cookwithme@gmail.com
          </li>
          <li>
            <img src="images/icons/phone.svg" alt="SĐT" class="icon-contact-img">
            <strong>SĐT:</strong> 0123 456 789
          </li>
          <li>
            <img src="images/icons/location.svg" alt="Địa chỉ" class="icon-contact-img">
            <strong>Địa chỉ:</strong> Đại học Sư phạm - Đại học Đà Nẵng
          </li>
        </ul>

        <!-- BỔ SUNG ĐOẠN NÀY ĐỂ HIỂN THỊ CÁC NÚT MẠNG XÃ HỘI -->
        <div class="mang-xa-hoi-gioi-thieu">
          <a href="#" title="Facebook">
            <img src="images/icons/social-facebook.svg" alt="Facebook" class="icon-svg-social">
          </a>
          <a href="#" title="Instagram">
            <img src="images/icons/social-instagram.svg" alt="Instagram" class="icon-svg-social">
          </a>
          <a href="#" title="YouTube">
            <img src="images/icons/social-youtube.svg" alt="YouTube" class="icon-svg-social">
          </a>
          <a href="#" title="TikTok">
            <img src="images/icons/social-tiktok.svg" alt="TikTok" class="icon-svg-social">
          </a>
        </div>
      </section>

    </div>

  </main>


  <?php
require __DIR__ . '/inc/footer.php';
?>