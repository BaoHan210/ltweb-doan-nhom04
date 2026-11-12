<?php
/**
 * Tệp: them-mon-an.php
 * Mục đích: Thêm món ăn mới (chỉ quản trị viên). Bài thực hành 6 – Chức năng 3.
 */

declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/xac-thuc.php';
require_once __DIR__ . '/inc/kiem-tra-mon-an.php';

use App\Data\KhoMonAn;

// 1. Kiểm tra quyền bằng dữ liệu MySQL
yeuCauQuyen('quan_tri');

$kho       = new KhoMonAn(db());
$dsDanhMuc = $kho->layDanhMucQuanTri();

$cacTruong = [
    'ten',
    'slug',
    'danh_muc_id',
    'thoi_gian',
    'khau_phan',
    'do_kho',
    'ngan_sach',
    'mo_ta',
    'video',
];

// Giá trị mặc định khi mở form lần đầu
$duLieu = [
    'ten'         => '',
    'slug'        => '',
    'danh_muc_id' => '',
    'thoi_gian'   => '30',
    'khau_phan'   => '2',
    'do_kho'      => 'Dễ',
    'ngan_sach'   => '50000',
    'mo_ta'       => '',
    'video'       => '',
];

$loi = [];
$danhSachNguyenLieu = [
    ['ten' => '', 'soLuong' => ''],
];

// 2. Xử lý gửi biểu mẫu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($cacTruong as $cot) {
        $gioiHan = $cot === 'mo_ta' ? 10001 : 255;
        $duLieu[$cot] = lay_chuoi($_POST, $cot, $gioiHan);
    }

    $loi = kiemTraDuLieuMonAn($duLieu, $dsDanhMuc);

    // Nhận danh sách tên nguyên liệu và số lượng
    $tenNguyenLieu = $_POST['nguyen_lieu_ten'] ?? [];
    $soLuongNguyenLieu = $_POST['nguyen_lieu_so_luong'] ?? [];

    if (!is_array($tenNguyenLieu) || !is_array($soLuongNguyenLieu)) {
        $loi['nguyen_lieu'] = 'Danh sách nguyên liệu không hợp lệ.';
    } elseif (
        count($tenNguyenLieu) > 50
        || count($soLuongNguyenLieu) > 50
        || array_keys($tenNguyenLieu) !== array_keys($soLuongNguyenLieu)
    ) {
        $loi['nguyen_lieu'] = 'Danh sách nguyên liệu không hợp lệ hoặc vượt quá 50 dòng.';
    } else {
        $danhSachNguyenLieu = [];

        foreach ($tenNguyenLieu as $i => $ten) {
            $soLuong = $soLuongNguyenLieu[$i] ?? null;

            if (!is_string($ten) || !is_string($soLuong)) {
                $loi['nguyen_lieu'] = 'Dữ liệu tên hoặc số lượng nguyên liệu không hợp lệ.';
                break;
            }

            $ten = trim($ten);
            $soLuong = trim($soLuong);

            if ($ten === '' && $soLuong === '') {
                continue;
            }

            if ($ten === '' || $soLuong === '') {
                $loi['nguyen_lieu'] = 'Vui lòng nhập đầy đủ tên và số lượng cho từng nguyên liệu.';
                break;
            }

            if (
                mb_strlen($ten, 'UTF-8') > 150
                || mb_strlen($soLuong, 'UTF-8') > 100
            ) {
                $loi['nguyen_lieu'] = 'Tên nguyên liệu tối đa 150 ký tự và số lượng tối đa 100 ký tự.';
                break;
            }

            $danhSachNguyenLieu[] = [
                'ten'     => $ten,
                'soLuong' => $soLuong,
            ];
        }

        if ($danhSachNguyenLieu === []) {
            $danhSachNguyenLieu = [
                ['ten' => '', 'soLuong' => ''],
            ];
        }
    }

    // Kiểm tra ảnh đại diện
    $anh = $_FILES['hinh_anh'] ?? null;
    $kiemTraAnh = kiemTraAnhMonAn(is_array($anh) ? $anh : null, true);

    if ($kiemTraAnh['loi'] !== null) {
        $loi['hinh_anh'] = $kiemTraAnh['loi'];
    }

    // Chỉ ghi tệp và CSDL khi dữ liệu đã hợp lệ
    if ($loi === []) {
        $thuMuc = __DIR__ . '/uploads';

        if (
            !is_dir($thuMuc)
            && !mkdir($thuMuc, 0755, true)
            && !is_dir($thuMuc)
        ) {
            $loi['hinh_anh'] = 'Không tạo được thư mục uploads.';
        } else {
            $tenAnh = bin2hex(random_bytes(16)) . '.' . $kiemTraAnh['duoi'];
            $duongDan = $thuMuc . '/' . $tenAnh;

            if (!move_uploaded_file((string) $anh['tmp_name'], $duongDan)) {
                $loi['hinh_anh'] = 'Không lưu được ảnh lên máy chủ.';
            } else {
                $duLieu['hinh_anh'] = 'uploads/' . $tenAnh;

                try {
                    $idMoi = $kho->themMonAn($duLieu, $danhSachNguyenLieu);

                    gan_thong_bao(
                        'success',
                        'Đã thêm món ăn #' . $idMoi . ' thành công.'
                    );

                    header('Location: quan-tri.php', true, 303); // PRG
                    exit;
                } catch (PDOException $e) {
                    // Ghi CSDL thất bại: xóa ảnh vừa tải lên
                    @unlink($duongDan);

                    if ((int) ($e->errorInfo[1] ?? 0) !== 1062) {
                        throw $e;
                    }

                    $loi['slug'] = 'Slug này đã tồn tại, hãy nhập slug khác.';
                }
            }
        }
    }
}

