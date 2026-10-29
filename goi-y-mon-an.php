<?php

/**
 * Tệp: goi-y-mon-an.php
 * Mục đích: Gợi ý món theo nguyên liệu và danh sách đi chợ trong session
 * Dùng bởi: ./dang-nhap.php, ./goi-y-mon-an.php, ./index.php, ./src/Data/KhoMonAn.php
 */

declare(strict_types=1);

// 1. PHẦN XỬ LÝ LÝ THUYẾT / LOGIC (Không echo)
require __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/xac-thuc.php';
$nguoiDung = yeuCauDangNhap();
if (empty($_SESSION['csrf_di_cho'])) { $_SESSION['csrf_di_cho'] = bin2hex(random_bytes(32)); }

use App\Data\KhoMonAn;
use App\Services\DanhSachDiChoService;

/**
 * Dựng URL trở về trang gợi ý, giữ nguyên bộ lọc người dùng đã chọn.
 * Lấy từ $_POST vì các form trong danh sách đi chợ đều gửi kèm bộ lọc.
 */
function duongDanGoiY(): string
{
    $thamSo = array_filter([
        'ingredients'  => trim((string) ($_POST['ingredients'] ?? '')),
        'budget'       => trim((string) ($_POST['budget'] ?? '')),
        'cooking_time' => trim((string) ($_POST['cooking_time'] ?? '')),
        'servings'     => trim((string) ($_POST['servings'] ?? '')),
    ], fn($giaTri) => $giaTri !== '');

    return 'goi-y-mon-an.php' . ($thamSo ? '?' . http_build_query($thamSo) : '');
}

$kho = new KhoMonAn(db());
$danhSachDiChoService = new DanhSachDiChoService(db(), (int)$nguoiDung['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? null;
    if (!is_string($csrf) || !hash_equals($_SESSION['csrf_di_cho'], $csrf)) {
        http_response_code(403); exit('CSRF không hợp lệ. Vui lòng tải lại trang.');
    }
    try {
        if (isset($_POST['xoa_danh_sach'])) {
            $danhSachDiChoService->xoaHet();
            gan_thong_bao('success', 'Đã xóa toàn bộ danh sách đi chợ.');
        } else {
            $hanhDong = $_POST['hanh_dong'] ?? '';
            $idMon = $_POST['id_mon'] ?? '';
            if (!is_string($idMon)) { $idMon = ''; }
            $idMon = trim($idMon);
            if ($hanhDong === 'xoa_di_cho') {
                $danhSachDiChoService->xoa($idMon);
                gan_thong_bao('success', 'Đã xóa món khỏi danh sách đi chợ.');
            } elseif ($hanhDong === 'cap_nhat_di_cho') {
                $soSuat = filter_var($_POST['so_luong'] ?? '', FILTER_VALIDATE_INT);
                if ($soSuat === false || !$danhSachDiChoService->capNhatSoLuong($idMon, $soSuat)) {
                    gan_thong_bao('error', 'Món không có trong danh sách hoặc số suất không hợp lệ (1–10).');
                } else { gan_thong_bao('success', 'Đã cập nhật số suất.'); }
            } else {
                $them = $_POST['them_danh_sach'] ?? '';
                if (!is_string($them)) { $them = ''; }
                $danhSachDiChoService->them(trim($them));
                gan_thong_bao('success', 'Đã thêm món vào danh sách đi chợ.');
            }
        }
    } catch (\DomainException $e) {
        gan_thong_bao('error', $e->getMessage());
    } catch (\Throwable $e) {
        error_log('Loi danh sach di cho: ' . $e->getMessage());
        gan_thong_bao('error', 'Không thể cập nhật danh sách đi chợ.');
    }
    chuyen_huong(duongDanGoiY());
    exit;
}

$danhSach = $kho->layTatCa();

$nguyenLieu = trim($_GET['ingredients'] ?? '');
$nganSach   = trim($_GET['budget'] ?? '');
$thoiGian   = trim($_GET['cooking_time'] ?? '');
$khauPhan   = trim($_GET['servings'] ?? '');

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
    if ($nganSach !== '' && (int) $monAn->nganSach > (int) $nganSach) {
        continue;
    }

    // Lọc theo thời gian
    if ($thoiGian !== '' && (int) $monAn->thoiGian > (int) $thoiGian) {
        continue;
    }

    // Lọc theo số người
    if ($khauPhan !== '' && (int) $monAn->khauPhan < (int) $khauPhan) {
        continue;
    }

    $danhSachGoiY[] = $monAn;
}

$danhSachDiCho = $danhSachDiChoService->layDanhSach($kho);

// Thiết lập thông số header
$tieuDe = 'Gợi ý món ăn';
$trang  = 'goi-y-mon-an';

