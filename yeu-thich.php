<?php
/** Cook with me - danh sach yeu thich va loi vao dat hang. */
declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';

use App\Data\KhoMonAn;
use App\Services\YeuThichService;

$kho = new KhoMonAn(db());
$yeuThich = new YeuThichService();

if (empty($_SESSION['csrf_yeu_thich'])) {
    $_SESSION['csrf_yeu_thich'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = $_POST['csrf_token'] ?? null;
    if (!is_string($csrf) || !hash_equals($_SESSION['csrf_yeu_thich'], $csrf)) {
        http_response_code(403);
        exit('Mã CSRF không hợp lệ. Vui lòng tải lại trang.');
    }
    $hanhDong = is_string($_POST['hanh_dong'] ?? null) ? $_POST['hanh_dong'] : '';
    $idMon = is_string($_POST['id_mon'] ?? null) ? trim($_POST['id_mon']) : '';

    switch ($hanhDong) {
        case 'them':
            if ($kho->timTheoId($idMon) !== null) {
                $yeuThich->them($idMon);
                gan_thong_bao('success', 'Đã thêm món vào danh sách yêu thích.');
            }
            break;
        case 'cap_nhat':
            $soLuong = filter_var($_POST['so_luong'] ?? '', FILTER_VALIDATE_INT);
            if ($soLuong === false || $soLuong < YeuThichService::SO_LUONG_TOI_THIEU || $soLuong > YeuThichService::SO_LUONG_TOI_DA) {
                gan_thong_bao('error', 'Số lượng phải là số nguyên từ 1 đến 10.');
            } elseif ($yeuThich->capNhatSoLuong($idMon, $soLuong)) {
                gan_thong_bao('success', 'Đã cập nhật số lượng.');
            } else {
                gan_thong_bao('error', 'Món này không có trong danh sách.');
            }
            break;
        case 'xoa':
            $yeuThich->xoa($idMon);
            gan_thong_bao('success', 'Đã xóa món khỏi danh sách.');
            break;
        case 'xoa_het':
            $yeuThich->xoaHet();
            gan_thong_bao('success', 'Đã xóa toàn bộ danh sách.');
            break;
    }
    chuyen_huong('yeu-thich.php');
    exit;
}

$gioHang = $yeuThich->layGioHang($kho);
$cacMon = $gioHang['mon'];
$tongTien = $gioHang['tongTien'];
$tongSoPhan = $yeuThich->tongSoPhan();
$tieuDe = 'Món ăn yêu thích';
$trang = 'yeu-thich';
require_once __DIR__ . '/inc/header.php';
?>
<main class="trang-yeu-thich container my-4">
    <h1 class="tieu-de-trang mb-4">Món ăn yêu thích của bạn</h1>
    <?= hien_thi_thong_bao() ?>
    <?php if (empty($cacMon)): ?>
        <div class="thong-bao-trong">
            <p>Bạn chưa thêm món ăn nào vào danh sách yêu thích!</p>
            <a href="danh-sach.php" class="nut">Khám phá món ăn ngay</a>
        </div>
    <?php else: ?>
        <div class="cho-cuon-ngang">
            <table class="bang-gio-hang">
                <thead><tr>
                    <th scope="col">Món ăn</th><th scope="col">Đơn giá</th>
                    <th scope="col">Số lượng</th><th scope="col">Thành tiền</th>
                    <th scope="col">Thao tác</th>
                </tr></thead>
                <tbody>
                    <?php foreach ($cacMon as $dong): ?>
                        <?php $mon = $dong['monAn']; ?>
                        <tr>
                            <td>
                                <img src="<?= e($mon->hinhAnh) ?>" alt="<?= e($mon->ten) ?>" width="60" height="45">
                                <a href="chi-tiet.php?id=<?= e($mon->id) ?>"><?= e($mon->ten) ?></a>
                            </td>
                            <td><?= vnd($dong['donGia']) ?></td>
                            <td>
                                <form method="post" action="yeu-thich.php">
                                    <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_yeu_thich']) ?>">
                                    <input type="hidden" name="id_mon" value="<?= e($mon->id) ?>">
                                    <input type="number" name="so_luong" value="<?= (int) $dong['soLuong'] ?>" min="1" max="10" step="1" required>
                                    <button type="submit" name="hanh_dong" value="cap_nhat">Cập nhật</button>
                                </form>
                            </td>
                            <td><?= vnd($dong['thanhTien']) ?></td>
                            <td><form method="post" action="yeu-thich.php">
                                    <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_yeu_thich']) ?>">
                                <input type="hidden" name="id_mon" value="<?= e($mon->id) ?>">
                                <button type="submit" name="hanh_dong" value="xoa">Xóa</button>
                            </form></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot><tr>
                    <th scope="row" colspan="3">Tổng tiền (<?= (int) $tongSoPhan ?> phần)</th>
                    <td colspan="2"><strong><?= vnd($tongTien) ?></strong></td>
                </tr></tfoot>
            </table>
        </div>
        <div class="hanh-dong-gio">
            <form method="post" action="yeu-thich.php">
                                    <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_yeu_thich']) ?>">
                <button type="submit" name="hanh_dong" value="xoa_het" class="nut nut-phu">Xóa tất cả yêu thích</button>
            </form>
            <a href="goi-y-mon-an.php" class="nut nut-chinh">Lập danh sách đi chợ</a>
        </div>
    <?php endif; ?>
<script src="js/gio-hang.js" defer></script>
</main>
<?php require_once __DIR__ . '/inc/footer.php'; ?>
