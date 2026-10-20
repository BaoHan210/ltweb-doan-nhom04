<?php
$tieuDe = 'Tất cả thông báo';
$trang = 'thong-bao';
include_once 'inc/header.php';
?>

<main class="noi-dung-trang trang-thong-bao-container">
  <div class="thanh-tieu-de-thong-bao">
    <h1 class="tieu-de-trang-tb">Thông báo của bạn</h1>
    <button type="button" class="nut-danh-dau-doc">Đánh dấu tất cả đã đọc</button>
  </div>
  
  <div class="card-danh-sach-tb">
    <ul class="danh-sach-tb-chi-tiet">
      <li class="item-tb-trang chua-doc">
        <div class="noi-dung-tb-left">
          <p class="van-ban-tb">Minh Anh đã thích công thức món ăn của bạn.</p>
          <small class="thoi-gian-tb-trang">5 phút trước</small>
        </div>
        <span class="nhan-moi-tb">Mới</span>
      </li>

      <li class="item-tb-trang chua-doc">
        <div class="noi-dung-tb-left">
          <p class="van-ban-tb">Gợi ý món ăn mới trong tuần đã được cập nhật!</p>
          <small class="thoi-gian-tb-trang">1 giờ trước</small>
        </div>
        <span class="nhan-moi-tb">Mới</span>
      </li>

      <li class="item-tb-trang">
        <div class="noi-dung-tb-left">
          <p class="van-ban-tb">Chào mừng bạn đã quay trở lại Cook with me.</p>
          <small class="thoi-gian-tb-trang">1 ngày trước</small>
        </div>
      </li>
    </ul>
  </div>
</main>

<?php include_once 'inc/footer.php'; ?>