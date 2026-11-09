<?php

/**
 * Tệp: goi-y-mon-an.php
 * Mục đích: Gợi ý món ăn theo nguyên liệu, ngân sách, thời gian và khẩu phần.
 * Cho phép thêm món vào danh sách đi chợ cá nhân.
 */
declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/xac-thuc.php';
require_once __DIR__ . '/src/Data/KhoMonAn.php';
require_once __DIR__ . '/src/Services/DanhSachDiChoService.php';

use App\Data\KhoMonAn;
use App\Services\DanhSachDiChoService;

$nguoiDung = yeuCauDangNhap();

/**
 * Dựng URL trở về trang gợi ý, giữ nguyên bộ lọc và số trang.
 */
function duongDanGoiY(): string
{
    $thamSo = [
        'ingredients'  => lay_chuoi($_POST, 'ingredients', 200),
        'budget'       => lay_chuoi($_POST, 'budget', 20),
        'cooking_time' => lay_chuoi($_POST, 'cooking_time', 20),
        'servings'     => lay_chuoi($_POST, 'servings', 20),
    ];

    $page = filter_var($_POST['page'] ?? 1, FILTER_VALIDATE_INT);
    if ($page !== false && $page > 1) {
        $thamSo['page'] = (string) $page;
    }

    $thamSo = array_filter(
        $thamSo,
        fn($giaTri) => $giaTri !== ''
    );

    return 'goi-y-mon-an.php' . (
        $thamSo ? '?' . http_build_query($thamSo) : ''
    );
}

$kho = new KhoMonAn(db());

$danhSachDiChoService = new DanhSachDiChoService(
    db(),
    (int) $nguoiDung['id']
);

// Xử lý thêm món vào danh sách đi chợ.
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {

    try {
        $them = $_POST['them_danh_sach'] ?? '';

        if (!is_string($them) || trim($them) === '') {
            throw new DomainException('Món ăn không hợp lệ.');
        }

        $danhSachDiChoService->them(trim($them));

        gan_thong_bao('success', 'Đã thêm món vào danh sách đi chợ.');
    } catch (DomainException $e) {
        gan_thong_bao('error', $e->getMessage());
    } catch (Throwable $e) {
        error_log('Loi them mon vao danh sach di cho: ' . $e->getMessage());
        gan_thong_bao('error', 'Không thể thêm món vào danh sách đi chợ.');
    }

    chuyen_huong(duongDanGoiY());
    exit;
}

// Lấy dữ liệu món ăn.
$danhSach = $kho->layTatCa();

// Lấy các tiêu chí lọc.
$nguyenLieu = lay_chuoi($_GET, 'ingredients', 200);
$nganSach   = lay_chuoi($_GET, 'budget', 20);
$thoiGian   = lay_chuoi($_GET, 'cooking_time', 20);
$khauPhan   = lay_chuoi($_GET, 'servings', 20);

// Lọc món ăn theo tiêu chí.
$danhSachGoiY = [];

foreach ($danhSach as $monAn) {
    // Lọc theo nguyên liệu.
    if ($nguyenLieu !== '') {
        $tuKhoaNguyenLieu = mb_strtolower($nguyenLieu, 'UTF-8');
        $coNguyenLieu = false;

        foreach ($monAn->nguyenLieu as $item) {
            $tenNguyenLieu = $item['ten'] ?? '';

            if (
                $tenNguyenLieu !== ''
                && mb_stripos(
                    $tenNguyenLieu,
                    $tuKhoaNguyenLieu,
                    0,
                    'UTF-8'
                ) !== false
            ) {
                $coNguyenLieu = true;
                break;
            }
        }

        if (!$coNguyenLieu) {
            continue;
        }
    }

    // Lọc theo ngân sách.
    if ($nganSach !== '' && (int) $monAn->nganSach > (int) $nganSach) {
        continue;
    }

    // Lọc theo thời gian nấu.
    if ($thoiGian !== '' && (int) $monAn->thoiGian > (int) $thoiGian) {
        continue;
    }

    // Lọc theo số người ăn.
    if ($khauPhan !== '' && (int) $monAn->khauPhan < (int) $khauPhan) {
        continue;
    }

    $danhSachGoiY[] = $monAn;
}

// Phân trang danh sách món ăn phù hợp.
$soMonMoiTrang = 8;
$tongSoMon = count($danhSachGoiY);
$tongSoTrang = max(1, (int) ceil($tongSoMon / $soMonMoiTrang));

$trangHienTai = filter_var(
    $_GET['page'] ?? 1,
    FILTER_VALIDATE_INT
);

$trangHienTai = $trangHienTai !== false
    ? max(1, min($tongSoTrang, $trangHienTai))
    : 1;

$danhSachHienThi = array_slice(
    $danhSachGoiY,
    ($trangHienTai - 1) * $soMonMoiTrang,
    $soMonMoiTrang
);

