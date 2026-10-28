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
use App\Data\KhoMonAn;
use App\Data\KhoDonHang;
use App\Services\LienHeService;

// 1. NẠP CẤU HÌNH VÀ CÁC LỚP DỮ LIỆU
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Data/KhoNguoiDung.php';
require_once __DIR__ . '/src/Services/LienHeService.php';
require_once __DIR__ . '/src/Data/KhoDonHang.php';

// 2. KHỞI TẠO SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. XÁC THỰC VÀ PHÂN QUYỀN BẰNG DỮ LIỆU MYSQL
require_once __DIR__ . '/inc/xac-thuc.php';
$nguoiDung = yeuCauQuyen('quan_tri');
$userLog = $nguoiDung;

// Token CSRF cho biểu mẫu xóa trong bảng quản trị.
if (empty($_SESSION['csrf_xoa_mon_an'])) {
    $_SESSION['csrf_xoa_mon_an'] = bin2hex(random_bytes(32));
}

// CSRF và dữ liệu quản trị đơn hàng từ MySQL.
if (empty($_SESSION['csrf_trang_thai_don'])) {
    $_SESSION['csrf_trang_thai_don'] = bin2hex(random_bytes(32));
}
$khoDonHang = new KhoDonHang(db());
$danhSachDonQuanTri = $khoDonHang->layDanhSachQuanTri(100);
$nhanTrangThai = [
    'cho_xac_nhan' => 'Chờ xác nhận',
    'da_xac_nhan' => 'Đã xác nhận',
    'da_huy' => 'Đã hủy',
    'hoan_thanh' => 'Hoàn thành',
];

// 5. ĐỌC DANH SÁCH LIÊN HỆ TỪ MYSQL
$lienHeService = new LienHeService(db());

$danhSachPhanHoi = $lienHeService->layDanhSach(100);

// Quản lý món ăn: COUNT(*) và LIMIT/OFFSET đều được thực hiện trong KhoMonAn.
$khoMonAn = new KhoMonAn(db());
$soMonMoiTrang = 10;
$tongMonTrongCSDL = $khoMonAn->demTatCa();
$tongTrangMon = max(1, (int) ceil($tongMonTrongCSDL / $soMonMoiTrang));
$trangMonYeuCau = filter_var($_GET['trang_mon'] ?? 1, FILTER_VALIDATE_INT);
$trangMon = ($trangMonYeuCau === false || $trangMonYeuCau < 1)
    ? 1 : min($trangMonYeuCau, $tongTrangMon);
$danhSachMonQuanTri = $khoMonAn->layTrangQuanTri($trangMon, $soMonMoiTrang);


