<?php
// 1. PHẦN XỬ LÝ LÝ THUYẾT / LOGIC (Không echo)
require __DIR__ . '/inc/config.php';

use App\Data\KhoMonAn; // (Nếu trang cần lấy dữ liệu món ăn)

// Thực hiện khai báo dữ liệu, lấy danh sách từ JSON
$kho      = new KhoMonAn(__DIR__ . '/data/mon-an.json');
$danhSach = $kho->tatCa(); 

// Thiết lập thông số header
$tieuDe   = 'Khám phá'; 
$trang    = 'danh-sach'; // Đánh dấu class active trên Menu (ví dụ: 'index', 'danh-sach', 'lien-he'...)
$customJS = 'js/trang-danh-sach.js'; // Nạp JS riêng (nếu có)

// Nhúng Header (đã bao gồm Nav)
require __DIR__ . '/inc/header.php';
?>

  <main class="kham-pha">

    <!-- 1. TIÊU ĐỀ TRANG KHÁM PHÁ NẰM TRÊN CÙNG -->
    <div class="tieu-de-danh-sach">
      <div>
        <p class="nhan-danh-sach">Khám phá</p>
        <h1 id="tieu-de-mon-an">Món ăn</h1>
      </div>
    </div>


    <!-- 2. HERO BANNER "TỦ LẠNH CỦA TÔI" -->
    <section class="hero-kham-pha">

      <div class="hero-kham-pha-icon-trai">
        <img
          src="images/icons/fridge.svg"
          alt="Tủ lạnh"
          width="60"
          height="60"
        >
      </div>

      <div class="hero-kham-pha-noi-dung">
        <p class="hero-kham-pha-nhan">
          Tủ lạnh của tôi
        </p>

        <h2>
          Hôm nay ăn gì?
        </h2>

        <p>
          Nhập nguyên liệu bạn có, chúng tôi sẽ gợi ý món ăn phù hợp!
        </p>
      </div>

      <div class="hero-kham-pha-icon-phai">
        <img
          src="images/basket-vegetables.svg"
          alt="Rau củ tươi"
          width="160"
          height="120"
        >
      </div>

    </section>


    <!-- KHU VỰC BỘ LỌC VÀ TÌM KIẾM MÓN ĂN -->
    <section
      class="khu-vuc-danh-sach-mon-an"
      aria-labelledby="tieu-de-mon-an"
    >

      <!-- THANH CÔNG CỤ BAO GỒM TÌM KIẾM, LỌC VÀ SẮP XẾP DUY NHẤT -->
      <div class="thanh-cong-cu-mon-an">

        <!-- Hàng trên: Ô Tìm kiếm bên trái + Ô Sắp xếp bên phải -->
        <div class="hang-tim-kiem-bo-loc">

          <!-- ĐÃ BỎ onsubmit NỘI TUYẾN TẠI ĐÂY -->
          <form
            class="o-tim-mon-an"
            id="o-tim-mon-an"
            action="danh-sach.php"
            method="get"
          >

            <label for="tim-mon-an">
              Tìm món ăn
            </label>

            <input
              type="search"
              id="tim-mon-an"
              name="keyword"
              placeholder="Tìm món ăn..."
              autocomplete="off"
            >

          </form>


          <div class="khu-vuc-sap-xep">

            <label for="sap-xep">
              Sắp xếp
            </label>

            <select
              id="sap-xep"
              name="sapXep"
            >
              <option value="">Mặc định</option>
              <option value="danhGiaGiam">Đánh giá cao nhất</option>
              <option value="thoiGianTang">Thời gian ngắn nhất</option>
              <option value="nganSachTang">Ngân sách thấp nhất</option>
              <option value="tenTang">Tên A → Z</option>
            </select>

          </div>

        </div>


        <!-- Hàng dưới: Thanh các nút bấm lọc theo Danh mục đã được chuẩn hóa theo mon-an.json -->
        <nav
          class="bo-loc-mon-an"
          aria-label="Lọc món ăn"
        >

          <button
            class="nut-bo-loc dang-loc"
            type="button"
            data-danh-muc="tat-ca"
          >
            Tất cả
          </button>

          <button
            class="nut-bo-loc"
            type="button"
            data-danh-muc="Món chính"
          >
            Món chính
          </button>

          <button
            class="nut-bo-loc"
            type="button"
            data-danh-muc="Món canh"
          >
            Món canh
          </button>

          <button
            class="nut-bo-loc"
            type="button"
            data-danh-muc="Món xào"
          >
            Món xào
          </button>

          <button
            class="nut-bo-loc"
            type="button"
            data-danh-muc="Món rau"
          >
            Món rau
          </button>

          <button
            class="nut-bo-loc"
            type="button"
            data-danh-muc="Món khai vị"
          >
            Món khai vị
          </button>

          <button
            class="nut-bo-loc"
            type="button"
            data-danh-muc="Đồ uống"
          >
            Đồ uống
          </button>

          <button
            class="nut-bo-loc"
            type="button"
            data-danh-muc="Món tráng miệng"
          >
            Món tráng miệng
          </button>

          <button
            class="nut-bo-loc"
            type="button"
            data-danh-muc="Món chay"
          >
            Món chay
          </button>

        </nav>

      </div>


      <!-- Kết quả danh sách món ăn -->
      <section
        class="khu-vuc-ket-qua"
        aria-labelledby="tieu-de-ket-qua"
      >

        <div class="tieu-de-ket-qua">

          <h2 id="tieu-de-ket-qua">
            Các món ăn
          </h2>

          <p
            class="so-luong-mon-an"
            id="so-luong-mon-an"
          >
            Đang tải món ăn...
          </p>

        </div>


        <div class="danh-sach-mon-an" id="danh-sach-mon-an">
  <?php if (!empty($danhSach)): ?>
    <?php foreach ($danhSach as $mon): ?>
      <article class="the-mon-an">
        <img src="<?= e($mon->hinhAnh) ?>" alt="<?= e($mon->ten) ?>">
        <h3><?= e($mon->ten) ?></h3>
        <p><?= e($mon->moTaNgan) ?></p>
        <a href="chi-tiet.php?id=<?= e($mon->id) ?>" class="nut">Xem chi tiết</a>
      </article>
    <?php endforeach; ?>
  <?php else: ?>
    <p>Chưa có món ăn nào.</p>
  <?php endif; ?>
</div>

      </section>


      <!-- Thông báo khi JavaScript bị tắt -->
      <noscript>

        <p class="thong-bao-noscript">
          JavaScript đang được tắt. Danh sách món ăn, tìm kiếm, lọc và sắp xếp động không thể được tải đầy đủ.
        </p>

      </noscript>


      <!-- Phân trang -->
      <nav
        class="phan-trang"
        id="phan-trang"
        aria-label="Phân trang danh sách món ăn"
      >

        <button
          class="nut-phan-trang"
          type="button"
          data-trang="truoc"
          aria-label="Trang trước"
        >
          ‹
        </button>

      </nav>

    </section>

  </main>


  <?php
require __DIR__ . '/inc/footer.php';
?>