<?php
/*
 * Trang cá nhân Phan Thị Bảo Hân (MSSV 3120224045) - Phần B.
 * Dự án của tôi lấy từ bảng tv_du_an; lịch sử phiên bản lấy từ bảng tv_phien_ban (5 mục mỗi trang).
 * Hồ sơ và danh sách công nghệ vẫn đọc từ storage/ (JSON).
 * Cách thử: khách chỉ xem; đăng nhập baohan@cookwithme.com để thêm, xóa dự án và lưu hồ sơ.
 */

require_once __DIR__ . '/../../inc/config.php';
require_once __DIR__ . '/../../inc/db.php';
require_once __DIR__ . '/../../inc/xac-thuc.php';

const MSSV = '3120224045';

$goc      = '../../';
$tieuDe   = 'Thông tin cá nhân - Bảo Hân';
$trang    = 'gioi-thieu';
$cssRieng = $goc . 'thanhvien/3120224045_baohan/trang-ca-nhan.css';

$thuMucStorage = dirname(__DIR__, 2) . '/storage';
$tepHoSo       = $thuMucStorage . '/3120224045_thongtin.json';

/*
 * Đọc dữ liệu JSON. Trả về mảng rỗng nếu tệp không tồn tại,
 * không đọc được hoặc nội dung không hợp lệ.
 */
function docDuLieuJson(string $duongDan): array
{
    if (!is_file($duongDan) || !is_readable($duongDan)) {
        return [];
    }

    $noiDung = file_get_contents($duongDan);

    if ($noiDung === false || trim($noiDung) === '') {
        return [];
    }

    $duLieu = json_decode($noiDung, true);

    return is_array($duLieu) ? $duLieu : [];
}

/*
 * Đếm số ký tự Unicode, kể cả khi máy chủ không bật mbstring.
 */
function doDaiChuoi(string $chuoi): int
{
    $ketQua = preg_match_all('/./us', $chuoi, $cacKyTu);

    return $ketQua === false ? strlen($chuoi) : $ketQua;
}

/* =========================================================
   1. HỒ SƠ (JSON)
   ========================================================= */
$hoSoMacDinh = [
    'email'    => 'baohanphan205@gmail.com',
    'ho_ten'   => 'Phan Thị Bảo Hân',
    'vai_tro'  => 'Nhóm trưởng',
    'nhiem_vu' => 'Quản lý kho mã nguồn GitHub, thiết lập GitHub Pages, xây dựng khung trang chủ và biểu mẫu liên hệ.'
];

$hoSoDocDuoc = docDuLieuJson($tepHoSo);

$hoSo = $hoSoMacDinh;

foreach (array_keys($hoSoMacDinh) as $khoa) {
    if (isset($hoSoDocDuoc[$khoa]) && is_string($hoSoDocDuoc[$khoa])) {
        $hoSo[$khoa] = $hoSoDocDuoc[$khoa];
    }
}

/* =========================================================
   2. BỘ LỌC GET (kiểm tra bằng whitelist)
   ========================================================= */
$nhomPhienBanHopLe = ['tat-ca', 'giao-dien', 'tinh-nang', 'sua-loi'];
$nhomCongNgheHopLe = ['tat-ca', 'frontend', 'backend', 'co-so-du-lieu', 'cong-cu'];

$nhomPhienBan = $_GET['nhom_phien_ban'] ?? 'tat-ca';
if (!is_string($nhomPhienBan) || !in_array($nhomPhienBan, $nhomPhienBanHopLe, true)) {
    $nhomPhienBan = 'tat-ca';
}

$nhomCongNghe = $_GET['nhom_cong_nghe'] ?? 'tat-ca';
if (!is_string($nhomCongNghe) || !in_array($nhomCongNghe, $nhomCongNgheHopLe, true)) {
    $nhomCongNghe = 'tat-ca';
}

/* =========================================================
   3. THÀNH VIÊN VÀ QUYỀN CHỦ TRANG (CSDL)
   ========================================================= */
$nguoiDung = nguoiDungHienTai();   // null nếu khách

