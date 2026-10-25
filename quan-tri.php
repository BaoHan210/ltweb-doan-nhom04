<?php
/**
 * Tệp: quan-tri.php
 * Website: Cook with me - Nhóm 04
 *
 * Chức năng:
 * - Kiểm tra đăng nhập và quyền quản trị
 * - Đọc danh sách liên hệ từ MySQL
 * - Hiển thị dashboard quản trị
 */

use App\Data\KhoNguoiDung;
use App\Services\LienHeService;

// 1. NẠP CẤU HÌNH VÀ CÁC LỚP DỮ LIỆU
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/src/Data/KhoNguoiDung.php';
require_once __DIR__ . '/src/Services/LienHeService.php';

// 2. KHỞI TẠO SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. KIỂM TRA ĐĂNG NHẬP
$userLog = $_SESSION['user'] ?? null;

if (
    !is_array($userLog) ||
    empty($userLog['id'])
) {
    gan_thong_bao(
        'error',
        'Bạn cần đăng nhập để truy cập trang quản trị!'
    );

    chuyen_huong('dang-nhap.php');
    exit;
}

// 4. KIỂM TRA QUYỀN QUẢN TRỊ TRONG MYSQL
$khoNguoiDung = new KhoNguoiDung(db());

$nguoiDung = $khoNguoiDung->timTheoId(
    (int) $userLog['id']
);

if (
    $nguoiDung === null ||
    $nguoiDung['vai_tro'] !== 'quan_tri'
) {
    http_response_code(403);

    exit('Bạn không có quyền truy cập trang quản trị.');
}

// Cập nhật thông tin tài khoản từ database
$userLog['ho_ten'] = $nguoiDung['ho_ten'];
$userLog['email'] = $nguoiDung['email'];
$userLog['vai_tro'] = $nguoiDung['vai_tro'];

// 5. ĐỌC DANH SÁCH LIÊN HỆ TỪ MYSQL
$lienHeService = new LienHeService(db());

$danhSachPhanHoi = $lienHeService->layDanhSach(100);

// 6. SỐ LIỆU MINH HỌA CỦA DASHBOARD
// Giữ nguyên dữ liệu mẫu từ Bài thực hành 5
$tongNguoiDung = 1248;
$tongMonAn = 856;
$tongBaiViet = 624;
$tongBinhLuan = 2341;

// 7. MÓN ĂN YÊU THÍCH (DỮ LIỆU MẪU)
$topMonAnYeuThich = [
    [
        'ten' => 'Phở bò',
        'luotThich' => '1.2k',
        'hinh' => 'images/pho-bo.jpg'
    ],
    [
        'ten' => 'Gà rán giòn',
        'luotThich' => '856',
        'hinh' => 'images/ga-ran.jpg'
    ],
    [
        'ten' => 'Trà sữa trân châu',
        'luotThich' => '742',
        'hinh' => 'images/tra-sua.jpg'
    ]
];

// 8. THÔNG TIN QUẢN TRỊ VIÊN
$tenAdmin = (string) $userLog['ho_ten'];

$avatarAdmin = !empty($userLog['avatar'])
    ? (string) $userLog['avatar']
    : 'images/icons/avt-default.svg';

// 9. THÔNG SỐ TRANG
$tieuDe = 'Trang quản trị - Cook with Me';
$trang = 'quan-tri';
$customJS = 'js/trang-quan-tri.js';

// 10. NHÚNG HEADER
require_once __DIR__ . '/inc/header.php';
?>

<!-- Chart.js phiên bản cố định. Script này là classic nên nạp trước js/trang-quan-tri.js (module). -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.js"></script>

