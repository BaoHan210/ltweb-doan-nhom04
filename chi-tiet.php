<?php
/**
 * Tệp: chi-tiet.php
 * Trang công khai: ai cũng xem được công thức.
 * Chỉ thao tác lưu yêu thích là phần riêng tư, buộc đăng nhập ở phía máy chủ.
 */

declare(strict_types=1);

require __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
use App\Data\KhoMonAn;
use App\Services\YeuThichService;

// 1. KIỂM TRA ID TRƯỚC MỌI THỨ KHÁC
// Thiếu ID hoặc ID sai thì trả 404 ngay, không chuyển hướng
$id       = trim((string) ($_GET['id'] ?? ''));
$khoMonAn = new KhoMonAn(db());
$monAn = $khoMonAn->timTheoId($id);

if ($monAn === null) {
    require __DIR__ . '/404.php'; // 404.php tự đặt mã HTTP 404
    exit;
}

// 2. TRẠNG THÁI ĐĂNG NHẬP VÀ YÊU THÍCH
$daDangNhap      = !empty($_SESSION['user']) || !empty($_SESSION['nguoi_dung']);
$yeuThichService = new YeuThichService();
$daYeuThich      = $daDangNhap && $yeuThichService->co($monAn->id);

// 3. XỬ LÝ POST: chỉ có thao tác lưu yêu thích
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Khách vãng lai không được lưu, chuyển sang trang đăng nhập
    if (!$daDangNhap) {
        chuyen_huong('dang-nhap.php');
    }

    // Lấy ID từ URL đã kiểm tra, không tin giá trị gửi lên từ form
    if ($daYeuThich) {
        $yeuThichService->xoa($monAn->id);
        gan_thong_bao('success', 'Đã bỏ món khỏi danh sách yêu thích.');
    } else {
        $yeuThichService->them($monAn->id);
        gan_thong_bao('success', 'Đã lưu món vào danh sách yêu thích.');
    }

    // PRG: F5 không gửi lại form
    header('Location: chi-tiet.php?id=' . urlencode($monAn->id), true, 303);
    exit;
}

// 4. GHI NHỚ MÓN VỪA XEM (cookie da_xem, tối đa 5 món)
$daXemIds = [];

if (!empty($_COOKIE['da_xem'])) {
    $giaiMa = json_decode($_COOKIE['da_xem'], true);

    if (is_array($giaiMa)) {
        foreach ($giaiMa as $idDaXem) {
            $idDaXem = trim((string) $idDaXem);

            if ($idDaXem !== '' && $khoMonAn->timTheoId($idDaXem) !== null) {
                $daXemIds[] = $idDaXem;
            }
        }
    }
}

// Đưa món hiện tại lên đầu, bỏ trùng, giữ tối đa 5 món
$daXemIds = array_slice(
    array_values(array_unique(array_merge([$monAn->id], $daXemIds))),
    0,
    5
);

setcookie('da_xem', json_encode($daXemIds), [
    'expires'  => time() + (30 * 24 * 60 * 60),
    'path'     => '/',
    'httponly' => true,
    'samesite' => 'Lax',
]);

/**
 * Gán class icon nguyên liệu theo tên tiếng Việt.
 */
function layClassNguyenLieu(string $ten): string
{
    $tenLower = mb_strtolower($ten);
    // ... giữ nguyên các dòng if bên dưới

    if (str_contains($tenLower, 'rau thơm') || str_contains($tenLower, 'rau sống')) return 'nguyen-lieu-rau-thom';
    if (str_contains($tenLower, 'rau'))        return 'nguyen-lieu-rau';
    if (str_contains($tenLower, 'thịt'))       return 'nguyen-lieu-thit';
    if (str_contains($tenLower, 'tỏi'))        return 'nguyen-lieu-toi';
    if (str_contains($tenLower, 'hành'))       return 'nguyen-lieu-hanh';
    if (str_contains($tenLower, 'nước mắm'))   return 'nguyen-lieu-nuoc-mam';
    if (str_contains($tenLower, 'tiêu'))       return 'nguyen-lieu-tieu';
    if (str_contains($tenLower, 'cá'))         return 'nguyen-lieu-ca';
    if (str_contains($tenLower, 'tôm'))        return 'nguyen-lieu-tom';
    if (str_contains($tenLower, 'ớt'))         return 'nguyen-lieu-ot';
    if (str_contains($tenLower, 'đường'))      return 'nguyen-lieu-duong';
    if (str_contains($tenLower, 'dầu'))        return 'nguyen-lieu-dau';
    if (str_contains($tenLower, 'sợi') || str_contains($tenLower, 'mì') || str_contains($tenLower, 'bún')) {
        return 'nguyen-lieu-soi';
    }

    return 'nguyen-lieu-gia-vi';
}

// 5. HIỂN THỊ
$tenMon = $monAn->ten ?: 'Chi tiết món ăn';
$tieuDe = $tenMon . ' - Cook with Me';
$trang  = 'chi-tiet';

require __DIR__ . '/inc/header.php';
?>

