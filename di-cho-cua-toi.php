<?php
/**
 * Tệp: di-cho-cua-toi.php
 * Mục đích: Quản lý danh sách đi chợ hiện tại và lịch sử đi chợ.
 * ?tab=hien-tai: Danh sách hiện tại.
 * ?tab=lich-su: Lịch sử các lần đi chợ.
 * ?tab=lich-su&id=N: Chi tiết một lần đi chợ.
 */
declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/xac-thuc.php';
require_once __DIR__ . '/src/Data/KhoMonAn.php';
require_once __DIR__ . '/src/Data/KhoLanDiCho.php';
require_once __DIR__ . '/src/Services/DanhSachDiChoService.php';

use App\Data\KhoMonAn;
use App\Data\KhoLanDiCho;
use App\Services\DanhSachDiChoService;

// ======================================
// 1. KHỞI TẠO
// ======================================

$nguoiDung = yeuCauDangNhap();
$uid = (int) $nguoiDung['id'];

$tab = $_GET['tab'] ?? 'hien-tai';
if (!is_string($tab) || !in_array($tab, ['hien-tai', 'lich-su'], true)) {
    $tab = 'hien-tai';
}

$coId = isset($_GET['id']);

// Có ID thì luôn hiển thị chi tiết lịch sử.
if ($coId) {
    $tab = 'lich-su';
}

$khoMonAn = new KhoMonAn(db());
$khoLanDiCho = new KhoLanDiCho(db());

$danhSachDiChoService = new DanhSachDiChoService(
    db(),
    $uid
);

// ======================================
// 2. XỬ LÝ POST: DANH SÁCH HIỆN TẠI
// ======================================

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
        try {
        $hanhDong = $_POST['hanh_dong'] ?? '';

        switch ($hanhDong) {
            case 'cap_nhat_di_cho':
                $slug = $_POST['id_mon'] ?? '';

                $soLuong = filter_var(
                    $_POST['so_luong'] ?? null,
                    FILTER_VALIDATE_INT
                );

                if (
                    !is_string($slug)
                    || $soLuong === false
                    || $soLuong === null
                ) {
                    throw new DomainException('Thông tin cập nhật không hợp lệ.');
                }

                if (!$danhSachDiChoService->capNhatSoLuong($slug, $soLuong)) {
                    throw new DomainException(
                        'Không tìm thấy món ăn trong danh sách.'
                    );
                }

                gan_thong_bao('success', 'Đã cập nhật số suất món ăn.');
                break;

            case 'xoa_di_cho':
                $slug = $_POST['id_mon'] ?? '';

                if (!is_string($slug)) {
                    throw new DomainException('Mã món ăn không hợp lệ.');
                }

                $danhSachDiChoService->xoa($slug);

                gan_thong_bao('success', 'Đã xóa món ăn khỏi danh sách.');
                break;

            case 'xoa_danh_sach':
                $danhSachDiChoService->xoaHet();

                gan_thong_bao('success', 'Đã xóa toàn bộ danh sách đi chợ.');
                break;

            default:
                throw new DomainException('Thao tác không hợp lệ.');
        }

    } catch (DomainException $e) {
        gan_thong_bao('error', $e->getMessage());

    } catch (Throwable $e) {
        error_log('Loi danh sach di cho: ' . $e->getMessage());

        gan_thong_bao(
            'error',
            'Không thể thực hiện thao tác. Vui lòng thử lại.'
        );
    }

    header('Location: di-cho-cua-toi.php?tab=hien-tai', true, 303);
    exit;
}

// ======================================
// 3. LẤY DỮ LIỆU THEO TAB
// ======================================

$danhSachDiCho = [];
$tongSoMon = 0;
$tongSoSuat = 0;
$tongNganSach = 0;

$dsLan = [];
$lan = null;
$khongTim = false;

if ($tab === 'hien-tai') {
    $danhSachDiCho = $danhSachDiChoService->layDanhSach($khoMonAn);

    $tongSoMon = count($danhSachDiCho);

    foreach ($danhSachDiCho as $dong) {
        $soLuong = (int) $dong['soLuong'];

        $tongSoSuat += $soLuong;
        $tongNganSach += (int) $dong['monAn']->nganSach * $soLuong;
    }

} elseif ($coId) {
    $id = filter_var(
        $_GET['id'],
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]
    );

    $lan = $id === false ? null : $khoLanDiCho->chiTiet($id, $uid);
    $khongTim = $lan === null;

    if ($khongTim) {
        http_response_code(404);
    }

} else {
    $dsLan = $khoLanDiCho->lichSu($uid);
}