<main class="noi-dung-quan-tri">
    <div class="khung-quan-tri-layout">

        <!-- MENU QUẢN TRỊ -->
        <aside class="sidebar-quan-tri">
            <div class="the-nguoi-dung-admin">
                <img
                    src="<?= e($avatarAdmin) ?>"
                    alt="Ảnh đại diện quản trị viên"
                    onerror="this.onerror=null; this.src='images/icons/avt-default.svg'"
                >
                <div class="thong-tin-admin">
                    <p class="ten-admin"><?= e($tenAdmin) ?></p>
                    <span class="chuc-vu-admin">Quản trị viên</span>
                </div>
            </div>

            <?php
            $mucQuanTri = 'tong-quan';
            require __DIR__ . '/inc/nav-quan-tri.php';
            ?>
        </aside>

        <!-- NỘI DUNG DASHBOARD -->
        <section class="noi-dung-dashboard">

            <div class="thanh-tieu-de-dashboard">
                <h1>Tổng quan</h1>
                <a class="nut-chinh-sua-dashboard" href="cai-dat.php">Chỉnh sửa</a>
            </div>

            <!-- CÁC THẺ THỐNG KÊ -->
            <div class="luoi-the-thong-ke">

                <article class="the-thong-ke-item">
                    <div class="bieu-tuong-thong-ke" aria-hidden="true">👥</div>
                    <div class="noi-dung-the-thong-ke">
                        <span class="label-thong-ke">Tổng người dùng</span>
                        <strong class="gia-tri-thong-ke"><?= number_format($tongNguoiDung) ?></strong>
                    </div>
                </article>

                <article class="the-thong-ke-item">
                    <div class="bieu-tuong-thong-ke" aria-hidden="true">🍲</div>
                    <div class="noi-dung-the-thong-ke">
                        <span class="label-thong-ke">Tổng món ăn</span>
                        <strong class="gia-tri-thong-ke"><?= number_format($tongMonAn) ?></strong>
                    </div>
                </article>

                <article class="the-thong-ke-item">
                    <div class="bieu-tuong-thong-ke" aria-hidden="true">📝</div>
                    <div class="noi-dung-the-thong-ke">
                        <span class="label-thong-ke">Tổng bài viết</span>
                        <strong class="gia-tri-thong-ke"><?= number_format($tongBaiViet) ?></strong>
                    </div>
                </article>

                <article class="the-thong-ke-item">
                    <div class="bieu-tuong-thong-ke" aria-hidden="true">💬</div>
                    <div class="noi-dung-the-thong-ke">
                        <span class="label-thong-ke">Tổng bình luận</span>
                        <strong class="gia-tri-thong-ke"><?= number_format($tongBinhLuan) ?></strong>
                    </div>
                </article>

            </div>

            <!-- BIỂU ĐỒ HOẠT ĐỘNG -->
            <section class="khung-noi-dung-qt" id="thong-ke-hoat-dong">
                <div class="thanh-tieu-de-dashboard">
                    <h2>Thống kê hoạt động</h2>

                    <div class="chu-thich-bieu-do">
                        <span>
                            <strong style="color: #198754;">—</strong> Bài viết
                        </span>
                        <span>
                            <strong style="color: #ffc107;">—</strong> Lượt thích
                        </span>
                    </div>
                </div>

                <div class="khung-bieu-do-hoat-dong" style="height: 260px;">
                    <canvas
                        id="bieuDoHoatDong"
                        role="img"
                        aria-label="Biểu đồ bài viết và lượt thích từ thứ Hai đến Chủ nhật"
                    ></canvas>
                </div>
            </section>

            <!-- MÓN ĂN ĐƯỢC YÊU THÍCH -->
            <section class="khung-noi-dung-qt">
                <h2>Món ăn được yêu thích</h2>

                <div class="danh-sach-mon-an-yeu-thich">
                    <?php foreach ($topMonAnYeuThich as $viTri => $mon): ?>
                        <div class="dong-mon-an-yeu-thich">
                            <div class="thong-tin-mon-an-yeu-thich">
                                <span class="thu-tu-mon-an"><?= $viTri + 1 ?>.</span>

                                <img
                                    src="<?= e($mon['hinh']) ?>"
                                    alt=""
                                    class="hinh-mon-an-yeu-thich"
                                    onerror="this.onerror=null; this.src='images/cao-lau.jpg'"
                                >

                                <strong class="ten-mon-an-yeu-thich"><?= e($mon['ten']) ?></strong>
                            </div>

                            <span class="luot-thich-mon-an"><?= e($mon['luotThich']) ?> lượt thích</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- DANH SÁCH THƯ LIÊN HỆ -->
            <section class="khung-noi-dung-qt">
                <h2>Danh sách thư liên hệ đã nhận</h2>

                <?php if (empty($danhSachPhanHoi)): ?>

                    <p class="thong-bao-chua-co-du-lieu">
                        Chưa có thư liên hệ nào trong hệ thống.
                    </p>

                <?php else: ?>

                    <div class="khu-vuc-bang-du-lieu">
                        <table class="bang-du-lieu-qt">
                            <thead>
                                <tr>
                                    <th>Thời gian</th>
                                    <th>Họ và tên</th>
                                    <th>Email</th>
                                    <th>Nội dung</th>
                                    <th class="cot-anh-lien-he">Hình ảnh</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($danhSachPhanHoi as $phanHoi): ?>
                                    <?php
                                    $thoiGian   = (string) ($phanHoi['ngay_gui'] ?? 'N/A');
                                    $hoTen      = (string) ($phanHoi['ho_ten'] ?? 'Khách');
                                    $email      = (string) ($phanHoi['email'] ?? 'N/A');
                                    $noiDung    = (string) ($phanHoi['noi_dung'] ?? '');
                                    // Chỉ lấy tên tệp, ảnh nằm trong thư mục uploads/
                                    $anh        = basename((string) ($phanHoi['anh'] ?? ''));
                                    $emailHopLe = filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
                                    ?>

                                    <tr>
                                        <td class="thoi-gian-lien-he"><?= e($thoiGian) ?></td>
                                        <td class="ten-nguoi-lien-he"><?= e($hoTen) ?></td>

                                        <td>
                                            <?php if ($emailHopLe): ?>
                                                <a class="email-lien-he" href="mailto:<?= e($email) ?>"><?= e($email) ?></a>
                                            <?php else: ?>
                                                <?= e($email) ?>
                                            <?php endif; ?>
                                        </td>

                                        <td class="noi-dung-lien-he"><?= e($noiDung) ?></td>

                                        <td class="cot-anh-lien-he">
                                            <?php if ($anh !== ''): ?>
                                                <img
                                                    src="uploads/<?= e($anh) ?>"
                                                    alt="Ảnh đính kèm"
                                                    class="anh-lien-he"
                                                    onerror="this.onerror=null; this.style.display='none'"
                                                >
                                            <?php else: ?>
                                                <span class="khong-co-anh-lien-he">Không</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                <?php endif; ?>
            </section>

        </section>
    </div>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>