// 3. Hiển thị biểu mẫu
$tieuDe = 'Thêm món ăn - Cook with me';
$trang = 'quan-tri';

$hienLoi = static function (string $cot) use ($loi): void {
    if (isset($loi[$cot])) {
        echo '<p class="thong-bao-loi-truong" role="alert">'
            . e($loi[$cot])
            . '</p>';
    }
};

$truongChu = [
    'ten'  => ['Tên món ăn', 200],
    'slug' => ['Slug (ví dụ: ca-kho-to)', 190],
];

$truongSo = [
    'thoi_gian' => ['Thời gian (phút)', 1],
    'khau_phan' => ['Khẩu phần (người)', 1],
    'ngan_sach' => ['Ngân sách (đồng)', 1000],
];

$doKhoHopLe = ['Dễ', 'Trung bình', 'Khó'];

$cssRieng = 'css/12-form-quan-ly-mon-an.css';
$customJS = 'js/trang-them-mon-an.js';

require __DIR__ . '/inc/header.php';
?>
<main class="noi-dung-trang form-mon-an-trang">
    <p><a href="quan-tri.php">← Quay lại quản trị</a></p>
    <h1>Thêm món ăn</h1>
    <p>Điền thông tin món ăn và chọn ảnh đại diện. Các mục có dấu * là bắt buộc.</p>

    <form action="them-mon-an.php" method="post" enctype="multipart/form-data" novalidate>
        <?= csrfField() ?>

        <div class="form-mon-an-luoi">
            <?php foreach ($truongChu as $cot => [$nhan, $doDaiToiDa]): ?>
                <div>
                    <label for="<?= e($cot) ?>"><?= e($nhan) ?> *</label><br>
                    <input
                        type="text"
                        id="<?= e($cot) ?>"
                        name="<?= e($cot) ?>"
                        maxlength="<?= $doDaiToiDa ?>"
                        <?= $cot === 'slug' ? 'pattern="[a-z0-9]+(-[a-z0-9]+)*"' : '' ?>
                        value="<?= e($duLieu[$cot]) ?>"
                        class="o-nhap-mon-an"
                    >
                    <?php $hienLoi($cot); ?>
                </div>
            <?php endforeach; ?>

            <div>
                <label for="danh_muc_id">Danh mục *</label><br>
                <select id="danh_muc_id" name="danh_muc_id" class="o-nhap-mon-an">
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($dsDanhMuc as $dm): ?>
                        <option
                            value="<?= (int) $dm['id'] ?>"
                            <?= (string) $dm['id'] === $duLieu['danh_muc_id'] ? 'selected' : '' ?>
                        >
                            <?= e($dm['ten']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php $hienLoi('danh_muc_id'); ?>
            </div>

            <?php foreach ($truongSo as $cot => [$nhan, $min]): ?>
                <div>
                    <label for="<?= e($cot) ?>"><?= e($nhan) ?> *</label><br>
                    <input
                        type="number"
                        id="<?= e($cot) ?>"
                        name="<?= e($cot) ?>"
                        min="<?= $min ?>"
                        step="1"
                        value="<?= e($duLieu[$cot]) ?>"
                        class="o-nhap-mon-an"
                    >
                    <?php $hienLoi($cot); ?>
                </div>
            <?php endforeach; ?>

            <div>
                <label for="do_kho">Độ khó *</label><br>
                <select id="do_kho" name="do_kho" class="o-nhap-mon-an">
                    <?php foreach ($doKhoHopLe as $muc): ?>
                        <option
                            value="<?= e($muc) ?>"
                            <?= $muc === $duLieu['do_kho'] ? 'selected' : '' ?>
                        >
                            <?= e($muc) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php $hienLoi('do_kho'); ?>
            </div>

            <div>
                <label for="hinh_anh">Ảnh đại diện * (JPG, PNG hoặc WebP, tối đa 3 MB)</label><br>
                <input
                    type="file"
                    id="hinh_anh"
                    name="hinh_anh"
                    accept="image/jpeg,image/png,image/webp"
                >
                <?php $hienLoi('hinh_anh'); ?>
            </div>
        </div>

        <section class="khu-vuc-nguyen-lieu">
            <h2>Nguyên liệu</h2>
            <p>Nhập tên và số lượng riêng cho từng nguyên liệu. Có thể thêm nhiều dòng.</p>

            <?php $hienLoi('nguyen_lieu'); ?>

            <div id="danh-sach-nguyen-lieu" class="danh-sach-nguyen-lieu">
                <?php foreach ($danhSachNguyenLieu as $nguyenLieu): ?>
                    <div class="dong-nguyen-lieu">
                        <div>
                            <label>Tên nguyên liệu</label>
                            <input
                                type="text"
                                name="nguyen_lieu_ten[]"
                                maxlength="150"
                                value="<?= e($nguyenLieu['ten']) ?>"
                                class="o-nhap-mon-an"
                                placeholder="Ví dụ: Thịt bò"
                            >
                        </div>

                        <div>
                            <label>Số lượng</label>
                            <input
                                type="text"
                                name="nguyen_lieu_so_luong[]"
                                maxlength="100"
                                value="<?= e($nguyenLieu['soLuong']) ?>"
                                class="o-nhap-mon-an"
                                placeholder="Ví dụ: 200 g"
                            >
                        </div>

                        <button
                            type="button"
                            class="nut nut-xoa-nguyen-lieu"
                            data-hanh-dong="xoa-nguyen-lieu"
                        >
                            Xóa
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>

            <button
                type="button"
                id="nut-them-nguyen-lieu"
                class="nut nut-them-nguyen-lieu"
            >
                + Thêm nguyên liệu
            </button>
        </section>

        <p>
            <label for="mo_ta">Mô tả</label><br>
            <textarea
                id="mo_ta"
                name="mo_ta"
                rows="5"
                class="o-nhap-mon-an"
            ><?= e($duLieu['mo_ta']) ?></textarea>
            <?php $hienLoi('mo_ta'); ?>
        </p>

        <p>
            <label for="video">Đường dẫn video (nếu có)</label><br>
            <input
                type="text"
                id="video"
                name="video"
                maxlength="255"
                value="<?= e($duLieu['video']) ?>"
                class="o-nhap-mon-an"
            >
            <?php $hienLoi('video'); ?>
        </p>

        <button class="nut nut-chinh" type="submit">Thêm món ăn</button>
        <a class="nut" href="quan-tri.php">Hủy</a>
    </form>
</main>

<?php require __DIR__ . '/inc/footer.php'; ?>