$st = db()->prepare('SELECT ho_ten, nguoi_dung_id FROM thanh_vien WHERE mssv = ?');
$st->execute([MSSV]);
$thanhVien = $st->fetch() ?: ['ho_ten' => '', 'nguoi_dung_id' => null];

$laChuTrang = $nguoiDung !== null
    && $thanhVien['nguoi_dung_id'] !== null
    && (int) $nguoiDung['id'] === (int) $thanhVien['nguoi_dung_id'];

if (empty($_SESSION['csrf_tv'])) {
    $_SESSION['csrf_tv'] = bin2hex(random_bytes(32));
}
$csrfTv = $_SESSION['csrf_tv'];

/* =========================================================
   4. XỬ LÝ POST: THÊM / XÓA DỰ ÁN (tv_du_an)
   ========================================================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hanh_dong'])) {

    if (!$laChuTrang) {
        http_response_code(403);
        exit('Chỉ chủ trang mới được thay đổi dữ liệu này.');
    }

    $csrf = is_string($_POST['csrf_token'] ?? null) ? $_POST['csrf_token'] : '';
    if (!hash_equals($csrfTv, $csrf)) {
        http_response_code(403);
        exit('Phiên làm việc không hợp lệ. Hãy tải lại trang.');
    }

    $hanhDong = $_POST['hanh_dong'];

    if ($hanhDong === 'them') {
        $ten  = is_string($_POST['ten'] ?? null) ? trim($_POST['ten']) : '';
        $moTa = is_string($_POST['mo_ta'] ?? null) ? trim($_POST['mo_ta']) : '';
        $nam  = filter_var($_POST['nam'] ?? '', FILTER_VALIDATE_INT,
                    ['options' => ['min_range' => 2000, 'max_range' => 2100]]);

        if ($ten === '' || doDaiChuoi($ten) > 100) {
            gan_thong_bao('error', 'Tên dự án dài 1 đến 100 ký tự.');
        } elseif ($nam === false) {
            gan_thong_bao('error', 'Năm phải từ 2000 đến 2100.');
        } elseif (doDaiChuoi($moTa) > 500) {
            gan_thong_bao('error', 'Mô tả tối đa 500 ký tự.');
        } else {
            db()->prepare('INSERT INTO tv_du_an (mssv, ten, mo_ta, nam) VALUES (?, ?, ?, ?)')
                ->execute([MSSV, $ten, $moTa === '' ? null : $moTa, $nam]);
            gan_thong_bao('success', 'Đã thêm dự án.');
        }

    } elseif ($hanhDong === 'xoa') {
        $id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);

        if ($id !== false && $id > 0) {
            // AND mssv = ?: không xóa được dự án của người khác dù sửa giá trị id
            db()->prepare('DELETE FROM tv_du_an WHERE id = ? AND mssv = ?')
                ->execute([$id, MSSV]);
            gan_thong_bao('success', 'Đã xóa dự án.');
        }
    }

    chuyen_huong('gioithieu.php#du-an');   // PRG: F5 không gửi lại
}

/* =========================================================
   5. XỬ LÝ POST: LƯU HỒ SƠ (JSON, chỉ chủ trang)
   ========================================================= */
