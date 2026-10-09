<?php
// 1. PHẦN XỬ LÝ LOGIC
require __DIR__ . '/inc/config.php';

use App\Data\KhoMonAn;
use App\Services\YeuThichService;

// Khởi tạo kho món ăn và dịch vụ yêu thích
$kho = new KhoMonAn(__DIR__ . '/data/mon-an.json');
$yeuThichService = new YeuThichService();

// Xử lý thêm hoặc bỏ món ăn khỏi danh sách yêu thích
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idMonAn = trim((string) ($_POST['doi_yeu_thich'] ?? ''));

    if (
        $idMonAn !== ''
        && $kho->timTheoId($idMonAn) !== null
    ) {
        $danhSachYeuThich = $yeuThichService->danhSachMonAn($kho);
        $daYeuThich = false;

        foreach ($danhSachYeuThich as $monYeuThich) {
            if ($monYeuThich->id === $idMonAn) {
                $daYeuThich = true;
                break;
            }
        }

        if ($daYeuThich) {
            $yeuThichService->xoa($idMonAn);
        } else {
            $yeuThichService->them($idMonAn);
        }
    }

    header(
        'Location: ' . ($_SERVER['REQUEST_URI'] ?? 'danh-sach.php'),
        true,
        303
    );
    exit;
}

// 2. LẤY THAM SỐ GET
$tuKhoa = trim($_GET['keyword'] ?? $_GET['q'] ?? '');
$danhMuc = trim($_GET['dm'] ?? '');
$sapXep = trim($_GET['sapXep'] ?? $_GET['sx'] ?? 'ten-az');

// Whitelist danh mục và sắp xếp hợp lệ
$danhMucHopLe = [
    '',
    'Món chính',
    'Món canh',
    'Món xào',
    'Món rau',
    'Món khai vị',
    'Đồ uống',
    'Món tráng miệng',
    'Món chay'
];

$sapXepHopLe = [
    'ten-az',
    'ten-za',
    'thoiGianTang',
    'danhGiaGiam',
    'nganSachTang'
];

if (!in_array($danhMuc, $danhMucHopLe, true)) {
    $danhMuc = '';
}

if (!in_array($sapXep, $sapXepHopLe, true)) {
    $sapXep = 'ten-az';
}

// 3. LỌC DỮ LIỆU THEO TỪ KHÓA VÀ DANH MỤC
$danhSach = $kho->timKiem($tuKhoa, $danhMuc);

// 4. SẮP XẾP DANH SÁCH MÓN ĂN
usort($danhSach, function ($a, $b) use ($sapXep) {
    if ($sapXep === 'ten-za') {
        return strcmp($b->ten ?? '', $a->ten ?? '');
    }

    if ($sapXep === 'thoiGianTang') {
        return ($a->thoiGian ?? 0) <=> ($b->thoiGian ?? 0);
    }

    if ($sapXep === 'danhGiaGiam') {
        return ($b->danhGia ?? 0) <=> ($a->danhGia ?? 0);
    }

    if ($sapXep === 'nganSachTang') {
        return ($a->nganSach ?? $a->gia ?? 0)
            <=> ($b->nganSach ?? $b->gia ?? 0);
    }

    return strcmp($a->ten ?? '', $b->ten ?? '');
});

// 5. PHÂN TRANG: 9 MÓN ĂN/TRANG
$soMonTrenTrang = 9;
$tongSoMon = count($danhSach);
$tongSoTrang = max(
    1,
    (int) ceil($tongSoMon / $soMonTrenTrang)
);

$trangHienTai = max(
    1,
    min($tongSoTrang, (int) ($_GET['page'] ?? 1))
);

$viTriBatDau = ($trangHienTai - 1) * $soMonTrenTrang;

$danhSachHienThi = array_slice(
    $danhSach,
    $viTriBatDau,
    $soMonTrenTrang
);

// 6. THIẾT LẬP THÔNG TIN HEADER
$tieuDe = 'Khám phá';
$trang = 'danh-sach';
$customJS = 'js/trang-danh-sach.js';

require __DIR__ . '/inc/header.php';
?>