// 6. SỐ LIỆU MINH HỌA CỦA DASHBOARD
// Giữ nguyên dữ liệu mẫu từ Bài thực hành 5
$tongNguoiDung = 1248;
$tongMonAn = $tongMonTrongCSDL; // Số món thực tế từ MySQL
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

                <div class="the-thong-ke-item">
                    <div class="bieu-tuong-thong-ke" aria-hidden="true">👥</div>
                    <div class="noi-dung-the-thong-ke">
                        <span class="label-thong-ke">Tổng người dùng</span>
                        <strong class="gia-tri-thong-ke"><?= number_format($tongNguoiDung) ?></strong>
                    </div>
                </div>

                <div class="the-thong-ke-item">
                    <div class="bieu-tuong-thong-ke" aria-hidden="true">🍲</div>
                    <div class="noi-dung-the-thong-ke">
                        <span class="label-thong-ke">Tổng món ăn</span>
                        <strong class="gia-tri-thong-ke"><?= number_format($tongMonAn) ?></strong>
                    </div>
                </div>

                <div class="the-thong-ke-item">
                    <div class="bieu-tuong-thong-ke" aria-hidden="true">📝</div>
                    <div class="noi-dung-the-thong-ke">
                        <span class="label-thong-ke">Tổng bài viết</span>
                        <strong class="gia-tri-thong-ke"><?= number_format($tongBaiViet) ?></strong>
                    </div>
                </div>

                <div class="the-thong-ke-item">
                    <div class="bieu-tuong-thong-ke" aria-hidden="true">💬</div>
                    <div class="noi-dung-the-thong-ke">
                        <span class="label-thong-ke">Tổng bình luận</span>
                        <strong class="gia-tri-thong-ke"><?= number_format($tongBinhLuan) ?></strong>
                    </div>
                </div>

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

            <!-- QUẢN LÝ MÓN ĂN - CHỨC NĂNG 3 -->
            <section class="khung-noi-dung-qt" id="quan-ly-mon-an">
                <div class="thanh-tieu-de-dashboard">
                    <h2>Quản lý món ăn (<?= (int) $tongMonTrongCSDL ?> món)</h2>
                    <a class="nut nut-chinh" href="them-mon-an.php">+ Thêm món ăn</a>
                </div>

                <?php if (empty($danhSachMonQuanTri)): ?>
                    <p class="thong-bao-chua-co-du-lieu">Chưa có món ăn nào.</p>
                <?php else: ?>
                    <div class="khu-vuc-bang-du-lieu">
                        <table class="bang-du-lieu-qt">
                            <thead><tr>
                                <th>Ảnh</th><th>Món ăn</th><th>Danh mục</th>
                                <th>Ngân sách</th><th>Thời gian</th><th>Thao tác</th>
                            </tr></thead>
                            <tbody>
                            <?php foreach ($danhSachMonQuanTri as $monQuanTri): ?>
                                <tr>
                                    <td><img src="<?= e($monQuanTri->hinhAnh ?: 'images/default.jpg') ?>"
                                        alt="" width="64" height="48" loading="lazy" style="object-fit:cover;border-radius:6px"></td>
                                    <td><?= e($monQuanTri->ten) ?></td>
                                    <td><?= e($monQuanTri->danhMuc) ?></td>
                                    <td><?= number_format((int) $monQuanTri->nganSach, 0, ',', '.') ?>đ</td>
                                    <td><?= (int) $monQuanTri->thoiGian ?> phút</td>
                                    <td>
                                        <a class="nut" href="sua-mon-an.php?id=<?= rawurlencode((string) $monQuanTri->id) ?>">Sửa</a>
                                        <form action="xoa-mon-an.php" method="post" style="display:inline">
                                            <input type="hidden" name="id" value="<?= e($monQuanTri->id) ?>">
                                            <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_xoa_mon_an']) ?>">
                                            <button class="nut" type="submit">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if ($tongTrangMon > 1): ?>
                    <nav class="phan-trang" aria-label="Phân trang quản trị món ăn">
                        <?php for ($i = 1; $i <= $tongTrangMon; $i++): ?>
                            <a class="nut-phan-trang <?= $i === $trangMon ? 'active dang-chon' : '' ?>"
                               href="quan-tri.php?trang_mon=<?= $i ?>#quan-ly-mon-an"
                               <?= $i === $trangMon ? 'aria-current="page"' : '' ?>><?= $i ?></a>
                        <?php endfor; ?>
                    </nav>
                <?php endif; ?>
            </section>

            <!-- QUẢN LÝ ĐƠN HÀNG – CHỨC NĂNG 5 -->
            <section class="khung-noi-dung-qt" id="quan-ly-don-hang">
                <div class="thanh-tieu-de-dashboard">
                    <h2>Quản lý đơn hàng (<?= count($danhSachDonQuanTri) ?> đơn gần nhất)</h2>
                </div>
                <?= hien_thi_thong_bao() ?>
                <?php if (empty($danhSachDonQuanTri)): ?>
                    <p class="thong-bao-chua-co-du-lieu">Chưa có đơn hàng.</p>
                <?php else: ?>
                <div class="khu-vuc-bang-du-lieu">
                    <table class="bang-du-lieu-qt" style="width:100%">
                        <thead><tr>
                            <th>Mã đơn</th><th>Người đặt</th><th>Ngày đặt</th>
                            <th>Số phần</th><th>Tổng tiền</th><th>Trạng thái</th><th>Thao tác</th>
                        </tr></thead>
                        <tbody>
                        <?php foreach ($danhSachDonQuanTri as $don): ?>
                            <?php $tt = (string) $don['trang_thai']; ?>
                            <tr>
                                <td>#<?= (int) $don['id'] ?></td>
                                <td><?= e($don['ho_ten']) ?><small style="display:block"><?= e($don['email']) ?></small></td>
                                <td><?= e($don['ngay_dat']) ?></td>
                                <td><?= (int) $don['tong_so_phan'] ?></td>
                                <td><?= vnd((int) $don['tong_tien']) ?></td>
                                <td><?= e($nhanTrangThai[$tt] ?? $tt) ?></td>
                                <td>
                                    <?php if (in_array($tt, ['cho_xac_nhan', 'da_xac_nhan'], true)): ?>
                                        <form action="cap-nhat-trang-thai-don.php" method="post" style="display:flex;gap:6px;flex-wrap:wrap;align-items:center">
                                            <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_trang_thai_don']) ?>">
                                            <input type="hidden" name="don_hang_id" value="<?= (int) $don['id'] ?>">
                                            <label>
                                                <span class="sr-only">Trạng thái mới</span>
                                                <select name="trang_thai_moi" required>
                                                    <option value="">-- Chọn thao tác --</option>
                                                    <?php if ($tt === 'cho_xac_nhan'): ?>
                                                        <option value="da_xac_nhan">Xác nhận</option>
                                                    <?php else: ?>
                                                        <option value="hoan_thanh">Hoàn thành</option>
                                                    <?php endif; ?>
                                                    <option value="da_huy">Hủy và hoàn kho</option>
                                                </select>
                                            </label>
                                            <button type="submit" class="nut">Cập nhật</button>
                                        </form>
                                    <?php else: ?>
                                        <span>Đã kết thúc</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
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