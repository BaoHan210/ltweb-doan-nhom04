<?php
/**
 * Tệp: chi-tiet.php
 * Chức năng: Hiển thị chi tiết công thức nấu ăn dựa vào ID truyền trên URL.
 */

require __DIR__ . '/inc/config.php';

<<<<<<< HEAD
// 1. Kiểm tra nếu chưa đăng nhập -> Chuyển hướng ngay sang trang đăng nhập
if (!isset($_SESSION['user'])) {
    chuyen_huong('dang-nhap.php');
    exit;
}

// 2. Lấy ID từ URL
$id = trim($_GET['id'] ?? '');

// Tìm trực tiếp từ dữ liệu mảng thô trong tệp JSON
$monAn = null;
if (!empty($id)) {
    $duongDanJson = __DIR__ . '/data/mon-an.json';
    if (file_exists($duongDanJson)) {
        $noiDungJson = file_get_contents($duongDanJson);
        $danhSachMang = json_decode($noiDungJson, true);
        
        if (is_array($danhSachMang)) {
            foreach ($danhSachMang as $item) {
                if (isset($item['id']) && trim((string)$item['id']) === trim((string)$id)) {
                    $monAn = $item;
                    break;
                }
=======
use App\Data\KhoMonAn;
use App\Services\YeuThichService;

// 1. Kiểm tra nếu chưa đăng nhập -> Chuyển hướng ngay sang trang đăng nhập
if (!isset($_SESSION['user'])) {
    chuyen_huong('dang-nhap.php');
    exit;
}

// 2. Lấy ID từ URL
$id = trim($_GET['id'] ?? '');

// Khởi tạo kho món ăn
$khoMonAn = new KhoMonAn(__DIR__ . '/data/mon-an.json');

// Tìm món ăn thông qua Data Access Layer
$monAn = null;

if (!empty($id)) {
    $monAn = $khoMonAn->timTheoId($id);
}

$yeuThichService = new YeuThichService();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $idMonAn = trim((string)($_POST['doi_yeu_thich'] ?? ''));

    if (
        $idMonAn !== '' &&
        $khoMonAn->timTheoId($idMonAn) !== null
    ) {
        $danhSachYeuThich = $yeuThichService->danhSachMonAn($khoMonAn);

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

    header('Location: chi-tiet.php?id=' . urlencode($id));
    exit;
}

// 3. XỬ LÝ: Nếu thiếu ID hoặc ID không tồn tại -> Trả về trang LỖI 404
if (empty($id) || !$monAn) {
    http_response_code(404);

    if (file_exists(__DIR__ . '/404.php')) {
        require __DIR__ . '/404.php';
    } else {
        $tieuDe = '404 - Không tìm thấy món ăn';
        $trang  = 'chi-tiet';

        require __DIR__ . '/inc/header.php';
        ?>
        <main class="trang-loi-404" style="padding: 60px 20px; text-align: center;">
            <h1 style="font-size: 48px; color: #e74c3c; margin-bottom: 10px;">404</h1>
            <h2>Không tìm thấy món ăn</h2>
            <p style="color: #666; margin-bottom: 20px;">
                Món ăn bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.
            </p>
            <a href="danh-sach.php"
               class="nut"
               style="display: inline-block; padding: 10px 20px; background: #2E6230; color: #fff; text-decoration: none; border-radius: 8px;">
                Quay lại danh sách
            </a>
        </main>
        <?php
        require __DIR__ . '/inc/footer.php';
    }

    exit;
}

// 4. Lưu món ăn vừa xem vào cookie
$daXemIds = [];

if (!empty($_COOKIE['da_xem'])) {
    $giaiMa = json_decode($_COOKIE['da_xem'], true);

    if (is_array($giaiMa)) {
        foreach ($giaiMa as $idDaXem) {
            $idDaXem = trim((string)$idDaXem);

            if (
                $idDaXem !== ''
                && $khoMonAn->timTheoId($idDaXem) !== null
            ) {
                $daXemIds[] = $idDaXem;
>>>>>>> e6e0155 (Update part A)
            }
        }
    }
}

<<<<<<< HEAD
// 3. XỬ LÝ: Nếu thiếu ID hoặc ID không tồn tại -> Trả về trang LỖI 404
if (empty($id) || !$monAn) {
    http_response_code(404);

    if (file_exists(__DIR__ . '/404.php')) {
        require __DIR__ . '/404.php';
    } else {
        $tieuDe = '404 - Không tìm thấy món ăn';
        $trang  = 'chi-tiet';
        require __DIR__ . '/inc/header.php';
        ?>
        <main class="trang-loi-404" style="padding: 60px 20px; text-align: center;">
            <h1 style="font-size: 48px; color: #e74c3c; margin-bottom: 10px;">404</h1>
            <h2>Không tìm thấy món ăn</h2>
            <p style="color: #666; margin-bottom: 20px;">Món ăn bạn đang tìm kiếm không tồn tại hoặc đã bị xóa.</p>
            <a href="danh-sach.php" class="nut" style="display: inline-block; padding: 10px 20px; background: #2E6230; color: #fff; text-decoration: none; border-radius: 8px;">Quay lại danh sách</a>
        </main>
        <?php
        require __DIR__ . '/inc/footer.php';
    }
    exit;
}
=======
// Đưa món vừa xem lên đầu danh sách
$daXemIds = array_values(
    array_unique(
        array_merge([$monAn->id], $daXemIds)
    )
);

// Chỉ lưu tối đa 5 món gần nhất
$daXemIds = array_slice($daXemIds, 0, 5);

// Ghi cookie trước khi xuất HTML
setcookie('da_xem', json_encode($daXemIds), [
    'expires'  => time() + (30 * 24 * 60 * 60),
    'path'     => '/',
    'httponly' => true,
    'samesite' => 'Lax',
]);
>>>>>>> e6e0155 (Update part A)

/**
 * Hàm phụ trợ tự động gán class icon nguyên liệu dựa theo tên tiếng Việt
 */
function layClassNguyenLieu($ten) {
    $tenLower = mb_strtolower($ten);
    if (str_contains($tenLower, 'rau thơm') || str_contains($tenLower, 'rau sống')) return 'nguyen-lieu-rau-thom';
    if (str_contains($tenLower, 'rau')) return 'nguyen-lieu-rau';
    if (str_contains($tenLower, 'thịt')) return 'nguyen-lieu-thit';
    if (str_contains($tenLower, 'tỏi')) return 'nguyen-lieu-toi';
    if (str_contains($tenLower, 'hành')) return 'nguyen-lieu-hanh';
    if (str_contains($tenLower, 'nước mắm')) return 'nguyen-lieu-nuoc-mam';
    if (str_contains($tenLower, 'tiêu')) return 'nguyen-lieu-tieu';
    if (str_contains($tenLower, 'cá')) return 'nguyen-lieu-ca';
    if (str_contains($tenLower, 'tôm')) return 'nguyen-lieu-tom';
    if (str_contains($tenLower, 'ớt')) return 'nguyen-lieu-ot';
    if (str_contains($tenLower, 'đường')) return 'nguyen-lieu-duong';
    if (str_contains($tenLower, 'dầu')) return 'nguyen-lieu-dau';
    if (str_contains($tenLower, 'sợi') || str_contains($tenLower, 'mì') || str_contains($tenLower, 'bún')) return 'nguyen-lieu-soi';
    return 'nguyen-lieu-gia-vi';
}

// 4. Nếu tìm thấy món ăn hợp lệ -> Hiển thị chi tiết theo đúng thiết kế mẫu
<<<<<<< HEAD
$tenMon  = $monAn['ten'] ?? 'Chi tiết món ăn';
=======
$tenMon = $monAn->ten ?: 'Chi tiết món ăn';
>>>>>>> e6e0155 (Update part A)
$tieuDe  = $tenMon . ' - Cook with Me'; 
$trang   = 'chi-tiet'; 

require __DIR__ . '/inc/header.php';
?>

<main class="chi-tiet-trang">
    <div class="chi-tiet-mon-an">
        <!-- Cột Trái / Hàng 1: Hình ảnh món ăn -->
        <div class="khu-vuc-hinh-anh">
            <figure class="hinh-anh-mon-an">
<<<<<<< HEAD
                <img src="<?= e($monAn['hinhAnh'] ?? 'images/default.jpg') ?>" alt="<?= e($tenMon) ?>">
=======
                <img src="<?= e($monAn->hinhAnh ?: 'images/default.jpg') ?>" alt="<?= e($tenMon) ?>">
>>>>>>> e6e0155 (Update part A)
            </figure>
        </div>

        <!-- Cột Phải / Hàng 1: Thông tin, đánh giá, mô tả & nút tương tác -->
        <div class="thong-tin-mon-an">
            <h1 class="tieu-de-mon-an"><?= e($tenMon) ?></h1>
            
            <div class="thong-tin-danh-gia">
<<<<<<< HEAD
                <span class="danh-gia">★★★★★</span>
                <span class="so-luot-danh-gia">
                    <?= e($monAn['diemDanhGia'] ?? '4.8') ?> (<?= e($monAn['soLuotDanhGia'] ?? '206') ?> đánh giá)
                </span>
            </div>
=======
    <span class="danh-gia">★★★★★</span>
    <span class="so-luot-danh-gia">
        <?= e((string)$monAn->danhGia) ?> (<?= e((string)$monAn->soLuotDanhGia) ?> đánh giá)
    </span>
</div>
>>>>>>> e6e0155 (Update part A)

            <!-- Thông tin cơ bản ngang kèm Icon chuẩn từ thư mục images/icons/ -->
            <div class="thong-tin-co-ban-ngang">
                <div class="item-meta">
                    <img src="images/icons/khau-phan.svg" alt="Khẩu phần" style="width: 18px; height: 18px; object-fit: contain;"> 
<<<<<<< HEAD
                    <span><?= e($monAn['khauPhan'] ?? '2') ?> người</span>
                </div>
                <div class="item-meta">
                    <img src="images/icons/thoi-gian.svg" alt="Thời gian" style="width: 18px; height: 18px; object-fit: contain;"> 
                    <span><?= e($monAn['thoiGian'] ?? '60') ?> phút</span>
                </div>
                <div class="item-meta">
                    <img src="images/icons/do-kho.svg" alt="Độ khó" style="width: 18px; height: 18px; object-fit: contain;"> 
                    <span><?= e($monAn['doKho'] ?? 'Trung bình') ?></span>
=======
                    <span><?= e($monAn->khauPhan) ?> người</span>
                </div>
                <div class="item-meta">
                    <img src="images/icons/thoi-gian.svg" alt="Thời gian" style="width: 18px; height: 18px; object-fit: contain;"> 
                    <span><?= e($monAn->thoiGian) ?> phút</span>
                </div>
                <div class="item-meta">
                    <img src="images/icons/do-kho.svg" alt="Độ khó" style="width: 18px; height: 18px; object-fit: contain;"> 
                    <span><?= e($monAn->doKho) ?></span>
>>>>>>> e6e0155 (Update part A)
                </div>
            </div>

            <div class="mo-ta-mon-an">
<<<<<<< HEAD
                <p><?= e($monAn['moTa'] ?? '') ?></p>
            </div>

            <div class="khu-vuc-hanh-dong">
                <!-- Thuộc tính data-id kết nối với trang-chi-tiet.js để lưu localStorage -->
                <button type="button" class="nut nut-yeu-thich" data-id="<?= e($monAn['id']) ?>">♡ Lưu công thức</button>
                <button type="button" class="nut nut-chia-se">Chia sẻ</button>
            </div>
=======
                <p><?= e($monAn->moTa) ?></p>
            </div>

            <div class="khu-vuc-hanh-dong">

    <form action="chi-tiet.php?id=<?= e($monAn->id) ?>" method="post">

        <?php
        $danhSachYeuThich = $yeuThichService->danhSachMonAn($khoMonAn);
        $daYeuThich = false;

        foreach ($danhSachYeuThich as $monYeuThich) {
            if ($monYeuThich->id === $monAn->id) {
                $daYeuThich = true;
                break;
            }
        }
        ?>

        <button
            type="submit"
            name="doi_yeu_thich"
            value="<?= e($monAn->id) ?>"
            class="nut nut-yeu-thich"
            aria-label="<?= $daYeuThich ? 'Bỏ khỏi yêu thích' : 'Thêm vào yêu thích' ?>"
        >
            <?= $daYeuThich ? '♥ Đã lưu' : '♡ Lưu công thức' ?>
        </button>

    </form>

    <button type="button" class="nut nut-chia-se">
        Chia sẻ
    </button>

</div>
>>>>>>> e6e0155 (Update part A)
        </div>

        <!-- Cột Trái / Hàng 2: Nguyên liệu & Nút bình luận -->
        <div class="cot-trai-chi-tiet">
            <section class="khu-vuc-nguyen-lieu">
                <h2>Nguyên liệu</h2>
                <ul class="danh-sach-nguyen-lieu">
<<<<<<< HEAD
                    <?php if (!empty($monAn['nguyenLieu']) && is_array($monAn['nguyenLieu'])): ?>
                        <?php foreach ($monAn['nguyenLieu'] as $nl): ?>
=======
                    <?php if (!empty($monAn->nguyenLieu) && is_array($monAn->nguyenLieu)): ?>
    <?php foreach ($monAn->nguyenLieu as $nl): ?>
>>>>>>> e6e0155 (Update part A)
                            <?php 
                                $tenNL = is_array($nl) ? ($nl['ten'] ?? '') : $nl;
                                $luongNL = is_array($nl) ? ($nl['soLuong'] ?? '') : '';
                                $classIcon = (is_array($nl) && isset($nl['class'])) ? $nl['class'] : layClassNguyenLieu($tenNL);
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

        <!-- Cột Phải / Hàng 2: Các bước chế biến & Video hướng dẫn -->
        <div class="cot-phai-chi-tiet">
            <section class="khu-vuc-cac-buoc">
                <h2>Các bước chế biến</h2>
                <ol class="cac-buoc-che-bien">
<<<<<<< HEAD
                    <?php if (!empty($monAn['cacBuoc']) && is_array($monAn['cacBuoc'])): ?>
                        <?php foreach ($monAn['cacBuoc'] as $buoc): ?>
                            <li><?= e($buoc) ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ol>
=======
    <?php if (!empty($monAn->cacBuoc) && is_array($monAn->cacBuoc)): ?>
        <?php foreach ($monAn->cacBuoc as $buoc): ?>
            <li><?= e($buoc) ?></li>
        <?php endforeach; ?>
    <?php endif; ?>
</ol>
>>>>>>> e6e0155 (Update part A)
            </section>

            <section class="video-huong-dan">
                <h2>Video hướng dẫn</h2>
                <div class="video-preview-card">
<<<<<<< HEAD
                    <img src="<?= e($monAn['hinhAnh'] ?? 'images/default.jpg') ?>" alt="Video hướng dẫn <?= e($tenMon) ?>">
=======
                    <img src="<?= e($monAn->hinhAnh ?: 'images/default.jpg') ?>" alt="Video hướng dẫn <?= e($tenMon) ?>">
>>>>>>> e6e0155 (Update part A)
                    <div class="nut-play-video">▶</div>
                    <div class="thoi-luong-video">3:42</div>
                </div>
            </section>
        </div>
    </div>
</main>

<script type="module" src="js/trang-chi-tiet.js"></script>

<?php
require __DIR__ . '/inc/footer.php';
?>