// Nhúng Header (đã bao gồm Nav)
require __DIR__ . '/inc/header.php';
?>

  <!-- NỘI DUNG CHÍNH -->
  <main class="goi-y-trang">

    <?= hien_thi_thong_bao() ?>

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
            <input type="text" id="ingredients" name="ingredients"
                   value="<?= e($nguyenLieu) ?>" placeholder="Nhập nguyên liệu...">

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
              <option value="50000"  <?= $nganSach === '50000' ? 'selected' : '' ?>>Dưới 50.000đ</option>
              <option value="100000" <?= $nganSach === '100000' ? 'selected' : '' ?>>50.000đ - 100.000đ</option>
              <option value="200000" <?= $nganSach === '200000' ? 'selected' : '' ?>>100.000đ - 200.000đ</option>
            </select>
          </div>

          <!-- Ô 3: Thời gian nấu -->
          <div class="o-nhap-loc">
            <label for="cooking-time">Thời gian nấu</label>
            <select id="cooking-time" name="cooking_time">
              <option value="">Chọn thời gian</option>
              <option value="15" <?= $thoiGian === '15' ? 'selected' : '' ?>>Dưới 15 phút</option>
              <option value="30" <?= $thoiGian === '30' ? 'selected' : '' ?>>Dưới 30 phút</option>
              <option value="60" <?= $thoiGian === '60' ? 'selected' : '' ?>>Dưới 60 phút</option>
            </select>
          </div>

          <!-- Ô 4: Số người ăn -->
          <div class="o-nhap-loc">
            <label for="servings">Số người ăn</label>
            <select id="servings" name="servings">
              <option value="">Chọn số người</option>
              <option value="1" <?= $khauPhan === '1' ? 'selected' : '' ?>>1 người</option>
              <option value="2" <?= $khauPhan === '2' ? 'selected' : '' ?>>2 - 3 người</option>
              <option value="4" <?= $khauPhan === '4' ? 'selected' : '' ?>>4 người trở lên</option>
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
                <?= (int) $monAn->thoiGian ?> phút ·
                <?= number_format((int) $monAn->nganSach, 0, ',', '.') ?> VNĐ ·
                <?= (int) $monAn->khauPhan ?> người
              </p>

              <div class="hanh-dong-the-goi-y">

                <a href="chi-tiet.php?id=<?= e($monAn->id) ?>" class="nut">
                  Xem chi tiết
                </a>

                <form action="goi-y-mon-an.php" method="post">
              <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_di_cho']) ?>">
                  <input type="hidden" name="them_danh_sach" value="<?= e($monAn->id) ?>">

                  <?php foreach ([
                      'ingredients'  => $nguyenLieu,
                      'budget'       => $nganSach,
                      'cooking_time' => $thoiGian,
                      'servings'     => $khauPhan,
                  ] as $ten => $giaTri): ?>
                    <input type="hidden" name="<?= $ten ?>" value="<?= e($giaTri) ?>">
                  <?php endforeach; ?>

                  <button type="submit" class="nut">
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
    <?php $duTinh = 0; foreach ($danhSachDiCho as $item) { $duTinh += $item['monAn']->nganSach * $item['soLuong']; } ?>
    <?php if (!empty($danhSachDiCho)): ?>
      <section class="danh-sach-di-cho" aria-labelledby="tieu-de-danh-sach-di-cho">
        <h2 id="tieu-de-danh-sach-di-cho">Danh sách đi chợ</h2>
        <p>Mỗi món kèm số suất cần nấu. Nguyên liệu của món được liệt kê bên dưới.</p>
        <p><strong>Ngân sách tham khảo theo món:</strong> <?= number_format($duTinh, 0, ',', '.') ?> VNĐ (không phải báo giá từng nguyên liệu).</p>

        <?php foreach ($danhSachDiCho as $dong): ?>
          <?php $mon = $dong['monAn']; ?>

          <article class="the-danh-sach">
            <h3><?= e($mon->ten) ?></h3>

            <form method="post" action="goi-y-mon-an.php">
              <input type="hidden" name="id_mon" value="<?= e($mon->id) ?>">

              <?php foreach ([
                  'ingredients'  => $nguyenLieu,
                  'budget'       => $nganSach,
                  'cooking_time' => $thoiGian,
                  'servings'     => $khauPhan,
              ] as $ten => $giaTri): ?>
                <input type="hidden" name="<?= $ten ?>" value="<?= e($giaTri) ?>">
              <?php endforeach; ?>

              <label for="sl-<?= e($mon->id) ?>">Số suất:</label>
              <input
                type="number"
                id="sl-<?= e($mon->id) ?>"
                name="so_luong"
                value="<?= (int) $dong['soLuong'] ?>"
                min="1"
                max="10"
                required
              >

              <button type="submit" name="hanh_dong" value="cap_nhat_di_cho">Cập nhật</button>
              <button type="submit" name="hanh_dong" value="xoa_di_cho">Xóa</button>
            </form>

            <ul>
              <?php foreach ($mon->nguyenLieu as $nguyenLieuItem): ?>
                <li><?= e($nguyenLieuItem['ten'] ?? '') ?></li>
              <?php endforeach; ?>
            </ul>
          </article>
        <?php endforeach; ?>

        <form method="post" action="goi-y-mon-an.php">
          <?php foreach ([
              'ingredients'  => $nguyenLieu,
              'budget'       => $nganSach,
              'cooking_time' => $thoiGian,
              'servings'     => $khauPhan,
          ] as $ten => $giaTri): ?>
            <input type="hidden" name="<?= $ten ?>" value="<?= e($giaTri) ?>">
          <?php endforeach; ?>

          <button type="submit" name="xoa_danh_sach" value="1" class="nut nut-phu">
            Xóa toàn bộ danh sách
          </button>
        </form>
      </section>
    <?php endif; ?>

  </main>

<?php
require __DIR__ . '/inc/footer.php';
?>
