<?php
// 1. PHẦN XỬ LÝ LÝ THUYẾT / LOGIC (Không echo)
require __DIR__ . '/inc/config.php';

use App\Data\KhoMonAn; // (Nếu trang cần lấy dữ liệu món ăn)

// Thực hiện khai báo dữ liệu, lấy danh sách từ JSON
$kho      = new KhoMonAn(__DIR__ . '/data/mon-an.json');
$danhSach = $kho->tatCa(); 

// Thiết lập thông số header
$tieuDe   = 'Gợi ý món ăn'; 
$trang    = 'goi-y-mon-an'; // Đánh dấu class active trên Menu (ví dụ: 'index', 'danh-sach', 'lien-he'...)
$customJS = 'js/trang-goi-y-mon-an.js'; // Nạp JS riêng (nếu có)

// Nhúng Header (đã bao gồm Nav)
require __DIR__ . '/inc/header.php';
?>

  <!-- NỘI DUNG CHÍNH (CẬP NHẬT THEO THIẾT KẾ MỚI) -->
  <main class="goi-y-trang">

    <!-- BANNER TỦ LẠNH CỦA TÔI (GIAO DIỆN MỚI NỔI BẬT) -->
<section class="banner-tu-lanh">
  
  <!-- Hình ảnh Tủ lạnh bên trái -->
  <div class="hinh-anh-banner hinh-anh-tu-lanh">
    <img src="images/icons/fridge.svg" alt="Tủ lạnh" class="anh-tu-lanh">
  </div>

  <!-- Khối chữ ở giữa / đẩy sang phải -->
  <div class="noi-dung-banner">
    <p class="nhan-tu-lanh">Tủ lạnh của tôi</p>
    <h1 class="tieu-de-banner">Hôm nay ăn gì?</h1>
    <p class="mo-ta-banner">Nhập nguyên liệu bạn có, chúng tôi sẽ gợi ý món ăn phù hợp!</p>
  </div>
  
  <!-- Hình ảnh Rổ rau củ bên phải -->
  <div class="hinh-anh-banner hinh-anh-ro-rau">
    <img src="images/basket-vegetables.svg" alt="Rổ rau củ quả" class="anh-ro-rau-cu">
  </div>

</section>

    <!-- FORM BỘ LỌC TÌM KIẾM -->
<section class="khung-bo-loc-goi-y">
  <form class="form-goi-y-moi" id="form-goi-y" action="#" method="get">
    
    <!-- Hàng 1: Các ô bộ lọc -->
    <div class="khong-gian-loc">
      
      <!-- Ô 1: Nguyên liệu -->
      <div class="o-nhap-loc o-nguyen-lieu">
        <label for="ingredients">Nguyên liệu (có thể chọn nhiều)</label>
        <input type="text" id="ingredients" name="ingredients" placeholder="Nhập nguyên liệu...">
        
        <!-- Tags nguyên liệu nằm ngay dưới ô nhập -->
        <div class="danh-sach-tags">
          <span class="tag-item">Thịt heo <button type="button" class="nut-xoa-tag">&times;</button></span>
          <span class="tag-item">Trứng <button type="button" class="nut-xoa-tag">&times;</button></span>
          <span class="tag-item">Cà chua <button type="button" class="nut-xoa-tag">&times;</button></span>
          <span class="tag-item">Rau cải <button type="button" class="nut-xoa-tag">&times;</button></span>
        </div>
      </div>

      <!-- Ô 2: Ngân sách -->
      <div class="o-nhap-loc">
        <label for="budget">Ngân sách</label>
        <select id="budget" name="budget">
          <option value="">Chọn ngân sách</option>
          <option value="50000">Dưới 50.000đ</option>
          <option value="100000" selected>50.000đ - 100.000đ</option>
          <option value="200000">100.000đ - 200.000đ</option>
        </select>
      </div>

      <!-- Ô 3: Thời gian nấu -->
      <div class="o-nhap-loc">
        <label for="cooking-time">Thời gian nấu</label>
        <select id="cooking-time" name="cooking_time">
          <option value="">Chọn thời gian</option>
          <option value="15">Dưới 15 phút</option>
          <option value="30" selected>Dưới 30 phút</option>
          <option value="60">Dưới 60 phút</option>
        </select>
      </div>

      <!-- Ô 4: Số người ăn -->
      <div class="o-nhap-loc">
        <label for="servings">Số người ăn</label>
        <select id="servings" name="servings">
          <option value="">Chọn số người</option>
          <option value="1">1 người</option>
          <option value="2" selected>2 - 3 người</option>
          <option value="4">4 người trở lên</option>
        </select>
      </div>

    </div>

    <!-- Hàng 2: Nút Tìm kiếm (Căn giữa) -->
    <div class="hanh-dong-goi-y">
      <button class="nut-goi-y-tim" type="submit">
        🔍 Gợi ý món ăn
      </button>
    </div>

  </form>
</section>

    <!-- MÓN ĂN PHÙ HỢP -->
<section class="mon-duoc-goi-y-moi" aria-labelledby="tieu-de-mon-goi-y">
  <div class="thanh-tieu-de-mon">
    <h2 id="tieu-de-mon-goi-y">Món ăn phù hợp</h2>
    <a href="danh-sach.php" class="xem-tat-ca">Xem tất cả &rarr;</a>
  </div>

  <p class="thong-bao-goi-y" id="thong-bao-goi-y">
    Nhập thông tin ở trên để nhận gợi ý món ăn phù hợp.
  </p>

  <!-- Lưới 4 cột chỉ áp dụng riêng cho khung chứa các card -->
  <div class="danh-sach-mon-goi-y" id="danh-sach-mon-goi-y"></div>
</section>

    <!-- DANH SÁCH ĐI CHỢ (ẨN MẶC ĐỊNH KHI CHƯA THÊM MÓN) -->
<section
  class="danh-sach-di-cho"
  id="khu-vuc-danh-sach-di-cho"
  aria-labelledby="tieu-de-danh-sach-di-cho"
  hidden
>
  <h2 id="tieu-de-danh-sach-di-cho">
    Danh sách đi chợ
  </h2>

  <p>
    Các nguyên liệu dưới đây là những nguyên liệu còn thiếu để chuẩn bị món ăn đã chọn.
  </p>

  <article class="the-danh-sach">
    <h3 id="ten-mon-danh-sach-di-cho">
      Nguyên liệu cần mua
    </h3>

    <ul id="danh-sach-nguyen-lieu-can-mua"></ul>
  </article>

  <div class="hanh-dong-danh-sach">
    <button
      class="nut nut-phu"
      id="nut-xoa-danh-sach"
      type="button"
    >
      Xóa danh sách
    </button>
  </div>
</section>

  </main>

  <?php
require __DIR__ . '/inc/footer.php';
?>