<?php
/**
 * Tệp: chi-tiet.php
 * Website: Cook with me - Nhóm 04
 *
 * Bài thực hành 6 - Chức năng 1:
 * - Đọc chi tiết món ăn từ MySQL
 * - Hiển thị tên danh mục
 * - Hiển thị tối đa 4 món cùng danh mục
 * - ID không hợp lệ trả về HTTP 404
 * - Không truy vấn MySQL trong vòng lặp
 * - Lưu yêu thích bằng POST khi tắt JavaScript
 */

declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';

use App\Data\KhoMonAn;
use App\Services\YeuThichService;

// ======================================
// 1. KIỂM TRA ID MÓN ĂN
// ======================================

// ID trên URL là slug của món ăn.
$id = trim((string) ($_GET['id'] ?? ''));

$khoMonAn = new KhoMonAn(db());

// Chỉ truy vấn khi có ID hợp lệ về mặt định dạng.
$monAn = null;

if ($id !== '' && strlen($id) <= 255) {
    $monAn = $khoMonAn->timTheoId($id);
}

// Không tìm thấy món -> HTTP 404.
if ($monAn === null) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

// ======================================
// 2. LẤY MÓN ĂN CÙNG DANH MỤC
// ======================================

$danhSachCungDanhMuc = $khoMonAn->layCungDanhMuc(
    (string) $monAn->danhMuc,
    (string) $monAn->id,
    4
);

// ======================================
// 3. TRẠNG THÁI ĐĂNG NHẬP VÀ YÊU THÍCH
// ======================================

$daDangNhap = !empty($_SESSION['user'])
    || !empty($_SESSION['nguoi_dung']);

$yeuThichService = new YeuThichService();

$daYeuThich = $daDangNhap
    && $yeuThichService->co((string) $monAn->id);

// ======================================
// 4. XỬ LÝ POST: LƯU HOẶC BỎ YÊU THÍCH
// ======================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!$daDangNhap) {
        chuyen_huong('dang-nhap.php');
        exit;
    }

    // Chỉ xử lý thao tác hợp lệ.
    if (isset($_POST['doi_yeu_thich'])) {

        if ($daYeuThich) {
            $yeuThichService->xoa(
                (string) $monAn->id
            );

            gan_thong_bao(
                'success',
                'Đã bỏ món khỏi danh sách yêu thích.'
            );
        } else {
            $yeuThichService->them(
                (string) $monAn->id
            );

            gan_thong_bao(
                'success',
                'Đã lưu món vào danh sách yêu thích.'
            );
        }
    }

    // PRG: tránh gửi lại POST khi nhấn F5.
    header(
        'Location: chi-tiet.php?id='
        . rawurlencode((string) $monAn->id),
        true,
        303
    );
    exit;
}

// ======================================
// 5. GHI NHỚ MÓN ĐÃ XEM BẰNG COOKIE
// ======================================

$daXemIds = [];

if (!empty($_COOKIE['da_xem'])) {

    $duLieuCookie = json_decode(
        (string) $_COOKIE['da_xem'],
        true
    );

    if (is_array($duLieuCookie)) {

        foreach (array_slice($duLieuCookie, 0, 20) as $idDaXem) {

            if (!is_string($idDaXem)) {
                continue;
            }

            $idDaXem = trim($idDaXem);

            if (
                $idDaXem !== ''
                && strlen($idDaXem) <= 255
            ) {
                $daXemIds[] = $idDaXem;
            }
        }
    }
}

// Đưa món hiện tại lên đầu.
// Loại bỏ trùng lặp, giữ tối đa 5 món.
$daXemIds = array_slice(
    array_values(
        array_unique(
            array_merge(
                [(string) $monAn->id],
                $daXemIds
            )
        )
    ),
    0,
    5
);

