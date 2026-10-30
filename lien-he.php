<?php
/**
 * Tệp: lien-he.php
 * Website Cook with me - Nhóm 04
 * Chức năng: Tiếp nhận liên hệ, upload ảnh an toàn,
 * lưu dữ liệu vào MySQL bằng PDO và áp dụng PRG.
 */

use App\Services\LienHeService;

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/src/Services/LienHeService.php';

$duLieu = [
    'ho_ten' => '',
    'email' => '',
    'subject' => '',
    'noi_dung' => ''
];

$loi = [];

// XỬ LÝ BIỂU MẪU POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $duLieu['ho_ten'] = trim(
        is_string($_POST['ho_ten'] ?? null)
            ? $_POST['ho_ten'] : ''
    );

    $duLieu['email'] = trim(
        is_string($_POST['email'] ?? null)
            ? $_POST['email'] : ''
    );

    $duLieu['subject'] = trim(
        is_string($_POST['subject'] ?? null)
            ? $_POST['subject'] : ''
    );

    $duLieu['noi_dung'] = trim(
        is_string($_POST['noi_dung'] ?? null)
            ? $_POST['noi_dung'] : ''
    );

    // 1. KIỂM TRA DỮ LIỆU PHÍA MÁY CHỦ
    if (
        mb_strlen($duLieu['ho_ten'], 'UTF-8') < 2 ||
        mb_strlen($duLieu['ho_ten'], 'UTF-8') > 100
    ) {
        $loi['ho_ten'] = 'Họ tên phải từ 2 đến 100 ký tự!';
    }

    if (
        strlen($duLieu['email']) > 254 ||
        !filter_var($duLieu['email'], FILTER_VALIDATE_EMAIL)
    ) {
        $loi['email'] = 'Email không hợp lệ!';
    }

    $chuDeHopLe = [
        'gop-y',
        'phan-hoi',
        'bao-loi',
        'gui-cong-thuc'
    ];

    if (!in_array($duLieu['subject'], $chuDeHopLe, true)) {
        $loi['subject'] = 'Vui lòng chọn chủ đề liên hệ hợp lệ!';
    }

    $doDaiNoiDung = mb_strlen(
        $duLieu['noi_dung'],
        'UTF-8'
    );

    if ($doDaiNoiDung < 10) {
        $loi['noi_dung'] =
            'Nội dung liên hệ phải từ 10 ký tự!';
    } elseif ($doDaiNoiDung > 500) {
        $loi['noi_dung'] =
            'Nội dung liên hệ không được vượt quá 500 ký tự!';
    }

    // 2. KIỂM TRA ẢNH ĐÍNH KÈM
    $tenAnhNhatKy = null;
    $tepAnhHopLe = null;
    $duoiAnh = '';

    if (isset($_FILES['anh_dinh_kem'])) {
        $file = $_FILES['anh_dinh_kem'];

        if (!is_array($file['error'] ?? null)) {
            $maLoi = $file['error'] ?? UPLOAD_ERR_NO_FILE;

            if ($maLoi === UPLOAD_ERR_OK) {

                if (
                    !is_string($file['tmp_name'] ?? null) ||
                    !is_uploaded_file($file['tmp_name'])
                ) {
                    $loi['anh_dinh_kem'] =
                        'Tệp tải lên không hợp lệ.';
                } elseif (
                    !is_int($file['size'] ?? null) ||
                    $file['size'] > 2 * 1024 * 1024
                ) {
                    $loi['anh_dinh_kem'] =
                        'Dung lượng ảnh không được vượt quá 2 MB!';
                } else {
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mime = $finfo->file($file['tmp_name']);

                    $mimeHopLe = [
                        'image/jpeg' => '.jpg',
                        'image/png' => '.png',
                        'image/webp' => '.webp'
                    ];

                    if (!isset($mimeHopLe[$mime])) {
                        $loi['anh_dinh_kem'] =
                            'Chỉ chấp nhận ảnh JPG, PNG hoặc WEBP!';
                    } else {
                        $tepAnhHopLe = $file['tmp_name'];
                        $duoiAnh = $mimeHopLe[$mime];
                    }
                }

            } elseif ($maLoi !== UPLOAD_ERR_NO_FILE) {
                $loi['anh_dinh_kem'] =
                    'Đã xảy ra lỗi khi tải ảnh lên. Vui lòng thử lại!';
            }
        } else {
            $loi['anh_dinh_kem'] =
                'Dữ liệu tệp đính kèm không hợp lệ.';
        }
    }

    // 3. LƯU ẢNH VÀ PHẢN HỒI VÀO MYSQL
    if (empty($loi)) {

        $anhDaLuu = null;

        if ($tepAnhHopLe !== null) {
            $thuMucUpload = __DIR__ . '/uploads/';

            if (
                !is_dir($thuMucUpload) &&
                !mkdir($thuMucUpload, 0755, true) &&
                !is_dir($thuMucUpload)
            ) {
                $loi['anh_dinh_kem'] =
                    'Không thể tạo thư mục lưu ảnh.';
            } else {
                $tenAnhNhatKy = bin2hex(
                    random_bytes(16)
                ) . $duoiAnh;

                $duongDanAnh = $thuMucUpload . $tenAnhNhatKy;

                if (
                    move_uploaded_file(
                        $tepAnhHopLe,
                        $duongDanAnh
                    )
                ) {
                    $anhDaLuu = $duongDanAnh;
                } else {
                    $loi['anh_dinh_kem'] =
                        'Không thể lưu ảnh đính kèm.';
                    $tenAnhNhatKy = null;
                }
            }
        }

        if (empty($loi)) {
            $service = new LienHeService(db());

            $daLuu = $service->guiPhanHoi([
                'ho_ten' => $duLieu['ho_ten'],
                'email' => $duLieu['email'],
                'subject' => $duLieu['subject'],
                'noi_dung' => $duLieu['noi_dung'],
                'anh' => $tenAnhNhatKy
            ]);

            if ($daLuu) {
                gan_thong_bao(
                    'success',
                    'Gửi thông tin liên hệ thành công! Cảm ơn bạn đã đóng góp.'
                );

                // POST/Redirect/GET
                chuyen_huong('lien-he.php');
                exit;
            }

            // Tránh để lại ảnh không có bản ghi MySQL
            if ($anhDaLuu !== null && is_file($anhDaLuu)) {
                unlink($anhDaLuu);
            }

            $loi['luu_du_lieu'] =
                'Không thể lưu liên hệ vào hệ thống. Vui lòng thử lại.';
        }
    }
}

