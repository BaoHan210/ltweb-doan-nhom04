<?php
/**
 * Tệp: dang-ky.php
 * Website: Cook with me - Nhóm 04
 *
 * Chức năng:
 * - Đăng ký tài khoản mới
 * - Kiểm tra dữ liệu phía server
 * - Lưu tài khoản vào MySQL qua KhoNguoiDung
 * - Mã hóa mật khẩu bằng password_hash() tại KhoNguoiDung
 * - Chặn email trùng, kể cả trường hợp hai yêu cầu đồng thời (MySQL 1062)
 * - Không lấy vai trò tài khoản từ dữ liệu POST
 * - Không sử dụng data/mon-an.json và inc/tai-khoan.php
 */

use App\Data\KhoNguoiDung;

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/src/Data/KhoNguoiDung.php';

// 1. KHỞI TẠO SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Tạo mã chống gửi biểu mẫu giả mạo (CSRF)
if (empty($_SESSION['csrf_dang_ky'])) {
    $_SESSION['csrf_dang_ky'] = bin2hex(random_bytes(32));
}

// 2. KHAI BÁO DỮ LIỆU BIỂU MẪU
$duLieu = [
    'ho_ten' => '',
    'email' => ''
];

$loi = [];
$loiChung = '';

// 3. XỬ LÝ KHI NGƯỜI DÙNG GỬI BIỂU MẪU
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $duLieu['ho_ten'] = is_string($_POST['ho_ten'] ?? null)
        ? trim($_POST['ho_ten'])
        : '';

    $duLieu['email'] = is_string($_POST['email'] ?? null)
        ? trim($_POST['email'])
        : '';

    $matKhau = is_string($_POST['mat_khau'] ?? null)
        ? $_POST['mat_khau']
        : '';

    $xacNhanMatKhau = is_string($_POST['xac_nhan_mat_khau'] ?? null)
        ? $_POST['xac_nhan_mat_khau']
        : '';

    $dongY = ($_POST['dong_y'] ?? '') === '1';

    $csrf = is_string($_POST['csrf_token'] ?? null)
        ? $_POST['csrf_token']
        : '';

    // 4. KIỂM TRA CSRF
    if (
        $csrf === '' ||
        !hash_equals($_SESSION['csrf_dang_ky'], $csrf)
    ) {
        $loiChung = 'Phiên biểu mẫu không hợp lệ. Vui lòng tải lại trang.';
    }

    // 5. KIỂM TRA HỌ TÊN
    $doDaiHoTen = mb_strlen($duLieu['ho_ten'], 'UTF-8');

    if ($doDaiHoTen < 2 || $doDaiHoTen > 100) {
        $loi['ho_ten'] =
            'Họ tên phải có từ 2 đến 100 ký tự.';
    }

    // 6. KIỂM TRA EMAIL
    if (
        $duLieu['email'] === '' ||
        strlen($duLieu['email']) > 150 ||
        !filter_var($duLieu['email'], FILTER_VALIDATE_EMAIL)
    ) {
        $loi['email'] = 'Email không hợp lệ.';
    }

    // 7. KIỂM TRA MẬT KHẨU
    if (strlen($matKhau) < 8) {
        $loi['mat_khau'] =
            'Mật khẩu phải có ít nhất 8 ký tự.';
    }

    if (strlen($matKhau) > 72) {
        $loi['mat_khau'] =
            'Mật khẩu không được vượt quá 72 byte.';
    }

    // 8. KIỂM TRA XÁC NHẬN MẬT KHẨU
    if ($matKhau !== $xacNhanMatKhau) {
        $loi['xac_nhan_mat_khau'] =
            'Mật khẩu xác nhận không khớp.';
    }

    // 9. KIỂM TRA ĐIỀU KHOẢN
    if (!$dongY) {
        $loi['dong_y'] =
            'Bạn cần đồng ý với điều khoản sử dụng.';
    }

    // 10. LƯU TÀI KHOẢN VÀO MYSQL
    if (empty($loi) && $loiChung === '') {

        $khoNguoiDung = new KhoNguoiDung(db());

        try {
            // Kiểm tra email đã tồn tại
            if ($khoNguoiDung->emailDaTonTai($duLieu['email'])) {

                $loi['email'] =
                    'Email này đã được đăng ký. Vui lòng dùng email khác.';

            } else {

                // KhoNguoiDung::taoTaiKhoan() phải tự password_hash()
                // và đặt vai trò khach_hang ở phía server, bỏ qua mọi
                // trường vai_tro do trình duyệt cố tình gửi lên.
                $daTao = $khoNguoiDung->taoTaiKhoan(
                    $duLieu['ho_ten'],
                    $duLieu['email'],
                    $matKhau
                );

                if ($daTao) {

                    // Tạo mã CSRF mới sau khi đăng ký
                    $_SESSION['csrf_dang_ky'] =
                        bin2hex(random_bytes(32));

                    gan_thong_bao(
                        'success',
                        'Đăng ký tài khoản thành công! Vui lòng đăng nhập.'
                    );

                    // POST / Redirect / GET
                    chuyen_huong('dang-nhap.php');
                    exit;

                } else {

                    $loiChung =
                        'Không thể tạo tài khoản. Vui lòng thử lại.';
                }
            }

        } catch (\PDOException $e) {

            // Ghi lỗi kỹ thuật trong log, không hiện ra giao diện
            error_log(
                'Loi dang ky MySQL: ' . $e->getMessage()
            );

            // Chỉ coi mã MySQL 1062 là email/giá trị UNIQUE bị trùng.
            // Các lỗi ràng buộc khác không nên gộp thành 'email trùng'.
            if ((int) ($e->errorInfo[1] ?? 0) === 1062) {
                $loi['email'] =
                    'Email này đã được đăng ký. Vui lòng dùng email khác.';
            } else {
                $loiChung =
                    'Hệ thống đang gặp lỗi. Vui lòng thử lại.';
            }
        }
    }
}