// Kiểm tra các món còn tồn tại bằng truy vấn nhóm.
// Không truy vấn riêng từng món trong vòng lặp.
$danhSachDaXem = $khoMonAn->timNhieuTheoSlug(
    $daXemIds
);

$daXemHopLe = [];

foreach ($danhSachDaXem as $monDaXem) {
    $daXemHopLe[] = (string) $monDaXem->id;
}

// Lưu cookie trong 30 ngày.
setcookie(
    'da_xem',
    json_encode(
        $daXemHopLe,
        JSON_UNESCAPED_UNICODE
    ),
    [
        'expires' => time() + (30 * 24 * 60 * 60),
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax'
    ]
);

// ======================================
// 6. CLASS ICON NGUYÊN LIỆU
// ======================================

function layClassNguyenLieu(string $ten): string
{
    $tenLower = mb_strtolower($ten, 'UTF-8');

    if (
        str_contains($tenLower, 'rau thơm')
        || str_contains($tenLower, 'rau sống')
    ) {
        return 'nguyen-lieu-rau-thom';
    }

    if (str_contains($tenLower, 'rau')) {
        return 'nguyen-lieu-rau';
    }

    if (str_contains($tenLower, 'thịt')) {
        return 'nguyen-lieu-thit';
    }

    if (str_contains($tenLower, 'tỏi')) {
        return 'nguyen-lieu-toi';
    }

    if (str_contains($tenLower, 'hành')) {
        return 'nguyen-lieu-hanh';
    }

    if (str_contains($tenLower, 'nước mắm')) {
        return 'nguyen-lieu-nuoc-mam';
    }

    if (str_contains($tenLower, 'tiêu')) {
        return 'nguyen-lieu-tieu';
    }

    if (str_contains($tenLower, 'cá')) {
        return 'nguyen-lieu-ca';
    }

    if (str_contains($tenLower, 'tôm')) {
        return 'nguyen-lieu-tom';
    }

    if (str_contains($tenLower, 'ớt')) {
        return 'nguyen-lieu-ot';
    }

    if (str_contains($tenLower, 'đường')) {
        return 'nguyen-lieu-duong';
    }

    if (str_contains($tenLower, 'dầu')) {
        return 'nguyen-lieu-dau';
    }

    if (
        str_contains($tenLower, 'sợi')
        || str_contains($tenLower, 'mì')
        || str_contains($tenLower, 'bún')
    ) {
        return 'nguyen-lieu-soi';
    }

    return 'nguyen-lieu-gia-vi';
}

// ======================================
// 7. THÔNG SỐ TRANG
// ======================================

$tenMon = $monAn->ten ?: 'Chi tiết món ăn';

$tieuDe = $tenMon . ' - Cook with Me';

$trang = 'chi-tiet';

require __DIR__ . '/inc/header.php';
?>

