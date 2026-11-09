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
use App\Data\KhoLanDiCho;
use App\Services\LienHeService;

// 1. NẠP CẤU HÌNH VÀ CÁC LỚP DỮ LIỆU
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Data/KhoNguoiDung.php';
require_once __DIR__ . '/src/Services/LienHeService.php';
require_once __DIR__ . '/src/Data/KhoLanDiCho.php';

// 2. XÁC THỰC VÀ PHÂN QUYỀN BẰNG DỮ LIỆU MYSQL
require_once __DIR__ . '/inc/xac-thuc.php';
$nguoiDung = yeuCauQuyen('quan_tri');
$userLog = $nguoiDung;

$khoLanDiCho = new KhoLanDiCho(db());
$danhSachLanDiCho = $khoLanDiCho->danhSachQuanTri(100);

$nhanTrangThai = [
    'moi'       => 'Mới',
    'da_di_cho' => 'Đã đi chợ',
    'da_huy'    => 'Đã hủy',
];

// 3. ĐỌC DANH SÁCH LIÊN HỆ TỪ MYSQL
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

// 4. SỐ LIỆU MINH HỌA CỦA DASHBOARD
// Giữ nguyên dữ liệu mẫu từ Bài thực hành 5.
$tongNguoiDung = 1248;
$tongMonAn = $tongMonTrongCSDL;
$tongBaiViet = 624;
$tongBinhLuan = 2341;

// 5. MÓN ĂN YÊU THÍCH (DỮ LIỆU MẪU)
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

// 6. THÔNG TIN QUẢN TRỊ VIÊN
$tenAdmin = (string) $userLog['ho_ten'];

$avatarAdmin = !empty($userLog['avatar'])
    ? (string) $userLog['avatar']
    : 'images/icons/avt-default.svg';

// 7. THÔNG SỐ TRANG
$tieuDe = 'Trang quản trị - Cook with Me';
$trang = 'quan-tri';
$cssRieng = 'css/11-quan-tri.css';
$customJS = 'js/trang-quan-tri.js';