// 11. THÔNG SỐ TRANG
$tieuDe = 'Đăng ký';
$trang = 'dang-ky';
$customJS = 'js/trang-dang-ky.js';

require __DIR__ . '/inc/header.php';
?>

<main class="dang-ky-trang">

    <div class="khung-dang-ky">

        <article class="the-dang-ky">

            <!-- TIÊU ĐỀ -->
            <header class="tieu-de-dang-ky">

                <h1>Tạo tài khoản</h1>

                <p>
                    Tham gia Cook with me và chia sẻ
                    công thức của bạn.
                </p>

            </header>

            <!-- THÔNG BÁO LỖI CHUNG -->
            <?php if ($loiChung !== ''): ?>
                <div
                    class="thong-bao-loi-dang-nhap"
                    role="alert"
                    style="color:#b42318; margin-bottom:16px;"
                >
                    <?= e($loiChung) ?>
                </div>
            <?php endif; ?>

            <!-- FORM ĐĂNG KÝ -->
            <form
                class="form-dang-ky"
                action="dang-ky.php"
                method="post"
                novalidate
            >

                <!-- CHỐNG CSRF -->
                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= e($_SESSION['csrf_dang_ky']) ?>"
                >

                <!-- HỌ VÀ TÊN -->
                <div class="nhom-truong">

                    <label for="ho-ten">
                        Họ và tên
                    </label>

                    <input
                        type="text"
                        id="ho-ten"
                        name="ho_ten"
                        autocomplete="name"
                        maxlength="100"
                        required
                        placeholder="Nhập họ và tên"
                        value="<?= e($duLieu['ho_ten']) ?>"
                    >

                    <?php if (isset($loi['ho_ten'])): ?>
                        <span
                            class="thong-bao-loi"

                        >
                            <?= e($loi['ho_ten']) ?>
                        </span>
                    <?php endif; ?>

                </div>

                <!-- EMAIL -->
                <div class="nhom-truong">

                    <label for="email-dang-ky">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email-dang-ky"
                        name="email"
                        autocomplete="email"
                        maxlength="150"
                        required
                        placeholder="Nhập email"
                        value="<?= e($duLieu['email']) ?>"
                    >

                    <?php if (isset($loi['email'])): ?>
                        <span
                            class="thong-bao-loi"

                        >
                            <?= e($loi['email']) ?>
                        </span>
                    <?php endif; ?>

                </div>

                <!-- MẬT KHẨU -->
                <div class="nhom-truong">

                    <label for="mat-khau">
                        Mật khẩu
                    </label>

                    <input
                        type="password"
                        id="mat-khau"
                        name="mat_khau"
                        autocomplete="new-password"
                        minlength="8"
                        required
                        placeholder="Nhập mật khẩu"
                    >

                    <?php if (isset($loi['mat_khau'])): ?>
                        <span
                            class="thong-bao-loi"

                        >
                            <?= e($loi['mat_khau']) ?>
                        </span>
                    <?php endif; ?>

                </div>

                <!-- XÁC NHẬN MẬT KHẨU -->
                <div class="nhom-truong">

                    <label for="xac-nhan-mat-khau">
                        Xác nhận mật khẩu
                    </label>

                    <input
                        type="password"
                        id="xac-nhan-mat-khau"
                        name="xac_nhan_mat_khau"
                        autocomplete="new-password"
                        required
                        placeholder="Nhập lại mật khẩu"
                    >

                    <?php if (isset($loi['xac_nhan_mat_khau'])): ?>
                        <span
                            class="thong-bao-loi"

                        >
                            <?= e($loi['xac_nhan_mat_khau']) ?>
                        </span>
                    <?php endif; ?>

                </div>

                <!-- ĐỒNG Ý ĐIỀU KHOẢN -->
                <div class="nhom-dong-y">

                    <label class="nhan-dong-y">

                        <input
                            type="checkbox"
                            id="dong-y-dieu-khoan"
                            name="dong_y"
                            value="1"
                            required
                            <?= ($_POST['dong_y'] ?? '') === '1'
                                ? 'checked' : '' ?>
                        >

                        <span>
                            Tôi đồng ý với
                            <a href="#">Điều khoản sử dụng</a>
                            và
                            <a href="#">Chính sách bảo mật</a>
                        </span>

                    </label>

                    <?php if (isset($loi['dong_y'])): ?>
                        <span
                            class="thong-bao-loi"

                        >
                            <?= e($loi['dong_y']) ?>
                        </span>
                    <?php endif; ?>

                </div>

                <!-- NÚT ĐĂNG KÝ -->
                <button
                    type="submit"
                    class="nut nut-dang-ky-pill"
                >

                    <svg
                        class="icon-btn-dang-ky"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <line x1="19" y1="8" x2="19" y2="14"></line>
                        <line x1="22" y1="11" x2="16" y2="11"></line>
                    </svg>

                    Đăng ký

                </button>

                <!-- ĐƯỜNG PHÂN CÁCH -->
                <div class="duong-phat-mang-xa-hoi">

                    <span>
                        Hoặc đăng ký bằng
                    </span>

                </div>

                <!-- NÚT ĐĂNG KÝ MẠNG XÃ HỘI -->
                <div class="danh-sach-mang-xa-hoi">

                    <!-- GOOGLE -->
                    <button
                        type="button"
                        class="nut-mxh nut-google"
                        title="Đăng ký bằng Google"
                    >
                        <svg
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                        >
                            <path
                                fill="#4285F4"
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                            />
                            <path
                                fill="#34A853"
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                            />
                            <path
                                fill="#FBBC05"
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"
                            />
                            <path
                                fill="#EA4335"
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"
                            />
                        </svg>
                    </button>

                    <!-- FACEBOOK -->
                    <button
                        type="button"
                        class="nut-mxh nut-facebook"
                        title="Đăng ký bằng Facebook"
                    >
                        <svg
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="#1877F2"
                        >
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12 24 5.373 18.627 0 12 0z"
                            />
                        </svg>
                    </button>

                    <!-- APPLE -->
                    <button
                        type="button"
                        class="nut-mxh nut-apple"
                        title="Đăng ký bằng Apple"
                    >
                        <svg
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="#000000"
                        >
                            <path
                                d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.1c.62-.76 1.05-1.82.93-2.88-.91.04-2.03.61-2.68 1.37-.58.67-1.09 1.75-.95 2.79 1.02.08 2.07-.52 2.7-1.28z"
                            />
                        </svg>
                    </button>

                </div>

                <!-- CHUYỂN SANG ĐĂNG NHẬP -->
                <p class="thong-tin-chuyen-trang">

                    Đã có tài khoản?

                    <a href="dang-nhap.php">
                        Đăng nhập ngay
                    </a>

                </p>

            </form>

        </article>

    </div>

</main>

<?php
require __DIR__ . '/inc/footer.php';
?>
