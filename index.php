<?php
$pageTitle = "Trang chủ | Cook with me";

// Nhúng Header và Nav
require_once 'includes/header.php';
require_once 'includes/nav.php';
?>


  <main class="noi-dung-trang">

    <h1 class="tieu-de-trang">
      Trang chủ Cook with me
    </h1>


    <!-- HERO -->
    <section class="hero">

      <div class="hero-noi-dung">

        <p class="hero-nhan">COOK WITH ME</p>

        <h2>
          Khám phá món ngon mỗi ngày
        </h2>

        <p>
          Cùng Cook with me tìm kiếm, học hỏi và chia sẻ những
          công thức nấu ăn tuyệt vời!
        </p>

        <a class="nut nut-chinh" href="danh-sach.php">
          Khám phá món ăn
        </a>

      </div>

    </section>


    <!-- BA THẺ CHỨC NĂNG -->
    <section class="the-gioi-thieu">

      <h2>
        Khám phá Cook with me
      </h2>


      <article class="the-gioi-thieu-item icon-dang-bai">

        <h3>
          Đăng bài viết
        </h3>

        <p>
          Chia sẻ công thức nấu ăn, hình ảnh món ăn và kinh nghiệm
          với cộng đồng Cook with me.
        </p>

        <a class="nut" href="dang-bai-viet.php">
          Đăng bài
        </a>

      </article>

      <article class="the-gioi-thieu-item icon-kham-pha-card">

        <h3>
          Khám phá món ăn
        </h3>

        <p>
          Tìm kiếm và khám phá nhiều món ăn theo danh mục
          và nhu cầu sử dụng.
        </p>

        <a class="nut" href="danh-sach.php">
          Khám phá
        </a>

      </article>


      <article class="the-gioi-thieu-item icon-goi-y-card">

        <h3>
          Gợi ý món ăn
        </h3>

        <p>
          Nhận gợi ý món ăn dựa trên nguyên liệu,
          thời gian nấu và nhu cầu của người dùng.
        </p>

        <a class="nut" href="goi-y-mon-an.php">
          Xem gợi ý
        </a>

      </article>

    </section>


    <!-- KHU VỰC TRANG CHỦ -->
    <div class="khu-vuc-trang-chu">

      <!-- B5: KHỐI DỮ LIỆU API (CỘT TRÁI - CHIẾM DÒNG 1 & 2) -->
      <section class="du-lieu-api" aria-labelledby="tieu-de-du-lieu-api">
        <div class="tieu-de-khu-vuc">
          <h2 id="tieu-de-du-lieu-api">
            Gợi ý món ăn hôm nay
          </h2>
        </div>
        <div class="noi-dung-api" id="noi-dung-api">
          <p class="api-trang-thai">
            Đang tải dữ liệu...
          </p>
        </div>
      </section>

      <noscript>
        <p class="thong-bao-noscript">
          JavaScript đang được tắt. Khối gợi ý món ăn từ API bên ngoài không thể tải dữ liệu động.
        </p>
      </noscript>

      <!-- MÓN ĂN NỔI BẬT (CỘT 2 - DÒNG 1) -->
      <section class="mon-noi-bat">
        <div class="tieu-de-khu-vuc">
          <h2>
            Món ăn nổi bật
          </h2>

          <a href="danh-sach.php">
            Xem tất cả →
          </a>
        </div>

        <article class="the-mon-an">
          <img src="images/ca-kho-to.jpg" alt="Món cá kho tộ với thịt cá và nước kho màu nâu đậm" width="300" height="200" loading="lazy">

          <div class="thong-tin-mon">
            <h3>
              Cá kho tộ
            </h3>

            <p class="danh-gia-mon" role="img" aria-label="5 trên 5 sao">
              ★★★★★
            </p>

            <a href="chi-tiet.php?id=ca-kho-to">
              Xem chi tiết
            </a>
          </div>
        </article>

        <article class="the-mon-an">
          <img src="images/goi-ngo-sen.jpg" alt="Món gỏi ngó sen với rau củ và nguyên liệu trộn" width="300" height="200" loading="lazy">

          <div class="thong-tin-mon">
            <h3>
              Gỏi ngó sen
            </h3>

            <p class="danh-gia-mon" role="img" aria-label="5 trên 5 sao">
              ★★★★★
            </p>

            <a href="chi-tiet.php?id=goi-ngo-sen">
              Xem chi tiết
            </a>
          </div>
        </article>

        <article class="the-mon-an">
          <img src="images/banh-xeo.jpg" alt="Bánh xèo vàng giòn ăn kèm rau sống" width="300" height="200" loading="lazy">

          <div class="thong-tin-mon">
            <h3>
              Bánh xèo
            </h3>

            <p class="danh-gia-mon" role="img" aria-label="5 trên 5 sao">
              ★★★★★
            </p>

            <a href="chi-tiet.php?id=banh-xeo">
              Xem chi tiết
            </a>
          </div>
        </article>
      </section>

      <!-- GỢI Ý NGƯỜI THEO DÕI (CỘT 2 - DÒNG 2) -->
