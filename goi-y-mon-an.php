<?php
// 1. PHẦN XỬ LÝ LÝ THUYẾT / LOGIC (Không echo)
require __DIR__ . '/inc/config.php';

// -------------------------------------------------------------
// KIỂM TRA QUYỀN ĐĂNG NHẬP
// Nếu chưa đăng nhập -> Chuyển hướng sang trang dang-nhap.php
// -------------------------------------------------------------
if (empty($_SESSION['nguoi_dung']) && empty($_SESSION['user'])) {
    header('Location: dang-nhap.php?thong_bao=can_dang_nhap');
    exit;
}

use App\Data\KhoMonAn;
use App\Services\DanhSachDiChoService;

$kho = new KhoMonAn(__DIR__ . '/data/mon-an.json');
$danhSachDiChoService = new DanhSachDiChoService();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($_POST['xoa_danh_sach'])) {
        $danhSachDiChoService->xoaHet();

        header('Location: goi-y-mon-an.php');
        exit;
    }

    $idMonAn = trim((string)($_POST['them_danh_sach'] ?? ''));
    $monAn = $kho->timTheoId($idMonAn);

    if ($idMonAn !== '' && $monAn !== null) {
        $nguyenLieuNguoiDung = trim(
            (string)($_POST['ingredients'] ?? '')
        );

        $danhSachNguyenLieuNguoiDung = [];

        if ($nguyenLieuNguoiDung !== '') {
            $danhSachNguyenLieuNguoiDung = array_filter(
                array_map(
                    'trim',
                    explode(',', mb_strtolower($nguyenLieuNguoiDung, 'UTF-8'))
                )
            );
        }

        $nguyenLieuConThieu = [];

        foreach ($monAn->nguyenLieu as $item) {
            $tenNguyenLieu = trim((string)($item['ten'] ?? ''));

            if ($tenNguyenLieu === '') {
                continue;
            }

            $coNguyenLieu = false;

            foreach ($danhSachNguyenLieuNguoiDung as $nguyenLieuCo) {
                if (
                    mb_stripos(
                        $tenNguyenLieu,
                        $nguyenLieuCo,
                        0,
                        'UTF-8'
                    ) !== false
                ) {
                    $coNguyenLieu = true;
                    break;
                }
            }

            if (!$coNguyenLieu) {
                $nguyenLieuConThieu[] = $item;
            }
        }

        $danhSachDiChoService->them(
            $idMonAn,
            $nguyenLieuConThieu
        );
    }

    $thamSo = [
        'ingredients' => trim((string)($_POST['ingredients'] ?? '')),
        'budget' => trim((string)($_POST['budget'] ?? '')),
        'cooking_time' => trim((string)($_POST['cooking_time'] ?? '')),
        'servings' => trim((string)($_POST['servings'] ?? '')),
    ];

    $thamSo = array_filter(
        $thamSo,
        fn($giaTri) => $giaTri !== ''
    );

    $url = 'goi-y-mon-an.php';

    if (!empty($thamSo)) {
        $url .= '?' . http_build_query($thamSo);
    }

    header('Location: ' . $url);
    exit;
}

$danhSach = $kho->layTatCa();

$nguyenLieu = trim($_GET['ingredients'] ?? '');
$nganSach = trim($_GET['budget'] ?? '');
$thoiGian = trim($_GET['cooking_time'] ?? '');
$khauPhan = trim($_GET['servings'] ?? '');

$danhSachGoiY = [];

foreach ($danhSach as $monAn) {
    // Lọc theo nguyên liệu
    if ($nguyenLieu !== '') {
        $tuKhoaNguyenLieu = mb_strtolower($nguyenLieu, 'UTF-8');
        $coNguyenLieu = false;

        foreach ($monAn->nguyenLieu as $item) {
    $tenNguyenLieu = $item['ten'] ?? '';

    if (
        $tenNguyenLieu !== '' &&
        mb_stripos($tenNguyenLieu, $tuKhoaNguyenLieu, 0, 'UTF-8') !== false
    ) {
        $coNguyenLieu = true;
        break;
    }
}

        if (!$coNguyenLieu) {
            continue;
        }
    }

    // Lọc theo ngân sách
    if ($nganSach !== '' && (int)$monAn->nganSach > (int)$nganSach) {
        continue;
    }

    // Lọc theo thời gian
    if ($thoiGian !== '' && (int)$monAn->thoiGian > (int)$thoiGian) {
        continue;
    }

    // Lọc theo số người
    if ($khauPhan !== '' && (int)$monAn->khauPhan < (int)$khauPhan) {
        continue;
    }

    $danhSachGoiY[] = $monAn;
}