$loiBieuMau = '';
$daLuu      = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['hanh_dong'])) {

    if (!$laChuTrang) {
        http_response_code(403);
        exit('Chỉ chủ trang mới được lưu hồ sơ.');
    }

    $csrf = is_string($_POST['csrf_token'] ?? null) ? $_POST['csrf_token'] : '';
    if (!hash_equals($csrfTv, $csrf)) {
        http_response_code(403);
        exit('Phiên làm việc không hợp lệ. Hãy tải lại trang.');
    }

    $emailGui   = $_POST['email'] ?? null;
    $hoTenGui   = $_POST['ho_ten'] ?? null;
    $vaiTroGui  = $_POST['vai_tro'] ?? null;
    $nhiemVuGui = $_POST['nhiem_vu'] ?? null;

    if (
        !is_string($emailGui)
        || !is_string($hoTenGui)
        || !is_string($vaiTroGui)
        || !is_string($nhiemVuGui)
    ) {
        $loiBieuMau = 'Dữ liệu gửi lên không hợp lệ.';
    } else {
        $email   = trim($emailGui);
        $hoTen   = trim($hoTenGui);
        $vaiTro  = trim($vaiTroGui);
        $nhiemVu = trim($nhiemVuGui);

        if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $loiBieuMau = 'Vui lòng nhập địa chỉ email hợp lệ.';
        } elseif ($hoTen === '' || $vaiTro === '' || $nhiemVu === '') {
            $loiBieuMau = 'Các trường thông tin không được để trống.';
        } elseif (
            strlen($email) > 254
            || doDaiChuoi($hoTen) > 100
            || doDaiChuoi($vaiTro) > 100
            || doDaiChuoi($nhiemVu) > 1000
        ) {
            $loiBieuMau = 'Một hoặc nhiều trường vượt quá độ dài cho phép.';
        } else {
            $hoSoMoi = [
                'email'    => $email,
                'ho_ten'   => $hoTen,
                'vai_tro'  => $vaiTro,
                'nhiem_vu' => $nhiemVu
            ];

            $noiDungJson = json_encode($hoSoMoi, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            $daGhiDuLieu = false;

            if ($noiDungJson !== false && is_dir($thuMucStorage) && is_writable($thuMucStorage)) {
                $soByteDaGhi = file_put_contents($tepHoSo, $noiDungJson, LOCK_EX);
                $daGhiDuLieu = $soByteDaGhi !== false;
            }

            if ($daGhiDuLieu) {
                // PRG: chuyển hướng sau POST thành công, giữ bộ lọc GET
                $chuoiTruyVan = http_build_query([
                    'da_luu'         => '1',
                    'nhom_phien_ban' => $nhomPhienBan,
                    'nhom_cong_nghe' => $nhomCongNghe
                ]);

                $duongDanTrang = $_SERVER['SCRIPT_NAME'] ?? 'gioithieu.php';

                header('Location: ' . $duongDanTrang . '?' . $chuoiTruyVan, true, 303);
                exit;
            }

            $loiBieuMau = 'Không thể lưu thông tin. Hãy kiểm tra quyền ghi của thư mục storage.';
        }
    }

    // Khi dữ liệu không hợp lệ: hiển thị lại dữ liệu đã nhập, không ghi file
    if ($loiBieuMau !== '') {
        $hoSo['email']    = trim($emailGui);
        $hoSo['ho_ten']   = trim($hoTenGui);
        $hoSo['vai_tro']  = trim($vaiTroGui);
        $hoSo['nhiem_vu'] = trim($nhiemVuGui);
    }
}

if (isset($_GET['da_luu']) && $_GET['da_luu'] === '1') {
    $daLuu = true;
}

/* =========================================================
   6. ĐỌC DỮ LIỆU CHO GIAO DIỆN
   ========================================================= */

// 6a. Dự án: tìm theo tên, lọc theo năm, sắp xếp (ORDER BY lấy từ whitelist)
$q = is_string($_GET['q'] ?? null) ? trim($_GET['q']) : '';

$namLoc = filter_var($_GET['nam'] ?? '', FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 2000, 'max_range' => 2100]]);

$sxKey = is_string($_GET['sx'] ?? null) ? $_GET['sx'] : 'moi';

// Chỉ các chuỗi cố định trong mảng này được nối vào SQL
$cauSapXepDuAn = [
    'moi' => 'nam DESC, id DESC',
    'cu'  => 'nam ASC, id ASC',
    'ten' => 'ten ASC, id ASC'
];
$orderByDuAn = $cauSapXepDuAn[$sxKey] ?? $cauSapXepDuAn['moi'];

$dieuKien = ['mssv = :mssv'];
$thamSo   = [':mssv' => MSSV];

if ($q !== '') {
    $dieuKien[] = 'ten LIKE :q';
    $thamSo[':q'] = '%' . addcslashes($q, '%_\\') . '%';
}
if ($namLoc !== false) {
    $dieuKien[] = 'nam = :nam';
    $thamSo[':nam'] = $namLoc;
}

