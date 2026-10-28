
<?php
/**
 * Trang cá nhân Nguyễn Thị Trinh - MSSV 3120224155.
 * BT6 Phần B: Sổ lưu bút MySQL (thêm, phân trang, chủ trang xóa).
 * Chức năng 2: Bộ đếm lượt xem theo ngày và thống kê 7 ngày MySQL.
 * Cách thử: gửi lời nhắn, phân trang, xóa, tải lại và mở phiên mới.
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

// Token bảo vệ biểu mẫu
if (empty($_SESSION['csrf_trinh'])) {
    $_SESSION['csrf_trinh'] = bin2hex(random_bytes(32));
}

$csrfTrinh = $_SESSION['csrf_trinh'];

// Lấy tài khoản chủ trang
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

// Chỉ chủ trang đã đăng nhập mới được xóa
$nguoiDung = nguoiDungHienTai();

$laChuTrang = $nguoiDung !== null
    && $thanhVien['nguoi_dung_id'] !== null
    && (int) $nguoiDung['id'] === (int) $thanhVien['nguoi_dung_id'];

// Xử lý gửi và xóa lời nhắn
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tokenGui = $_POST['csrf'] ?? null;

    if (
        !is_string($tokenGui) ||
        !hash_equals($csrfTrinh, $tokenGui)
    ) {
        http_response_code(403);
        exit('Phiên gửi biểu mẫu không hợp lệ.');
    }

    $hanhDong = $_POST['hanh_dong'] ?? '';

    // XÓA LỜI NHẮN
    if ($hanhDong === 'xoa') {

        if (!$laChuTrang) {
            http_response_code(403);
            exit('Chỉ chủ trang đăng nhập mới được xóa lời nhắn.');
        }

        $idXoa = filter_var(
            $_POST['id'] ?? null,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        );

        if ($idXoa === false || $idXoa === null) {
            http_response_code(400);
            exit('Mã lời nhắn không hợp lệ.');
        }

        $st = db()->prepare(
            'DELETE FROM tv_trinh_luu_but
             WHERE id = ? AND mssv = ?'
        );

        $st->execute([$idXoa, MSSV_TRINH]);

        $_SESSION['flash_trinh'] = 'Đã xóa lời nhắn.';

        $trangVe = filter_var(
            $_POST['trang'] ?? 1,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        ) ?: 1;

        header(
            'Location: gioithieu.php?trang=' .
            $trangVe .
            '#so-luu-but'
        );
        exit;
    }

    // GỬI LỜI NHẮN
    if ($hanhDong !== 'gui') {
        http_response_code(400);
        exit('Thao tác không hợp lệ.');
    }

    $tenNhap = $_POST['ten'] ?? '';
    $nhanNhap = $_POST['loinhan'] ?? '';

    $du['ten'] = is_string($tenNhap)
        ? trim($tenNhap)
        : '';

    $du['loinhan'] = is_string($nhanNhap)
        ? trim($nhanNhap)
        : '';

    // Kiểm tra dữ liệu phía server
    if (
        $du['ten'] === '' ||
        mb_strlen($du['ten']) > 50
    ) {
        $loi['ten'] = 'Họ tên phải dài từ 1 đến 50 ký tự.';
    }

    if (
        $du['loinhan'] === '' ||
        mb_strlen($du['loinhan']) > 500
    ) {
        $loi['loinhan'] = 'Lời nhắn phải dài từ 1 đến 500 ký tự.';
    }

    if (!$loi) {

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

        // PRG tránh gửi lại khi nhấn F5
        header('Location: gioithieu.php?trang=1#so-luu-but');
        exit;
    }
}

// PHÂN TRANG: MỖI TRANG 5 LỜI NHẮN
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

$trangYeuCau = filter_var(
    $_GET['trang'] ?? 1,
    FILTER_VALIDATE_INT,
    ['options' => ['min_range' => 1]]
) ?: 1;

$hienTai = min($trangYeuCau, $soTrang);

// Lấy danh sách lời nhắn
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
// CHỨC NĂNG 2: BỘ ĐẾM LƯỢT XEM THEO NGÀY MYSQL
// ==================================================

// Mỗi phiên chỉ tăng lượt xem một lần
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

// TỔNG LƯỢT XEM
$stTongLuot = db()->prepare(
    'SELECT COALESCE(SUM(so_luot), 0)
     FROM tv_trinh_luot_xem
     WHERE mssv = ?'
);

$stTongLuot->execute([MSSV_TRINH]);

$luotXem = (int) $stTongLuot->fetchColumn();


// THỐNG KÊ 7 NGÀY GẦN NHẤT
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

// Lấy ngày hiện tại theo máy chủ MySQL
$ngayHomNay = new DateTimeImmutable(
    (string) db()->query('SELECT CURDATE()')->fetchColumn()
);

// Tạo đủ 7 dòng, kể cả ngày có 0 lượt xem
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
// NẠP HEADER NHÓM
// ==================================================

$goc = '../../';
$tieuDe = 'Thông tin cá nhân - Nguyễn Thị Trinh';
$trang = '';

require __DIR__ . '/../../inc/header.php';
?>

<link rel="stylesheet" href="trang-ca-nhan.css">

<main class="ho-so-trang">

    <h1 class="tieu-de-ho-so">
        Hồ sơ thành viên: Nguyễn Thị Trinh
    </h1>

    <!-- BỘ ĐẾM LƯỢT XEM MYSQL -->
    <section
        aria-labelledby="tieu-de-luot-xem"
        style="
            margin:15px 0;
            padding:15px;
            background:#e8f5e9;
            border-left:4px solid #2e7d32;
        "
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

        <!-- BẢNG THỐNG KÊ 7 NGÀY -->
        <table style="
            width:100%;
            border-collapse:collapse;
            background:#fff;
        ">

            <caption>
                Thống kê lượt xem trong 7 ngày gần nhất
            </caption>

            <thead>
                <tr>
                    <th
                        scope="col"
                        style="padding:8px; border:1px solid #ccc;"
                    >
                        Ngày
                    </th>

                    <th
                        scope="col"
                        style="padding:8px; border:1px solid #ccc;"
                    >
                        Số lượt xem
                    </th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($thongKeBayNgay as $dong): ?>

                    <tr>
                        <td style="
                            padding:8px;
                            border:1px solid #ccc;
                            text-align:center;
                        ">
                            <?= e(date(
                                'd/m/Y',
                                strtotime($dong['ngay'])
                            )) ?>
                        </td>

                        <td style="
                            padding:8px;
                            border:1px solid #ccc;
                            text-align:center;
                        ">
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
            <li>Sử dụng hệ thống quản lý mã nguồn Git và GitHub</li>
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
        style="
            margin-top:30px;
            padding:20px;
            border:1px solid #ddd;
            border-radius:8px;
            background:#fafafa;
        "
    >

        <h2>✍️ Sổ lưu bút</h2>

        <?php if ($thongBao !== ''): ?>

            <p
                role="status"
                style="
                    padding:10px;
                    background:#d4edda;
                    color:#155724;
                "
            >
                <?= e($thongBao) ?>
            </p>

        <?php endif; ?>

        <!-- FORM GỬI LỜI NHẮN -->
        <form
            method="post"
            action="gioithieu.php#so-luu-but"
            style="
                display:flex;
                flex-direction:column;
                gap:12px;
                margin-bottom:25px;
            "
        >

            <input
                type="hidden"
                name="hanh_dong"
                value="gui"
            >

            <input
                type="hidden"
                name="csrf"
                value="<?= e($csrfTrinh) ?>"
            >

            <div>
                <label for="ten">Họ tên của bạn (*):</label>

                <input
                    type="text"
                    id="ten"
                    name="ten"
                    maxlength="50"
                    value="<?= e($du['ten']) ?>"
                    style="
                        width:100%;
                        padding:8px;
                        border:1px solid #ccc;
                    "
                >

                <?php if (isset($loi['ten'])): ?>
                    <p style="color:#b91c1c;">
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
                    style="
                        width:100%;
                        padding:8px;
                        border:1px solid #ccc;
                    "
                ><?= e($du['loinhan']) ?></textarea>

                <?php if (isset($loi['loinhan'])): ?>
                    <p style="color:#b91c1c;">
                        <?= e($loi['loinhan']) ?>
                    </p>
                <?php endif; ?>
            </div>

            <button
                type="submit"
                class="nut"
                style="
                    padding:8px 18px;
                    background:#e67e22;
                    color:white;
                    border:0;
                    border-radius:4px;
                    cursor:pointer;
                "
            >
                Gửi lời nhắn
            </button>

        </form>

        <!-- DANH SÁCH LỜI NHẮN -->
        <h3>
            Lời nhắn
            (<?= $tongLoiNhan ?> lời nhắn -
            trang <?= $hienTai ?>/<?= $soTrang ?>)
        </h3>

        <?php if (!$danhSachLuuBut): ?>

            <p>Chưa có lời nhắn nào.</p>

        <?php else: ?>

            <ul style="list-style:none; padding-left:0;">

                <?php foreach ($danhSachLuuBut as $lb): ?>

                    <li style="
                        padding:10px;
                        border-bottom:1px dashed #ccc;
                    ">

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
                            <?= e($lb['loi_nhan']) ?>
                        </p>

                        <!-- CHỈ CHỦ TRANG ĐƯỢC XÓA -->
                        <?php if ($laChuTrang): ?>

                            <form
                                method="post"
                                action="gioithieu.php"
                                style="margin-top:6px;"
                            >

                                <input
                                    type="hidden"
                                    name="hanh_dong"
                                    value="xoa"
                                >

                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= (int) $lb['id'] ?>"
                                >

                                <input
                                    type="hidden"
                                    name="trang"
                                    value="<?= $hienTai ?>"
                                >

                                <input
                                    type="hidden"
                                    name="csrf"
                                    value="<?= e($csrfTrinh) ?>"
                                >

                                <button
                                    type="submit"
                                    onclick="return confirm('Bạn muốn xóa lời nhắn này?')"
                                >
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
                style="
                    display:flex;
                    flex-wrap:wrap;
                    gap:10px;
                    margin-top:14px;
                "
            >

                <?php for ($i = 1; $i <= $soTrang; $i++): ?>

                    <a
                        href="?trang=<?= $i ?>#so-luu-but"
                        <?= $i === $hienTai
                            ? 'aria-current="page"'
                            : '' ?>
                    >
                        Trang <?= $i ?>
                    </a>

                <?php endfor; ?>

            </nav>

        <?php endif; ?>

    </section>

    <p class="quay-lai" style="margin-top:20px;">
        <a href="<?= e($goc) ?>index.php">
            Quay lại trang chủ
        </a>
    </p>

</main>

<script type="module" src="js/canhan.js"></script>

<?php
require __DIR__ . '/../../inc/footer.php';
?>