// 8. NHÚNG HEADER
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
                    data-fallback-src="images/icons/avt-default.svg"
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
                            <strong class="mau-chu-bai-viet">—</strong> Bài viết
                        </span>
                        <span>
                            <strong class="mau-chu-luot-thich">—</strong> Lượt thích
                        </span>
                    </div>
                </div>

                <div class="khung-bieu-do-hoat-dong">
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
                                    data-fallback-src="images/cao-lau.jpg"
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
                            <thead>
                                <tr>
                                    <th>Ảnh</th>
                                    <th>Món ăn</th>
                                    <th>Danh mục</th>
                                    <th>Ngân sách</th>
                                    <th>Thời gian</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($danhSachMonQuanTri as $monQuanTri): ?>
                                    <tr>
                                        <td>
                                            <img
                                                src="<?= e($monQuanTri->hinhAnh ?: 'images/default.jpg') ?>"
                                                alt=""
                                                width="64"
                                                height="48"
                                                loading="lazy"
                                                class="anh-mon-an-quan-tri"
                                            >
                                        </td>
                                        <td><?= e($monQuanTri->ten) ?></td>
                                        <td><?= e($monQuanTri->danhMuc) ?></td>
                                        <td><?= number_format((int) $monQuanTri->nganSach, 0, ',', '.') ?>đ</td>
                                        <td><?= (int) $monQuanTri->thoiGian ?> phút</td>
                                        <td>
                                            <a
                                                class="nut"
                                                href="sua-mon-an.php?id=<?= rawurlencode((string) $monQuanTri->id) ?>"
                                            >Sửa</a>

                                            <form
                                                action="xoa-mon-an.php"
                                                method="post"
                                                class="form-xoa-mon-an-quan-tri"
                                            >
                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= e($monQuanTri->id) ?>"
                                                >

                                                <?= csrfField() ?>


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
                            <a
                                class="nut-phan-trang <?= $i === $trangMon ? 'active dang-chon' : '' ?>"
                                href="quan-tri.php?trang_mon=<?= $i ?>#quan-ly-mon-an"
                                <?= $i === $trangMon ? 'aria-current="page"' : '' ?>
                            ><?= $i ?></a>
                        <?php endfor; ?>
                    </nav>
                <?php endif; ?>
            </section>

            <!-- QUẢN LÝ LỊCH SỬ ĐI CHỢ – CHỨC NĂNG 5 -->
            <section class="khung-noi-dung-qt" id="quan-ly-di-cho">
                <div class="thanh-tieu-de-dashboard">
                    <h2>Quản lý lịch sử đi chợ (<?= count($danhSachLanDiCho) ?> lần gần nhất)</h2>
                </div>

                <?= hien_thi_thong_bao() ?>

                <?php if (empty($danhSachLanDiCho)): ?>
                    <p class="thong-bao-chua-co-du-lieu">
                        Chưa có lịch sử đi chợ.
                    </p>
                <?php else: ?>
                    <div class="khu-vuc-bang-du-lieu">
                        <table class="bang-du-lieu-qt">
                            <thead>
                                <tr>
                                    <th>Mã lần đi chợ</th>
                                    <th>Người dùng</th>
                                    <th>Ngày chốt</th>
                                    <th>Số món</th>
                                    <th>Tổng số suất</th>
                                    <th>Ngân sách tham khảo</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($danhSachLanDiCho as $lan): ?>
                                    <?php $tt = (string) $lan['trang_thai']; ?>

                                    <tr>
                                        <td>#<?= (int) $lan['id'] ?></td>

                                        <td>
                                            <?= e($lan['ho_ten']) ?>
                                            <small class="email-nguoi-dung-quan-tri">
                                                <?= e($lan['email']) ?>
                                            </small>
                                        </td>

                                        <td><?= e($lan['ngay_chot']) ?></td>
                                        <td><?= (int) $lan['so_mon'] ?></td>
                                        <td><?= (int) $lan['tong_so_suat'] ?></td>

                                        <td>
                                            <?= vnd((float) $lan['tong_ngan_sach']) ?>
                                        </td>

                                        <td><?= e($nhanTrangThai[$tt] ?? $tt) ?></td>

                                        <td>
                                            <?php if ($tt === 'moi'): ?>
                                                <form
                                                    action="cap-nhat-trang-thai-di-cho.php"
                                                    method="post"
                                                    class="form-cap-nhat-di-cho-quan-tri"
                                                >
                                                    <?= csrfField() ?>

                                                    <input
                                                        type="hidden"
                                                        name="lan_di_cho_id"
                                                        value="<?= (int) $lan['id'] ?>"
                                                    >

                                                    <label>
                                                        <span class="sr-only">Trạng thái mới</span>

                                                        <select name="trang_thai_moi" required>
                                                            <option value="">-- Chọn thao tác --</option>
                                                            <option value="da_di_cho">Đánh dấu đã đi chợ</option>
                                                            <option value="da_huy">Hủy lần đi chợ</option>
                                                        </select>
                                                    </label>

                                                    <button type="submit" class="nut">
                                                        Cập nhật
                                                    </button>
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
                                    // Chỉ lấy tên tệp, ảnh nằm trong thư mục uploads/.
                                    $anh        = basename((string) ($phanHoi['anh'] ?? ''));
                                    $emailHopLe = filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
                                    ?>

                                    <tr>
                                        <td class="thoi-gian-lien-he"><?= e($thoiGian) ?></td>
                                        <td class="ten-nguoi-lien-he"><?= e($hoTen) ?></td>

                                        <td>
                                            <?php if ($emailHopLe): ?>
                                                <a
                                                    class="email-lien-he"
                                                    href="mailto:<?= e($email) ?>"
                                                ><?= e($email) ?></a>
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
                                                    data-hide-on-error
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
