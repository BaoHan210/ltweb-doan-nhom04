<?php
// 1. PHẦN XỬ LÝ LOGIC
require __DIR__ . '/inc/config.php';

// Kiểm tra và kích hoạt Session nếu hệ thống chưa bật
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$loiChung = '';
$email    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $matKhau = $_POST['mat_khau'] ?? '';
    $danhSachTaiKhoan = require __DIR__ . '/inc/tai-khoan.php';

    if (isset($danhSachTaiKhoan[$email]) && password_verify($matKhau, $danhSachTaiKhoan[$email]['mat_khau'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = $danhSachTaiKhoan[$email];
        gan_thong_bao('success', 'Đăng nhập thành công!');
        chuyen_huong('quan-tri.php');
    } else {
        $logMsg = sprintf("[%s] Đăng nhập thất bại - Email: %s - IP: %s\n", date('Y-m-d H:i:s'), $email, $_SERVER['REMOTE_ADDR']);
        file_put_contents(__DIR__ . '/logs/access-error.log', $logMsg, FILE_APPEND);
        
        $loiChung = 'Email hoặc mật khẩu không chính xác!';
    }
}

// Thiết lập thông số header
$tieuDe   = 'Đăng nhập - Cook with Me'; 
$trang    = 'dang-nhap'; 
$customJS = 'js/trang-dang-nhap.js'; 

// Nhúng Header (đã bao gồm Nav)
require __DIR__ . '/inc/header.php';
?>

<main class="trang-dang-nhap-container">

  <div class="khung-dang-nhap-moi">
    
    <!-- Logo & Slogan trong Card -->
<div class="header-card-dang-nhap">
  <div class="logo-dang-nhap">
    <img src="<?= URL_GOC ?>images/icons/chef.svg" alt="Cook with Me Logo" class="icon-chef-logo">
    <h1>Cook with Me</h1>
  </div>
  <p class="sub-title">Cùng nhau nấu ăn ngon mỗi ngày!</p>
</div>

    <!-- Tab Đăng nhập / Đăng ký -->
    <div class="tab-dang-nhap-dang-ky">
      <a href="dang-nhap.php" class="tab-item active">Đăng nhập</a>
      <a href="dang-ky.php" class="tab-item">Đăng ký</a>
    </div>

    <!-- Hiển thị thông báo lỗi (nếu có) -->
    <?php if (!empty($loiChung)): ?>
      <div class="thong-bao-loi-dang-nhap">
        <?= e($loiChung) ?>
      </div>
    <?php endif; ?>

    <!-- Biểu mẫu đăng nhập -->
    <form class="form-dang-nhap" action="dang-nhap.php" method="post" novalidate>
      
      <!-- Trường Email -->
      <div class="nhom-truong-nhap">
        <label for="email-dang-nhap">Email</label>
        <input
          type="email"
          id="email-dang-nhap"
          name="email"
          value="<?= e($email) ?>"
          autocomplete="email"
          required
          placeholder="Nhập email"
        >
      </div>

      <!-- Trường Mật khẩu -->
      <div class="nhom-truong-nhap">
        <label for="mat-khau-dang-nhap">Mật khẩu</label>
        <div class="khung-nhap-mat-khau">
          <input
            type="password"
            id="mat-khau-dang-nhap"
            name="mat_khau"
            autocomplete="current-password"
            required
            placeholder="Nhập mật khẩu"
          >
          <button type="button" class="nut-an-hien-mat-khau" id="nut-toggle-mat-khau" aria-label="Hiện hoặc ẩn mật khẩu">
            <svg class="icon-eye" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </button>
        </div>
      </div>

      <!-- Nhớ tài khoản & Quên mật khẩu -->
      <div class="hang-tuy-chon">
        <label class="ghi-nho-label">
          <input type="checkbox" name="nho_tai_khoan" id="nho-tai-khoan">
          <span>Nhớ tài khoản</span>
        </label>
        <a href="#" class="quen-mat-khau">Quên mật khẩu?</a>
      </div>

      <!-- Nút Submit Đăng nhập -->
      <button type="submit" class="nut-submit-dang-nhap">
        Đăng nhập
      </button>

      <!-- Đường phân cách Mạng xã hội -->
      <div class="duong-phat-mang-xa-hoi">
        <span>Hoặc đăng nhập với</span>
      </div>

      <!-- Các nút đăng nhập bằng MXH -->
      <div class="danh-sach-mang-xa-hoi">
        <button type="button" class="nut-mxh google" title="Đăng nhập với Google">
          <svg viewBox="0 0 24 24" width="20" height="20">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
          </svg>
        </button>
        <button type="button" class="nut-mxh facebook" title="Đăng nhập với Facebook">
          <svg viewBox="0 0 24 24" width="20" height="20" fill="#1877F2">
            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
          </svg>
        </button>
        <button type="button" class="nut-mxh apple" title="Đăng nhập với Apple">
          <svg viewBox="0 0 24 24" width="20" height="20" fill="#000000">
            <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.13c.67-.82 1.12-1.96.99-3.13-1 .04-2.23.67-2.93 1.49-.62.72-1.16 1.88-1.01 3.01 1.12.09 2.28-.55 2.95-1.37z"/>
          </svg>
        </button>
      </div>

      <!-- Đăng ký ngay -->
      <p class="chuyen-dang-ky">
        Chưa có tài khoản? <a href="dang-ky.php">Đăng ký ngay</a>
      </p>

    </form>

  </div>

</main>

<?php
require __DIR__ . '/inc/footer.php';
?>