<section class="goi-y-theo-doi">
  <div class="tieu-de-khu-vuc">
    <h2>Gợi ý người theo dõi</h2>
    <a href="nguoi-dung.php">Xem tất cả →</a>
  </div>

  <!-- Thẻ 1 -->
  <article class="the-nguoi-dung nguoi-dung-gladly">
    <div class="thong-tin-hang-tren">
      <img 
        src="images/icons/avt-default.svg" 
        alt="Gladly" 
        onerror="this.src='images/icons/avt-default.svg'"
      >
      <div class="thong-tin-nguoi-dung">
        <h3>Gladly</h3>
        <p>Chia sẻ công thức món ăn gia đình.</p>
      </div>
    </div>
    <button class="nut nut-phu" type="button">Theo dõi</button>
  </article>

  <!-- Thẻ 2 -->
  <article class="the-nguoi-dung nguoi-dung-serena">
    <div class="thong-tin-hang-tren">
      <img 
        src="images/icons/avt-default.svg" 
        alt="Serena" 
        onerror="this.src='images/icons/avt-default.svg'"
      >
      <div class="thong-tin-nguoi-dung">
        <h3>Serena</h3>
        <p>Thường xuyên chia sẻ món ăn nhanh.</p>
      </div>
    </div>
    <button class="nut nut-phu" type="button">Theo dõi</button>
  </article>

  <!-- Thẻ 3 -->
  <article class="the-nguoi-dung nguoi-dung-jasmine">
    <div class="thong-tin-hang-tren">
      <img 
        src="images/icons/avt-default.svg" 
        alt="Jasmine" 
        onerror="this.src='images/icons/avt-default.svg'"
      >
      <div class="thong-tin-nguoi-dung">
        <h3>Jasmine</h3>
        <p>Yêu thích các món tráng miệng.</p>
      </div>
    </div>
    <button class="nut nut-phu" type="button">Theo dõi</button>
  </article>