<main class="trang-kham-pha kham-pha">

    <!-- 1. TIÊU ĐỀ TRANG KHÁM PHÁ -->
    <div class="tieu-de-danh-sach">
        <div>
            <p class="nhan-danh-sach">Khám phá</p>
            <h1 id="tieu-de-mon-an">Món ăn</h1>
        </div>
    </div>

    <!-- 2. HERO BANNER -->
    <section class="hero-kham-pha">
        <div class="hero-kham-pha-icon-trai">
            <img
                src="images/icons/fridge.svg"
                alt="Tủ lạnh"
                width="60"
                height="60"
            >
        </div>

        <div class="hero-kham-pha-noi-dung">
            <p class="hero-kham-pha-nhan">Tủ lạnh của tôi</p>
            <h2>Hôm nay ăn gì?</h2>
            <p>Nhập nguyên liệu bạn có, chúng tôi sẽ gợi ý món ăn phù hợp!</p>
        </div>

        <div class="hero-kham-pha-icon-phai">
            <img
                src="images/basket-vegetables.svg"
                alt="Rau củ tươi"
                width="160"
                height="120"
            >
        </div>
    </section>

    <!-- 3. KHU VỰC BỘ LỌC VÀ TÌM KIẾM MÓN ĂN -->
    <section
        class="khu-vuc-danh-sach-mon-an"
        aria-labelledby="tieu-de-mon-an"
    >
        <div class="thanh-cong-cu-mon-an">

            <!-- Hàng trên: Tìm kiếm và sắp xếp -->
            <div class="hang-tim-kiem-bo-loc">

                <!-- Form tìm kiếm -->
                <form
                    class="o-tim-mon-an"
                    id="o-tim-mon-an"
                    action="danh-sach.php"
                    method="get"
                >
                    <?php if (!empty($danhMuc)): ?>
                        <input
                            type="hidden"
                            name="dm"
                            value="<?= e($danhMuc) ?>"
                        >
                    <?php endif; ?>

                    <?php if (!empty($sapXep)): ?>
                        <input
                            type="hidden"
                            name="sapXep"
                            value="<?= e($sapXep) ?>"
                        >
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
                </form>

                <!-- Form sắp xếp -->
                <form
                    class="khu-vuc-sap-xep"
                    action="danh-sach.php"
                    method="get"
                >
                    <?php if (!empty($tuKhoa)): ?>
                        <input
                            type="hidden"
                            name="keyword"
                            value="<?= e($tuKhoa) ?>"
                        >
                    <?php endif; ?>

                    <?php if (!empty($danhMuc)): ?>
                        <input
                            type="hidden"
                            name="dm"
                            value="<?= e($danhMuc) ?>"
                        >
                    <?php endif; ?>

                    <label for="sap-xep">Sắp xếp</label>

                    <select
                        id="sap-xep"
                        name="sapXep"
                        onchange="this.form.submit()"
                    >
                        <option
                            value="ten-az"
                            <?= $sapXep === 'ten-az' ? 'selected' : '' ?>
                        >
                            Mặc định (A → Z)
                        </option>

                        <option
                            value="danhGiaGiam"
                            <?= $sapXep === 'danhGiaGiam' ? 'selected' : '' ?>
                        >
                            Đánh giá cao nhất
                        </option>

                        <option
                            value="thoiGianTang"
                            <?= $sapXep === 'thoiGianTang' ? 'selected' : '' ?>
                        >
                            Thời gian ngắn nhất
                        </option>

                        <option
                            value="nganSachTang"
                            <?= $sapXep === 'nganSachTang' ? 'selected' : '' ?>
                        >
                            Ngân sách thấp nhất
                        </option>

                        <option
                            value="ten-za"
                            <?= $sapXep === 'ten-za' ? 'selected' : '' ?>
                        >
                            Tên Z → A
                        </option>
                    </select>
                </form>

            </div>

            <!-- Hàng dưới: Lọc danh mục -->
            <nav
                class="bo-loc-mon-an"
                aria-label="Lọc món ăn"
            >
                <?php
                $dsDanhMuc = [
                    '' => 'Tất cả',
                    'Món chính' => 'Món chính',
                    'Món canh' => 'Món canh',
                    'Món xào' => 'Món xào',
                    'Món rau' => 'Món rau',
                    'Món khai vị' => 'Món khai vị',
                    'Đồ uống' => 'Đồ uống',
                    'Món tráng miệng' => 'Món tráng miệng',
                    'Món chay' => 'Món chay'
                ];

                foreach ($dsDanhMuc as $key => $label):
                    $isDangChon = ($danhMuc === $key);

                    $params = $_GET;
                    $params['dm'] = $key;
                    $params['page'] = 1;

                    if ($key === '') {
                        unset($params['dm']);
                    }

                    $url = 'danh-sach.php?' . http_build_query($params);
                ?>
                    <a
                        href="<?= e($url) ?>"
                        class="nut-bo-loc <?= $isDangChon ? 'dang-loc active' : '' ?>"
                    >
                        <?= e($label) ?>
                    </a>
                <?php endforeach; ?>
            </nav>

        </div>

        <!-- 4. KẾT QUẢ DANH SÁCH MÓN ĂN -->
        <section
            class="khu-vuc-ket-qua"
            aria-labelledby="tieu-de-ket-qua"
        >
            <div class="tieu-de-ket-qua">
                <h2 id="tieu-de-ket-qua">Các món ăn</h2>

                <p class="so-luong-mon-an" id="so-luong-mon-an">
                    Hiển thị <?= count($danhSachHienThi) ?>
                    / <?= $tongSoMon ?> món ăn
                    (Trang <?= $trangHienTai ?>/<?= $tongSoTrang ?>)
                </p>
            </div>

            <div class="danh-sach-mon-an" id="danh-sach-mon-an">
                <?php if (!empty($danhSachHienThi)): ?>

                    <?php foreach ($danhSachHienThi as $mon): ?>
                        <?php
                        // Lấy ID món ăn
                        $idChuan = $mon->id ?? $mon->maMon ?? '';

                        // Kiểm tra trạng thái yêu thích
                        $danhSachYeuThich =
                            $yeuThichService->danhSachMonAn($kho);

                        $daYeuThich = false;

                        foreach ($danhSachYeuThich as $monYeuThich) {
                            if ($monYeuThich->id === $idChuan) {
                                $daYeuThich = true;
                                break;
                            }
                        }
                        ?>

                        <article
                            class="the-mon-an"
                            data-danh-muc="<?= e(
                                $mon->danhMuc
                                ?? $mon->danh_muc
                                ?? $mon->loai_mon
                                ?? ''
                            ) ?>"
                        >
                            <div class="khung-anh-mon">
                                <img
                                    src="<?= e(
                                        $mon->hinhAnh
                                        ?? $mon->hinh_anh
                                        ?? 'images/ca-kho-to.jpg'
                                    ) ?>"
                                    alt="<?= e($mon->ten ?? '') ?>"
                                    loading="lazy"
                                >

                                <!-- Nút thêm hoặc bỏ yêu thích -->
                                <form
                                    action="<?= e(
                                        $_SERVER['REQUEST_URI']
                                        ?? 'danh-sach.php'
                                    ) ?>"
                                    method="post"
                                >
                                    <button
                                        class="nut-yeu-thich"
                                        type="submit"
                                        name="doi_yeu_thich"
                                        value="<?= e($idChuan) ?>"
                                        aria-label="<?= $daYeuThich
                                            ? 'Bỏ khỏi yêu thích'
                                            : 'Thêm vào yêu thích' ?>"
                                    >
                                        <?= $daYeuThich ? '♥' : '♡' ?>
                                    </button>
                                </form>
                            </div>

                            <div class="noi-dung-the-mon">
                                <h3><?= e($mon->ten ?? '') ?></h3>

                                <p class="thong-tin-phu">
                                    <span class="item-thong-tin">
                                        <img
                                            src="images/icons/icon-thoi-gian.svg"
                                            alt="Thời gian"
                                            class="icon-phu"
                                        >
                                        <?= e(
                                            $mon->thoiGian
                                            ?? $mon->thoi_gian
                                            ?? '20'
                                        ) ?> phút
                                    </span>

                                    <span class="cham-phan-cach">•</span>

                                    <span class="item-thong-tin">
                                        <img
                                            src="images/icons/icon-ngan-sach.svg"
                                            alt="Ngân sách"
                                            class="icon-phu"
                                        >
                                        <?php
                                        if (isset($mon->nganSach)) {
                                            echo number_format(
                                                $mon->nganSach,
                                                0,
                                                ',',
                                                '.'
                                            ) . 'đ';
                                        } elseif (isset($mon->gia)) {
                                            echo number_format(
                                                $mon->gia,
                                                0,
                                                ',',
                                                '.'
                                            ) . 'đ';
                                        } else {
                                            echo '30.000đ';
                                        }
                                        ?>
                                    </span>

                                    <span class="cham-phan-cach">•</span>

                                    <span class="item-thong-tin">
                                        <img
                                            src="images/icons/icon-do-kho.svg"
                                            alt="Độ khó"
                                            class="icon-phu"
                                        >
                                        <?= e(
                                            $mon->doKho
                                            ?? $mon->do_kho
                                            ?? 'Dễ'
                                        ) ?>
                                    </span>
                                </p>

                                <a
                                    href="chi-tiet.php?id=<?= e($idChuan) ?>"
                                    class="nut"
                                >
                                    Chi tiết món ăn
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>

                <?php else: ?>
                    <p style="padding: 20px; text-align: center; width: 100%;">
                        Không tìm thấy món ăn nào phù hợp với lựa chọn của bạn.
                    </p>
                <?php endif; ?>
            </div>
        </section>

        <!-- 5. PHÂN TRANG ĐỘNG -->
        <?php if ($tongSoTrang > 1): ?>
            <nav
                class="phan-trang"
                id="phan-trang"
                aria-label="Phân trang danh sách món ăn"
            >
                <?php if ($trangHienTai > 1): ?>
                    <?php
                    $params = $_GET;
                    $params['page'] = $trangHienTai - 1;
                    ?>

                    <a
                        href="?<?= http_build_query($params) ?>"
                        class="nut-phan-trang"
                        aria-label="Trang trước"
                    >
                        ‹
                    </a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $tongSoTrang; $i++): ?>
                    <?php
                    $params = $_GET;
                    $params['page'] = $i;
                    ?>

                    <a
                        href="?<?= http_build_query($params) ?>"
                        class="nut-phan-trang <?= $i === $trangHienTai
                            ? 'active dang-chon'
                            : '' ?>"
                    >
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($trangHienTai < $tongSoTrang): ?>
                    <?php
                    $params = $_GET;
                    $params['page'] = $trangHienTai + 1;
                    ?>

                    <a
                        href="?<?= http_build_query($params) ?>"
                        class="nut-phan-trang"
                        aria-label="Trang sau"
                    >
                        ›
                    </a>
                <?php endif; ?>
            </nav>
        <?php endif; ?>

    </section>
</main>

<?php
require __DIR__ . '/inc/footer.php';
?>