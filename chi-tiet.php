<?php
// 1. PHẦN XỬ LÝ LOGIC (Không echo)
require __DIR__ . '/inc/config.php';

use App\Data\KhoMonAn;

// Thực hiện khai báo dữ liệu, lấy danh sách từ JSON
$kho      = new KhoMonAn(__DIR__ . '/data/mon-an.json');
$danhSach = $kho->tatCa(); 

$loiChung = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $matKhau = $_POST['mat_khau'] ?? '';
    $danhSachTaiKhoan = require __DIR__ . '/inc/tai-khoan.php';

    if (isset($danhSachTaiKhoan[$email]) && password_verify($matKhau, $danhSachTaiKhoan[$email]['mat_khau'])) {
        session_regenerate_id(true); // Cấp mã phiên mới phòng chống Session Fixation
        $_SESSION['user'] = $danhSachTaiKhoan[$email];
        gan_thong_bao('success', 'Đăng nhập thành công!');
        chuyen_huong('quan-tri.php');
    } else {
        // Ghi log đăng nhập thất bại
        $logMsg = sprintf("[%s] Đăng nhập thất bại - Email: %s - IP: %s\n", date('Y-m-d H:i:s'), $email, $_SERVER['REMOTE_ADDR']);
        file_put_contents(__DIR__ . '/logs/access-error.log', $logMsg, FILE_APPEND);
        
        $loiChung = 'Email hoặc mật khẩu không chính xác!';
    }
}

// Thiết lập thông số header
$tieuDe   = 'Đăng nhập'; 
$trang    = 'dang-nhap';
$customJS = 'js/trang-dang-nhap.js';

// Nhúng Header (đã bao gồm Nav)
require __DIR__ . '/inc/header.php';
?>

<main class="dang-nhap-trang">

    <h1>Đăng nhập</h1>

    <div class="khung-dang-nhap">

        <div class="the-dang-nhap">

            <header class="tieu-de-dang-nhap">
                <p>
                    Đăng nhập để quản lý tài khoản và chia sẻ công thức của bạn.
                </p>
            </header>

            <?php if (!empty($loiChung)): ?>
                <div class="thong-bao-loi" style="color: red; margin-bottom: 15px;">
                    <?= e($loiChung) ?>
                </div>
            <?php endif; ?>

            <form
                class="form-dang-nhap"
                action="dang-nhap.php"
                method="post"
                novalidate
            >

                <div class="nhom-truong">

                    <label for="email-dang-nhap">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email-dang-nhap"
                        name="email"
                        autocomplete="email"
                        required
                        placeholder="Nhập email"
                    >

                </div>


                <div class="nhom-truong">

                    <label for="mat-khau-dang-nhap">
                        Mật khẩu
                    </label>

                    <input
                        type="password"
                        id="mat-khau-dang-nhap"
                        name="mat_khau"
                        autocomplete="current-password"
                        required
                        placeholder="Nhập mật khẩu"
                    >

                </div>


                <button
                    type="submit"
                    class="nut nut-dang-nhap"
                >
                    Đăng nhập
                </button>


                <p class="thong-tin-chuyen-trang">

                    Chưa có tài khoản?

                    <a href="dang-ky.php">
                        Đăng ký
                    </a>

                </p>

            </form>

        </div>

    </div>

</main>

<?php
require __DIR__ . '/inc/footer.php';
?>