// THÔNG SỐ TRANG
$tieuDe = 'Liên hệ';
$trang = 'lien-he';
$customJS = 'js/trang-lien-he.js';

require __DIR__ . '/inc/header.php';
?>

<main class="lien-he-trang">

    <!-- BANNER ĐẦU TRANG -->
    <section class="lien-he-banner">

        <div class="lien-he-banner-icon">
            <img
                src="images/icons/info.svg"
                alt="Icon Liên hệ"
                class="icon-svg-banner"
            >
        </div>

        <div class="lien-he-banner-noi-dung">
            <h1 class="tieu-de-lien-he">
                Liên hệ với chúng tôi
            </h1>

            <p class="tieu-de-phu-lien-he">
                Chúng tôi luôn sẵn sàng lắng nghe ý kiến của bạn!
            </p>
        </div>

    </section>

    <div class="khu-vuc-lien-he">

        <!-- CỘT TRÁI: FORM LIÊN HỆ -->
        <div class="khu-vuc-form-lien-he">

            <?= hien_thi_thong_bao() ?>

            <?php if (isset($loi['luu_du_lieu'])): ?>
                <p
                    class="thong-bao-loi"
                    role="alert"
                    style="color:#b42318;"
                >
                    <?= e($loi['luu_du_lieu']) ?>
                </p>
            <?php endif; ?>

            <noscript>
                <p class="thong-bao-noscript">
                    JavaScript đang được tắt.
                    Bạn vẫn có thể gửi biểu mẫu bằng
                    cơ chế gửi biểu mẫu HTML thông thường.
                    Việc kiểm tra dữ liệu vẫn được
                    thực hiện tại máy chủ.
                </p>
            </noscript>

            <form
                class="form-lien-he"
                action="lien-he.php"
                method="post"
                enctype="multipart/form-data"
                novalidate
            >

                <!-- HỌ VÀ TÊN -->
                <div class="truong-form">

                    <label for="full-name">
                        Họ và tên
                        <span class="bat-buoc">*</span>
                    </label>

                    <input
                        type="text"
                        id="full-name"
                        name="ho_ten"
                        placeholder="Nhập họ và tên"
                        value="<?= e($duLieu['ho_ten']) ?>"
                        required
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
                <div class="truong-form">

                    <label for="email">
                        Email
                        <span class="bat-buoc">*</span>
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Nhập email"
                        value="<?= e($duLieu['email']) ?>"
                        required
                    >

                    <?php if (isset($loi['email'])): ?>
                        <span
                            class="thong-bao-loi"

                        >
                            <?= e($loi['email']) ?>
                        </span>
                    <?php endif; ?>

                </div>

                <!-- CHỦ ĐỀ -->
                <div class="truong-form">

                    <label for="subject">
                        Chủ đề
                        <span class="bat-buoc">*</span>
                    </label>

                    <select
                        id="subject"
                        name="subject"
                        required
                    >

                        <option value="">
                            Chọn chủ đề
                        </option>

                        <option
                            value="gop-y"
                            <?= $duLieu['subject'] === 'gop-y'
                                ? 'selected' : '' ?>
                        >
                            Góp ý
                        </option>

                        <option
                            value="phan-hoi"
                            <?= $duLieu['subject'] === 'phan-hoi'
                                ? 'selected' : '' ?>
                        >
                            Phản hồi
                        </option>

                        <option
                            value="bao-loi"
                            <?= $duLieu['subject'] === 'bao-loi'
                                ? 'selected' : '' ?>
                        >
                            Báo lỗi website
                        </option>

                        <option
                            value="gui-cong-thuc"
                            <?= $duLieu['subject'] === 'gui-cong-thuc'
                                ? 'selected' : '' ?>
                        >
                            Gửi công thức
                        </option>

                    </select>

                    <?php if (isset($loi['subject'])): ?>
                        <span
                            class="thong-bao-loi"

                        >
                            <?= e($loi['subject']) ?>
                        </span>
                    <?php endif; ?>

                </div>

                <!-- ẢNH ĐÍNH KÈM -->
                <div class="truong-form">

                    <label for="anh-dinh-kem">
                        Ảnh đính kèm (Tùy chọn)
                    </label>

                    <input
                        type="file"
                        id="anh-dinh-kem"
                        name="anh_dinh_kem"
                        accept="image/jpeg,image/png,image/webp"
                    >

                    <?php if (isset($loi['anh_dinh_kem'])): ?>
                        <span
                            class="thong-bao-loi"

                        >
                            <?= e($loi['anh_dinh_kem']) ?>
                        </span>
                    <?php endif; ?>

                </div>

                <!-- NỘI DUNG -->
                <div class="truong-form">

                    <label for="message">
                        Nội dung
                        <span class="bat-buoc">*</span>
                    </label>

                    <textarea
                        id="message"
                        name="noi_dung"
                        rows="5"
                        maxlength="500"
                        placeholder="Nhập nội dung..."
                        required
                    ><?= e($duLieu['noi_dung']) ?></textarea>

                    <?php if (isset($loi['noi_dung'])): ?>
                        <span
                            class="thong-bao-loi"

                        >
                            <?= e($loi['noi_dung']) ?>
                        </span>
                    <?php endif; ?>

                </div>

                <!-- NÚT GỬI -->
                <div class="hanh-dong-lien-he">

                    <button
                        class="nut nut-gui-lien-he"
                        type="submit"
                    >

                        <img
                            src="images/icons/email.svg"
                            alt=""
                            class="icon-svg-btn"
                        >

                        Gửi

                    </button>

                </div>

            </form>

        </div>

        <!-- CỘT PHẢI: THÔNG TIN LIÊN HỆ -->
        <aside class="thong-tin-lien-he">

            <section class="the-thong-tin-lien-he">

                <h2>Thông tin liên hệ</h2>

                <div class="thong-tin-lien-he-item">

                    <span class="khung-icon-svg">
                        <img
                            src="images/icons/email.svg"
                            alt="Email"
                            class="icon-svg-lh"
                        >
                    </span>

                    <div class="noi-dung-item-lh">
                        <strong>Email</strong>
                        <p>cookwithme@gmail.com</p>
                    </div>

                </div>

                <div class="thong-tin-lien-he-item">

                    <span class="khung-icon-svg">
                        <img
                            src="images/icons/phone.svg"
                            alt="Điện thoại"
                            class="icon-svg-lh"
                        >
                    </span>

                    <div class="noi-dung-item-lh">
                        <strong>Điện thoại</strong>
                        <p>0123 456 789</p>
                    </div>

                </div>

                <div class="thong-tin-lien-he-item">

                    <span class="khung-icon-svg">
                        <img
                            src="images/icons/location.svg"
                            alt="Địa chỉ"
                            class="icon-svg-lh"
                        >
                    </span>

                    <div class="noi-dung-item-lh">
                        <strong>Địa chỉ</strong>
                        <p>Đà Nẵng, Việt Nam</p>
                    </div>

                </div>

            </section>

            <!-- MẠNG XÃ HỘI -->
            <section class="the-thong-tin-lien-he">

                <h2>Kết nối với chúng tôi</h2>

                <div class="mang-xa-hoi-lien-he">

                    <a href="#">
                        <img
                            src="images/icons/social-facebook.svg"
                            alt="Facebook"
                            class="icon-svg-social"
                        >
                    </a>

                    <a href="#">
                        <img
                            src="images/icons/social-instagram.svg"
                            alt="Instagram"
                            class="icon-svg-social"
                        >
                    </a>

                    <a href="#">
                        <img
                            src="images/icons/social-youtube.svg"
                            alt="YouTube"
                            class="icon-svg-social"
                        >
                    </a>

                    <a href="#">
                        <img
                            src="images/icons/social-tiktok.svg"
                            alt="TikTok"
                            class="icon-svg-social"
                        >
                    </a>

                </div>

            </section>

            <!-- LỜI NHẮN -->
            <div class="loi-nhan-lien-he">

                <img
                    src="images/icons/chef.svg"
                    alt="Chef"
                    class="icon-svg-card"
                >

                <p>
                    Bạn cũng có thể gửi công thức
                    hoặc góp ý cho Cook with Me!
                </p>

            </div>

        </aside>

    </div>

</main>

<?php
require __DIR__ . '/inc/footer.php';
?>
