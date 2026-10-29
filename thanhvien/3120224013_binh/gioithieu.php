<?php
// Trang ca nhan Nguyen Thi Ngoc Binh - MSSV 3120224013.
// Chuc nang 1: Loc danh gia theo danh muc bang PDO (GET, JOIN).
// Chuc nang 2: Them/sua/xoa danh gia vao MySQL (POST, CSRF, PRG).
// Thu: mo trang, loc danh muc, dang nhap chu trang de gui/sua/xoa.

$goc = '../../';
require_once __DIR__ . '/../../inc/config.php';
require_once __DIR__ . '/../../inc/db.php';
require_once __DIR__ . '/../../inc/xac-thuc.php';

$pdo = db();
$mssvBinh = '3120224013';

// Quyen chu trang duoc kiem tra o may chu theo ID tai khoan dang nhap.
$stmt = $pdo->prepare('SELECT nguoi_dung_id FROM thanh_vien WHERE mssv = :mssv LIMIT 1');
$stmt->execute(['mssv' => $mssvBinh]);
$chuTrangId = $stmt->fetchColumn();
$nguoiDungId = idNguoiDungHienTai();
$laChuTrang = $chuTrangId !== false && $chuTrangId !== null
    && $nguoiDungId > 0 && (int) $chuTrangId === $nguoiDungId;

if (!isset($_SESSION['csrf_binh']) || !is_string($_SESSION['csrf_binh'])) {
    $_SESSION['csrf_binh'] = bin2hex(random_bytes(32));
}
$csrfBinh = $_SESSION['csrf_binh'];

// Danh muc lay truc tiep tu MySQL, khong can mang ten co dinh.
$stmt = $pdo->query('SELECT id, ten FROM danh_muc ORDER BY ten ASC');
$danhMuc = $stmt->fetchAll(PDO::FETCH_ASSOC);
$chonDanhMuc = filter_input(INPUT_GET, 'danh_muc', FILTER_VALIDATE_INT);
$chonDanhMuc = ($chonDanhMuc === false || $chonDanhMuc === null || $chonDanhMuc < 1)
    ? 0 : $chonDanhMuc;
$idDanhMucHopLe = array_map('intval', array_column($danhMuc, 'id'));
if ($chonDanhMuc !== 0 && !in_array($chonDanhMuc, $idDanhMucHopLe, true)) {
    $chonDanhMuc = 0;
}

