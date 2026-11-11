
<?php
/**
 * Trang cá nhân Nguyễn Thị Trinh - MSSV 3120224155.
 * BT6 Phần B: Sổ lưu bút MySQL (thêm, phân trang, chủ trang xóa).
 * Chức năng 2: Bộ đếm lượt xem theo ngày và thống kê 7 ngày MySQL.
 * BT7 Phần B: Rà soát CSRF, XSS, phân quyền và phương thức HTTP.
 */
require_once __DIR__ . '/../../inc/config.php';
require_once __DIR__ . '/../../inc/db.php';
require_once __DIR__ . '/../../inc/xac-thuc.php';

const MSSV_TRINH = '3120224155';

// ==================================================
// CHỨC NĂNG 1: SỔ LƯU BÚT MYSQL
// ==================================================

$loi = [];
$du = ['ten' => '', 'loinhan' => ''];

$thongBao = $_SESSION['flash_trinh'] ?? '';
unset($_SESSION['flash_trinh']);

// Lấy tài khoản chủ trang.
$st = db()->prepare(
    'SELECT nguoi_dung_id
     FROM thanh_vien
     WHERE mssv = ?'
);

$st->execute([MSSV_TRINH]);
$thanhVien = $st->fetch();

if ($thanhVien === false) {
    http_response_code(404);
    exit('Chưa tìm thấy thông tin thành viên.');
}

// Chỉ chủ trang đã đăng nhập mới được xóa.
$nguoiDung = nguoiDungHienTai();

$laChuTrang = $nguoiDung !== null
    && $thanhVien['nguoi_dung_id'] !== null
    && (int) $nguoiDung['id'] === (int) $thanhVien['nguoi_dung_id'];

// ==================================================
// XỬ LÝ POST - CSRF ĐƯỢC KIỂM TRA TRONG inc/config.php
// ==================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $hanhDong = chuoi($_POST['hanh_dong'] ?? '');

    // ----------------------------------------------
    // BT7: GHI LƯỢT XEM BẰNG POST THAY VÌ GET
    // ----------------------------------------------

    if ($hanhDong === 'ghi_luot_xem') {

        // Mỗi phiên chỉ tính một lượt.
        if (empty($_SESSION['da_xem_trinh_mysql'])) {

            $stTangLuot = db()->prepare(
                'INSERT INTO tv_trinh_luot_xem
                    (mssv, ngay, so_luot)
                 VALUES (?, CURDATE(), 1)
                 ON DUPLICATE KEY UPDATE
                    so_luot = so_luot + 1'
            );

            $stTangLuot->execute([MSSV_TRINH]);

            $_SESSION['da_xem_trinh_mysql'] = true;
        }

        $trangVe = filter_var(
            $_POST['trang'] ?? 1,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        ) ?: 1;

        // PRG: POST xong chuyển về GET.
        header(
            'Location: gioithieu.php?trang=' . $trangVe,
            true,
            303
        );
        exit;
    }

    // ----------------------------------------------
    // XÓA LỜI NHẮN - CHỈ CHỦ TRANG
    // ----------------------------------------------

    if ($hanhDong === 'xoa') {

        if (!$laChuTrang) {

            ghiLogBaoMat(
                'cam_truy_cap',
                ['ly_do' => 'xoa_luu_but_khong_co_quyen']
            );

            http_response_code(403);
            exit('Chỉ chủ trang đăng nhập mới được xóa lời nhắn.');
        }

        // Chỉ chấp nhận ID là số nguyên dương.
        $idXoa = filter_var(
            $_POST['id'] ?? null,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        );

        if ($idXoa === false || $idXoa === null) {
            http_response_code(400);
            exit('Mã lời nhắn không hợp lệ.');
        }

        // Ràng buộc ID với MSSV trên máy chủ.
        $st = db()->prepare(
            'DELETE FROM tv_trinh_luu_but
             WHERE id = ? AND mssv = ?'
        );

        $st->execute([$idXoa, MSSV_TRINH]);

        // Không xóa được ID thuộc trang thành viên khác.
        if ($st->rowCount() === 0) {
            http_response_code(404);
            exit('Không tìm thấy lời nhắn thuộc trang này.');
        }

        $_SESSION['flash_trinh'] = 'Đã xóa lời nhắn.';

        $trangVe = filter_var(
            $_POST['trang'] ?? 1,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        ) ?: 1;

        header(
            'Location: gioithieu.php?trang=' .
            $trangVe .
            '#so-luu-but',
            true,
            303
        );
        exit;
    }

    // ----------------------------------------------
    // GỬI LỜI NHẮN
    // ----------------------------------------------

    if ($hanhDong !== 'gui') {
        http_response_code(400);
        exit('Thao tác không hợp lệ.');
    }

    // BT7: Chỉ nhận kiểu chuỗi, không nhận mảng.
    $du['ten'] = trim(chuoi($_POST['ten'] ?? ''));
    $du['loinhan'] = trim(chuoi($_POST['loinhan'] ?? ''));

    // Kiểm tra phía máy chủ.
    if (
        $du['ten'] === ''
        || mb_strlen($du['ten']) > 50
    ) {
        $loi['ten'] = 'Họ tên phải dài từ 1 đến 50 ký tự.';
    }

    if (
        $du['loinhan'] === ''
        || mb_strlen($du['loinhan']) > 500
    ) {
        $loi['loinhan'] = 'Lời nhắn phải dài từ 1 đến 500 ký tự.';
    }

    if (!$loi) {

        // Prepared statement ngăn SQL Injection.
        $st = db()->prepare(
            'INSERT INTO tv_trinh_luu_but
                (mssv, ten_khach, loi_nhan)
             VALUES (?, ?, ?)'
        );

        $st->execute([
            MSSV_TRINH,
            $du['ten'],
            $du['loinhan']
        ]);

        $_SESSION['flash_trinh'] = 'Đã gửi lời nhắn thành công!';

        // PRG tránh gửi lại biểu mẫu khi nhấn F5.
        header(
            'Location: gioithieu.php?trang=1#so-luu-but',
            true,
            303
        );
        exit;
    }
}

