<?php
$pageTitle = "Liên hệ và gửi công thức | Cook with me";

// Nhúng Header và Nav từ thư mục includes/
require_once 'includes/header.php';
require_once 'includes/nav.php';
?>


  <!-- ==============================
       MAIN
       ============================== -->

  <main class="lien-he-trang">

    <!-- BANNER ĐẦU TRANG -->

    <section class="lien-he-banner">

      <div class="lien-he-banner-icon">

        <img
          src="images/icons/info.svg"
          alt="Icon Liên hệ"
          class="icon-svg-banner"
        >

      </div>


      <div class="lien-he-banner-noi-dung">

        <h1 class="tieu-de-lien-he">
          Liên hệ với chúng tôi
        </h1>

        <p class="tieu-de-phu-lien-he">
          Chúng tôi luôn sẵn sàng lắng nghe ý kiến của bạn!
        </p>

      </div>

    </section>


    <!--
      Đây là container bố cục 2 cột.
      Không dùng section vì khu vực này không có tiêu đề riêng.
    -->

    <div class="khu-vuc-lien-he">


      <!-- ==============================
           CỘT TRÁI: FORM
           ============================== -->

      <div class="khu-vuc-form-lien-he">

        <noscript>

          <p class="thong-bao-noscript">
            JavaScript đang được tắt. Bạn vẫn có thể gửi biểu mẫu bằng cơ chế
            gửi biểu mẫu HTML thông thường; các kiểm tra và thông báo nâng cao
            của website sẽ không được thực hiện.
          </p>

        </noscript>


        <!--
          Form liên hệ độc lập với form tìm kiếm ở header.
          Không được đặt form này bên trong form tìm kiếm.
        -->

        <form
          class="form-lien-he"
          action="lien-he.php"
          method="post"
          novalidate
        >


          <!-- HỌ VÀ TÊN -->

          <div class="truong-form">

            <label for="full-name">
              Họ và tên
              <span class="bat-buoc">*</span>
            </label>

            <input
              type="text"
              id="full-name"
              name="full_name"
              placeholder="Nhập họ và tên"
              required
            >

          </div>


          <!-- EMAIL -->

          <div class="truong-form">

            <label for="email">
              Email
              <span class="bat-buoc">*</span>
            </label>

            <input
              type="email"
              id="email"
              name="email"
              placeholder="Nhập email"
              required
            >

          </div>


          <!-- CHỦ ĐỀ -->

          <div class="truong-form">

            <label for="subject">
              Chủ đề
              <span class="bat-buoc">*</span>
            </label>

            <select
              id="subject"
              name="subject"
              required
            >

              <option value="">
                Chọn chủ đề
              </option>

              <option value="gop-y">
                Góp ý
              </option>

              <option value="phan-hoi">
                Phản hồi
              </option>

              <option value="bao-loi">
                Báo lỗi website
              </option>

              <option value="gui-cong-thuc">
                Gửi công thức
              </option>

            </select>

          </div>


          <!-- NỘI DUNG -->

          <div class="truong-form">

            <label for="message">
              Nội dung
              <span class="bat-buoc">*</span>
            </label>

            <textarea
              id="message"
              name="message"
              rows="5"
              maxlength="500"
              placeholder="Nhập nội dung..."
              required
            ></textarea>

            <small class="dem-ky-tu">
              0/500
            </small>

          </div>


          <!-- NÚT GỬI -->

          <div class="hanh-dong-lien-he">

            <button
              class="nut nut-gui-lien-he"
              type="submit"
            >

              <img
                src="images/icons/email.svg"
                alt=""
                class="icon-svg-btn"
              >

              Gửi

            </button>

          </div>


        </form>

      </div>


      <!-- ==============================
           CỘT PHẢI: THÔNG TIN LIÊN HỆ
           ============================== -->

      <aside class="thong-tin-lien-he">


        <!-- THÔNG TIN LIÊN HỆ -->

        <section class="the-thong-tin-lien-he">

          <h2>
            Thông tin liên hệ
          </h2>


          <!-- EMAIL -->

          <div class="thong-tin-lien-he-item">

            <span class="khung-icon-svg">

              <img
                src="images/icons/email.svg"
                alt="Email"
                class="icon-svg-lh"
              >

            </span>


            <div class="noi-dung-item-lh">

              <strong>
                Email
              </strong>

              <p>
                cookwithme@gmail.com
              </p>

            </div>

          </div>


          <!-- ĐIỆN THOẠI -->

          <div class="thong-tin-lien-he-item">

            <span class="khung-icon-svg">

              <img
                src="images/icons/phone.svg"
                alt="Điện thoại"
                class="icon-svg-lh"
              >

            </span>


            <div class="noi-dung-item-lh">

              <strong>
                Điện thoại
              </strong>

              <p>
                0123 456 789
              </p>

            </div>

          </div>


          <!-- ĐỊA CHỈ -->

          <div class="thong-tin-lien-he-item">

            <span class="khung-icon-svg">

              <img
                src="images/icons/location.svg"
                alt="Địa chỉ"
                class="icon-svg-lh"
              >

            </span>


            <div class="noi-dung-item-lh">

              <strong>
                Địa chỉ
              </strong>

              <p>
                Đà Nẵng, Việt Nam
              </p>

            </div>

          </div>

        </section>


        <!-- MẠNG XÃ HỘI -->

        <section class="the-thong-tin-lien-he">

          <h2>
            Kết nối với chúng tôi
          </h2>


          <div class="mang-xa-hoi-lien-he">

            <a href="#">
              <img
                src="images/icons/social-facebook.svg"
                alt="Facebook"
                class="icon-svg-social"
              >
            </a>

            <a href="#">
              <img
                src="images/icons/social-instagram.svg"
                alt="Instagram"
                class="icon-svg-social"
              >
            </a>

            <a href="#">
              <img
                src="images/icons/social-youtube.svg"
                alt="YouTube"
                class="icon-svg-social"
              >
            </a>

            <a href="#">
              <img
                src="images/icons/social-tiktok.svg"
                alt="TikTok"
                class="icon-svg-social"
              >
            </a>

          </div>

        </section>


        <!-- LỜI NHẮN -->

        <div class="loi-nhan-lien-he">

          <img
            src="images/icons/chef.svg"
            alt="Chef"
            class="icon-svg-card"
          >

          <p>
            Bạn cũng có thể gửi công thức hoặc góp ý cho Cook with Me!
          </p>

        </div>


      </aside>

    </div>

  </main>


<?php
// Khai báo file JS riêng cho trang liên hệ (đuôi .js)
$customJS = 'js/trang-lien-he.js';

// Nhúng Footer từ thư mục includes/
require_once 'includes/footer.php';
?>