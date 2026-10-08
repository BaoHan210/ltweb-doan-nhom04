<?php
/**
 * Trang cá nhân: Nguyễn Thị Trinh - MSSV: 3120224155
 * File: thanhvien/3120224155_trinh/gioithieu.php
 * Chức năng PHP phía máy chủ:
 * 1. Bộ đếm lượt xem (mỗi phiên session chỉ tính 1 lần, lưu storage/3120224155_views.txt).
 * 2. Sổ lưu bút (POST form, validate ở server, lưu storage/3120224155_luubut.jsonl, PRG, in qua e()).
 * Cách thử: Mở trình duyệt chạy http://localhost:8000/thanhvien/3120224155_trinh/gioithieu.php
 */

require_once __DIR__ . '/../../inc/config.php';

// ==========================================
// 1. CHỨC NĂNG PHÍA SERVER: SỔ LƯU BÚT (PRG)
// ==========================================
$tepLuuBut = __DIR__ . '/../../storage/3120224155_luubut.jsonl';
$loi = [];
$du  = ['ten' => '', 'loinhan' => ''];

if (!is_dir(__DIR__ . '/../../storage')) {
    mkdir(__DIR__ . '/../../storage', 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $du['ten']     = trim($_POST['ten'] ?? '');
    $du['loinhan'] = trim($_POST['loinhan'] ?? '');

    if ($du['ten'] === '') {
        $loi['ten'] = 'Vui lòng nhập họ tên của bạn.';
    } elseif (mb_strlen($du['ten']) > 50) {
        $loi['ten'] = 'Họ tên không được quá 50 ký tự.';
    }

    if ($du['loinhan'] === '') {
        $loi['loinhan'] = 'Vui lòng nhập nội dung lời nhắn.';
    } elseif (mb_strlen($du['loinhan']) > 255) {
        $loi['loinhan'] = 'Lời nhắn không được dài quá 255 ký tự.';
    }

    if (empty($loi)) {
        $dong = json_encode([
            'thoiGian' => date('d/m/Y H:i'),
            'ten'      => $du['ten'],
            'loinhan'  => $du['loinhan']
        ], JSON_UNESCAPED_UNICODE) . PHP_EOL;

        file_put_contents($tepLuuBut, $dong, FILE_APPEND | LOCK_EX);
        $_SESSION['flash_trinh'] = 'Đã gửi lời nhắn thành công!';
        header('Location: gioithieu.php'); // PRG: F5 không bị gửi lại dữ liệu
        exit;
    }
}

$thongBao = $_SESSION['flash_trinh'] ?? '';
unset($_SESSION['flash_trinh']);

$danhSachLuuBut = [];
if (is_file($tepLuuBut)) {
    $cacDong = file($tepLuuBut, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $danhSachLuuBut = array_map(fn($line) => json_decode($line, true), $cacDong);
    $danhSachLuuBut = array_reverse(array_filter($danhSachLuuBut, 'is_array'));
    $danhSachLuuBut = array_slice($danhSachLuuBut, 0, 5);
}

// ==========================================
// 2. CHỨC NĂNG PHÍA SERVER: BỘ ĐẾM LƯỢT XEM
// ==========================================
$tepDem = __DIR__ . '/../../storage/3120224155_views.txt';

if (empty($_SESSION['da_xem_trinh'])) {
    $luotXem = is_file($tepDem) ? (int)file_get_contents($tepDem) : 0;
    $luotXem++;
    file_put_contents($tepDem, (string)$luotXem, LOCK_EX);
    $_SESSION['da_xem_trinh'] = true;
} else {
    $luotXem = is_file($tepDem) ? (int)file_get_contents($tepDem) : 0;
}

// ==========================================
// THIẾT LẬP THÔNG SỐ VÀ NẠP HEADER NHÓM
// ==========================================
$goc    = '../../'; 
$tieuDe = 'Thông tin cá nhân - Nguyễn Thị Trinh';
$trang  = ''; // Không active mục nào trên menu chính

require __DIR__ . '/../../inc/header.php';
?>

<!-- Giữ CSS riêng của cá nhân -->
<link rel="stylesheet" href="trang-ca-nhan.css">

<!-- NỘI DUNG CHÍNH TRANG CÁ NHÂN -->
<main class="ho-so-trang">

  <h1 class="tieu-de-ho-so">Hồ sơ thành viên: Nguyễn Thị Trinh</h1>

  <!-- HIỂN THỊ LƯỢT XEM TỪ SERVER -->
  <div style="margin: 15px 0; padding: 10px; background: #e8f5e9; border-left: 4px solid #2e7d32; font-weight: bold;">
    👁️ Lượt xem trang cá nhân: <?= e((string)$luotXem) ?> lượt (mỗi phiên làm việc đếm 1 lần)
  </div>

  <!-- THÔNG TIN CHUNG -->
  <section class="thong-tin-chung">
    <h2>Thông tin chung</h2>
    <figure class="anh-dai-dien">
      <img src="<?= $goc ?>images/avatar-trinh.jpg" alt="Ảnh chân dung thành viên Nguyễn Thị Trinh" width="200" height="200">
      <figcaption>Ảnh chân dung thành viên Nguyễn Thị Trinh - Nhóm 04.</figcaption>
    </figure>

    <ul class="thong-tin-ca-nhan">
      <li><strong>Họ và tên:</strong> Nguyễn Thị Trinh</li>
      <li><strong>Vai trò:</strong> Thành viên</li>
      <li><strong>Nhiệm vụ chính:</strong> Xây dựng cấu trúc HTML5 ngữ nghĩa và thực hiện kiểm chuẩn chất lượng mã nguồn.</li>
    </ul>
  </section>

  <!-- DỰ ÁN VÀ SỞ THÍCH -->
  <article class="du-an-so-thich">
    <h2>Dự án và sở thích</h2>
    <p>Nguyễn Thị Trinh cùng các thành viên xây dựng website Cook with me, một mạng xã hội chia sẻ công thức ẩm thực.</p>
    <p>Trong dự án, công việc tập trung vào xây dựng cấu trúc HTML5 theo hướng ngữ nghĩa và kiểm chuẩn chất lượng mã nguồn, giúp nội dung được tổ chức rõ ràng và dễ tiếp cận.</p>
    <p>Sở thích cá nhân gồm nghiên cứu công nghệ web, trải nghiệm ẩm thực các vùng miền và chạy bộ thể thao.</p>
  </article>

  <!-- KỸ NĂNG -->
  <section class="ky-nang">
    <h2>Kỹ năng</h2>
    <ul class="danh-sach-ky-nang">
      <li>Ngôn ngữ HTML5 chuẩn ngữ nghĩa W3C</li>
      <li>Sử dụng hệ thống quản lý mã nguồn Git và GitHub</li>
      <li>Kiểm thử khả năng tiếp cận (Accessibility) và SEO bằng Google Lighthouse</li>
      <li>Làm việc nhóm và thiết kế giao diện web cơ bản</li>
    </ul>
  </section>

  <!-- THỜI KHÓA BIỂU -->
  <section class="thoi-khoa-bieu">
    <h2>Thời khóa biểu tuần</h2>
    <p>Bảng thời khóa biểu có thể cuộn ngang trên màn hình nhỏ.</p>
    <div class="khung-bang">
      <table>
        <caption>Thời khóa biểu học tập và nghiên cứu đồ án trong tuần</caption>
        <thead>
          <tr>
            <th scope="col">Khung giờ</th>
            <th scope="col">Thứ Hai</th>
            <th scope="col">Thứ Tư</th>
            <th scope="col">Thứ Sáu</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Buổi sáng</th>
            <td>Lập trình Web (Lý thuyết)</td>
            <td>Tự học HTML5 ngữ nghĩa và Cơ sở dữ liệu</td>
            <td>Nghiên cứu tài liệu đồ án</td>
          </tr>
          <tr>
            <th scope="row">Buổi chiều</th>
            <td>Họp tiến độ Nhóm 04</td>
            <td>Thực hành Lập trình Web - Kiểm thử W3C và Lighthouse</td>
            <td>Tổng hợp báo cáo tuần</td>
          </tr>
          <tr>
            <th scope="row">Buổi tối</th>
            <td>Ôn tập</td>
            <td>Kiểm tra W3C</td>
            <td>Kiểm tra Lighthouse</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  <!-- CHỨC NĂNG SỔ LƯU BÚT PHÍA SERVER -->
  <section class="so-luu-but" style="margin-top: 30px; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #fafafa;">
    <h2>✍️ Sổ lưu bút</h2>

    <?php if ($thongBao): ?>
      <div style="padding: 10px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; margin-bottom: 15px;">
        <?= e($thongBao) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="gioithieu.php" style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 25px;">
      <div>
        <label for="ten" style="display: block; font-weight: bold; margin-bottom: 5px;">Họ tên của bạn (*):</label>
        <input type="text" id="ten" name="ten" value="<?= e($du['ten']) ?>" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        <?php if (isset($loi['ten'])): ?>
          <span style="color: #dc3545; font-size: 13px;"><?= e($loi['ten']) ?></span>
        <?php endif; ?>
      </div>

      <div>
        <label for="loinhan" style="display: block; font-weight: bold; margin-bottom: 5px;">Lời nhắn (*):</label>
        <textarea id="loinhan" name="loinhan" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"><?= e($du['loinhan']) ?></textarea>
        <?php if (isset($loi['loinhan'])): ?>
          <span style="color: #dc3545; font-size: 13px;"><?= e($loi['loinhan']) ?></span>
        <?php endif; ?>
      </div>

      <div>
        <button type="submit" class="nut" style="padding: 8px 18px; background: #e67e22; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Gửi lời nhắn</button>
      </div>
    </form>

    <h3>Lời nhắn gần đây (Tối đa 5 lời nhắn):</h3>
    <?php if (empty($danhSachLuuBut)): ?>
      <p style="color: #777; font-style: italic;">Chưa có lời nhắn nào.</p>
    <?php else: ?>
      <ul style="list-style: none; padding-left: 0;">
        <?php foreach ($danhSachLuuBut as $lb): ?>
          <li style="padding: 10px; border-bottom: 1px dashed #ccc;">
            <strong><?= e($lb['ten']) ?></strong> <small style="color: #888;">(<?= e($lb['thoiGian']) ?>)</small>:
            <p style="margin: 5px 0 0 0;"><?= e($lb['loinhan']) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </section>

  <p class="quay-lai" style="margin-top: 20px;">
    <a href="<?= $goc ?>index.php">Quay lại trang chủ</a>
  </p>

</main>

<!-- Giữ JS riêng của cá nhân -->
<script type="module" src="js/canhan.js"></script>

<?php 
// NẠP FOOTER DÙNG CHUNG CỦA NHÓM
require __DIR__ . '/../../inc/footer.php'; 
?>
