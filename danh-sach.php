<?php
/**
 * Tệp: danh-sach.php
 * Khám phá món ăn: tìm kiếm, lọc danh mục, sắp xếp, phân trang.
 * Trang công khai. Chỉ thao tác yêu thích cần đăng nhập.
 */

declare(strict_types=1);


require __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';

use App\Data\KhoMonAn;
use App\Services\YeuThichService;

$kho = new KhoMonAn(db());
$yeuThichService = new YeuThichService();
$daDangNhap = !empty($_SESSION['user']) || !empty($_SESSION['nguoi_dung']);

// 1. THAM SỐ GET, KIỂM TRA BẰNG WHITELIST

$tuKhoa  = trim((string) ($_GET['keyword'] ?? $_GET['q'] ?? ''));
$danhMuc = trim((string) ($_GET['dm'] ?? ''));
$sapXep  = trim((string) ($_GET['sapXep'] ?? $_GET['sx'] ?? 'ten-az'));
$giaRaw  = trim((string) ($_GET['gia'] ?? ''));
$giaToiDa = ($giaRaw !== '' && ctype_digit($giaRaw) && (float) $giaRaw <= 4294967295)
    ? (int) $giaRaw : null;

$danhMucHopLe = [
    '',
    'Món chính',
    'Món canh',
    'Món xào',
    'Món rau',
    'Món khai vị',
    'Đồ uống',
    'Món tráng miệng',
    'Món chay',
];

$sapXepHopLe = [
    'ten-az',
    'ten-za',
    'thoiGianTang',
    'danhGiaGiam',
    'nganSachTang',
];

if (!in_array($danhMuc, $danhMucHopLe, true)) {
    $danhMuc = '';
}

if (!in_array($sapXep, $sapXepHopLe, true)) {
    $sapXep = 'ten-az';
}

$trangYeuCau = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT);
$trangYeuCau = ($trangYeuCau === false || $trangYeuCau < 1) ? 1 : $trangYeuCau;

/**
 * Dựng URL của trang danh sách, bỏ các tham số rỗng.
 * Chỉ dùng giá trị đã kiểm tra ở trên, không dùng trực tiếp $_GET.
 */
function urlDanhSach(array $thamSo): string
{
    $thamSo = array_filter($thamSo, fn($giaTri) => $giaTri !== '' && $giaTri !== null);

    return 'danh-sach.php' . ($thamSo ? '?' . http_build_query($thamSo) : '');
}

// Bộ lọc hiện tại, dùng lại cho form, phân trang và redirect sau POST
$thamSoGoc = [
    'keyword' => $tuKhoa,
    'dm'      => $danhMuc,
    'sapXep'  => $sapXep,
    'gia'     => $giaToiDa,
    'page'    => $trangYeuCau,
];

// 2. XỬ LÝ POST: THÊM HOẶC BỎ YÊU THÍCH

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Yêu thích là phần riêng tư: khách phải đăng nhập
    if (!$daDangNhap) {
        chuyen_huong('dang-nhap.php');
    }

    $idMonAn = trim((string) ($_POST['doi_yeu_thich'] ?? ''));

    if ($idMonAn !== '' && $kho->timTheoId($idMonAn) !== null) {
        if ($yeuThichService->co($idMonAn)) {
            $yeuThichService->xoa($idMonAn);
            gan_thong_bao('success', 'Đã bỏ món khỏi danh sách yêu thích.');
        } else {
            $yeuThichService->them($idMonAn);
            gan_thong_bao('success', 'Đã lưu món vào danh sách yêu thích.');
        }
    }

    // PRG: quay lại đúng bộ lọc, F5 không gửi lại form
    header('Location: ' . urlDanhSach($thamSoGoc), true, 303);
    exit;
}

// 3. LỌC, SẮP XẾP VÀ PHÂN TRANG

$soMonTrenTrang = 9;

