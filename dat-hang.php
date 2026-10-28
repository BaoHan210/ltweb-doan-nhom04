<?php
/** Bài thực hành 6 - Chức năng 5: đặt hàng có transaction. */
declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/xac-thuc.php';
require_once __DIR__ . '/src/Data/KhoDonHang.php';

use App\Data\KhoMonAn;
use App\Data\KhoDonHang;
use App\Services\YeuThichService;

$nguoiDung = yeuCauDangNhap();
$khoMon = new KhoMonAn(db());
$yeuThich = new YeuThichService();
$gioHang = $yeuThich->layGioHang($khoMon);
$cacMon = $gioHang['mon'];
$tongTienThamKhao = $gioHang['tongTien'];
$loi = '';

if (!isset($_SESSION['csrf_dat_hang'])) {
    $_SESSION['csrf_dat_hang'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !hash_equals($_SESSION['csrf_dat_hang'], $token)) {
        http_response_code(403);
        exit('Phiên biểu mẫu không hợp lệ. Hãy tải lại trang.');
    }

    $slugs = [];
    foreach ($cacMon as $dong) {
        $slug = (string) $dong['monAn']->id;
        $slugs[$slug] = (int) $dong['soLuong'];
    }

    try {
        $idDon = (new KhoDonHang(db()))->datHang((int) $nguoiDung['id'], $slugs);
        // Làm mới mã CSRF: tải lại trang / F5 không gửi lại đơn.
        $_SESSION['csrf_dat_hang'] = bin2hex(random_bytes(32));
        // Danh sách yêu thích được giữ lại; không tự động xóa sở thích người dùng.
        gan_thong_bao('success', 'Đặt hàng thành công! Mã đơn #' . $idDon . '.');
        header('Location: don-hang.php?id=' . $idDon, true, 303);
        exit;
    } catch (DomainException $e) {
        $loi = $e->getMessage();
    } catch (Throwable $e) {
        error_log('Dat hang loi: ' . $e->getMessage());
        $loi = 'Không thể đặt hàng lúc này. Vui lòng thử lại.';
    }
}
$tieuDe = 'Xác nhận đặt hàng';
$trang = 'dat-hang';
require __DIR__ . '/inc/header.php';
?>
<main class="trang-yeu-thich container my-4">
  <h1 class="tieu-de-trang mb-4">Xác nhận đặt hàng</h1>
  <?= hien_thi_thong_bao() ?>
  <?php if ($loi !== ''): ?>
    <p role="alert" style="color:#b42318"><?= e($loi) ?></p>
  <?php endif; ?>
  <?php if (!$cacMon): ?>
    <p>Danh sách món đang trống.</p>
    <a class="nut" href="danh-sach.php">Khám phá món ăn</a>
  <?php else: ?>
    <div class="cho-cuon-ngang">
      <table class="bang-gio-hang">
        <thead><tr><th>Món ăn</th><th>Đơn giá tham khảo</th><th>Số lượng</th><th>Thành tiền</th></tr></thead>
        <tbody>
        <?php foreach ($cacMon as $dong): $mon = $dong['monAn']; ?>
          <tr>
            <td><?= e($mon->ten) ?></td>
            <td><?= vnd($dong['donGia']) ?></td>
            <td><?= (int) $dong['soLuong'] ?></td>
            <td><?= vnd($dong['thanhTien']) ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot><tr><th colspan="3">Tổng tiền tham khảo</th><td><strong><?= vnd($tongTienThamKhao) ?></strong></td></tr></tfoot>
      </table>
    </div>
    <p>Giá và tồn kho được kiểm tra lại từ MySQL tại thời điểm xác nhận. Nếu không đủ tồn kho, toàn bộ giao dịch được hủy.</p>
    <form action="dat-hang.php" method="post">
      <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_dat_hang']) ?>">
      <button type="submit" class="nut nut-chinh">Xác nhận đặt hàng</button>
      <a class="nut" href="yeu-thich.php">Quay lại</a>
    </form>
  <?php endif; ?>
</main>
<?php require __DIR__ . '/inc/footer.php'; ?>