// ==================================================
// PHÂN TRANG SỔ LƯU BÚT
// ==================================================

$soMoiTrang = 5;

$st = db()->prepare(
    'SELECT COUNT(*)
     FROM tv_trinh_luu_but
     WHERE mssv = ?'
);

$st->execute([MSSV_TRINH]);
$tongLoiNhan = (int) $st->fetchColumn();

$soTrang = max(
    1,
    (int) ceil($tongLoiNhan / $soMoiTrang)
);

// BT7: Tham số số dùng filter_var().
$trangYeuCau = filter_var(
    $_GET['trang'] ?? 1,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
) ?: 1;

$hienTai = min($trangYeuCau, $soTrang);

// Lấy danh sách lời nhắn.
$st = db()->prepare(
    'SELECT id, ten_khach, loi_nhan, thoi_gian
     FROM tv_trinh_luu_but
     WHERE mssv = ?
     ORDER BY thoi_gian DESC, id DESC
     LIMIT ? OFFSET ?'
);

$st->bindValue(1, MSSV_TRINH, PDO::PARAM_STR);
$st->bindValue(2, $soMoiTrang, PDO::PARAM_INT);
$st->bindValue(
    3,
    ($hienTai - 1) * $soMoiTrang,
    PDO::PARAM_INT
);

$st->execute();
$danhSachLuuBut = $st->fetchAll();

// ==================================================
// CHỨC NĂNG 2: THỐNG KÊ LƯỢT XEM MYSQL
// ==================================================

// BT7: GET chỉ truy vấn đọc dữ liệu.
// Việc INSERT/UPDATE lượt xem đã chuyển sang POST ở trên.

// TỔNG LƯỢT XEM.
$stTongLuot = db()->prepare(
    'SELECT COALESCE(SUM(so_luot), 0)
     FROM tv_trinh_luot_xem
     WHERE mssv = ?'
);

$stTongLuot->execute([MSSV_TRINH]);
$luotXem = (int) $stTongLuot->fetchColumn();