// COUNT(*) trước để tính tổng số trang.
$tongSoMon = $kho->demTimKiemNangCao($tuKhoa, $danhMuc, $giaToiDa);
$tongSoTrang = max(1, (int) ceil($tongSoMon / $soMonTrenTrang));
$trangHienTai = min($trangYeuCau, $tongSoTrang);

// MySQL lọc + sắp xếp + phân trang, PHP chỉ hiển thị dữ liệu đã lấy.
$danhSachHienThi = $kho->timKiemPhanTrang(
    $tuKhoa, $danhMuc, $giaToiDa, $sapXep, $trangHienTai, $soMonTrenTrang
);

// Điều chỉnh URL sau POST theo trang thực tế đang hiển thị.
$thamSoGoc['page'] = $trangHienTai;

// 4. HIỂN THỊ

$tieuDe = 'Khám phá';
$trang  = 'danh-sach';

require __DIR__ . '/inc/header.php';
?>

<main class="trang-kham-pha kham-pha">

    <?= hien_thi_thong_bao() ?>

    <!-- 1. Tiêu đề trang -->
    <div class="tieu-de-danh-sach">
        <div>
            <p class="nhan-danh-sach">Khám phá</p>
            <h1 id="tieu-de-mon-an">Món ăn</h1>
        </div>
    </div>

    <!-- 2. Hero -->
    <section class="hero-kham-pha">
        <div class="hero-kham-pha-icon-trai">
            <img src="images/icons/fridge.svg" alt="Tủ lạnh" width="60" height="60">
        </div>

        <div class="hero-kham-pha-noi-dung">
            <p class="hero-kham-pha-nhan">Tủ lạnh của tôi</p>
            <h2>Hôm nay ăn gì?</h2>
            <p>Nhập nguyên liệu bạn có, chúng tôi sẽ gợi ý món ăn phù hợp!</p>
        </div>

        <div class="hero-kham-pha-icon-phai">
            <img src="images/basket-vegetables.svg" alt="Rau củ tươi" width="160" height="120">
        </div>
    </section>

    <!-- 3. Tìm kiếm, sắp xếp, lọc danh mục -->
    <div class="khu-vuc-danh-sach-mon-an">
        <div class="thanh-cong-cu-mon-an">

            <div class="hang-tim-kiem-bo-loc">

                <!-- Tìm kiếm -->
                <form class="o-tim-mon-an" id="o-tim-mon-an" action="danh-sach.php" method="get">
                    <?php if ($danhMuc !== ''): ?>
                        <input type="hidden" name="dm" value="<?= e($danhMuc) ?>">
                    <?php endif; ?>

                    <input type="hidden" name="sapXep" value="<?= e($sapXep) ?>">
                    <?php if ($giaToiDa !== null): ?>
                        <input type="hidden" name="gia" value="<?= $giaToiDa ?>">
                    <?php endif; ?>

                    <label for="tim-mon-an">Tìm món ăn</label>
                    <input
                        type="search"
                        id="tim-mon-an"
                        name="keyword"
                        placeholder="Tìm món ăn..."
                        value="<?= e($tuKhoa) ?>"
                        autocomplete="off"
                    >
                    <button class="nut" type="submit">Tìm kiếm</button>
                </form>

                <!-- Sắp xếp -->
                <form class="khu-vuc-sap-xep" action="danh-sach.php" method="get">
                    <?php if ($tuKhoa !== ''): ?>
                        <input type="hidden" name="keyword" value="<?= e($tuKhoa) ?>">
                    <?php endif; ?>

                    <?php if ($danhMuc !== ''): ?>
                        <input type="hidden" name="dm" value="<?= e($danhMuc) ?>">
                    <?php endif; ?>

                    <?php if ($giaToiDa !== null): ?>
                        <input type="hidden" name="gia" value="<?= $giaToiDa ?>">
                    <?php endif; ?>

                    <label for="sap-xep">Sắp xếp</label>

                    <select id="sap-xep" name="sapXep" onchange="this.form.submit()">
                        <option value="ten-az"        <?= $sapXep === 'ten-az' ? 'selected' : '' ?>>Mặc định (A → Z)</option>
                        <option value="danhGiaGiam"   <?= $sapXep === 'danhGiaGiam' ? 'selected' : '' ?>>Đánh giá cao nhất</option>
                        <option value="thoiGianTang"  <?= $sapXep === 'thoiGianTang' ? 'selected' : '' ?>>Thời gian ngắn nhất</option>
                        <option value="nganSachTang"  <?= $sapXep === 'nganSachTang' ? 'selected' : '' ?>>Ngân sách thấp nhất</option>
                        <option value="ten-za"        <?= $sapXep === 'ten-za' ? 'selected' : '' ?>>Tên Z → A</option>
                    </select>

                    <noscript>
                        <button type="submit" class="nut">Áp dụng</button>
                    </noscript>
                </form>

            </div>

            <!-- Lọc ngân sách tối đa: biểu mẫu GET chạy được khi tắt JS -->
            <form class="khu-vuc-loc-gia" action="danh-sach.php" method="get">
                <input type="hidden" name="keyword" value="<?= e($tuKhoa) ?>">
                <input type="hidden" name="dm" value="<?= e($danhMuc) ?>">
                <input type="hidden" name="sapXep" value="<?= e($sapXep) ?>">
                <label for="gia-toi-da">Ngân sách tối đa (đ)</label>
                <input id="gia-toi-da" name="gia" type="number" min="0"
                       step="1000" placeholder="Ví dụ: 100000"
                       value="<?= $giaToiDa !== null ? $giaToiDa : '' ?>">
                <button class="nut" type="submit">Áp dụng bộ lọc</button>
                <a class="nut" href="<?= e(urlDanhSach(array_merge($thamSoGoc, ['gia' => null, 'page' => 1]))) ?>">Bỏ lọc giá</a>
            </form>

            <!-- Lọc danh mục: liên kết thường, không cần JavaScript -->
            <nav class="bo-loc-mon-an" aria-label="Lọc món ăn">
                <?php
                $dsDanhMuc = [
                    ''                => 'Tất cả',
                    'Món chính'       => 'Món chính',
                    'Món canh'        => 'Món canh',
                    'Món xào'         => 'Món xào',
                    'Món rau'         => 'Món rau',
                    'Món khai vị'     => 'Món khai vị',
                    'Đồ uống'         => 'Đồ uống',
                    'Món tráng miệng' => 'Món tráng miệng',
                    'Món chay'        => 'Món chay',
                ];

                foreach ($dsDanhMuc as $maDanhMuc => $tenDanhMuc):
                    $dangChon = ($danhMuc === $maDanhMuc);
                ?>
                    <a
                        href="<?= e(urlDanhSach(array_merge($thamSoGoc, ['dm' => $maDanhMuc, 'page' => 1]))) ?>"
                        class="nut-bo-loc <?= $dangChon ? 'dang-loc active' : '' ?>"
                    >
                        <?= e($tenDanhMuc) ?>
                    </a>
                <?php endforeach; ?>
            </nav>

        </div>

        <!-- 4. Kết quả -->
        <section class="khu-vuc-ket-qua" aria-labelledby="tieu-de-ket-qua">
            <div class="tieu-de-ket-qua">
                <h2 id="tieu-de-ket-qua">Các món ăn</h2>

                <p class="so-luong-mon-an">
                    Hiển thị <?= count($danhSachHienThi) ?> / <?= $tongSoMon ?> món ăn
                    (Trang <?= $trangHienTai ?>/<?= $tongSoTrang ?>)
                </p>
            </div>

            <div class="danh-sach-mon-an" id="danh-sach-mon-an">
                <?php if (!empty($danhSachHienThi)): ?>

                    <?php foreach ($danhSachHienThi as $mon): ?>
                        <?php
                        $idChuan    = $mon->id;
                        $daYeuThich = $yeuThichService->co($idChuan);
                        ?>

                        <article class="the-mon-an" data-danh-muc="<?= e($mon->danhMuc) ?>">

                            <div class="khung-anh-mon">
                                <img
                                    src="<?= e($mon->hinhAnh ?: 'images/ca-kho-to.jpg') ?>"
                                    alt="<?= e($mon->ten) ?>"
                                    loading="lazy"
                                >

                                <?php if ($daDangNhap): ?>
                                    <form action="<?= e(urlDanhSach($thamSoGoc)) ?>" method="post">
                                        <button
                                            class="nut-yeu-thich"
                                            type="submit"
                                            name="doi_yeu_thich"
                                            value="<?= e($idChuan) ?>"
                                            aria-label="<?= $daYeuThich ? 'Bỏ khỏi yêu thích' : 'Thêm vào yêu thích' ?>"
                                        >
                                            <?= $daYeuThich ? '♥' : '♡' ?>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <a
                                        href="dang-nhap.php"
                                        class="nut-yeu-thich"
                                        aria-label="Đăng nhập để lưu món"
                                    >♡</a>
                                <?php endif; ?>
                            </div>

                            <div class="noi-dung-the-mon">
                                <h3><?= e($mon->ten) ?></h3>

                                <p class="thong-tin-phu">
                                    <span class="item-thong-tin">
                                        <img src="images/icons/icon-thoi-gian.svg" alt="" class="icon-phu">
                                        <?= (int) $mon->thoiGian ?> phút
                                    </span>

                                    <span class="cham-phan-cach">•</span>

                                    <span class="item-thong-tin">
                                        <img src="images/icons/icon-ngan-sach.svg" alt="" class="icon-phu">
                                        <?= number_format($mon->nganSach, 0, ',', '.') ?>đ
                                    </span>

                                    <span class="cham-phan-cach">•</span>

                                    <span class="item-thong-tin">
                                        <img src="images/icons/icon-do-kho.svg" alt="" class="icon-phu">
                                        <?= e($mon->doKho) ?>
                                    </span>
                                </p>

                                <a href="chi-tiet.php?id=<?= e($idChuan) ?>" class="nut">
                                    Chi tiết món ăn
                                </a>
                            </div>

                        </article>
                    <?php endforeach; ?>

                <?php else: ?>
                    <p class="thong-bao-khong-co">
                        Không tìm thấy món ăn nào phù hợp với lựa chọn của bạn.
                    </p>
                <?php endif; ?>
            </div>
        </section>

        <!-- 5. Phân trang: liên kết thường -->
        <?php if ($tongSoTrang > 1): ?>
            <nav class="phan-trang" id="phan-trang" aria-label="Phân trang danh sách món ăn">

                <?php if ($trangHienTai > 1): ?>
                    <a
                        href="<?= e(urlDanhSach(array_merge($thamSoGoc, ['page' => $trangHienTai - 1]))) ?>"
                        class="nut-phan-trang"
                        aria-label="Trang trước"
                    >‹</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $tongSoTrang; $i++): ?>
                    <a
                        href="<?= e(urlDanhSach(array_merge($thamSoGoc, ['page' => $i]))) ?>"
                        class="nut-phan-trang <?= $i === $trangHienTai ? 'active dang-chon' : '' ?>"
                        <?= $i === $trangHienTai ? 'aria-current="page"' : '' ?>
                    ><?= $i ?></a>
                <?php endfor; ?>

                <?php if ($trangHienTai < $tongSoTrang): ?>
                    <a
                        href="<?= e(urlDanhSach(array_merge($thamSoGoc, ['page' => $trangHienTai + 1]))) ?>"
                        class="nut-phan-trang"
                        aria-label="Trang sau"
                    >›</a>
                <?php endif; ?>

            </nav>
        <?php endif; ?>

    </div>
<script src="js/tim-kiem.js" defer></script>
</main>

<?php
require __DIR__ . '/inc/footer.php';
?>