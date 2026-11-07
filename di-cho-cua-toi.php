<?php
/**
 * Tệp: di-cho-cua-toi.php
 * Mục đích: Lịch sử đi chợ của người dùng đăng nhập (chức năng 5).
 * ?id=N: chi tiết một lần, chỉ khi thuộc người dùng này, nếu không trả 404.
 */
declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/xac-thuc.php';
require_once __DIR__ . '/src/Data/KhoLanDiCho.php';

use App\Data\KhoLanDiCho;

$nguoiDung = yeuCauDangNhap();
$uid = (int) $nguoiDung['id'];
$kho = new KhoLanDiCho(db());

$coId = isset($_GET['id']);
$lan = null;
$dsLan = [];
$khongTim = false;

if ($coId) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $lan = $id === false ? null : $kho->chiTiet($id, $uid);
    $khongTim = $lan === null;
    if ($khongTim) {
        http_response_code(404);
    }
} else {
    $dsLan = $kho->lichSu($uid);
}

$nhanTrangThai = [
    'moi'       => 'Mới',
    'da_di_cho' => 'Đã đi chợ',
    'da_huy'    => 'Đã hủy',
];

$tieuDe = 'Lịch sử đi chợ';
$trang = 'di-cho-cua-toi';
require __DIR__ . '/inc/header.php';
?>
<main class="trang-yeu-thich container my-4">
  <h1 class="tieu-de-trang mb-4">Lịch sử đi chợ</h1>
  <?= hien_thi_thong_bao() ?>

  <?php if ($coId): ?>
    <?php if ($khongTim): ?>
      <p>Không tìm thấy lần đi chợ này hoặc bạn không có quyền xem.</p>
    <?php else: ?>
      <h2>Lần đi chợ #<?= (int) $lan['id'] ?></h2>
      <p>
        Ngày chốt: <?= e($lan['ngay_chot']) ?> ·
        Trạng thái: <?= e($nhanTrangThai[$lan['trang_thai']] ?? $lan['trang_thai']) ?>
      </p>
      <div class="cho-cuon-ngang">
        <table class="bang-gio-hang">
          <thead>
            <tr>
              <th>Món ăn</th>
              <th>Số suất</th>
              <th>Ngân sách tham khảo</th>
            </tr>
          </thead>
          <tbody>
          <?php $tong = 0; foreach ($lan['cac_mon'] as $dong): ?>
            <?php $tong += (int) $dong['so_suat'] * (int) $dong['ngan_sach_tham_khao']; ?>
            <tr>
              <td><a href="chi-tiet.php?id=<?= (int) $dong['mon_an_id'] ?>"><?= e($dong['ten_mon']) ?></a></td>
              <td><?= (int) $dong['so_suat'] ?></td>
              <td><?= vnd((int) $dong['ngan_sach_tham_khao'] * (int) $dong['so_suat']) ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="2">Tổng ngân sách tham khảo</th>
              <td><strong><?= vnd($tong) ?></strong></td>
            </tr>
          </tfoot>
        </table>
      </div>
    <?php endif; ?>
    <p><a href="di-cho-cua-toi.php">← Tất cả lần đi chợ</a></p>

  <?php elseif (!$dsLan): ?>
    <p>Bạn chưa chốt danh sách đi chợ nào.</p>
    <a class="nut" href="goi-y-mon-an.php">Lập danh sách đi chợ</a>

  <?php else: ?>
    <div class="cho-cuon-ngang">
      <table class="bang-gio-hang">
        <thead>
          <tr>
            <th>Mã</th>
            <th>Ngày chốt</th>
            <th>Số món</th>
            <th>Tổng số suất</th>
            <th>Ngân sách tham khảo</th>
            <th>Trạng thái</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($dsLan as $dong): ?>
          <tr>
            <td><a href="di-cho-cua-toi.php?id=<?= (int) $dong['id'] ?>">#<?= (int) $dong['id'] ?></a></td>
            <td><?= e($dong['ngay_chot']) ?></td>
            <td><?= (int) $dong['so_mon'] ?></td>
            <td><?= (int) $dong['tong_so_suat'] ?></td>
            <td><?= vnd((int) $dong['tong_ngan_sach']) ?></td>
            <td><?= e($nhanTrangThai[$dong['trang_thai']] ?? $dong['trang_thai']) ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</main>
<?php require __DIR__ . '/inc/footer.php'; ?>