// THỐNG KÊ 7 NGÀY GẦN NHẤT.
$stBayNgay = db()->prepare(
    'SELECT ngay, so_luot
     FROM tv_trinh_luot_xem
     WHERE mssv = ?
       AND ngay BETWEEN
           DATE_SUB(CURDATE(), INTERVAL 6 DAY)
           AND CURDATE()
     ORDER BY ngay DESC'
);

$stBayNgay->execute([MSSV_TRINH]);

$luotTheoNgay = [];

foreach ($stBayNgay->fetchAll() as $dong) {
    $luotTheoNgay[$dong['ngay']] = (int) $dong['so_luot'];
}

// Lấy ngày hiện tại từ MySQL.
$ngayHomNay = new DateTimeImmutable(
    (string) db()->query('SELECT CURDATE()')->fetchColumn()
);

// Tạo đủ 7 ngày, kể cả ngày không có lượt xem.
$thongKeBayNgay = [];

for ($i = 0; $i < 7; $i++) {

    $ngay = $ngayHomNay
        ->modify("-$i days")
        ->format('Y-m-d');

    $thongKeBayNgay[] = [
        'ngay' => $ngay,
        'so_luot' => $luotTheoNgay[$ngay] ?? 0
    ];
}

// ==================================================
// NẠP HEADER CỦA NHÓM
// ==================================================

$goc = '../../';
$tieuDe = 'Thông tin cá nhân - Nguyễn Thị Trinh';
$trang = '';
$customJS = 'thanhvien/3120224155_trinh/js/canhan.js';

require __DIR__ . '/../../inc/header.php';
?>

<link
    rel="stylesheet"
    href="<?= e($goc) ?>thanhvien/3120224155_trinh/trang-ca-nhan.css"
>