$danhSachDiCho = $danhSachDiChoService->danhSachMonAn($kho);

// Thiết lập thông số header
$tieuDe   = 'Gợi ý món ăn'; 
$trang    = 'goi-y-mon-an'; 
$customJS = 'js/trang-goi-y-mon-an.js'; 

// Nhúng Header (đã bao gồm Nav)
require __DIR__ . '/inc/header.php';
?>

  <!-- NỘI DUNG CHÍNH -->
  <main class="goi-y-trang">

    <!-- BANNER TỦ LẠNH CỦA TÔI -->
    <section class="banner-tu-lanh">
      <div class="hinh-anh-banner hinh-anh-tu-lanh">
        <img src="images/icons/fridge.svg" alt="Tủ lạnh" class="anh-tu-lanh">
      </div>

      <div class="noi-dung-banner">
        <p class="nhan-tu-lanh">Tủ lạnh của tôi</p>
        <h1 class="tieu-de-banner">Hôm nay ăn gì?</h1>
        <p class="mo-ta-banner">Nhập nguyên liệu bạn có, chúng tôi sẽ gợi ý món ăn phù hợp!</p>
      </div>
      
      <div class="hinh-anh-banner hinh-anh-ro-rau">
        <img src="images/basket-vegetables.svg" alt="Rổ rau củ quả" class="anh-ro-rau-cu">
      </div>
    </section>

    <!-- FORM BỘ LỌC TÌM KIẾM -->
<div class="khung-bo-loc-goi-y">
      <form class="form-goi-y-moi" id="form-goi-y" action="goi-y-mon-an.php" method="get">
        
        <div class="khong-gian-loc">
          
          <!-- Ô 1: Nguyên liệu -->
          <div class="o-nhap-loc o-nguyen-lieu">
            <label for="ingredients">Nguyên liệu (có thể chọn nhiều)</label>
            <input type="text" id="ingredients" name="ingredients" placeholder="Nhập nguyên liệu...">
            
            <div class="danh-sach-tags">
              <span class="tag-item">Thịt heo <button type="button" class="nut-xoa-tag">&times;</button></span>
              <span class="tag-item">Trứng <button type="button" class="nut-xoa-tag">&times;</button></span>
              <span class="tag-item">Cà chua <button type="button" class="nut-xoa-tag">&times;</button></span>
              <span class="tag-item">Rau cải <button type="button" class="nut-xoa-tag">&times;</button></span>
            </div>
          </div>

          <!-- Ô 2: Ngân sách -->
          <div class="o-nhap-loc">
            <label for="budget">Ngân sách</label>
            <select id="budget" name="budget">
              <option value="">Chọn ngân sách</option>
              <option value="50000">Dưới 50.000đ</option>
              <option value="100000" selected>50.000đ - 100.000đ</option>
              <option value="200000">100.000đ - 200.000đ</option>
            </select>
          </div>

          <!-- Ô 3: Thời gian nấu -->
          <div class="o-nhap-loc">
            <label for="cooking-time">Thời gian nấu</label>
            <select id="cooking-time" name="cooking_time">
              <option value="">Chọn thời gian</option>
              <option value="15">Dưới 15 phút</option>
              <option value="30" selected>Dưới 30 phút</option>
              <option value="60">Dưới 60 phút</option>
            </select>
          </div>

          <!-- Ô 4: Số người ăn -->
          <div class="o-nhap-loc">
            <label for="servings">Số người ăn</label>
            <select id="servings" name="servings">
              <option value="">Chọn số người</option>
              <option value="1">1 người</option>
              <option value="2" selected>2 - 3 người</option>
              <option value="4">4 người trở lên</option>
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

      <?php if (!empty($danhSachGoiY)): ?>

    <p class="thong-bao-goi-y">
        Tìm thấy <?= count($danhSachGoiY) ?> món ăn phù hợp.
    </p>

    <div class="danh-sach-mon-goi-y" id="danh-sach-mon-goi-y">

        <?php foreach ($danhSachGoiY as $monAn): ?>

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
        <?= (int)$monAn->thoiGian ?> phút ·
        <?= number_format((int)$monAn->nganSach, 0, ',', '.') ?> VNĐ ·
        <?= (int)$monAn->khauPhan ?> người
    </p>

    <div class="hanh-dong-the-goi-y">

    <a
        href="chi-tiet.php?id=<?= e($monAn->id) ?>"
        class="nut"
    >
        Xem chi tiết
    </a>

    <form action="goi-y-mon-an.php" method="post">
    <input
        type="hidden"
        name="them_danh_sach"
        value="<?= e($monAn->id) ?>"
    >

    <input
    type="hidden"
    name="ingredients"
    value="<?= e($nguyenLieu) ?>"
