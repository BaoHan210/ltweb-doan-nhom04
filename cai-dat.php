<?php
// 1. PHẦN XỬ LÝ LÝ THUYẾT / LOGIC (Không echo)
require __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/bao-ve.php';

use App\Data\KhoMonAn; // (Nếu trang cần lấy dữ liệu món ăn)

// Thực hiện khai báo dữ liệu, lấy danh sách từ JSON
$kho      = new KhoMonAn(__DIR__ . '/data/mon-an.json');
$danhSach = $kho->tatCa(); 

// Thiết lập thông số header
$tieuDe   = 'Cài đặt'; 
$trang    = 'cai-dat'; // Đánh dấu class active trên Menu (ví dụ: 'index', 'danh-sach', 'lien-he'...)
$customJS = 'js/trang-cai-dat.js'; // Nạp JS riêng (nếu có)

// Nhúng Header (đã bao gồm Nav)
require __DIR__ . '/inc/header.php';
?>

  <main class="cai-dat-trang">

    <h1 class="tieu-de-cai-dat">
      <span class="icon-banh-rang">⚙</span> Cài đặt
    </h1>


    <p
      class="thong-bao-cai-dat"
      id="thong-bao-cai-dat"
      aria-live="polite"
      hidden
    ></p>


    <form
      class="form-cai-dat-mau"
      id="form-cai-dat"
      action="#"
      method="post"
      novalidate
    >

      <!-- KHỐI 1: THÔNG TIN CÁ NHÂN (GIAO DIỆN MỚI CHUẨN MẪU) -->
      <section class="card-cai-dat card-thong-tin-ca-nhan">
        <h2 class="tieu-de-card-cai-dat">Thông tin cá nhân</h2>

        <div class="noi-dung-thong-tin-ca-nhan">
          <div class="khoi-avatar-cai-dat">
            <img src="images/icons/avt-default.svg" alt="Avatar" id="anh-avatar-preview" class="avatar-preview-img">
            <input type="file" id="avatar" name="avatar" accept="image/*" class="input-file-hidden">
          </div>

          <div class="khoi-input-ca-nhan">
            <div class="dong-form-ngang">
              <label for="fullname">Tên hiển thị</label>
              <input type="text" id="fullname" name="fullname" value="Nguyễn Thị Ngọc Bình" required>
            </div>

            <div class="dong-form-ngang">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" value="ngocbinh@gmail.com" required>
            </div>

            <div class="dong-form-ngang">
              <label for="phone">Số điện thoại</label>
              <input type="tel" id="phone" name="phone" value="0123 456 789" required>
            </div>

            <button class="nut-luu-thay-doi" type="submit">Lưu thay đổi</button>
          </div>
        </div>
      </section>


      <!-- KHỐI 2: TÙY CHỌN (BỔ SUNG TỪ ẢNH) -->
      <section class="card-cai-dat card-tuy-chon">
        <h2 class="tieu-de-card-cai-dat">Tùy chọn</h2>

        <div class="danh-sach-tuy-chon">
          <div class="item-tuy-chon">
            <span class="ten-tuy-chon"> Nhận thông báo</span>
            <label class="cong-tac-switch">
              <input type="checkbox" name="nhan_thong_bao" checked>
              <span class="the-gieu-khiem"></span>
            </label>
          </div>

          <div class="item-tuy-chon">
            <span class="ten-tuy-chon"> Email</span>
            <label class="cong-tac-switch">
              <input type="checkbox" name="thong_bao_email" checked>
              <span class="the-gieu-khiem"></span>
            </label>
          </div>

          <div class="item-tuy-chon">
            <span class="ten-tuy-chon"> Chế độ tối</span>
            <label class="cong-tac-switch">
              <input type="checkbox" name="che_do_toi" id="che-do-toi">
              <span class="the-gieu-khiem"></span>
            </label>
          </div>
        </div>
      </section>


      <!-- KHỐI 3: HIỂN THỊ (BỔ SUNG TỪ ẢNH) -->
      <section class="card-cai-dat card-hien-thi">
        <h2 class="tieu-de-card-cai-dat">Hiển thị</h2>

        <div class="danh-sach-hien-thi">
          <div class="dong-form-ngang">
            <label for="ngon-ngu">Ngôn ngữ</label>
            <select id="ngon-ngu" name="ngon_ngu">
              <option value="vi">Tiếng Việt</option>
              <option value="en">English</option>
            </select>
          </div>

          <div class="dong-form-ngang">
            <label for="kich-thuoc-chu">Kích thước chữ</label>
            <select id="kich-thuoc-chu" name="kich_thuoc_chu">
              <option value="mac-dinh">Mặc định</option>
              <option value="nho">Nhỏ</option>
              <option value="lon">Lớn</option>
            </select>
          </div>
        </div>
      </section>


      <!-- KHỐI 4: TÙY CHỈNH SỞ THÍCH -->