</section>

    </div> <!-- KẾT THÚC KHU VỰC TRANG CHỦ -->

    <!-- BẢNG TIN -->
    <section class="bang-tin">

      <div class="tieu-de-khu-vuc">
        <h2>
          Bảng tin
        </h2>

        <a href="dang-bai-viet.php">
          Đăng bài viết →
        </a>
      </div>

      <article class="the-bai-dang" data-bai-viet-id="pho-bo-truyen-thong">

        <div class="thong-tin-tac-gia">
          <strong>Angel</strong>
          <span>Chia sẻ một công thức mới</span>
        </div>

        <h3>
          Phở bò truyền thống
        </h3>

        <p>
          Công thức phở bò thơm ngon với nước dùng đậm đà
          và các nguyên liệu quen thuộc.
        </p>

        <img src="images/pho-bo.jpg" alt="Tô phở bò với bánh phở, thịt bò, rau thơm và chanh" width="500" height="320" loading="lazy">

        <div class="noi-dung-mo-rong" hidden>

          <p>
            Phở bò là món ăn quen thuộc với nước dùng trong,
            thơm và đậm vị.
          </p>

        </div>


        <div class="hanh-dong-bai-dang">

          <button class="nut-tuong-tac nut-thich" type="button" data-bai-viet-id="pho-bo-truyen-thong" aria-label="Thích bài viết" title="Thích">
            ♡
          </button>

          <button class="nut-tuong-tac nut-binh-luan" type="button" aria-label="Bình luận" title="Bình luận">
            💬
          </button>

          <button class="nut-tuong-tac nut-chia-se" type="button" aria-label="Chia sẻ bài viết" title="Chia sẻ">
            ↗
          </button>

          <button class="nut-tuong-tac nut-luu" type="button" data-bai-viet-id="pho-bo-truyen-thong" aria-label="Lưu bài viết" title="Lưu">
            🔖
          </button>

          <button class="nut-tuong-tac nut-xem" type="button" aria-label="Xem nội dung bài viết" title="Xem">
            ⋯
          </button>

        </div>


        <div class="khu-vuc-binh-luan" hidden>

          <form class="form-binh-luan">

            <label for="binh-luan-pho-bo">
              Bình luận
            </label>

            <input type="text" id="binh-luan-pho-bo" name="comment" maxlength="200" placeholder="Viết bình luận..." autocomplete="off">

            <button class="nut" type="submit">
              Gửi
            </button>

          </form>

          <div class="danh-sach-binh-luan"></div>

        </div>

      </article>


      <article class="the-bai-dang" data-bai-viet-id="mi-quang-tom-thit">

        <div class="thong-tin-tac-gia">
          <strong>Helia</strong>
          <span>Chia sẻ một công thức mới</span>
        </div>

        <h3>
          Mì Quảng tôm thịt
        </h3>

        <p>
          Công thức mì Quảng với tôm, thịt và rau sống ăn kèm.
        </p>

        <img src="images/mi-quang.jpg" alt="Tô mì Quảng với sợi mì vàng, tôm, thịt và rau sống" width="500" height="320" loading="lazy">

        <div class="noi-dung-mo-rong" hidden>

          <p>
            Công thức phù hợp cho bữa ăn gia đình và có thể điều chỉnh
            nguyên liệu theo khẩu phần.
          </p>

        </div>


        <div class="hanh-dong-bai-dang">

          <button class="nut-tuong-tac nut-thich" type="button" data-bai-viet-id="mi-quang-tom-thit" aria-label="Thích bài viết" title="Thích">
            ♡
          </button>

          <button class="nut-tuong-tac nut-binh-luan" type="button" aria-label="Bình luận" title="Bình luận">
            💬
          </button>

          <button class="nut-tuong-tac nut-chia-se" type="button" aria-label="Chia sẻ bài viết" title="Chia sẻ">
            ↗
          </button>

          <button class="nut-tuong-tac nut-luu" type="button" data-bai-viet-id="mi-quang-tom-thit" aria-label="Lưu bài viết" title="Lưu">
            🔖
          </button>

          <button class="nut-tuong-tac nut-xem" type="button" aria-label="Xem nội dung bài viết" title="Xem">
            ⋯
          </button>

        </div>


        <div class="khu-vuc-binh-luan" hidden>

          <form class="form-binh-luan">

            <label for="binh-luan-mi-quang">
              Bình luận
            </label>

            <input type="text" id="binh-luan-mi-quang" name="comment" maxlength="200" placeholder="Viết bình luận..." autocomplete="off">

            <button class="nut" type="submit">
              Gửi
            </button>

          </form>

          <div class="danh-sach-binh-luan"></div>

        </div>

      </article>

    </section>

  </main>


  <?php
// Khai báo file JS riêng của trang chủ
$customJS = 'js/trang-chu.js';

// Nhúng Footer
require_once 'includes/footer.php';
?>