>

<input
    type="hidden"
    name="budget"
    value="<?= e($nganSach) ?>"
>

<input
    type="hidden"
    name="cooking_time"
    value="<?= e($thoiGian) ?>"
>

<input
    type="hidden"
    name="servings"
    value="<?= e($khauPhan) ?>"
>

    <button
        type="submit"
        class="nut"
    >
        Thêm vào danh sách đi chợ
    </button>
</form>

</div>

</article>

<?php endforeach; ?>

</div>

<?php elseif (
    $nguyenLieu !== '' ||
    $nganSach !== '' ||
    $thoiGian !== '' ||
    $khauPhan !== ''
): ?>

    <p class="thong-bao-goi-y">
        Không tìm thấy món ăn phù hợp với các tiêu chí đã chọn.
    </p>

<?php else: ?>

    <p class="thong-bao-goi-y">
        Nhập thông tin ở trên để nhận gợi ý món ăn phù hợp.
    </p>

<?php endif; ?>
    </section>

    <!-- DANH SÁCH ĐI CHỢ -->
    <?php if (!empty($danhSachDiCho)): ?>

<section
    class="danh-sach-di-cho"
    id="khu-vuc-danh-sach-di-cho"
    aria-labelledby="tieu-de-danh-sach-di-cho"
>
    <h2 id="tieu-de-danh-sach-di-cho">
        Danh sách đi chợ
    </h2>

    <p>
        Các nguyên liệu dưới đây là những nguyên liệu còn thiếu để chuẩn bị món ăn đã chọn.
    </p>

    <form action="goi-y-mon-an.php" method="post">
    <button
        class="nut nut-phu"
        type="submit"
        name="xoa_danh_sach"
        value="1"
    >
        Xóa danh sách
    </button>
</form>

    <?php foreach ($danhSachDiCho as $item): ?>

        <?php
        $monAnDiCho = $item['monAn'];
        $nguyenLieuConThieu = $item['nguyenLieuConThieu'];
        ?>

        <article class="the-danh-sach">
            <h3>
                <?= e($monAnDiCho->ten) ?>
            </h3>

            <?php if (!empty($nguyenLieuConThieu)): ?>

                <ul>
                    <?php foreach ($nguyenLieuConThieu as $nguyenLieuItem): ?>

                        <li>
                            <?= e($nguyenLieuItem['ten'] ?? '') ?>

                            <?php if (!empty($nguyenLieuItem['soLuong'])): ?>
                                -
                                <?= e($nguyenLieuItem['soLuong']) ?>
                            <?php endif; ?>

                        </li>

                    <?php endforeach; ?>
                </ul>

            <?php else: ?>

                <p>
                    Không còn nguyên liệu nào cần mua.
                </p>

            <?php endif; ?>
        </article>

    <?php endforeach; ?>

</section>

<?php endif; ?>

  </main>

<?php
require __DIR__ . '/inc/footer.php';
?>