<main class="chi-tiet-trang">

    <?= hien_thi_thong_bao() ?>

    <div class="chi-tiet-mon-an">

        <!-- Hàng 1, trái: hình ảnh -->
        <div class="khu-vuc-hinh-anh">
            <figure class="hinh-anh-mon-an">
                <img src="<?= e($monAn->hinhAnh ?: 'images/default.jpg') ?>" alt="<?= e($tenMon) ?>">
            </figure>
        </div>

        <!-- Hàng 1, phải: thông tin, mô tả, hành động -->
        <div class="thong-tin-mon-an">
            <h1 class="tieu-de-mon-an"><?= e($tenMon) ?></h1>

            <div class="thong-tin-danh-gia">
                <span class="danh-gia">★★★★★</span>
                <span class="so-luot-danh-gia">
                    <?= e((string) $monAn->danhGia) ?> (<?= e((string) $monAn->soLuotDanhGia) ?> đánh giá)
                </span>
            </div>

            <div class="thong-tin-co-ban-ngang">
                <div class="item-meta">
                    <img src="images/icons/khau-phan.svg" alt="Khẩu phần" style="width: 18px; height: 18px; object-fit: contain;">
                    <span><?= e((string) $monAn->khauPhan) ?> người</span>
                </div>
                <div class="item-meta">
                    <img src="images/icons/thoi-gian.svg" alt="Thời gian" style="width: 18px; height: 18px; object-fit: contain;">
                    <span><?= e((string) $monAn->thoiGian) ?> phút</span>
                </div>
                <div class="item-meta">
                    <img src="images/icons/do-kho.svg" alt="Độ khó" style="width: 18px; height: 18px; object-fit: contain;">
                    <span><?= e($monAn->doKho) ?></span>
                </div>
            </div>

            <div class="mo-ta-mon-an">
                <p><?= e($monAn->moTa) ?></p>
            </div>

            <div class="khu-vuc-hanh-dong">
                <?php if ($daDangNhap): ?>
                    <!-- Đã đăng nhập: gửi POST để lưu hoặc bỏ lưu -->
                    <form action="chi-tiet.php?id=<?= e($monAn->id) ?>" method="post">
                        <button
                            type="submit"
                            name="doi_yeu_thich"
                            value="1"
                            class="nut nut-yeu-thich"
                            aria-label="<?= $daYeuThich ? 'Bỏ khỏi yêu thích' : 'Thêm vào yêu thích' ?>"
                        >
                            <?= $daYeuThich ? '♥ Đã lưu' : '♡ Lưu công thức' ?>
                        </button>
                    </form>
                <?php else: ?>
                    <!-- Khách vãng lai: đưa sang trang đăng nhập -->
                    <a href="dang-nhap.php" class="nut nut-yeu-thich">
                        ♡ Đăng nhập để lưu công thức
                    </a>
                <?php endif; ?>

                <button type="button" class="nut nut-chia-se">
                    Chia sẻ
                </button>
            </div>
        </div>

        <!-- Hàng 2, trái: nguyên liệu, bình luận -->
        <div class="cot-trai-chi-tiet">
            <section class="khu-vuc-nguyen-lieu">
                <h2>Nguyên liệu</h2>
                <ul class="danh-sach-nguyen-lieu">
                    <?php if (!empty($monAn->nguyenLieu) && is_array($monAn->nguyenLieu)): ?>
                        <?php foreach ($monAn->nguyenLieu as $nl): ?>
                            <?php
                                $tenNL     = is_array($nl) ? ($nl['ten'] ?? '') : (string) $nl;
                                $luongNL   = is_array($nl) ? ($nl['soLuong'] ?? '') : '';
                                $classIcon = (is_array($nl) && isset($nl['class']))
                                    ? $nl['class']
                                    : layClassNguyenLieu($tenNL);
                            ?>
                            <li class="<?= e($classIcon) ?>">
                                <span><?= e($tenNL) ?></span>
                                <?php if ($luongNL !== ''): ?>
                                    <span class="so-luong-nl" style="font-weight: 600; color: var(--mau-chinh);"><?= e($luongNL) ?></span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </section>

            <button type="button" class="nut-binh-luan-full">Bình luận (24)</button>
        </div>

        <!-- Hàng 2, phải: các bước, video -->
        <div class="cot-phai-chi-tiet">
            <section class="khu-vuc-cac-buoc">
                <h2>Các bước chế biến</h2>
                <ol class="cac-buoc-che-bien">
                    <?php if (!empty($monAn->cacBuoc) && is_array($monAn->cacBuoc)): ?>
                        <?php foreach ($monAn->cacBuoc as $buoc): ?>
                            <li><?= e($buoc) ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ol>
            </section>

            <section class="video-huong-dan">
                <h2>Video hướng dẫn</h2>
                <div class="video-preview-card">
                    <img src="<?= e($monAn->hinhAnh ?: 'images/default.jpg') ?>" alt="Video hướng dẫn <?= e($tenMon) ?>">
                    <div class="nut-play-video">▶</div>
                    <div class="thoi-luong-video">3:42</div>
                </div>
            </section>
        </div>

    </div>
</main>

<?php
require __DIR__ . '/inc/footer.php';
?>