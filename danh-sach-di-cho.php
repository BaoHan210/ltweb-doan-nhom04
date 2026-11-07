<?php

/**
 * Tệp: danh-sach-di-cho.php
 * Mục đích: Quản lý danh sách đi chợ hiện tại của người dùng.
 * Chức năng: Xem danh sách, cập nhật số suất, xóa món, xóa toàn bộ và chốt danh sách.
 */
declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/xac-thuc.php';
require_once __DIR__ . '/src/Data/KhoMonAn.php';
require_once __DIR__ . '/src/Services/DanhSachDiChoService.php';

use App\Data\KhoMonAn;
use App\Services\DanhSachDiChoService;

$nguoiDung = yeuCauDangNhap();
$uid = (int) $nguoiDung['id'];

if (empty($_SESSION['csrf_di_cho'])) {
    $_SESSION['csrf_di_cho'] = bin2hex(random_bytes(32));
}

$kho = new KhoMonAn(db());

$danhSachDiChoService = new DanhSachDiChoService(
    db(),
    $uid
);

// Xử lý các thao tác trên danh sách.
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $csrf = $_POST['csrf_token'] ?? '';

    if (
        !is_string($csrf)
        || empty($_SESSION['csrf_di_cho'])
        || !hash_equals((string) $_SESSION['csrf_di_cho'], $csrf)
    ) {
        http_response_code(403);
        exit('CSRF không hợp lệ. Vui lòng tải lại trang.');
    }

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

    header('Location: danh-sach-di-cho.php', true, 303);
    exit;
}

// Lấy danh sách đi chợ hiện tại.
$danhSachDiCho = $danhSachDiChoService->layDanhSach($kho);

$tongSoMon = count($danhSachDiCho);
$tongSoSuat = 0;
$tongNganSach = 0;

foreach ($danhSachDiCho as $dong) {
    $soLuong = (int) $dong['soLuong'];

    $tongSoSuat += $soLuong;
    $tongNganSach += (int) $dong['monAn']->nganSach * $soLuong;
}

// Thiết lập header.
$tieuDe = 'Danh sách đi chợ';
$trang = 'danh-sach-di-cho';

require __DIR__ . '/inc/header.php';
?>

<main class="trang-danh-sach-di-cho container my-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>
            <h1 class="tieu-de-trang mb-2">Danh sách đi chợ</h1>

            <p class="mb-0">
                Quản lý những món ăn đã chọn trước khi chốt danh sách đi chợ.
            </p>
        </div>

        <a class="nut" href="goi-y-mon-an.php">
            ← Tiếp tục chọn món
        </a>

    </div>

    <?= hien_thi_thong_bao() ?>

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
                <strong>
                    <?= number_format($tongNganSach, 0, ',', '.') ?> VNĐ
                </strong>
            </p>

            <small>
                Ngân sách được ước tính theo mức tham khảo của các món ăn,
                không phải báo giá chi tiết từng nguyên liệu.
            </small>

        </div>

        <!-- BẢNG DANH SÁCH ĐI CHỢ -->
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
                            <a href="chi-tiet.php?id=<?= (int) $mon->id ?>">
                                <?= e($mon->ten) ?>
                            </a>
                        </td>

                        <td>

                            <form
                                method="POST"
                                action="danh-sach-di-cho.php"
                                class="d-flex align-items-center gap-2"
                            >

                                <input
                                    type="hidden"
                                    name="csrf_token"
                                    value="<?= e($_SESSION['csrf_di_cho']) ?>"
                                >

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
                                    class="form-control"
                                    style="width: 85px;"
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
                                action="danh-sach-di-cho.php"
                                onsubmit="return confirm('Bạn có chắc muốn xóa món ăn này?');"
                            >

                                <input
                                    type="hidden"
                                    name="csrf_token"
                                    value="<?= e($_SESSION['csrf_di_cho']) ?>"
                                >

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
                action="danh-sach-di-cho.php"
                onsubmit="return confirm('Bạn có chắc muốn xóa toàn bộ danh sách?');"
            >

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= e($_SESSION['csrf_di_cho']) ?>"
                >

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
                onsubmit="return confirm('Bạn muốn chốt danh sách đi chợ này?');"
            >

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= e($_SESSION['csrf_di_cho']) ?>"
                >

                <button type="submit" class="nut">
                    Chốt danh sách đi chợ
                </button>

            </form>

        </div>

    <?php endif; ?>

    <div class="mt-4">
        <a href="di-cho-cua-toi.php">
            Xem lịch sử đi chợ →
        </a>
    </div>

</main>

<?php require __DIR__ . '/inc/footer.php'; ?>