<section class="card-cai-dat card-so-thich">
  <h2 class="tieu-de-card-cai-dat">Tùy chỉnh sở thích</h2>

  <div class="danh-sach-so-thich">
    <div class="dong-form-ngang">
      <label for="favorite-category">Danh mục món ăn yêu thích</label>
      <select id="favorite-category" name="favorite_category">
        <option value="">-- Chọn danh mục --</option>
        <option value="mon-chinh" selected>Món chính</option>
        <option value="mon-canh">Món canh</option>
        <option value="mon-xao">Món xào</option>
        <option value="mon-chien">Món chiên</option>
        <option value="mon-an-vat">Món ăn vặt</option>
        <option value="mon-an-nhanh">Món ăn nhanh</option>
        <option value="mon-chay">Món chay</option>
        <option value="mon-trang-mieng">Món tráng miệng</option>
        <option value="do-uong">Đồ uống</option>
      </select>
    </div>

    <div class="dong-form-ngang">
      <label for="preferred-budget">Ngân sách thường sử dụng (VNĐ)</label>
      <input type="number" id="preferred-budget" name="preferred_budget" min="10000" placeholder="Nhập số tiền...">
    </div>

    <div class="dong-form-ngang">
      <label for="preferred-time">Thời gian nấu ưu tiên (phút)</label>
      <input type="number" id="preferred-time" name="preferred_time" min="10" max="180" placeholder="Nhập số phút...">
    </div>

    <div class="dong-form-ngang">
      <label for="preferred-servings">Số người ăn thường xuyên</label>
      <input type="number" id="preferred-servings" name="preferred_servings" min="1" max="20" placeholder="Nhập số người...">
    </div>
  </div>
</section>


      <!-- KHỐI 5: TÀI KHOẢN VÀ BẢO MẬT (GIỮ NGUYÊN TỪ CODE CŨ) -->
      <section class="card-cai-dat card-tai-khoan">

        <h2 class="tieu-de-card-cai-dat">Tài khoản và bảo mật</h2>

        <fieldset class="khung-cai-dat khung-tai-khoan">
          <legend>Thiết lập tài khoản</legend>

          <p class="hanh-dong-bao-mat card-bao-mat phan-bao-mat">
            <button class="nut nut-phu" id="nut-doi-mat-khau" type="button">
              Đổi mật khẩu
            </button>

            <button class="nut nut-phu" id="nut-dang-xuat" type="button">
              Đăng xuất
            </button>

            <button class="nut nut-nguy-hiem" id="nut-xoa-tai-khoan" type="button">
              Xóa tài khoản
            </button>
          </p>

        </fieldset>

      </section>


      <!-- NÚT THAO TÁC FORM -->
      <p class="hanh-dong-cai-dat">
        <button class="nut nut-chinh" type="submit">
          Lưu toàn bộ cài đặt
        </button>

        <button class="nut nut-phu" type="reset">
          Khôi phục
        </button>
      </p>

    </form>

  </main>


  <?php
require_once 'inc/footer.php';
?>