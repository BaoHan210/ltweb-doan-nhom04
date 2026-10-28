<?php
declare(strict_types=1);
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/xac-thuc.php';
require_once __DIR__ . '/src/Data/KhoDonHang.php';

use App\Data\KhoDonHang;
$nguoiDung = yeuCauDangNhap();
$kho = new KhoDonHang(db());
$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
$don = null;
if ($id !== null && $id !== false && $id > 0) {
    $don = $kho->layChiTietCuaNguoiDung($id, (int) $nguoiDung['id']);
    if ($don === null) {
        http_response_code(404);
    }
}
$danhSach = $id ? [] : $kho->layCuaNguoiDung((int) $nguoiDung['id']);
$tieuDe = 'Đơn hàng của tôi';
$trang = 'don-hang';
require __DIR__ . '/inc/header.php';
?>
<main class="trang-yeu-thich container my-4">
<h1 class="tieu-de-trang mb-4">Đơn hàng của tôi</h1>
<?= hien_thi_thong_bao() ?>
<?php if ($id): ?>
    <?php if (!$don): ?>
        <p>Không tìm thấy đơn hàng hoặc bạn không có quyền xem đơn này.</p>
    <?php else: ?>
        <h2>Đơn #<?= (int) $don['id'] ?></h2>
        <p>Ngày đặt: <?= e($don['ngay_dat']) ?> · Trạng thái: <?= e($don['trang_thai']) ?></p>
        <div class="cho-cuon-ngang"><table class="bang-gio-hang">
          <thead><tr><th>Món ăn</th><th>Số lượng</th><th>Đơn giá lúc đặt</th><th>Thành tiền</th></tr></thead>
          <tbody><?php $tong = 0; foreach ($don['cac_mon'] as $dong): $tong += (int) $dong['thanh_tien']; ?>
          <tr>
            <td><a href="chi-tiet.php?id=<?= e($dong['slug']) ?>"><?= e($dong['ten']) ?></a></td>
            <td><?= (int) $dong['so_luong'] ?></td>
            <td><?= vnd((int) $dong['don_gia']) ?></td>
            <td><?= vnd((int) $dong['thanh_tien']) ?></td>
          </tr><?php endforeach; ?></tbody>
          <tfoot><tr><th colspan="3">Tổng tiền</th><td><?= vnd($tong) ?></td></tr></tfoot>
        </table></div>
    <?php endif; ?>
    <p><a href="don-hang.php">← Tất cả đơn hàng</a></p>
<?php elseif (!$danhSach): ?>
    <p>Bạn chưa có đơn hàng nào.</p>
<?php else: ?>
    <div class="cho-cuon-ngang"><table class="bang-gio-hang">
    <thead><tr><th>Mã đơn</th><th>Ngày đặt</th><th>Trạng thái</th><th>Số phần</th><th>Tổng tiền</th></tr></thead>
    <tbody><?php foreach ($danhSach as $don): ?>
    <tr>
        <td><a href="don-hang.php?id=<?= (int) $don['id'] ?>">#<?= (int) $don['id'] ?></a></td>
        <td><?= e($don['ngay_dat']) ?></td><td><?= e($don['trang_thai']) ?></td>
        <td><?= (int) $don['tong_so_phan'] ?></td><td><?= vnd((int) $don['tong_tien']) ?></td>
    </tr><?php endforeach; ?></tbody></table></div>
<?php endif; ?>
</main>
<?php require __DIR__ . '/inc/footer.php'; ?>
