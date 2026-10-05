<?php
// 1. PHẦN XỬ LÝ LOGIC (Không echo)
require __DIR__ . '/inc/config.php';

use App\Data\KhoMonAn;

// Nạp dữ liệu từ file JSON
$kho = new KhoMonAn(__DIR__ . '/data/mon-an.json');

// Lấy ID từ URL (Ví dụ: chi-tiet.php?id=ca-kho-to). Nếu không có ID thì mặc định lấy 'ca-kho-to'
$id = $_GET['id'] ?? 'ca-kho-to';

// Tìm món ăn theo ID
$monAn = $kho->timTheoId($id);

// Thiết lập tiêu đề trang theo tên món ăn
$tieuDe   = $monAn ? $monAn->ten : 'Chi tiết món ăn'; 
$trang    = 'chi-tiet';
$customJS = 'js/trang-chi-tiet.js';

// Nhúng Header (đã bao gồm Nav)
require __DIR__ . '/inc/header.php';
?>

  <main class="chi-tiet-trang">

    <!-- Container bố cục, không cần dùng section -->
    <div class="khung-chi-tiet">

      <div class="trang-thai-chi-tiet" aria-live="polite"></div>

      <article class="chi-tiet-mon-an">

        <!-- CỘT TRÊN TRÁI: ẢNH MÓN ĂN (ĐỘNG) -->
        <div class="khu-vuc-hinh-anh">

          <figure class="hinh-anh-mon-an">

            <img src="<?= e($monAn->hinhAnh ?? 'images/cao-lau.jpg') ?>" alt="<?= e($monAn->ten ?? 'Chi tiết món ăn') ?>">

          </figure>

        </div>

        <!-- CỘT BÊN PHẢI: THÔNG TIN MÓN ĂN (ĐỘNG) -->
        <div class="thong-tin-mon-an">

          <h1 class="tieu-de-mon-an">
            <?= e($monAn->ten ?? 'Cao lầu Hội An') ?>
          </h1>

          <div class="thong-tin-danh-gia">

            <span class="danh-gia">
              ★★★★★
            </span>

            <span class="so-luot-danh-gia">
              4.8 (206 đánh giá)
            </span>

          </div>

          <div class="thong-tin-co-ban-ngang">

            <div class="item-meta meta-khau-phan">
              <img src="images/icons/khau-phan.svg" alt="Khẩu phần" class="icon-meta">
              <span>2 người</span>
            </div>

            <div class="item-meta meta-thoi-gian">
              <img src="images/icons/thoi-gian.svg" alt="Thời gian" class="icon-meta">
              <span>60 phút</span>
            </div>

            <div class="item-meta meta-do-kho">
              <img src="images/icons/do-kho.svg" alt="Độ khó" class="icon-meta">
              <span>Trung bình</span>
            </div>

          </div>

          <!-- Container mô tả (ĐỘNG) -->
          <div class="mo-ta-mon-an">

            <p>
              <?= e($monAn->moTaNgan ?? 'Món ăn đặc trưng thơm ngon, hấp dẫn.') ?>
            </p>

          </div>

          <div class="khu-vuc-hanh-dong">

            <button type="button" class="nut nut-yeu-thich nut-chinh">
              ♡ Đã lưu
            </button>

            <button type="button" class="nut nut-chia-se nut-phu">
              ➦ Chia sẻ
            </button>

          </div>

        </div>

        <!-- CỘT DƯỚI TRÁI: NGUYÊN LIỆU -->
        <div class="cot-trai-chi-tiet">

          <section class="khu-vuc-nguyen-lieu">

            <h2>
              🍳 Nguyên liệu
            </h2>

            <ul class="danh-sach-nguyen-lieu">

              <li class="nguyen-lieu-soi">
                <span>
                  Sợi mì / Nguyên liệu chính
                </span>
                <strong>
                  300g
                </strong>
              </li>

              <li class="nguyen-lieu-thit">
                <span>
                  Thịt heo / Thịt kèm
                </span>
                <strong>
                  200g
                </strong>
              </li>

              <li class="nguyen-lieu-rau">
                <span>
                  Rau sống
                </span>
                <strong>
                  100g
                </strong>
              </li>

              <li class="nguyen-lieu-gia-vi">
                <span>
                  Gia vị (nước mắm, đường, hành, tỏi...)
                </span>
                <strong>
                  vừa đủ
                </strong>
              </li>

            </ul>

          </section>

          <button type="button" class="nut-binh-luan-full">
            Bình luận (24)
          </button>

        </div>

        <!-- CỘT DƯỚI PHẢI: CÁC BƯỚC + VIDEO -->
        <div class="cot-phai-chi-tiet">

          <section class="khu-vuc-cac-buoc">

            <h2>
              👨‍🍳 Các bước chế biến
            </h2>

            <ol class="cac-buoc-che-bien">

              <li>
                Sơ chế nguyên liệu: rửa sạch thái rau, hành, tỏi...
              </li>

              <li>
                Ướp nguyên liệu với gia vị vừa ăn, để 15 phút.
              </li>

              <li>
                Chế biến theo công thức truyền thống.
              </li>

              <li>
                Thưởng thức món ăn khi còn nóng.
              </li>

            </ol>

          </section>

          <section class="video-huong-dan">

            <h2>
              Video hướng dẫn
            </h2>

            <div class="khung-video">

              <div class="video-preview-card">

                <img src="<?= e($monAn->hinhAnh ?? 'images/cao-lau.jpg') ?>" alt="Xem video hướng dẫn">

                <div class="nut-play-video">
                  ▶
                </div>

                <span class="thoi-luong-video">
                  3:52
                </span>

              </div>

            </div>

          </section>

        </div>

      </article>

    </div>

  </main>

  <?php
require_once 'inc/footer.php';
?>