$st = db()->prepare('SELECT id, ten, mo_ta, nam FROM tv_du_an WHERE '
    . implode(' AND ', $dieuKien) . ' ORDER BY ' . $orderByDuAn);
$st->execute($thamSo);
$duAn = $st->fetchAll();

// 6b. Lịch sử phiên bản: đọc từ tv_phien_ban, 5 mục mỗi trang
$dkPhienBan   = $nhomPhienBan === 'tat-ca' ? '' : ' AND nhom = :nhom';
$thamPhienBan = [':mssv' => MSSV];
if ($nhomPhienBan !== 'tat-ca') {
    $thamPhienBan[':nhom'] = $nhomPhienBan;
}

$st = db()->prepare("SELECT COUNT(*) FROM tv_phien_ban WHERE mssv = :mssv$dkPhienBan");
$st->execute($thamPhienBan);
$soTrangPB = max(1, (int) ceil($st->fetchColumn() / 5));

$trangPB = filter_var($_GET['trang'] ?? 1, FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1, 'default' => 1]]);
$trangPB = min($trangPB, $soTrangPB);

$st = db()->prepare("SELECT ma, ten, ngay, nhom, mo_ta FROM tv_phien_ban
                     WHERE mssv = :mssv$dkPhienBan
                     ORDER BY ngay DESC, id DESC
                     LIMIT :gioi OFFSET :bo");
foreach ($thamPhienBan as $khoa => $giaTri) {
    $st->bindValue($khoa, $giaTri);
}
$st->bindValue(':gioi', 5, PDO::PARAM_INT);
$st->bindValue(':bo', ($trangPB - 1) * 5, PDO::PARAM_INT);
$st->execute();
$pbDong = $st->fetchAll();

// 6c. Danh sách công nghệ: vẫn đọc từ JSON
$cacCongNghe = docDuLieuJson($thuMucStorage . '/3120224045_congnghe.json');

$congNgheHienThi = array_filter(
    $cacCongNghe,
    function ($congNghe) use ($nhomCongNghe) {
        return is_array($congNghe)
            && isset($congNghe['nhom'])
            && is_string($congNghe['nhom'])
            && ($nhomCongNghe === 'tat-ca' || $congNghe['nhom'] === $nhomCongNghe);
    }
);

require __DIR__ . '/../../inc/header.php';
?>

<!-- NỘI DUNG CHÍNH -->
<main class="ho-so-trang">

    <h1 class="tieu-de-ho-so">
        Hồ sơ thành viên: Bảo Hân
    </h1>

    <!-- KHU VỰC TƯƠNG TÁC TRANG CÁ NHÂN -->
    <div class="khu-vuc-thao-tac-ca-nhan">

        <div class="nhom-nut-chinh-sua">
            <button type="button" class="nut-chinh-sua">Chỉnh sửa</button>
            <button type="button" class="nut-luu-thay-doi" hidden>Lưu thay đổi</button>
            <button type="button" class="nut-huy-chinh-sua" hidden>Hủy</button>
        </div>

        <!-- Form nhận dữ liệu do canhan.js chuyển vào các input ẩn -->
        <form id="form-luu-ho-so" method="POST" hidden>
            <input type="hidden" name="csrf_token" value="<?= e($csrfTv) ?>">

            <input type="hidden" name="email" id="du-lieu-email"
                   value="<?= e($hoSo['email']) ?>">
            <input type="hidden" name="ho_ten" id="du-lieu-ho-ten"
                   value="<?= e($hoSo['ho_ten']) ?>">
            <input type="hidden" name="vai_tro" id="du-lieu-vai-tro"
                   value="<?= e($hoSo['vai_tro']) ?>">
            <input type="hidden" name="nhiem_vu" id="du-lieu-nhiem-vu"
                   value="<?= e($hoSo['nhiem_vu']) ?>">
        </form>

        <?php if ($daLuu): ?>
            <p class="thong-bao-thanh-cong" role="status">
                Đã lưu thông tin hồ sơ thành công.
            </p>
        <?php endif; ?>

        <?php if ($loiBieuMau !== ''): ?>
            <p class="thong-bao-loi" role="alert">
                <?= e($loiBieuMau) ?>
            </p>
        <?php endif; ?>

        <button type="button" class="nut-chuyen-giao-dien" aria-pressed="false">
            Chế độ tối
        </button>

    </div>

    <!-- KHU VỰC EMAIL -->
    <div class="khu-vuc-email-ca-nhan">

        <p class="email-ca-nhan">
            Email:
            <span class="dia-chi-email" data-editable><?= e($hoSo['email']) ?></span>
        </p>

        <button type="button" class="nut-sao-chep-email">Sao chép email</button>

        <p class="thong-bao-sao-chep" aria-live="polite"></p>

    </div>

    <!-- THÔNG TIN CHUNG -->
    <section class="thong-tin-chung">

        <h2>Thông tin chung</h2>

        <figure class="anh-chan-dung-thanh-vien">
            <img src="../../images/avatar-baohan.jpg"
                 alt="Ảnh chân dung thành viên Phan Thị Bảo Hân"
                 width="200" height="200">
            <figcaption>
                Ảnh chân dung thành viên Phan Thị Bảo Hân - Nhóm 04.
            </figcaption>
        </figure>

        <ul class="thong-tin-ca-nhan">
            <li>
                <strong>Họ và tên:</strong>
                <span data-editable><?= e($hoSo['ho_ten']) ?></span>
            </li>
            <li>
                <strong>Vai trò:</strong>
                <span data-editable><?= e($hoSo['vai_tro']) ?></span>
            </li>
            <li>
                <strong>Nhiệm vụ chính:</strong>
                <span data-editable><?= e($hoSo['nhiem_vu']) ?></span>
            </li>
        </ul>

    </section>

    <!-- DỰ ÁN VÀ SỞ THÍCH -->
    <article class="du-an-so-thich">

        <h2>Dự án và sở thích</h2>

        <p>
            Bảo Hân tham gia xây dựng website Cook with me,
            một mạng xã hội chia sẻ và khám phá công thức nấu ăn.
        </p>

        <p>
            Trong dự án, các công việc tập trung vào tổ chức mã nguồn,
            xây dựng cấu trúc HTML và phối hợp triển khai website.
        </p>

        <p>
            Sở thích gồm tìm hiểu công nghệ thông tin, thiết kế website,
            đọc sách và khám phá các món ăn.
        </p>

    </article>

    <!-- DỰ ÁN CỦA TÔI: DỮ LIỆU TỪ CSDL (tv_du_an) -->
    <section class="du-an-db" id="du-an">

        <h2>Dự án của tôi (lưu trong CSDL)</h2>

        <?= hien_thi_thong_bao() ?>

        <form method="get" action="gioithieu.php#du-an">
            <label for="q">Tìm theo tên:</label>
            <input type="search" id="q" name="q" value="<?= e($q) ?>">

            <label for="nam">Năm:</label>
            <input type="number" id="nam" name="nam" min="2000" max="2100"
                   value="<?= $namLoc !== false ? (int) $namLoc : '' ?>">

            <label for="sx">Sắp xếp:</label>
            <select id="sx" name="sx">
                <option value="moi" <?= $sxKey === 'moi' ? 'selected' : '' ?>>Mới nhất</option>
                <option value="cu"  <?= $sxKey === 'cu'  ? 'selected' : '' ?>>Cũ nhất</option>
                <option value="ten" <?= $sxKey === 'ten' ? 'selected' : '' ?>>Tên A → Z</option>
            </select>

            <button type="submit">Lọc</button>
        </form>

        <?php if (empty($duAn)): ?>
            <p>Không có dự án phù hợp.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($duAn as $da): ?>
                    <li>
                        <strong><?= e($da['ten']) ?></strong>
                        (<?= (int) $da['nam'] ?>)
                        <?php if ($da['mo_ta'] !== null): ?>
                            — <?= e($da['mo_ta']) ?>
                        <?php endif; ?>

                        <?php if ($laChuTrang): ?>
                            <form method="post" action="gioithieu.php#du-an">
                                <input type="hidden" name="csrf_token" value="<?= e($csrfTv) ?>">
                                <input type="hidden" name="hanh_dong" value="xoa">
                                <input type="hidden" name="id" value="<?= (int) $da['id'] ?>">
                                <button type="submit">Xóa</button>
                            </form>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if ($laChuTrang): ?>
            <h3>Thêm dự án</h3>
            <form method="post" action="gioithieu.php#du-an">
                <input type="hidden" name="csrf_token" value="<?= e($csrfTv) ?>">
                <input type="hidden" name="hanh_dong" value="them">

                <label for="ten-da">Tên:</label>
                <input type="text" id="ten-da" name="ten" maxlength="100" required>

                <label for="nam-da">Năm:</label>
                <input type="number" id="nam-da" name="nam" min="2000" max="2100" required>

                <label for="mo-ta-da">Mô tả:</label>
                <textarea id="mo-ta-da" name="mo_ta" maxlength="500"></textarea>

                <button type="submit">Thêm</button>
            </form>
        <?php endif; ?>

    </section>

    <!-- KỸ NĂNG -->
    <section class="ky-nang">

        <h2>Kỹ năng</h2>

        <ul class="danh-sach-ky-nang">
            <li>HTML5</li>
            <li>Git và GitHub</li>
            <li>Thiết kế cấu trúc website</li>
            <li>Làm việc nhóm</li>
            <li>Quản lý mã nguồn</li>
        </ul>

    </section>

    <!-- LỊCH SỬ PHIÊN BẢN: DỮ LIỆU TỪ CSDL (tv_phien_ban) -->
    <section class="lich-su-phien-ban" id="lich-su">

        <h2>Lịch sử phiên bản Cook with me</h2>

        <p>
            Theo dõi các thay đổi và cải tiến trong quá trình phát triển website.
        </p>

        <form method="GET" action="gioithieu.php#lich-su">
            <label for="nhom-phien-ban">Lọc theo nhóm cập nhật:</label>

            <select id="nhom-phien-ban" name="nhom_phien_ban">
                <option value="tat-ca"    <?= $nhomPhienBan === 'tat-ca'    ? 'selected' : '' ?>>Tất cả phiên bản</option>
                <option value="giao-dien" <?= $nhomPhienBan === 'giao-dien' ? 'selected' : '' ?>>Giao diện</option>
                <option value="tinh-nang" <?= $nhomPhienBan === 'tinh-nang' ? 'selected' : '' ?>>Tính năng</option>
                <option value="sua-loi"   <?= $nhomPhienBan === 'sua-loi'   ? 'selected' : '' ?>>Sửa lỗi</option>
            </select>

            <input type="hidden" name="nhom_cong_nghe" value="<?= e($nhomCongNghe) ?>">

            <button type="submit">Lọc phiên bản</button>
        </form>

        <?php if (empty($pbDong)): ?>
            <p>Không tìm thấy phiên bản phù hợp.</p>
        <?php else: ?>
            <?php foreach ($pbDong as $phienBan): ?>
                <article class="muc-phien-ban">

                    <h3>
                        <?= e($phienBan['ma']) ?> -
                        <?= e($phienBan['ten']) ?>
                    </h3>

                    <p>
                        <strong>Ngày cập nhật:</strong>
                        <?= e($phienBan['ngay']) ?>
                    </p>

                    <p>
                        <strong>Nhóm:</strong>
                        <?= e($phienBan['nhom']) ?>
                    </p>

                    <p><?= e($phienBan['mo_ta'] ?? '') ?></p>

                </article>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($soTrangPB > 1): ?>
            <nav aria-label="Phân trang phiên bản">
                <?php for ($i = 1; $i <= $soTrangPB; $i++): ?>
                    <a href="?<?= e(http_build_query([
                                'nhom_phien_ban' => $nhomPhienBan,
                                'nhom_cong_nghe' => $nhomCongNghe,
                                'trang'          => $i
                            ])) ?>#lich-su"
                       <?= $i === $trangPB ? 'aria-current="page"' : '' ?>><?= $i ?></a>
                <?php endfor; ?>
            </nav>
        <?php endif; ?>

    </section>

    <!-- CÔNG NGHỆ SỬ DỤNG: DỮ LIỆU TỪ JSON -->
    <section class="tra-cuu-cong-nghe">

        <h2>Công nghệ sử dụng</h2>

        <p>
            Các công nghệ và công cụ được sử dụng trong quá trình xây dựng Cook with me.
        </p>

        <form method="GET" action="gioithieu.php#cong-nghe">
            <label for="nhom-cong-nghe">Lọc theo nhóm công nghệ:</label>

            <select id="nhom-cong-nghe" name="nhom_cong_nghe">
                <option value="tat-ca"        <?= $nhomCongNghe === 'tat-ca'        ? 'selected' : '' ?>>Tất cả công nghệ</option>
                <option value="frontend"      <?= $nhomCongNghe === 'frontend'      ? 'selected' : '' ?>>Frontend</option>
                <option value="backend"       <?= $nhomCongNghe === 'backend'       ? 'selected' : '' ?>>Backend</option>
                <option value="co-so-du-lieu" <?= $nhomCongNghe === 'co-so-du-lieu' ? 'selected' : '' ?>>Cơ sở dữ liệu</option>
                <option value="cong-cu"       <?= $nhomCongNghe === 'cong-cu'       ? 'selected' : '' ?>>Công cụ</option>
            </select>

            <input type="hidden" name="nhom_phien_ban" value="<?= e($nhomPhienBan) ?>">

            <button type="submit">Tra cứu</button>
        </form>

        <?php if (empty($congNgheHienThi)): ?>
            <p>Không tìm thấy công nghệ phù hợp.</p>
        <?php else: ?>
            <ul class="danh-sach-cong-nghe">
                <?php foreach ($congNgheHienThi as $congNghe): ?>
                    <li>
                        <strong><?= e($congNghe['ten'] ?? '') ?></strong>
                        <p><?= e($congNghe['mo_ta'] ?? '') ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    </section>

    <!-- THỜI KHÓA BIỂU -->
    <section class="thoi-khoa-bieu">

        <h2>Thời khóa biểu tuần</h2>

        <p>Bảng thời khóa biểu có thể cuộn ngang trên màn hình nhỏ.</p>

        <div class="khung-bang">
            <table>
                <caption>Thời khóa biểu học tập và hoạt động trong tuần</caption>

                <thead>
                    <tr>
                        <th scope="col">Ngày</th>
                        <th scope="col">Buổi sáng</th>
                        <th scope="col">Buổi chiều</th>
                        <th scope="col">Buổi tối</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th scope="row">Thứ Hai</th>
                        <td>Học tập</td><td>Học tập</td><td>Làm đồ án</td>
                    </tr>
                    <tr>
                        <th scope="row">Thứ Ba</th>
                        <td>Học tập</td><td>Thực hành</td><td>Tự học</td>
                    </tr>
                    <tr>
                        <th scope="row">Thứ Tư</th>
                        <td>Học tập</td><td>Học tập</td><td>Làm đồ án</td>
                    </tr>
                    <tr>
                        <th scope="row">Thứ Năm</th>
                        <td>Học tập</td><td>Thực hành</td><td>Tự học</td>
                    </tr>
                    <tr>
                        <th scope="row">Thứ Sáu</th>
                        <td>Học tập</td><td>Học tập</td><td>Làm đồ án</td>
                    </tr>
                    <tr>
                        <th scope="row">Thứ Bảy</th>
                        <td>Tự học</td><td>Hoạt động cá nhân</td><td>Ôn tập</td>
                    </tr>
                    <tr>
                        <th scope="row">Chủ Nhật</th>
                        <td>Nghỉ ngơi</td><td>Đọc sách</td><td>Lên kế hoạch tuần</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </section>

    <!-- QUAY LẠI -->
    <p class="quay-lai">
        <a href="<?= e($goc) ?>index.php">Quay lại trang chủ</a>
    </p>

</main>

<script type="module" src="js/canhan.js"></script>

<?php require __DIR__ . '/../../inc/footer.php'; ?>