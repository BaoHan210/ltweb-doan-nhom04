<?php
require __DIR__ . '/inc/config.php';

use App\Data\KhoMonAn;
use App\Services\YeuThichService;

if (!isset($_SESSION['user'])) {
    chuyen_huong('dang-nhap.php');
    exit;
}

$user   = $_SESSION['user'];
$hoTen  = $user['hoTen'] ?? $user['ho_ten'] ?? 'Phan Thị Bảo Hân (Trưởng nhóm)';
$email  = $user['email'] ?? '';
$avatar = !empty($user['avatar']) ? $user['avatar'] : 'images/icons/avt-default.svg';

$kho         = new KhoMonAn(__DIR__ . '/data/mon-an.json');
$danhSachRaw = $kho->layTatCa();

$yeuThichService = new YeuThichService();
$danhSachYeuThich = $yeuThichService->danhSachMonAn($kho);

// Chuẩn hóa dữ liệu tương thích chính xác với Object từ KhoMonAn
$danhSach = array_map(function($item) {
    $id = '';
    $ten = 'Món ăn';
    $hinhAnh = ['images/cao-lau.jpg'];
    $thoiGian = 30;
    $khauPhan = 2;
    $moTa = '';

    if (is_object($item)) {
        $id       = $item->id ?? $item->maMon ?? (method_exists($item, 'getId') ? $item->getId() : '');
        $ten      = $item->ten ?? $item->tenMon ?? (method_exists($item, 'getTen') ? $item->getTen() : 'Món ăn');
        $hinhAnh  = $item->hinhAnh ?? (method_exists($item, 'getHinhAnh') ? $item->getHinhAnh() : ['images/cao-lau.jpg']);
        $thoiGian = $item->thoiGian ?? $item->thoiGianNau ?? (method_exists($item, 'getThoiGian') ? $item->getThoiGian() : 30);
        $khauPhan = $item->khauPhan ?? $item->soNguoiAn ?? (method_exists($item, 'getKhauPhan') ? $item->getKhauPhan() : 2);
        $moTa     = $item->moTa ?? (method_exists($item, 'getMoTa') ? $item->getMoTa() : '');
    } elseif (is_array($item)) {
        $id       = $item['id'] ?? $item['maMon'] ?? $item['ma_mon'] ?? '';
        $ten      = $item['ten'] ?? $item['tenMon'] ?? $item['ten_mon'] ?? 'Món ăn';
        $hinhAnh  = $item['hinhAnh'] ?? $item['hinh_anh'] ?? ['images/cao-lau.jpg'];
        $thoiGian = $item['thoiGian'] ?? $item['thoi_gian'] ?? 30;
        $khauPhan = $item['khauPhan'] ?? $item['khau_phan'] ?? 2;
        $moTa     = $item['moTa'] ?? $item['mo_ta'] ?? '';
    }

    return [
        'id'          => (string)$id,
        'tenMon'      => $ten,
        'hinhAnh'     => $hinhAnh,
        'thoiGianNau' => $thoiGian,
        'soNguoiAn'   => $khauPhan,
        'moTa'        => $moTa
    ];
}, $danhSachRaw);

$tieuDe   = 'Trang cá nhân - Cook with Me'; 
$trang    = 'ca-nhan'; 
$customJS = 'js/trang-ca-nhan.js'; 

require __DIR__ . '/inc/header.php';
?>

<!-- Đảm bảo truyền mảng dữ liệu đã chuẩn hóa vào JavaScript -->
<script>
  window.danhSachMonAnGoc = <?= json_encode($danhSach, JSON_UNESCAPED_UNICODE) ?>;
</script>

<main class="ca-nhan-trang bao" style="padding-top: 16px; padding-bottom: 40px;">
  <div class="khung-ca-nhan-card">
    
    <!-- 1. Banner ảnh bìa món ăn -->
    <div class="anh-bia-ca-nhan">
      <img src="images/cao-lau.jpg" alt="Ảnh bìa trang cá nhân" onerror="this.src='images/cao-lau.jpg'">
    </div>

    <!-- 2. Khối thông tin cá nhân & Thống kê -->
    <div class="phong-so-ca-nhan">
      <div class="hang-thong-tin-top">
        <div class="khoi-avatar-ten">
          <div class="anh-dai-dien-ca-nhan">
            <img src="<?= e($avatar) ?>" alt="<?= e($hoTen) ?>" class="avatar-img-cn" onerror="this.onerror=null; this.src='images/icons/avt-default.svg';">
          </div>
          <div class="noi-dung-ca-nhan">
            <h1 class="ten-nguoi-dung"><?= e($hoTen) ?></h1>
            <p class="mo-ta-nguoi-dung">Người yêu thích nấu ăn</p>
          </div>
        </div>
        
        <a href="cai-dat.php" class="nut-chinh-sua-cn">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
          Chỉnh sửa
        </a>
      </div>

      <!-- Khối thống kê 3 chỉ số -->
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

    <!-- 3. Thanh Tab Công thức / Món đã lưu -->
    <div class="cac-tab-ca-nhan">
      <button type="button" class="tab-ca-nhan dang-chon">Công thức của tôi</button>
      <button type="button" class="tab-ca-nhan">Món đã lưu</button>
    </div>

    <!-- 4. Lưới hiển thị danh sách công thức -->
    <div class="khu-vuc-cong-thuc-ca-nhan">
      <div class="danh-sach-bai-viet-cua-toi luoi-mon-an-cn"></div>
    </div>

    <!-- 5. Lưới món đã lưu (Để trống hoàn toàn để JS đổ khung vào) -->
    <?php if (!empty($danhSachYeuThich)): ?>

  <div class="khu-vuc-mon-da-luu">

    <div class="danh-sach-mon-an">
      <?php foreach ($danhSachYeuThich as $monAn): ?>

        <article class="the-mon-an">

          <div class="khung-anh-mon">
            <img
              src="<?= e($monAn->hinhAnh) ?>"
              alt="<?= e($monAn->ten) ?>"
              width="300"
              height="200"
              loading="lazy"
            >
          </div>

          <div class="noi-dung-the-mon">
            <h3><?= e($monAn->ten) ?></h3>

            <p>
              <?= e($monAn->moTa) ?>
            </p>

            <p class="thong-tin-phu">
              <?= (int)$monAn->thoiGian ?> phút ·
              <?= (int)$monAn->khauPhan ?> người
            </p>

            <a
              href="chi-tiet.php?id=<?= e($monAn->id) ?>"
              class="nut"
            >
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

<?php
require_once __DIR__ . '/inc/footer.php';
?>