<main class="ho-so-trang">

    <h1 class="tieu-de-ho-so">
        Hồ sơ thành viên: Nguyễn Thị Trinh
    </h1>

    <!--
        BT7: Ghi lượt xem bằng POST có mã CSRF.
        JavaScript tự gửi form một lần trong mỗi phiên.
        Khi tắt JavaScript, có thể bấm nút thủ công.
    -->

    <?php if (
        ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET'
        && empty($_SESSION['da_xem_trinh_mysql'])
    ): ?>

        <form
            id="form-ghi-luot-xem"
            method="post"
            action="gioithieu.php"
        >

            <?= csrfField() ?>

            <input
                type="hidden"
                name="hanh_dong"
                value="ghi_luot_xem"
            >

            <input
                type="hidden"
                name="trang"
                value="<?= e((string) $hienTai) ?>"
            >

            <button type="submit">
                Ghi nhận lượt xem
            </button>

        </form>

    <?php endif; ?>

    <!-- BỘ ĐẾM LƯỢT XEM MYSQL -->
    <section
        class="khu-vuc-luot-xem"
        aria-labelledby="tieu-de-luot-xem"
    >

        <h2 id="tieu-de-luot-xem">
            👁️ Lượt xem trang cá nhân
        </h2>

        <p>
            <strong>
                Tổng lượt xem:
                <?= e((string) $luotXem) ?> lượt
            </strong>
            (mỗi phiên làm việc chỉ tính một lần).
        </p>

        <table class="bang-luot-xem">

            <caption>
                Thống kê lượt xem trong 7 ngày gần nhất
            </caption>

            <thead>
                <tr>
                    <th scope="col">Ngày</th>
                    <th scope="col">Số lượt xem</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($thongKeBayNgay as $dong): ?>

                    <tr>
                        <td>
                            <?= e(date(
                                'd/m/Y',
                                strtotime($dong['ngay'])
                            )) ?>
                        </td>

                        <td>
                            <?= e((string) $dong['so_luot']) ?>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>

        </table>

    </section>

    <!-- THÔNG TIN CHUNG -->
    <section class="thong-tin-chung">

        <h2>Thông tin chung</h2>

        <figure class="anh-chan-dung-thanh-vien">

            <img
                src="<?= e($goc) ?>images/avatar-trinh.jpg"
                alt="Ảnh chân dung thành viên Nguyễn Thị Trinh"
                width="200"
                height="200"
            >

            <figcaption>
                Ảnh chân dung thành viên Nguyễn Thị Trinh - Nhóm 04.
            </figcaption>

        </figure>

        <ul class="thong-tin-ca-nhan">

            <li>
                <strong>Họ và tên:</strong>
                Nguyễn Thị Trinh
            </li>

            <li>
                <strong>Vai trò:</strong>
                Thành viên
            </li>

            <li>
                <strong>Nhiệm vụ chính:</strong>
                Xây dựng cấu trúc HTML5 ngữ nghĩa và
                thực hiện kiểm chuẩn chất lượng mã nguồn.
            </li>

        </ul>

    </section>

    <!-- DỰ ÁN VÀ SỞ THÍCH -->
    <article class="du-an-so-thich">

        <h2>Dự án và sở thích</h2>

        <p>
            Nguyễn Thị Trinh cùng các thành viên xây dựng
            website Cook with me, một mạng xã hội chia sẻ
            công thức ẩm thực.
        </p>

        <p>
            Trong dự án, công việc tập trung vào xây dựng
            cấu trúc HTML5 theo hướng ngữ nghĩa và kiểm
            chuẩn chất lượng mã nguồn, giúp nội dung được
            tổ chức rõ ràng và dễ tiếp cận.
        </p>

        <p>
            Sở thích cá nhân gồm nghiên cứu công nghệ web,
            trải nghiệm ẩm thực các vùng miền và chạy bộ
            thể thao.
        </p>

    </article>

    <!-- KỸ NĂNG -->
    <section class="ky-nang">

        <h2>Kỹ năng</h2>

        <ul class="danh-sach-ky-nang">

            <li>Ngôn ngữ HTML5 chuẩn ngữ nghĩa W3C</li>

            <li>
                Sử dụng hệ thống quản lý mã nguồn Git và GitHub
            </li>

            <li>
                Kiểm thử khả năng tiếp cận (Accessibility)
                và SEO bằng Google Lighthouse
            </li>

            <li>Làm việc nhóm và thiết kế giao diện web cơ bản</li>

        </ul>

    </section>

    <!-- THỜI KHÓA BIỂU -->
    <section class="thoi-khoa-bieu">

        <h2>Thời khóa biểu tuần</h2>

        <p>
            Bảng thời khóa biểu có thể cuộn ngang trên
            màn hình nhỏ.
        </p>

        <div class="khung-bang">

            <table>

                <caption>
                    Thời khóa biểu học tập và nghiên cứu
                    đồ án trong tuần
                </caption>

                <thead>
                    <tr>
                        <th scope="col">Khung giờ</th>
                        <th scope="col">Thứ Hai</th>
                        <th scope="col">Thứ Tư</th>
                        <th scope="col">Thứ Sáu</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <th scope="row">Buổi sáng</th>
                        <td>Lập trình Web (Lý thuyết)</td>
                        <td>
                            Tự học HTML5 ngữ nghĩa
                            và Cơ sở dữ liệu
                        </td>
                        <td>Nghiên cứu tài liệu đồ án</td>
                    </tr>

                    <tr>
                        <th scope="row">Buổi chiều</th>
                        <td>Họp tiến độ Nhóm 04</td>
                        <td>
                            Thực hành Lập trình Web -
                            Kiểm thử W3C và Lighthouse
                        </td>
                        <td>Tổng hợp báo cáo tuần</td>
                    </tr>

                    <tr>
                        <th scope="row">Buổi tối</th>
                        <td>Ôn tập</td>
                        <td>Kiểm tra W3C</td>
                        <td>Kiểm tra Lighthouse</td>
                    </tr>

                </tbody>

            </table>

        </div>

    </section>

    <!-- SỔ LƯU BÚT MYSQL -->
    <section
        id="so-luu-but"
        class="so-luu-but"
    >

        <h2>✍️ Sổ lưu bút</h2>

        <?php if ($thongBao !== ''): ?>

            <p
                class="thong-bao-luu-but"
                role="status"
            >
                <?= e($thongBao) ?>
            </p>

        <?php endif; ?>

        <!-- FORM GỬI LỜI NHẮN -->
        <form
            method="post"
            action="gioithieu.php#so-luu-but"
            class="form-luu-but"
        >

            <?= csrfField() ?>

            <input
                type="hidden"
                name="hanh_dong"
                value="gui"
            >

            <div>

                <label for="ten">Họ tên của bạn (*):</label>

                <input
                    type="text"
                    id="ten"
                    name="ten"
                    maxlength="50"
                    value="<?= e($du['ten']) ?>"
                >

                <?php if (isset($loi['ten'])): ?>

                    <p class="loi-luu-but">
                        <?= e($loi['ten']) ?>
                    </p>

                <?php endif; ?>

            </div>

            <div>

                <label for="loinhan">Lời nhắn (*):</label>

                <textarea
                    id="loinhan"
                    name="loinhan"
                    rows="3"
                    maxlength="500"
                ><?= e($du['loinhan']) ?></textarea>

                <?php if (isset($loi['loinhan'])): ?>

                    <p class="loi-luu-but">
                        <?= e($loi['loinhan']) ?>
                    </p>

                <?php endif; ?>

            </div>

            <button
                type="submit"
                class="nut nut-gui-loi-nhan"
            >
                Gửi lời nhắn
            </button>

        </form>

        <!-- DANH SÁCH LỜI NHẮN -->
        <h3>
            Lời nhắn
            (<?= e((string) $tongLoiNhan) ?> lời nhắn -
            trang <?= e((string) $hienTai) ?>/<?= e((string) $soTrang) ?>)
        </h3>

        <?php if (!$danhSachLuuBut): ?>

            <p>Chưa có lời nhắn nào.</p>

        <?php else: ?>

            <ul class="danh-sach-luu-but">

                <?php foreach ($danhSachLuuBut as $lb): ?>

                    <li>

                        <strong>
                            <?= e($lb['ten_khach']) ?>
                        </strong>

                        <small>
                            (<?= e(date(
                                'd/m/Y H:i',
                                strtotime($lb['thoi_gian'])
                            )) ?>)
                        </small>

                        <p>
                            <?= nl2br(e($lb['loi_nhan'])) ?>
                        </p>

                        <!-- CHỈ CHỦ TRANG ĐƯỢC XÓA -->
                        <?php if ($laChuTrang): ?>

                            <form
                                method="post"
                                action="gioithieu.php"
                                class="form-xoa-loi-nhan"
                                data-confirm="Bạn muốn xóa lời nhắn này?"
                            >

                                <?= csrfField() ?>

                                <input
                                    type="hidden"
                                    name="hanh_dong"
                                    value="xoa"
                                >

                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= e((string) (int) $lb['id']) ?>"
                                >

                                <input
                                    type="hidden"
                                    name="trang"
                                    value="<?= e((string) $hienTai) ?>"
                                >

                                <button type="submit">
                                    Xóa
                                </button>

                            </form>

                        <?php endif; ?>

                    </li>

                <?php endforeach; ?>

            </ul>

        <?php endif; ?>

        <!-- PHÂN TRANG -->
        <?php if ($soTrang > 1): ?>

            <nav
                aria-label="Phân trang sổ lưu bút"
                class="phan-trang-luu-but"
            >

                <?php for ($i = 1; $i <= $soTrang; $i++): ?>
<a
    href="?trang=<?= e((string) $i) ?>#so-luu-but"
    <?= $i === $hienTai
        ? 'aria-current="page"'
        : '' ?>
>
    Trang <?= e((string) $i) ?>
</a>


                <?php endfor; ?>

            </nav>

        <?php endif; ?>

    </section>

    <p class="quay-lai quay-lai-trang-chu">
        <a href="<?= e($goc) ?>index.php">
            Quay lại trang chủ
        </a>
    </p>

</main>

<?php
require __DIR__ . '/../../inc/footer.php';
?>
