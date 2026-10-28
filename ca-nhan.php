<?php
/**
 * Tệp: ca-nhan.php
 * Mục đích: Trang cá nhân của người đã đăng nhập, hiển thị món đã lưu yêu thích
 *           kèm số lượng và thành tiền.
 * Dùng bởi: Liên kết "Trang cá nhân" trong menu tài khoản (inc/header.php).
 */

declare(strict_types=1);

require __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/xac-thuc.php';
use App\Data\KhoMonAn;
use App\Services\YeuThichService;

$user = yeuCauDangNhap();
$hoTen  = (string) ($user['hoTen'] ?? $user['ho_ten'] ?? 'Người dùng');
$avatar = !empty($user['avatar']) ? (string) $user['avatar'] : 'images/icons/avt-default.svg';

$kho = new KhoMonAn(db());
$yeuThichService = new YeuThichService();

// Đồng bộ session với dữ liệu món hiện có, sau đó lấy giỏ hàng để hiển thị
$yeuThichService->loaiBoMonKhongCon($kho);
$gioHang        = $yeuThichService->layGioHang($kho);
$cacMonYeuThich = $gioHang['mon'];

$tieuDe   = 'Trang cá nhân - Cook with Me';
$trang    = 'ca-nhan';
$customJS = 'js/trang-ca-nhan.js';

require __DIR__ . '/inc/header.php';
?>

<main class="ca-nhan-trang bao" style="padding-top: 16px; padding-bottom: 40px;">
  <div class="khung-ca-nhan-card">

    <!-- 1. Banner -->
    <div class="anh-bia-ca-nhan">
      <img src="images/cao-lau.jpg" alt="Ảnh bìa trang cá nhân">
    </div>

    <!-- 2. Thông tin và thống kê -->
    <div class="phong-so-ca-nhan">
      <div class="hang-thong-tin-top">
        <div class="khoi-avatar-ten">
          <div class="anh-dai-dien-ca-nhan">
            <img
              src="<?= e($avatar) ?>"
              alt="<?= e($hoTen) ?>"
              class="avatar-img-cn"
              onerror="this.onerror=null; this.src='images/icons/avt-default.svg';"
            >
          </div>
          <div class="noi-dung-ca-nhan">
            <h1 class="ten-nguoi-dung"><?= e($hoTen) ?></h1>
            <p class="mo-ta-nguoi-dung">Người yêu thích nấu ăn</p>
          </div>
        </div>

        <a href="cai-dat.php" class="nut-chinh-sua-cn">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
          Chỉnh sửa
        </a>
      </div>

      <div class="thong-ke-ca-nhan">
        <div class="thong-ke-item">
          <strong class="so-bai-dang">0</strong>
          <span>Bài đăng</span>
        </div>
        <div class="thong-ke-item thanh-ngan-tk">
          <strong>128</strong>
          <span>Theo dõi</span>
        </div>
        <div class="thong-ke-item">
          <strong>96</strong>
          <span>Đang theo dõi</span>
        </div>
      </div>
    </div>

    <!-- 3. Tab -->
    <div class="cac-tab-ca-nhan">
      <button type="button" class="tab-ca-nhan dang-chon">Công thức của tôi</button>
      <button type="button" class="tab-ca-nhan">Món đã lưu</button>
    </div>

    <!-- 4. Công thức của tôi: JS đổ bài viết từ localStorage vào đây -->
    <div class="khu-vuc-cong-thuc-ca-nhan">
      <div class="danh-sach-bai-viet-cua-toi luoi-mon-an-cn"></div>
    </div>

    <!-- 5. Món đã lưu: lấy từ session -->
    <?php if (!empty($cacMonYeuThich)): ?>

      <div class="khu-vuc-mon-da-luu">
        <div class="danh-sach-mon-an">
          <?php foreach ($cacMonYeuThich as $dong): ?>
            <?php $mon = $dong['monAn']; ?>

            <article class="the-mon-an">
              <div class="khung-anh-mon">
                <img
                  src="<?= e($mon->hinhAnh) ?>"
                  alt="<?= e($mon->ten) ?>"
                  width="300"
                  height="200"
                  loading="lazy"
                >
              </div>

              <div class="noi-dung-the-mon">
                <h3><?= e($mon->ten) ?></h3>

                <p><?= e($mon->moTa) ?></p>

                <p class="thong-tin-phu">
                  <?= (int) $mon->thoiGian ?> phút ·
                  Số lượng: <?= (int) $dong['soLuong'] ?> ·
                  Thành tiền: <?= vnd($dong['thanhTien']) ?>
                </p>

                <a href="chi-tiet.php?id=<?= e($mon->id) ?>" class="nut">
                  Xem chi tiết
                </a>
              </div>
            </article>

          <?php endforeach; ?>
        </div>
      </div>

    <?php else: ?>

      <div class="khu-vuc-mon-da-luu">
        <p class="thong-bao-trong">
          Bạn chưa thêm món ăn nào vào danh sách yêu thích!
        </p>

        <a href="danh-sach.php" class="nut">
          Khám phá món ăn ngay
        </a>
      </div>

    <?php endif; ?>

  </div>
</main>

<?php require __DIR__ . '/inc/footer.php'; ?>