<main class="chi-tiet-trang">

    <?= hien_thi_thong_bao() ?>

    <div class="chi-tiet-mon-an">

        <!-- ==================================
             HÀNG 1: HÌNH ẢNH
        =================================== -->

        <div class="khu-vuc-hinh-anh">

            <figure class="hinh-anh-mon-an">

                <img
                    src="<?= e(
                        $monAn->hinhAnh
                        ?: 'images/default.jpg'
                    ) ?>"
                    alt="<?= e($tenMon) ?>"
                >

            </figure>

        </div>

        <!-- ==================================
             HÀNG 1: THÔNG TIN MÓN ĂN
        =================================== -->

        <div class="thong-tin-mon-an">

            <h1 class="tieu-de-mon-an">
                <?= e($tenMon) ?>
            </h1>

            <!-- TÊN DANH MỤC TỪ MYSQL -->
            <p class="danh-muc-mon-an">

                <strong>Danh mục:</strong>

                <a
                    href="danh-sach.php?dm=<?= urlencode(
                        (string) $monAn->danhMuc
                    ) ?>"
                >
                    <?= e($monAn->danhMuc) ?>
                </a>

            </p>

            <!-- ĐÁNH GIÁ -->
            <div class="thong-tin-danh-gia">

                <span class="danh-gia">
                    ★★★★★
                </span>

                <span class="so-luot-danh-gia">
                    <?= e((string) $monAn->danhGia) ?>
                    (
                    <?= e((string) $monAn->soLuotDanhGia) ?>
                    đánh giá)
                </span>

            </div>

            <!-- THÔNG TIN CƠ BẢN -->
            <div class="thong-tin-co-ban-ngang">

                <div class="item-meta">

                    <img
                        src="images/icons/khau-phan.svg"
                        alt="Khẩu phần"
                        style="width:18px;height:18px;object-fit:contain;"
                    >

                    <span>
                        <?= e((string) $monAn->khauPhan) ?>
                        người
                    </span>

                </div>

                <div class="item-meta">

                    <img
                        src="images/icons/thoi-gian.svg"
                        alt="Thời gian"
                        style="width:18px;height:18px;object-fit:contain;"
                    >

                    <span>
                        <?= e((string) $monAn->thoiGian) ?>
                        phút
                    </span>

                </div>

                <div class="item-meta">

                    <img
                        src="images/icons/do-kho.svg"
                        alt="Độ khó"
                        style="width:18px;height:18px;object-fit:contain;"
                    >

                    <span>
                        <?= e($monAn->doKho) ?>
                    </span>

                </div>

            </div>

            <!-- MÔ TẢ MÓN ĂN -->
            <div class="mo-ta-mon-an">

                <p>
                    <?= e($monAn->moTa) ?>
                </p>

            </div>

            <!-- HÀNH ĐỘNG -->
            <div class="khu-vuc-hanh-dong">

                <?php if ($daDangNhap): ?>

                    <!-- FORM HOẠT ĐỘNG KHI TẮT JS -->
                    <form
                        action="chi-tiet.php?id=<?= urlencode(
                            (string) $monAn->id
                        ) ?>"
                        method="post"
                    >

                        <button
                            type="submit"
                            name="doi_yeu_thich"
                            value="1"
                            class="nut nut-yeu-thich"
                            aria-label="<?= $daYeuThich
                                ? 'Bỏ khỏi yêu thích'
                                : 'Thêm vào yêu thích'
                            ?>"
                        >
                            <?= $daYeuThich
                                ? '♥ Đã lưu'
                                : '♡ Lưu công thức'
                            ?>
                        </button>

                    </form>

                <?php else: ?>

                    <a
                        href="dang-nhap.php"
                        class="nut nut-yeu-thich"
                    >
                        ♡ Đăng nhập để lưu công thức
                    </a>

                <?php endif; ?>

                <button
                    type="button"
                    class="nut nut-chia-se"
                >
                    Chia sẻ
                </button>

            </div>

        </div>

        <!-- ==================================
             HÀNG 2: NGUYÊN LIỆU
        =================================== -->

        <div class="cot-trai-chi-tiet">

            <section class="khu-vuc-nguyen-lieu">

                <h2>
                    Nguyên liệu
                </h2>

                <ul class="danh-sach-nguyen-lieu">

                    <?php if (
                        !empty($monAn->nguyenLieu)
                        && is_array($monAn->nguyenLieu)
                    ): ?>

                        <?php foreach (
                            $monAn->nguyenLieu as $nl
                        ): ?>

                            <?php
                                $tenNL = is_array($nl)
                                    ? (string) ($nl['ten'] ?? '')
                                    : (string) $nl;

                                $luongNL = is_array($nl)
                                    ? (string) ($nl['soLuong'] ?? '')
                                    : '';

                                $classIcon = (
                                    is_array($nl)
                                    && isset($nl['class'])
                                )
                                    ? (string) $nl['class']
                                    : layClassNguyenLieu($tenNL);
                            ?>

                            <li class="<?= e($classIcon) ?>">

                                <span>
                                    <?= e($tenNL) ?>
                                </span>

                                <?php if ($luongNL !== ''): ?>

                                    <span
                                        class="so-luong-nl"
                                        style="font-weight:600;color:var(--mau-chinh);"
                                    >
                                        <?= e($luongNL) ?>
                                    </span>

                                <?php endif; ?>

                            </li>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <li>
                            Chưa có thông tin nguyên liệu.
                        </li>

                    <?php endif; ?>

                </ul>

            </section>

            <!-- BÌNH LUẬN -->
            <button
                type="button"
                class="nut-binh-luan-full"
            >
                Bình luận (24)
            </button>

        </div>

        <!-- ==================================
             HÀNG 2: CÁC BƯỚC CHẾ BIẾN
        =================================== -->

        <div class="cot-phai-chi-tiet">

            <section class="khu-vuc-cac-buoc">

                <h2>
                    Các bước chế biến
                </h2>

                <ol class="cac-buoc-che-bien">

                    <?php if (
                        !empty($monAn->cacBuoc)
                        && is_array($monAn->cacBuoc)
                    ): ?>

                        <?php foreach (
                            $monAn->cacBuoc as $buoc
                        ): ?>

                            <li>
                                <?= e($buoc) ?>
                            </li>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <li>
                            Chưa có hướng dẫn chế biến.
                        </li>

                    <?php endif; ?>

                </ol>

            </section>

            <!-- VIDEO HƯỚNG DẪN -->
            <section class="video-huong-dan">

                <h2>
                    Video hướng dẫn
                </h2>

                <div class="video-preview-card">

                    <img
                        src="<?= e(
                            $monAn->hinhAnh
                            ?: 'images/default.jpg'
                        ) ?>"
                        alt="Video hướng dẫn <?= e($tenMon) ?>"
                    >

                    <div class="nut-play-video">
                        ▶
                    </div>

                    <div class="thoi-luong-video">
                        3:42
                    </div>

                </div>

            </section>

        </div>

    </div>

    <!-- ==================================
         MÓN ĂN CÙNG DANH MỤC
    =================================== -->

    <section class="mon-cung-danh-muc">

        <div class="tieu-de-khu-vuc">

            <h2>
                Món ăn cùng danh mục:
                <?= e($monAn->danhMuc) ?>
            </h2>

            <a
                href="danh-sach.php?dm=<?= urlencode(
                    (string) $monAn->danhMuc
                ) ?>"
            >
                Xem danh mục →
            </a>

        </div>

        <?php if (empty($danhSachCungDanhMuc)): ?>

            <p>
                Hiện chưa có món ăn khác cùng danh mục.
            </p>

        <?php else: ?>

            <div class="danh-sach-mon-an">

                <?php foreach (
                    $danhSachCungDanhMuc as $monLienQuan
                ): ?>

                    <article class="the-mon-an">

                        <div class="khung-anh-mon">

                            <img
                                src="<?= e(
                                    $monLienQuan->hinhAnh
                                    ?: 'images/default.jpg'
                                ) ?>"
                                alt="<?= e($monLienQuan->ten) ?>"
                                loading="lazy"
                            >

                        </div>

                        <div class="noi-dung-the-mon">

                            <h3>
                                <?= e($monLienQuan->ten) ?>
                            </h3>

                            <p>
                                <?= (int) $monLienQuan->thoiGian ?>
                                phút ·
                                <?= number_format(
                                    (int) $monLienQuan->nganSach,
                                    0,
                                    ',',
                                    '.'
                                ) ?>đ
                            </p>

                            <a
                                class="nut"
                                href="chi-tiet.php?id=<?= urlencode(
                                    (string) $monLienQuan->id
                                ) ?>"
                            >
                                Xem công thức
                            </a>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </section>

</main>

<?php
require __DIR__ . '/inc/footer.php';
?>
