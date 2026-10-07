<?php
// 1. PHẦN XỬ LÝ LÝ THUYẾT / LOGIC (Không echo)
require _DIR_ . '/inc/config.php';
require_once _DIR_ . '/src/Services/LienHeService.php';

use App\Data\KhoMonAn; 
use App\Services\LienHeService;

// Thực hiện khai báo dữ liệu, lấy danh sách từ JSON
$kho      = new KhoMonAn(_DIR_ . '/data/mon-an.json');
$danhSach = $kho->tatCa(); 

$duLieu = ['ho_ten' => '', 'email' => '', 'noi_dung' => ''];
$loi = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $duLieu['ho_ten'] = trim($_POST['ho_ten'] ?? '');
    $duLieu['email'] = trim($_POST['email'] ?? '');
    $duLieu['noi_dung'] = trim($_POST['noi_dung'] ?? '');

    // Validate phía Server
    if (mb_strlen($duLieu['ho_ten'], 'UTF-8') < 2) $loi['ho_ten'] = 'Họ tên phải từ 2 ký tự trở lên!';
    if (!filter_var($duLieu['email'], FILTER_VALIDATE_EMAIL)) $loi['email'] = 'Email không hợp lệ!';
    if (mb_strlen($duLieu['noi_dung'], 'UTF-8') < 10) $loi['noi_dung'] = 'Nội dung liên hệ phải từ 10 ký tự!';

    // Xử lý Upload Ảnh (không bắt buộc)
    $tenAnhNhatKy = null;
    if (isset($_FILES['anh_dinh_kem']) && $_FILES['anh_dinh_kem']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['anh_dinh_kem'];
        if ($file['size'] > 2 * 1024 * 1024) {
            $loi['anh_dinh_kem'] = 'Dung lượng ảnh đính kèm không được vượt quá 2 MB!';
        } else {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($file['tmp_name']);
            $mimeHopLe = ['image/jpeg' => '.jpg', 'image/png' => '.png', 'image/webp' => '.webp'];

            if (!isset($mimeHopLe[$mime])) {
                $loi['anh_dinh_kem'] = 'Chỉ chấp nhận tệp ảnh JPG, PNG hoặc WEBP!';
            } else {
                $tenAnhNhatKy = bin2hex(random_bytes(8)) . $mimeHopLe[$mime];
                $thuMucUpload = _DIR_ . '/uploads/';
                if (!is_dir($thuMucUpload)) {
                    mkdir($thuMucUpload, 0755, true);
                }
                move_uploaded_file($file['tmp_name'], $thuMucUpload . $tenAnhNhatKy);
            }
        }
    }

    // Nếu không có lỗi -> Lưu file và Redirect (PRG)
    if (empty($loi)) {
        $service = new LienHeService(_DIR_ . '/storage/lien-he.jsonl');
        $service->guiPhanHoi([
            'ho_ten' => $duLieu['ho_ten'],
            'email' => $duLieu['email'],
            'noi_dung' => $duLieu['noi_dung'],
            'anh' => $tenAnhNhatKy,
            'ngay_gui' => date('Y-m-d H:i:s')
        ]);

        gan_thong_bao('success', 'Gửi thông tin liên hệ thành công! Cảm ơn bạn đã đóng góp.');
        chuyen_huong('lien-he.php');
    }
}

// Thiết lập thông số header
$tieuDe   = 'Liên hệ'; 
$trang    = 'lien-he'; 
$customJS = 'js/trang-lien-he.js'; 