// ======================================
// 4. TRẠNG THÁI VÀ HEADER
// ======================================

$nhanTrangThai = [
    'moi'       => 'Mới',
    'da_di_cho' => 'Đã đi chợ',
    'da_huy'    => 'Đã hủy',
];

$tieuDe = 'Đi chợ của tôi';
$trang = 'di-cho-cua-toi';
$cssRieng = 'css/10-di-cho-cua-toi.css';

require __DIR__ . '/inc/header.php';
?>

<main class="trang-yeu-thich trang-danh-sach-di-cho container my-4">

    <h1 class="tieu-de-trang mb-4">Đi chợ của tôi</h1>

    <?= hien_thi_thong_bao() ?>

    <!-- HAI TAB CHÍNH -->
    <div class="d-flex flex-wrap gap-3 mb-4">
        <a
            href="di-cho-cua-toi.php?tab=hien-tai"
            class="nut <?= $tab === 'hien-tai' ? '' : 'nut-phu' ?>"
            <?= $tab === 'hien-tai' ? 'aria-current="page"' : '' ?>
        >
            Danh sách hiện tại
        </a>

        <a
            href="di-cho-cua-toi.php?tab=lich-su"
            class="nut <?= $tab === 'lich-su' ? '' : 'nut-phu' ?>"
            <?= $tab === 'lich-su' ? 'aria-current="page"' : '' ?>
        >
            Lịch sử đi chợ
        </a>
    </div>

    <?php if ($tab === 'hien-tai'): ?>

        <!-- ======================================
             TAB 1: DANH SÁCH HIỆN TẠI
        ======================================= -->

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

            <div>
                <h2>Danh sách hiện tại</h2>
                <p class="mb-0">
                    Quản lý những món ăn đã chọn trước khi chốt danh sách đi chợ.
                </p>
            </div>

            <a class="nut" href="goi-y-mon-an.php">
                ← Tiếp tục chọn món
            </a>

        </div>

        <?php if (!$danhSachDiCho): ?>

            <section class="khung-rong text-center py-5">

                <h2>Danh sách đi chợ đang trống</h2>

                <p>
                    Bạn chưa thêm món ăn nào vào danh sách.
                    Hãy khám phá và chọn những món muốn nấu.
                </p>

                <a class="nut" href="goi-y-mon-an.php">
                    Khám phá món ăn
                </a>

            </section>

        <?php else: ?>

            <!-- THÔNG TIN TỔNG QUAN -->
            <div class="thong-tin-danh-sach mb-4">

                <p class="mb-1">
                    Số món ăn:
                    <strong><?= $tongSoMon ?></strong>
                </p>

                <p class="mb-1">
                    Tổng số suất:
                    <strong><?= $tongSoSuat ?></strong>
                </p>

                <p class="mb-0">
                    Ngân sách tham khảo:
                    <strong><?= vnd($tongNganSach) ?></strong>
                </p>

                <small>
                    Ngân sách được ước tính theo mức tham khảo của các món ăn,
                    không phải báo giá chi tiết từng nguyên liệu.
                </small>

            </div>

            <!-- BẢNG DANH SÁCH -->
            <div class="cho-cuon-ngang">

                <table class="bang-gio-hang">

                    <thead>
                        <tr>
                            <th>Món ăn</th>
                            <th>Số suất</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($danhSachDiCho as $dong): ?>

                        <?php
                        $mon = $dong['monAn'];
                        $soLuong = (int) $dong['soLuong'];
                        ?>

                        <tr>

                            <td>
                                <a href="chi-tiet.php?id=<?= e($mon->id) ?>">
                                    <?= e($mon->ten) ?>
                                </a>
                            </td>

                            <td>
                                <form
                                    method="POST"
                                    action="di-cho-cua-toi.php?tab=hien-tai"
                                    class="d-flex align-items-center gap-2"
                                >

                                    <?= csrfField() ?>
                                    <input
                                        type="hidden"
                                        name="hanh_dong"
                                        value="cap_nhat_di_cho"
                                    >

                                    <input
                                        type="hidden"
                                        name="id_mon"
                                        value="<?= e($mon->id) ?>"
                                    >

                                    <input
                                        type="number"
                                        name="so_luong"
                                        value="<?= $soLuong ?>"
                                        min="1"
                                        max="<?= DanhSachDiChoService::SO_SUAT_TOI_DA ?>"
                                        class="form-control o-nhap-so-luong-di-cho"
                                        required
                                    >

                                    <button type="submit" class="nut">
                                        Cập nhật
                                    </button>

                                </form>
                            </td>

                            <td>
                                <form
                                    method="POST"
                                    action="di-cho-cua-toi.php?tab=hien-tai"
                                    data-confirm="Bạn có chắc muốn xóa món ăn này?"
                                >

                                    <?= csrfField() ?>

                                    <input
                                        type="hidden"
                                        name="hanh_dong"
                                        value="xoa_di_cho"
                                    >

                                    <input
                                        type="hidden"
                                        name="id_mon"
                                        value="<?= e($mon->id) ?>"
                                    >

                                    <button type="submit" class="nut nut-phu">
                                        Xóa
                                    </button>

                                </form>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <!-- CÁC THAO TÁC -->
            <div class="cac-thao-tac-danh-sach d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">

                <form
                    method="POST"
                    action="di-cho-cua-toi.php?tab=hien-tai"
                    data-confirm="Bạn có chắc muốn xóa toàn bộ danh sách?"
                >

                    <?= csrfField() ?>

                    <input
                        type="hidden"
                        name="hanh_dong"
                        value="xoa_danh_sach"
                    >

                    <button type="submit" class="nut nut-phu">
                        Xóa toàn bộ danh sách
                    </button>

                </form>

                <form
                    method="POST"
                    action="chot-di-cho.php"
                    data-confirm="Bạn muốn chốt danh sách đi chợ này?"
                >

                    <?= csrfField() ?>

                    <button type="submit" class="nut">
                        Chốt danh sách đi chợ
                    </button>

                </form>

            </div>

        <?php endif; ?>

    <?php elseif ($coId): ?>

        <!-- ======================================
             TAB 2: CHI TIẾT LỊCH SỬ
        ======================================= -->

        <?php if ($khongTim): ?>

            <p>Không tìm thấy lần đi chợ này hoặc bạn không có quyền xem.</p>

        <?php else: ?>

            <h2>Lần đi chợ #<?= (int) $lan['id'] ?></h2>

            <p>
                Ngày chốt: <?= e($lan['ngay_chot']) ?> ·
                Trạng thái:
                <?= e($nhanTrangThai[$lan['trang_thai']] ?? $lan['trang_thai']) ?>
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

                    <?php $tong = 0; ?>

                    <?php foreach ($lan['cac_mon'] as $dong): ?>

                        <?php
                        $tong += (int) $dong['so_suat']
                            * (int) $dong['ngan_sach_tham_khao'];
                        ?>

                        <tr>
                            <td>
                                <?= e($dong['ten_mon']) ?>
                            </td>

                            <td><?= (int) $dong['so_suat'] ?></td>

                            <td>
                                <?= vnd(
                                    (int) $dong['ngan_sach_tham_khao']
                                    * (int) $dong['so_suat']
                                ) ?>
                            </td>
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

        <p class="mt-4">
            <a href="di-cho-cua-toi.php?tab=lich-su">
                ← Tất cả lần đi chợ
            </a>
        </p>

    <?php else: ?>

        <!-- ======================================
             TAB 2: DANH SÁCH LỊCH SỬ
        ======================================= -->

        <h2>Lịch sử đi chợ</h2>

        <?php if (!$dsLan): ?>

            <p>Bạn chưa chốt danh sách đi chợ nào.</p>

            <a class="nut" href="di-cho-cua-toi.php?tab=hien-tai">
                Xem danh sách hiện tại
            </a>

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
                            <td>
                                <a href="di-cho-cua-toi.php?tab=lich-su&id=<?= (int) $dong['id'] ?>">
                                    #<?= (int) $dong['id'] ?>
                                </a>
                            </td>

                            <td><?= e($dong['ngay_chot']) ?></td>

                            <td><?= (int) $dong['so_mon'] ?></td>

                            <td><?= (int) $dong['tong_so_suat'] ?></td>

                            <td><?= vnd((int) $dong['tong_ngan_sach']) ?></td>

                            <td>
                                <?= e($nhanTrangThai[$dong['trang_thai']] ?? $dong['trang_thai']) ?>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    <?php endif; ?>

</main>

<?php require __DIR__ . '/inc/footer.php'; ?>
