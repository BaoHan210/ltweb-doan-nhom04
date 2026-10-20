<?php
require_once __DIR__ . '/inc/bao-ve.php'; // Bắt buộc phải đăng nhập

// 1. Đọc dữ liệu thư liên hệ từ file log .jsonl
$danhSachPhanHoi = [];
$tepLog = __DIR__ . '/storage/lien-he.jsonl';

if (is_file($tepLog)) {
    $dong = file($tepLog, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($dong as $d) {
        $data = json_decode($d, true);
        if (is_array($data)) {
            array_unshift($danhSachPhanHoi, $data);
        } else {
            array_unshift($danhSachPhanHoi, [
                'ngay_gui' => 'N/A',
                'ho_ten'   => 'Khách',
                'email'    => 'N/A',
                'noi_dung' => $d,
                'anh'      => ''
            ]);
        }
    }
}

// 2. Thống kê giả lập số liệu tổng quan
$tongNguoiDung = 1248;
$tongMonAn     = 856;
$tongBaiViet   = 624;
$tongBinhLuan  = 2341;

// Top món ăn được yêu thích
$topMonAnYeuThich = [
    ['ten' => 'Phở bò', 'luotThich' => '1.2k', 'hinh' => 'images/pho-bo.jpg'],
    ['ten' => 'Gà rán giòn', 'luotThich' => '856', 'hinh' => 'images/ga-ran.jpg'],
    ['ten' => 'Trà sữa trân châu', 'luotThich' => '742', 'hinh' => 'images/tra-sua.jpg']
];

$tieuDe   = 'Trang quản trị - Cook with Me';
$trang    = 'quan-tri';
$customJS = 'js/trang-quan-tri.js';

require_once __DIR__ . '/inc/header.php';

$userLog = $_SESSION['user'] ?? $_SESSION['nguoi_dung'] ?? [];
$tenAdmin = $userLog['ho_ten'] ?? $userLog['hoTen'] ?? $userLog['email'] ?? 'admin admin';
$avatarAdmin = !empty($userLog['avatar']) ? $userLog['avatar'] : 'images/icons/avt-default.svg';
?>

<!-- Nhúng thư viện Chart.js vẽ biểu đồ -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<main class="trang-quan-tri-container">
  <div class="khung-quan-tri-layout">
    
    <!-- CỘT TRÁI: SIDEBAR ĐIỀU HƯỚNG QUẢN TRỊ -->
    <aside class="sidebar-quan-tri">
      <div class="the-nguoi-dung-admin">
        <img src="<?= e($avatarAdmin) ?>" alt="Admin" onerror="this.src='images/icons/avt-default.svg'">
        <div>
          <p class="ten-admin"><?= e($tenAdmin) ?></p>
          <span class="chuc-vu-admin">Quản trị viên</span>
        </div>
      </div>

      <nav class="menu-dieu-huong-quan-tri">
        <a href="quan-tri.php" class="item-menu-qt active">
          <span>🏠</span> Tổng quan
        </a>
        <a href="#quan-ly-nguoi-dung" class="item-menu-qt">
          <span>👥</span> Quản lý người dùng
        </a>
        <a href="#quan-ly-mon-an" class="item-menu-qt">
          <span>👨‍🍳</span> Quản lý món ăn
        </a>
        <a href="#quan-ly-danh-muc" class="item-menu-qt">
          <span>📋</span> Quản lý danh mục
        </a>
        <a href="#quan-ly-binh-luan" class="item-menu-qt">
          <span>📝</span> Quản lý bình luận
        </a>
        <a href="#thong-ke" class="item-menu-qt">
          <span>🔍</span> Thống kê
        </a>
        <a href="cai-dat.php" class="item-menu-qt">
          <span>⚙️</span> Cài đặt
        </a>
      </nav>
    </aside>

    <!-- CỘT PHẢI: DASHBOARD NỘI DUNG -->
    <section class="noi-dung-dashboard">
      
      <!-- Hàng Tiêu đề & Nút Chỉnh sửa -->
      <div class="thanh-tieu-de-dashboard">
        <h1>Tổng quan</h1>
        <a href="cai-dat.php" class="nut-chinh-sua-qt">Chỉnh sửa</a>
      </div>

      <!-- 1. BỘ 4 THẺ THỐNG KÊ -->
      <div class="luoi-the-thong-ke">
        <div class="the-thong-ke-item">
          <div class="bieu-tuong-thong-ke">👥</div>
          <div>
            <span class="label-thong-ke">Người dùng</span>
            <strong class="gia-tri-thong-ke"><?= number_format($tongNguoiDung) ?></strong>
          </div>
        </div>

        <div class="the-thong-ke-item">
          <div class="bieu-tuong-thong-ke">👨‍🍳</div>
          <div>
            <span class="label-thong-ke">Món ăn</span>
            <strong class="gia-tri-thong-ke"><?= number_format($tongMonAn) ?></strong>
          </div>
        </div>

        <div class="the-thong-ke-item">
          <div class="bieu-tuong-thong-ke">📄</div>
          <div>
            <span class="label-thong-ke">Bài viết</span>
            <strong class="gia-tri-thong-ke"><?= number_format($tongBaiViet) ?></strong>
          </div>
        </div>

        <div class="the-thong-ke-item">
          <div class="bieu-tuong-thong-ke">💬</div>
          <div>
            <span class="label-thong-ke">Bình luận</span>
            <strong class="gia-tri-thong-ke"><?= number_format($tongBinhLuan) ?></strong>
          </div>
        </div>
      </div>

      <!-- 2. KHU VỰC BIỂU ĐỒ HOẠT ĐỘNG -->
      <div class="khung-noi-dung-qt">
        <div class="thanh-tieu-de-dashboard">
          <h2>Thống kê hoạt động</h2>
          <div style="display: flex; gap: 16px; font-size: 13px; color: #718096;">
            <span><strong style="color: #2E7D32;">—</strong> Bài viết</span>
            <span><strong style="color: #FFA726;">—</strong> Lượt thích</span>
          </div>
        </div>
        <div style="height: 260px;">
          <canvas id="bieuDoHoatDong"></canvas>
        </div>
      </div>

      <!-- 3. BẢNG MÓN ĂN ĐƯỢC YÊU THÍCH -->
      <div class="khung-noi-dung-qt">
        <h2>Món ăn được yêu thích</h2>
        <div style="display: flex; flex-direction: column; gap: 12px;">
          <?php foreach ($topMonAnYeuThich as $index => $mon): ?>
            <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 12px; border-bottom: 1px solid #EDF2F7;">
              <div style="display: flex; align-items: center; gap: 16px;">
                <span style="font-weight: 600; color: #718096; width: 20px;"><?= ($index + 1) ?>.</span>
                <img src="<?= e($mon['hinh']) ?>" alt="" style="width: 48px; height: 48px; border-radius: 12px; object-fit: cover;" onerror="this.src='images/cao-lau.jpg'">
                <strong style="font-size: 15px; color: #2D3748;"><?= e($mon['ten']) ?></strong>
              </div>
              <span style="font-size: 13px; color: #718096;"><?= e($mon['luotThich']) ?> lượt thích</span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- 4. DANH SÁCH THƯ LIÊN HỆ ĐÃ NHẬN -->
      <div class="khung-noi-dung-qt">
        <h2>Danh sách Thư liên hệ đã nhận</h2>
        <?php if (empty($danhSachPhanHoi)): ?>
          <p style="padding: 16px; background: #EBF8FF; color: #2B6CB0; border-radius: 8px;">Chưa có thư liên hệ nào trong hệ thống.</p>
        <?php else: ?>
          <div style="overflow-x: auto;">
            <table class="bang-du-lieu-qt">
              <thead>
                <tr>
                  <th>Thời gian</th>
                  <th>Họ tên</th>
                  <th>Email</th>
                  <th>Nội dung</th>
                  <th style="text-align: center;">Ảnh</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($danhSachPhanHoi as $lh): ?>
                  <tr>
                    <td style="color: #718096; font-size: 12px;"><?= e($lh['ngay_gui'] ?? 'N/A') ?></td>
                    <td style="font-weight: 600; color: #2D3748;"><?= e($lh['ho_ten'] ?? 'Chưa nhập') ?></td>
                    <td><a href="mailto:<?= e($lh['email'] ?? '') ?>" style="color: #3182CE; text-decoration: none;"><?= e($lh['email'] ?? '') ?></a></td>
                    <td style="max-width: 250px; word-break: break-word; color: #4A5568;"><?= e($lh['noi_dung'] ?? '') ?></td>
                    <td style="text-align: center;">
                      <?php if (!empty($lh['anh'])): ?>
                        <a href="uploads/<?= e($lh['anh']) ?>" target="_blank">
                          <img src="uploads/<?= e($lh['anh']) ?>" alt="" style="width: 40px; height: 40px; border-radius: 6px; object-fit: cover;">
                        </a>
                      <?php else: ?>
                        <span style="color: #A0AEC0; font-size: 12px;">Không</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>

    </section>

  </div>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>