// Form danh gia chon mon tu bang mon_an (ID so la khoa ngoai).
$stmt = $pdo->query('SELECT id, ten FROM mon_an ORDER BY ten ASC');
$danhSachTatCa = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Xoa/sua/tao phai co POST, CSRF, quyen chu trang va truy van rang buoc MSSV.
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!$laChuTrang) {
        http_response_code(403);
        exit('403 - Chi chu trang moi duoc quan ly danh gia.');
    }
    $token = $_POST['csrf_token'] ?? null;
    if (!is_string($token) || !hash_equals($csrfBinh, $token)) {
        http_response_code(403);
        exit('403 - CSRF token khong hop le.');
    }

    $hanhDong = $_POST['hanh_dong'] ?? 'them';
    if (!is_string($hanhDong) || !in_array($hanhDong, ['them', 'sua', 'xoa'], true)) {
        http_response_code(400);
        exit('400 - Thao tac khong hop le.');
    }
    $danhGiaId = filter_var($_POST['danh_gia_id'] ?? null, FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]);

    if ($hanhDong === 'xoa') {
        if ($danhGiaId === false || $danhGiaId === null) {
            gan_thong_bao('error', 'Danh gia can xoa khong hop le.');
        } else {
            $stmt = $pdo->prepare('DELETE FROM tv_binh_danh_gia WHERE id = :id AND mssv = :mssv');
            $stmt->execute(['id' => $danhGiaId, 'mssv' => $mssvBinh]);
            gan_thong_bao($stmt->rowCount() ? 'success' : 'error',
                $stmt->rowCount() ? 'Da xoa danh gia.' : 'Khong tim thay danh gia de xoa.');
        }
    } else {
        $soSao = filter_var($_POST['so_sao'] ?? null, FILTER_VALIDATE_INT);
        $nhanXetInput = $_POST['nhan_xet'] ?? null;
        $nhanXet = is_string($nhanXetInput) ? trim($nhanXetInput) : '';
        $doDai = mb_strlen($nhanXet, 'UTF-8');
        $idMon = filter_var($_POST['id_mon'] ?? null, FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]);

        if ($soSao === false || $soSao === null || $soSao < 1 || $soSao > 5) {
            gan_thong_bao('error', 'So sao phai tu 1 den 5.');
        } elseif ($doDai < 5 || $doDai > 500) {
            gan_thong_bao('error', 'Nhan xet phai tu 5 den 500 ky tu.');
        } elseif ($hanhDong === 'them') {
            if ($idMon === false || $idMon === null) {
                gan_thong_bao('error', 'Vui long chon mon an hop le.');
            } else {
                $stmt = $pdo->prepare('INSERT INTO tv_binh_danh_gia '
                    . '(mssv, mon_an_id, so_sao, nhan_xet) '
                    . 'SELECT :mssv, m.id, :so_sao, :nhan_xet FROM mon_an m WHERE m.id = :id_mon');
                $stmt->execute(['mssv' => $mssvBinh, 'so_sao' => $soSao,
                    'nhan_xet' => $nhanXet, 'id_mon' => $idMon]);
                gan_thong_bao($stmt->rowCount() ? 'success' : 'error',
                    $stmt->rowCount() ? 'Da luu danh gia vao MySQL.' : 'Mon an khong ton tai.');
            }
        } else {
            if ($danhGiaId === false || $danhGiaId === null) {
                gan_thong_bao('error', 'Danh gia can sua khong hop le.');
            } else {
                $stmt = $pdo->prepare('UPDATE tv_binh_danh_gia '
                    . 'SET so_sao = :so_sao, nhan_xet = :nhan_xet '
                    . 'WHERE id = :id AND mssv = :mssv');
                $stmt->execute(['so_sao' => $soSao, 'nhan_xet' => $nhanXet,
                    'id' => $danhGiaId, 'mssv' => $mssvBinh]);
                gan_thong_bao('success', 'Da xu ly yeu cau cap nhat danh gia.');
            }
        }
    }
    // POST/Redirect/GET: tai lai trang khong gui lai bieu mau.
    $duongDan = 'gioithieu.php' . ($chonDanhMuc > 0 ? '?danh_muc=' . $chonDanhMuc : '');
    chuyen_huong($duongDan);
}

// CHUC NANG 1: chi loc cac mon da duoc Binh danh gia (khong trung bo loc chung).
$sql = 'SELECT dg.id, dg.so_sao, dg.nhan_xet, dg.thoi_gian, '
    . 'm.ten AS ten_mon, m.slug, dm.ten AS danh_muc '
    . 'FROM tv_binh_danh_gia dg '
    . 'JOIN mon_an m ON dg.mon_an_id = m.id '
    . 'JOIN danh_muc dm ON m.danh_muc_id = dm.id '
    . 'WHERE dg.mssv = :mssv';
$params = ['mssv' => $mssvBinh];
if ($chonDanhMuc > 0) {
    $sql .= ' AND dm.id = :danh_muc_id';
    $params['danh_muc_id'] = $chonDanhMuc;
}
$sql .= ' ORDER BY dg.thoi_gian DESC, dg.id DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$monAnHienThi = $stmt->fetchAll(PDO::FETCH_ASSOC);

// CHUC NANG 2: lich su danh gia tu MySQL (day du, khong phu thuoc bo loc).
$stmt = $pdo->prepare('SELECT dg.id, dg.so_sao, dg.nhan_xet, dg.thoi_gian, '
    . 'm.ten AS ten_mon FROM tv_binh_danh_gia dg '
    . 'JOIN mon_an m ON dg.mon_an_id = m.id '
    . 'WHERE dg.mssv = :mssv ORDER BY dg.thoi_gian DESC, dg.id DESC');
$stmt->execute(['mssv' => $mssvBinh]);
$danhSachDanhGia = $stmt->fetchAll(PDO::FETCH_ASSOC);

$tieuDe = 'Thong tin ca nhan - Nguyen Thi Ngoc Binh';
$trang = 'gioi-thieu';
$cssRieng = $goc . 'thanhvien/3120224013_binh/trang-ca-nhan.css';
require_once __DIR__ . '/../../inc/header.php';
?>

