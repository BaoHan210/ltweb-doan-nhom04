<?php
/**
 * Tệp: yeu-thich.php
 * Danh sách món yêu thích có số lượng, thành tiền và tổng tiền.
 * Mọi thao tác là form POST nên hoạt động khi tắt JavaScript.
 */

declare(strict_types=1);


require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';

use App\Data\KhoMonAn;
use App\Services\YeuThichService;

$kho = new KhoMonAn(db());
$yeuThich = new YeuThichService();


// 1. XỬ LÝ POST: mọi kiểm tra đều thực hiện ở máy chủ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $hanhDong = $_POST['hanh_dong'] ?? '';
    $idMon    = trim((string) ($_POST['id_mon'] ?? ''));

    switch ($hanhDong) {

        case 'them':
            if ($kho->timTheoId($idMon) !== null) {
                $yeuThich->them($idMon);
                gan_thong_bao('success', 'Đã thêm món vào danh sách yêu thích.');
            }
            break;

        case 'cap_nhat':
            // FILTER_VALIDATE_INT trả về false nếu giá trị không phải số nguyên
            $soLuong = filter_var($_POST['so_luong'] ?? '', FILTER_VALIDATE_INT);

            if (
                $soLuong === false
                || $soLuong < YeuThichService::SO_LUONG_TOI_THIEU
                || $soLuong > YeuThichService::SO_LUONG_TOI_DA
            ) {
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

    // PRG: sau POST luôn chuyển hướng, F5 không gửi lại form
    chuyen_huong('yeu-thich.php');
}

// 2. CHUẨN BỊ DỮ LIỆU HIỂN THỊ
$gioHang   = $yeuThich->layGioHang($kho);
$cacMon    = $gioHang['mon'];
$tongTien  = $gioHang['tongTien'];
$tongSoPhan = $yeuThich->tongSoPhan();

$tieuDe = 'Món ăn yêu thích';
$trang  = 'yeu-thich';

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
                <thead>
                    <tr>
                        <th scope="col">Món ăn</th>
                        <th scope="col">Đơn giá</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Thành tiền</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>

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
                                <!-- Form cập nhật số lượng -->
                                <form method="post" action="yeu-thich.php">
                                    <input type="hidden" name="id_mon" value="<?= e($mon->id) ?>">
                                    <input
                                        type="number"
                                        name="so_luong"
                                        value="<?= (int) $dong['soLuong'] ?>"
                                        min="1"
                                        max="10"
                                        step="1"
                                        required
                                    >
                                    <button type="submit" name="hanh_dong" value="cap_nhat">Cập nhật</button>
                                </form>
                            </td>

                            <td><?= vnd($dong['thanhTien']) ?></td>

                            <td>
                                <!-- Form xóa một món -->
                                <form method="post" action="yeu-thich.php">
                                    <input type="hidden" name="id_mon" value="<?= e($mon->id) ?>">
                                    <button type="submit" name="hanh_dong" value="xoa">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

                <tfoot>
                    <tr>
                        <th scope="row" colspan="3">Tổng tiền (<?= $tongSoPhan ?> phần)</th>
                        <td colspan="2"><strong><?= vnd($tongTien) ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <form method="post" action="yeu-thich.php" class="hanh-dong-gio">
            <button type="submit" name="hanh_dong" value="xoa_het" class="nut nut-phu">
                Xóa tất cả yêu thích
            </button>
        </form>

    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>