// Nhúng Header (đã bao gồm Nav)
require _DIR_ . '/inc/header.php';
?>

  <main class="lien-he-trang">

    <!-- BANNER ĐẦU TRANG -->
    <section class="lien-he-banner">
      <div class="lien-he-banner-icon">
        <img src="images/icons/info.svg" alt="Icon Liên hệ" class="icon-svg-banner">
      </div>

      <div class="lien-he-banner-noi-dung">
        <h1 class="tieu-de-lien-he">Liên hệ với chúng tôi</h1>
        <p class="tieu-de-phu-lien-he">Chúng tôi luôn sẵn sàng lắng nghe ý kiến của bạn!</p>
      </div>
    </section>

    <div class="khu-vuc-lien-he">

      <!-- CỘT TRÁI: FORM -->
      <div class="khu-vuc-form-lien-he">

        <!-- Hiển thị thông báo thành công (Flash Message) -->
        <?= hien_thi_thong_bao() ?>

        <noscript>
          <p class="thong-bao-noscript">
            JavaScript đang được tắt. Bạn vẫn có thể gửi biểu mẫu bằng cơ chế
            gửi biểu mẫu HTML thông thường; các kiểm tra và thông báo nâng cao
            của website sẽ không được thực hiện.
          </p>
        </noscript>

        <!-- BỔ SUNG: enctype="multipart/form-data" để upload được ảnh -->
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
              <span class="thong-bao-loi" style="color:red; font-size:14px;"><?= e($loi['ho_ten']) ?></span>
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
              <span class="thong-bao-loi" style="color:red; font-size:14px;"><?= e($loi['email']) ?></span>
            <?php endif; ?>
          </div>

          <!-- CHỦ ĐỀ -->
          <div class="truong-form">
            <label for="subject">
              Chủ đề
              <span class="bat-buoc">*</span>
            </label>
            <select id="subject" name="subject" required>
              <option value="">Chọn chủ đề</option>
              <option value="gop-y">Góp ý</option>
              <option value="phan-hoi">Phản hồi</option>
              <option value="bao-loi">Báo lỗi website</option>
              <option value="gui-cong-thuc">Gửi công thức</option>
            </select>
          </div>

          <!-- BỔ SUNG TRƯỜNG UPLOAD ÁNH ĐÍNH KÈM -->
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
              <span class="thong-bao-loi" style="color:red; font-size:14px;"><?= e($loi['anh_dinh_kem']) ?></span>
            <?php endif; ?>
          </div>

          <!-- NỘI DUNG -->
          <div class="truong-form">
            <label for="message">
              Nội dung
              <span class="bat-buoc">*</span>
            </label>
            <textarea id="message" name="noi_dung" rows="5" maxlength="500" placeholder="Nhập nội dung..." required><?= e($duLieu['noi_dung']) ?></textarea>
            <?php if (isset($loi['noi_dung'])): ?>
              <span class="thong-bao-loi" style="color:red; font-size:14px;"><?= e($loi['noi_dung']) ?></span>
            <?php endif; ?>
          </div>

          <!-- NÚT GỬI -->
          <div class="hanh-dong-lien-he">
            <button class="nut nut-gui-lien-he" type="submit">
              <img src="images/icons/email.svg" alt="" class="icon-svg-btn">
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
              <img src="images/icons/email.svg" alt="Email" class="icon-svg-lh">
            </span>
            <div class="noi-dung-item-lh">
              <strong>Email</strong>
              <p>cookwithme@gmail.com</p>
            </div>
          </div>

          <div class="thong-tin-lien-he-item">
            <span class="khung-icon-svg">
              <img src="images/icons/phone.svg" alt="Điện thoại" class="icon-svg-lh">
            </span>
            <div class="noi-dung-item-lh">
              <strong>Điện thoại</strong>
              <p>0123 456 789</p>
            </div>
          </div>

          <div class="thong-tin-lien-he-item">
            <span class="khung-icon-svg">
              <img src="images/icons/location.svg" alt="Địa chỉ" class="icon-svg-lh">
            </span>
            <div class="noi-dung-item-lh">
              <strong>Địa chỉ</strong>
              <p>Đà Nẵng, Việt Nam</p>
            </div>
          </div>
        </section>

        <section class="the-thong-tin-lien-he">
          <h2>Kết nối với chúng tôi</h2>
          <div class="mang-xa-hoi-lien-he">
            <a href="#"><img src="images/icons/social-facebook.svg" alt="Facebook" class="icon-svg-social"></a>
            <a href="#"><img src="images/icons/social-instagram.svg" alt="Instagram" class="icon-svg-social"></a>
            <a href="#"><img src="images/icons/social-youtube.svg" alt="YouTube" class="icon-svg-social"></a>
            <a href="#"><img src="images/icons/social-tiktok.svg" alt="TikTok" class="icon-svg-social"></a>
          </div>
        </section>

        <div class="loi-nhan-lien-he">
          <img src="images/icons/chef.svg" alt="Chef" class="icon-svg-card">
          <p>Bạn cũng có thể gửi công thức hoặc góp ý cho Cook with Me!</p>
        </div>

      </aside>

    </div>

  </main>

<?php
require _DIR_ . '/inc/footer.php';
?>