<main class="ho-so-trang container">

    <h1 class="tieu-de-ho-so">
        Hồ sơ thành viên: Nguyễn Thị Ngọc Bình
    </h1>

    <?= hien_thi_thong_bao() ?>

    <!-- THÔNG TIN CHUNG -->
    <section class="thong-tin-chung">
        <h2>Thông tin chung</h2>

        <figure class="anh-chan-dung-thanh-vien">
            <img
                src="../../images/avatar-binh.jpg"
                alt="Ảnh chân dung Nguyễn Thị Ngọc Bình"
                width="200"
                height="200"
            >

            <figcaption>
                Ảnh chân dung thành viên Nguyễn Thị Ngọc Bình
                - Nhóm 04.
            </figcaption>
        </figure>

        <ul class="thong-tin-ca-nhan">
            <li>
                <strong>Họ và tên:</strong>
                Nguyễn Thị Ngọc Bình
            </li>
            <li>
                <strong>Vai trò:</strong>
                Thành viên thực hiện
            </li>
            <li>
                <strong>Nhiệm vụ chính:</strong>
                Xây dựng biểu mẫu liên hệ backend,
                xử lý upload ảnh an toàn,
                kiểm tra W3C Validator và Lighthouse,
                hoàn thiện nội dung đồ án nhóm.
            </li>
        </ul>
    </section>

    <!-- DỰ ÁN VÀ SỞ THÍCH -->
    <article class="du-an-so-thich">
        <h2>Dự án và sở thích</h2>

        <button
            type="button"
            id="nut-mo-rong"
            class="nut-mo-rong"
            aria-controls="noi-dung-du-an"
            aria-expanded="true"
        >
            ▲ Thu gọn
        </button>

        <div id="noi-dung-du-an">
            <p>
                Nguyễn Thị Ngọc Bình tham gia phát triển
                website Cook with me, nền tảng chia sẻ
                công thức nấu ăn tiện lợi và gần gũi.
            </p>

            <p>
                Công việc tập trung vào xây dựng trang cá nhân,
                hoàn thiện giao diện, kiểm thử bảo mật
                và kiểm tra chất lượng mã nguồn website.
            </p>

            <p>
                Sở thích cá nhân bao gồm tìm hiểu công nghệ web,
                ăn, ngủ, đọc sách và khám phá
                các công thức nấu ăn mới.
            </p>
        </div>
    </article>

    <!-- KỸ NĂNG -->
    <section class="ky-nang">
        <h2>Kỹ năng</h2>

        <label for="tim-ky-nang">
            Tìm kiếm kỹ năng:
        </label>

        <input
            type="search"
            id="tim-ky-nang"
            placeholder="Nhập tên kỹ năng..."
            autocomplete="off"
        >

        <ul
            class="danh-sach-ky-nang"
            id="danh-sach-ky-nang"
        >
            <li>HTML5 cơ bản và nâng cao</li>
            <li>Kiểm tra lỗi W3C Validator</li>
            <li>Tối ưu Google Lighthouse (Accessibility)</li>
            <li>Lập trình Web động với PHP và Xử lý Form</li>
            <li>Sử dụng Git và GitHub quản lý mã nguồn</li>
            <li>Làm việc nhóm và thiết kế nội dung</li>
        </ul>

        <p
            id="khong-co-ky-nang"
            class="khong-co-ky-nang"
            hidden
        >
            Không tìm thấy kỹ năng phù hợp.
        </p>
    </section>

    <!-- CHỨC NĂNG 1: LỌC ĐÁNH GIÁ THEO DANH MỤC BẰNG PDO -->
    <section class="chuc-nang-php" aria-labelledby="tieu-de-loc-mon">
        <h2 id="tieu-de-loc-mon">1. Lọc món Bình đã đánh giá theo danh mục (MySQL)</h2>
        <p>Chọn danh mục để lọc các công thức đã được Bình đánh giá.</p>
        <form method="get" action="gioithieu.php">
            <label for="danh_muc">Chọn danh mục món ăn:</label>
            <select name="danh_muc" id="danh_muc">
                <option value="0">Tất cả danh mục</option>
                <?php foreach ($danhMuc as $dm): ?>
                    <option value="<?= (int) $dm['id'] ?>" <?= $chonDanhMuc === (int) $dm['id'] ? 'selected' : '' ?>><?= e($dm['ten']) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Lọc món ăn</button>
        </form>
        <?php if ($monAnHienThi === []): ?>
            <p>Chưa có đánh giá thuộc danh mục này.</p>
        <?php else: ?>
            <ul class="ket-qua-mon-an">
                <?php foreach ($monAnHienThi as $mon): ?>
                    <li>
                        <strong><a href="<?= e($goc) ?>chi-tiet.php?id=<?= e($mon['slug']) ?>"><?= e($mon['ten_mon']) ?></a></strong>
                        — Danh mục: <em><?= e($mon['danh_muc']) ?></em>
                        — Đánh giá: <?= (int) $mon['so_sao'] ?>/5 ⭐
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>

    <!-- CHỨC NĂNG 2: QUẢN LÝ ĐÁNH GIÁ TRÊN MYSQL -->
    <section class="chuc-nang-php" aria-labelledby="tieu-de-danh-gia">
        <h2 id="tieu-de-danh-gia">2. Đánh giá công thức món ăn (MySQL, POST)</h2>
        <p>Đánh giá được lưu trong bảng <code>tv_binh_danh_gia</code>. Chỉ chủ trang được thêm, sửa hoặc xóa.</p>
        <?php if ($laChuTrang): ?>
            <form method="post" action="gioithieu.php">
                <input type="hidden" name="csrf_token" value="<?= e($csrfBinh) ?>">
                <input type="hidden" name="hanh_dong" value="them">
                <div>
                    <label for="id_mon">Chọn món ăn muốn đánh giá:</label>
                    <select name="id_mon" id="id_mon" required>
                        <option value="">-- Chọn món ăn --</option>
                        <?php foreach ($danhSachTatCa as $mon): ?>
                            <option value="<?= (int) $mon['id'] ?>"><?= e($mon['ten']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="so_sao">Chấm điểm chất lượng:</label>
                    <select name="so_sao" id="so_sao" required>
                        <option value="">-- Chọn số sao --</option>
                        <?php for ($sao = 5; $sao >= 1; $sao--): ?>
                            <option value="<?= $sao ?>"><?= $sao ?> sao</option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div>
                    <label for="nhan_xet">Nhận xét chi tiết (5–500 ký tự):</label>
                    <textarea name="nhan_xet" id="nhan_xet" rows="4" minlength="5" maxlength="500" required></textarea>
                </div>
                <button type="submit">Gửi đánh giá</button>
            </form>
        <?php else: ?>
            <p>Chỉ chủ trang đã đăng nhập và liên kết tài khoản mới được quản lý đánh giá.
            <a href="<?= e($goc) ?>dang-nhap.php">Đăng nhập</a></p>
        <?php endif; ?>

        <h3>Lịch sử đánh giá gần đây</h3>
        <?php if ($danhSachDanhGia === []): ?>
            <p>Chưa có đánh giá nào được ghi nhận.</p>
        <?php else: ?>
            <ul class="danh-sach-danh-gia">
                <?php foreach ($danhSachDanhGia as $dg): ?>
                    <li>
                        <strong><?= e($dg['ten_mon']) ?></strong>
                        — Đánh giá: <strong><?= (int) $dg['so_sao'] ?>/5 ⭐</strong>
                        <p><?= nl2br(e($dg['nhan_xet'])) ?></p>
                        <small><?= e($dg['thoi_gian']) ?></small>
                        <?php if ($laChuTrang): ?>
                            <form method="post" action="gioithieu.php">
                                <input type="hidden" name="csrf_token" value="<?= e($csrfBinh) ?>">
                                <input type="hidden" name="hanh_dong" value="sua">
                                <input type="hidden" name="danh_gia_id" value="<?= (int) $dg['id'] ?>">
                                <label for="sao-sua-<?= (int) $dg['id'] ?>">Sửa số sao:</label>
                                <select id="sao-sua-<?= (int) $dg['id'] ?>" name="so_sao">
                                    <?php for ($sao = 1; $sao <= 5; $sao++): ?>
                                        <option value="<?= $sao ?>" <?= (int) $dg['so_sao'] === $sao ? 'selected' : '' ?>><?= $sao ?> sao</option>
                                    <?php endfor; ?>
                                </select>
                                <label for="nx-sua-<?= (int) $dg['id'] ?>">Sửa nhận xét:</label>
                                <textarea id="nx-sua-<?= (int) $dg['id'] ?>" name="nhan_xet" rows="2" minlength="5" maxlength="500" required><?= e($dg['nhan_xet']) ?></textarea>
                                <button type="submit">Lưu sửa</button>
                            </form>
                            <form method="post" action="gioithieu.php">
                                <input type="hidden" name="csrf_token" value="<?= e($csrfBinh) ?>">
                                <input type="hidden" name="hanh_dong" value="xoa">
                                <input type="hidden" name="danh_gia_id" value="<?= (int) $dg['id'] ?>">
                                <button type="submit">Xóa đánh giá</button>
                            </form>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>

    <!-- THỜI KHÓA BIỂU -->
    <section class="thoi-khoa-bieu">
        <h2>Thời khóa biểu tuần</h2>

        <p>
            Bảng thời khóa biểu có thể cuộn ngang
            trên màn hình nhỏ.
        </p>

        <div class="khung-bang">
            <table>
                <caption>
                    Thời khóa biểu học tập và thực hiện
                    đồ án trong tuần
                </caption>

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
                        <td>Học tập</td>
                        <td>Thực hành chuyên môn</td>
                        <td>Làm đồ án web</td>
                    </tr>
                    <tr>
                        <th scope="row">Thứ Ba</th>
                        <td>Học tập</td>
                        <td>Nghiên cứu tài liệu</td>
                        <td>Tự học</td>
                    </tr>
                    <tr>
                        <th scope="row">Thứ Tư</th>
                        <td>Học tập</td>
                        <td>Thực hành chuyên môn</td>
                        <td>Làm đồ án web</td>
                    </tr>
                    <tr>
                        <th scope="row">Thứ Năm</th>
                        <td>Học tập</td>
                        <td>Hoạt động cá nhân</td>
                        <td>Tự học</td>
                    </tr>
                    <tr>
                        <th scope="row">Thứ Sáu</th>
                        <td>Học tập</td>
                        <td>Thực hành chuyên môn</td>
                        <td>Làm đồ án web</td>
                    </tr>
                    <tr>
                        <th scope="row">Thứ Bảy</th>
                        <td>Thể thao</td>
                        <td>Hoạt động ngoại khóa</td>
                        <td>Ôn tập</td>
                    </tr>
                    <tr>
                        <th scope="row">Chủ Nhật</th>
                        <td>Nghỉ ngơi</td>
                        <td>Đọc sách</td>
                        <td>Lên kế hoạch tuần mới</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <p class="quay-lai">
        <a href="<?= e($goc) ?>index.php">
            Quay lại trang chủ
        </a>
    </p>

</main>

<script>
(function () {
    function khoiTaoTuongTac() {

        // Thu gọn / mở rộng Dự án và sở thích
        const nutMoRong =
            document.getElementById('nut-mo-rong');

        const noiDungDuAn =
            document.getElementById('noi-dung-du-an');

        if (nutMoRong && noiDungDuAn) {
            nutMoRong.onclick = function () {
                const dangMo =
                    noiDungDuAn.style.display !== 'none';

                if (dangMo) {
                    noiDungDuAn.style.display = 'none';
                    nutMoRong.setAttribute(
                        'aria-expanded', 'false'
                    );
                    nutMoRong.textContent = '▼ Mở rộng';
                } else {
                    noiDungDuAn.style.display = 'block';
                    nutMoRong.setAttribute(
                        'aria-expanded', 'true'
                    );
                    nutMoRong.textContent = '▲ Thu gọn';
                }
            };
        }

        // Tìm kiếm kỹ năng
        const oTimKyNang =
            document.getElementById('tim-ky-nang');

        const danhSachKyNang =
            document.querySelectorAll(
                '#danh-sach-ky-nang li'
            );

        const thongBaoKhongCo =
            document.getElementById('khong-co-ky-nang');

        if (oTimKyNang && danhSachKyNang.length > 0) {
            oTimKyNang.oninput = function () {
                const tuKhoa =
                    oTimKyNang.value.toLowerCase().trim();

                let soLuongKhop = 0;

                danhSachKyNang.forEach(function (item) {
                    const noiDung =
                        item.textContent.toLowerCase();

                    if (noiDung.includes(tuKhoa)) {
                        item.style.display = '';
                        soLuongKhop++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                if (thongBaoKhongCo) {
                    thongBaoKhongCo.hidden =
                        soLuongKhop > 0;
                }
            };
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            khoiTaoTuongTac
        );
    } else {
        khoiTaoTuongTac();
    }
})();
</script>

<?php
require_once __DIR__ . '/../../inc/footer.php';
?>