// Chỉ lấy số lượng món, không tải toàn bộ danh sách đi chợ.
$soMonTrongDanhSach = $danhSachDiChoService->soLuong();

// Giữ lại bộ lọc khi chuyển trang.
$thamSoPhanTrang = array_filter([
    'ingredients'  => $nguyenLieu,
    'budget'       => $nganSach,
    'cooking_time' => $thoiGian,
    'servings'     => $khauPhan,
], fn($giaTri) => $giaTri !== '');

// Thiết lập header.
$tieuDe = 'Gợi ý món ăn';
$trang = 'goi-y-mon-an';

require __DIR__ . '/inc/header.php';
?>

<main class="goi-y-trang">

    <?= hien_thi_thong_bao() ?>

    <!-- LIÊN KẾT ĐI CHỢ CỦA TÔI -->
    <div class="nut-mo-danh-sach-di-cho">
        <a href="di-cho-cua-toi.php?tab=hien-tai" class="nut">
            Đi chợ của tôi
            <span>(<?= $soMonTrongDanhSach ?> món)</span>
        </a>
    </div>

    <!-- BANNER TỦ LẠNH CỦA TÔI -->
    <section class="banner-tu-lanh">
        <div class="hinh-anh-banner hinh-anh-tu-lanh">
            <img src="images/icons/fridge.svg" alt="Tủ lạnh" class="anh-tu-lanh">
        </div>

        <div class="noi-dung-banner">
            <p class="nhan-tu-lanh">Tủ lạnh của tôi</p>
            <h1 class="tieu-de-banner">Hôm nay ăn gì?</h1>
            <p class="mo-ta-banner">
                Nhập nguyên liệu bạn có, chúng tôi sẽ gợi ý món ăn phù hợp!
            </p>
        </div>

        <div class="hinh-anh-banner hinh-anh-ro-rau">
            <img src="images/basket-vegetables.svg" alt="Rổ rau củ quả" class="anh-ro-rau-cu">
        </div>
    </section>

    <!-- FORM BỘ LỌC TÌM KIẾM -->
    <div class="khung-bo-loc-goi-y">
        <form class="form-goi-y-moi" id="form-goi-y" action="goi-y-mon-an.php" method="get">

            <div class="khong-gian-loc">

                <div class="o-nhap-loc o-nguyen-lieu">
                    <label for="ingredients">Nguyên liệu (có thể chọn nhiều)</label>

                    <input
                        type="text"
                        id="ingredients"
                        name="ingredients"
                        value="<?= e($nguyenLieu) ?>"
                        placeholder="Nhập nguyên liệu..."
                    >

                    <div class="danh-sach-tags">
                        <span class="tag-item">
                            Thịt heo
                            <button type="button" class="nut-xoa-tag">&times;</button>
                        </span>
                        <span class="tag-item">
                            Trứng
                            <button type="button" class="nut-xoa-tag">&times;</button>
                        </span>
                        <span class="tag-item">
                            Cà chua
                            <button type="button" class="nut-xoa-tag">&times;</button>
                        </span>
                        <span class="tag-item">
                            Rau cải
                            <button type="button" class="nut-xoa-tag">&times;</button>
                        </span>
                    </div>
                </div>

                <div class="o-nhap-loc">
                    <label for="budget">Ngân sách</label>

                    <select id="budget" name="budget">
                        <option value="">Chọn ngân sách</option>
                        <option value="50000" <?= $nganSach === '50000' ? 'selected' : '' ?>>
                            Dưới 50.000đ
                        </option>
                        <option value="100000" <?= $nganSach === '100000' ? 'selected' : '' ?>>
                            50.000đ - 100.000đ
                        </option>
                        <option value="200000" <?= $nganSach === '200000' ? 'selected' : '' ?>>
                            100.000đ - 200.000đ
                        </option>
                    </select>
                </div>

                <div class="o-nhap-loc">
                    <label for="cooking-time">Thời gian nấu</label>

                    <select id="cooking-time" name="cooking_time">
                        <option value="">Chọn thời gian</option>
                        <option value="15" <?= $thoiGian === '15' ? 'selected' : '' ?>>
                            Dưới 15 phút
                        </option>
                        <option value="30" <?= $thoiGian === '30' ? 'selected' : '' ?>>
                            Dưới 30 phút
                        </option>
                        <option value="60" <?= $thoiGian === '60' ? 'selected' : '' ?>>
                            Dưới 60 phút
                        </option>
                    </select>
                </div>

                <div class="o-nhap-loc">
                    <label for="servings">Số người ăn</label>

                    <select id="servings" name="servings">
                        <option value="">Chọn số người</option>
                        <option value="1" <?= $khauPhan === '1' ? 'selected' : '' ?>>
                            1 người
                        </option>
                        <option value="2" <?= $khauPhan === '2' ? 'selected' : '' ?>>
                            2 - 3 người
                        </option>
                        <option value="4" <?= $khauPhan === '4' ? 'selected' : '' ?>>
                            4 người trở lên
                        </option>
                    </select>
                </div>

            </div>

            <div class="hanh-dong-goi-y">
                <button class="nut-goi-y-tim" type="submit">
                    🔍 Gợi ý món ăn
                </button>
            </div>

        </form>
    </div>

    <!-- MÓN ĂN PHÙ HỢP -->
    <section class="mon-duoc-goi-y-moi" aria-labelledby="tieu-de-mon-goi-y">

        <div class="thanh-tieu-de-mon">
            <h2 id="tieu-de-mon-goi-y">Món ăn phù hợp</h2>
            <a href="danh-sach.php" class="xem-tat-ca">Xem tất cả &rarr;</a>
        </div>

        <?php if ($tongSoMon > 0): ?>

            <p class="thong-bao-goi-y">
                Tìm thấy <?= $tongSoMon ?> món ăn phù hợp.
                Đang hiển thị <?= count($danhSachHienThi) ?> món trên trang
                <?= $trangHienTai ?>/<?= $tongSoTrang ?>.
            </p>

            <div class="danh-sach-mon-goi-y" id="danh-sach-mon-goi-y">

                <?php foreach ($danhSachHienThi as $monAn): ?>

                    <article class="the-goi-y">

                        <img
                            src="<?= e($monAn->hinhAnh) ?>"
                            alt="Hình ảnh món <?= e($monAn->ten) ?>"
                            width="300"
                            height="200"
                            loading="lazy"
                        >

                        <h3><?= e($monAn->ten) ?></h3>

                        <p class="mo-ta-mon">
                            <?= e($monAn->moTa) ?>
                        </p>

                        <p class="thong-tin-ngan">
                            <?= (int) $monAn->thoiGian ?> phút ·
                            <?= number_format((int) $monAn->nganSach, 0, ',', '.') ?> VNĐ ·
                            <?= (int) $monAn->khauPhan ?> người
                        </p>

                        <div class="hanh-dong-the-goi-y">

                            <a href="chi-tiet.php?id=<?= e($monAn->id) ?>" class="nut">
                                Xem chi tiết
                            </a>

                            <form action="goi-y-mon-an.php" method="post">

                                <?= csrfField() ?>

                                <input
                                    type="hidden"
                                    name="them_danh_sach"
                                    value="<?= e($monAn->id) ?>"
                                >

                                <?php foreach ([
                                    'ingredients'  => $nguyenLieu,
                                    'budget'       => $nganSach,
                                    'cooking_time' => $thoiGian,
                                    'servings'     => $khauPhan,
                                    'page'         => $trangHienTai,
                                ] as $ten => $giaTri): ?>

                                    <input
                                        type="hidden"
                                        name="<?= e($ten) ?>"
                                        value="<?= e((string) $giaTri) ?>"
                                    >

                                <?php endforeach; ?>

                                <button type="submit" class="nut">
                                    Thêm vào danh sách đi chợ
                                </button>

                            </form>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

            <!-- PHÂN TRANG -->
            <?php if ($tongSoTrang > 1): ?>

                <nav class="phan-trang-goi-y" aria-label="Phân trang món ăn">

                    <?php if ($trangHienTai > 1): ?>
                        <?php
                        $urlTruoc = http_build_query(
                            $thamSoPhanTrang + ['page' => $trangHienTai - 1]
                        );
                        ?>

                        <a href="goi-y-mon-an.php?<?= e($urlTruoc) ?>">
                            ← Trước
                        </a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $tongSoTrang; $i++): ?>
                        <?php
                        $urlTrang = http_build_query(
                            $thamSoPhanTrang + ['page' => $i]
                        );
                        ?>

                        <a
                            href="goi-y-mon-an.php?<?= e($urlTrang) ?>"
                            class="<?= $i === $trangHienTai ? 'dang-chon' : '' ?>"
                            <?= $i === $trangHienTai ? 'aria-current="page"' : '' ?>
                        >
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($trangHienTai < $tongSoTrang): ?>
                        <?php
                        $urlSau = http_build_query(
                            $thamSoPhanTrang + ['page' => $trangHienTai + 1]
                        );
                        ?>

                        <a href="goi-y-mon-an.php?<?= e($urlSau) ?>">
                            Sau →
                        </a>
                    <?php endif; ?>

                </nav>

            <?php endif; ?>

        <?php elseif (
            $nguyenLieu !== ''
            || $nganSach !== ''
            || $thoiGian !== ''
            || $khauPhan !== ''
        ): ?>

            <p class="thong-bao-goi-y">
                Không tìm thấy món ăn phù hợp với các tiêu chí đã chọn.
            </p>

        <?php else: ?>

            <p class="thong-bao-goi-y">
                Chưa có món ăn để hiển thị.
            </p>

        <?php endif; ?>

    </section>

</main>

<?php require __DIR__ . '/inc/footer.php'; ?>