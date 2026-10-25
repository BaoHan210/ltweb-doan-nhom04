
<?php
// Trang cá nhân Nguyễn Thị Ngọc Bình - Nhóm 04
// Chức năng 1: Lọc món ăn theo danh mục (GET)
// Chức năng 2: Đánh giá món ăn (POST, PRG)

use App\Data\KhoMonAn;

$goc = '../../';

require_once __DIR__ . '/../../inc/config.php';
require_once __DIR__ . '/../../inc/db.php';

// Đọc dữ liệu món ăn từ MySQL qua PDO
$kho = new KhoMonAn(db());
$danhSachTatCa = $kho->layTatCa();

$danhMucChuan = [
    'tat-ca' => 'Tất cả danh mục',
    'Món chính' => 'Món chính',
    'Món khai vị' => 'Món khai vị',
    'Món canh' => 'Món canh',
    'Món xào' => 'Món xào',
    'Món rau' => 'Món rau',
    'Món tráng miệng' => 'Món tráng miệng',
    'Đồ uống' => 'Đồ uống',
    'Món chay' => 'Món chay'
];

// CHỨC NĂNG 1: LỌC MÓN ĂN
$chonDanhMuc = $_GET['danh_muc'] ?? 'tat-ca';

if (
    !is_string($chonDanhMuc) ||
    !array_key_exists($chonDanhMuc, $danhMucChuan)
) {
    $chonDanhMuc = 'tat-ca';
}

$monAnHienThi = array_filter(
    $danhSachTatCa,
    static function ($mon) use ($chonDanhMuc): bool {
        return $chonDanhMuc === 'tat-ca'
            || $mon->danhMuc === $chonDanhMuc;
    }
);

// CHỨC NĂNG 2: ĐÁNH GIÁ MÓN ĂN
$thuMucLuu = __DIR__ . '/../../storage';
$tepDanhGia = $thuMucLuu . '/3120224013_binh_danhgia.json';

if (!is_dir($thuMucLuu)) {
    mkdir($thuMucLuu, 0755, true);
}

if (
    ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' &&
    isset($_POST['gui_danh_gia'])
) {
    $idMonGui = $_POST['id_mon'] ?? '';
    $nhanXetGui = $_POST['nhan_xet'] ?? '';

    $idMon = is_string($idMonGui)
        ? trim($idMonGui) : '';

    $nhanXet = is_string($nhanXetGui)
        ? trim($nhanXetGui) : '';

    $soSao = filter_var(
        $_POST['so_sao'] ?? null,
        FILTER_VALIDATE_INT
    );

    $doDai = mb_strlen($nhanXet, 'UTF-8');

    $tenMonDuocChon = null;

    foreach ($danhSachTatCa as $mon) {
        if ((string)$mon->id === $idMon) {
            $tenMonDuocChon = $mon->ten;
            break;
        }
    }

    if ($tenMonDuocChon === null) {
        gan_thong_bao(
            'error',
            'Vui lòng chọn món ăn hợp lệ!'
        );
    } elseif (
        $soSao === false ||
        $soSao < 1 ||
        $soSao > 5
    ) {
        gan_thong_bao(
            'error',
            'Số sao phải từ 1 đến 5!'
        );
    } elseif (
        $nhanXet === '' ||
        $doDai < 5 ||
        $doDai > 500
    ) {
        gan_thong_bao(
            'error',
            'Nhận xét phải từ 5 đến 500 ký tự!'
        );
    } else {
        $danhGiaMoi = [
            'id_mon' => $idMon,
            'ten_mon' => $tenMonDuocChon,
            'so_sao' => $soSao,
            'nhan_xet' => $nhanXet,
            'thoi_gian' => date('d/m/Y H:i')
        ];

        $fp = fopen($tepDanhGia, 'c+');
        $daLuu = false;

        if ($fp !== false) {
            if (flock($fp, LOCK_EX)) {
                rewind($fp);
                $noiDungCu = stream_get_contents($fp);
                $duLieuCu = [];

                if (
                    is_string($noiDungCu) &&
                    trim($noiDungCu) !== ''
                ) {
                    $jsonCu = json_decode($noiDungCu, true);

                    if (is_array($jsonCu)) {
                        $duLieuCu = $jsonCu;
                    }
                }

                $duLieuCu[] = $danhGiaMoi;

                $jsonMoi = json_encode(
                    $duLieuCu,
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                );

                if ($jsonMoi !== false) {
                    rewind($fp);
                    $daXoa = ftruncate($fp, 0);

                    if ($daXoa) {
                        $soByte = fwrite($fp, $jsonMoi);
                        fflush($fp);

                        $daLuu = $soByte !== false
                            && $soByte === strlen($jsonMoi);
                    }
                }

                flock($fp, LOCK_UN);
            }

            fclose($fp);
        }

        if ($daLuu) {
            gan_thong_bao(
                'success',
                'Đánh giá món ăn đã được lưu thành công!'
            );
        } else {
            gan_thong_bao(
                'error',
                'Không thể lưu đánh giá lúc này.'
            );
        }
    }

    $query = $chonDanhMuc !== 'tat-ca'
        ? '?danh_muc=' . urlencode($chonDanhMuc)
        : '';

    chuyen_huong('gioithieu.php' . $query);
}

// Đọc danh sách đánh giá
$danhSachDanhGia = [];

if (is_file($tepDanhGia) && is_readable($tepDanhGia)) {
    $noiDung = file_get_contents($tepDanhGia);
    $duLieu = json_decode($noiDung ?: '', true);

    if (is_array($duLieu)) {
        $danhSachDanhGia = $duLieu;
    }
}

// Cấu hình trang và CSS riêng
$tieuDe = 'Thông tin cá nhân - Nguyễn Thị Ngọc Bình';
$trang = 'gioi-thieu';
$cssRieng = $goc .
    'thanhvien/3120224013_binh/trang-ca-nhan.css';

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

    <!-- CHỨC NĂNG 1: LỌC MÓN ĂN -->
    <section
        class="chuc-nang-php"
        aria-labelledby="tieu-de-loc-mon"
    >
        <h2 id="tieu-de-loc-mon">
            1. Khám phá món ăn theo danh mục (PHP GET)
        </h2>

        <p>
            Chọn danh mục để lọc các món ăn từ
            kho dữ liệu máy chủ.
        </p>

        <form method="get" action="gioithieu.php">
            <div>
                <label for="danh_muc">
                    Chọn danh mục món ăn:
                </label>

                <select name="danh_muc" id="danh_muc">
                    <?php foreach ($danhMucChuan as $ma => $ten): ?>
                        <option
                            value="<?= e($ma) ?>"
                            <?= $chonDanhMuc === $ma ? 'selected' : '' ?>
                        >
                            <?= e($ten) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit">
                    Lọc món ăn
                </button>
            </div>
        </form>

        <ul class="ket-qua-mon-an">
            <?php foreach ($monAnHienThi as $mon): ?>
                <li>
                    <strong>
                        <a
                            href="<?= e($goc) ?>chi-tiet.php?id=<?= e($mon->id) ?>"
                            style="color:inherit;text-decoration:none;"
                        >
                            <?= e($mon->ten) ?>
                        </a>
                    </strong>

                    — Danh mục:
                    <em><?= e($mon->danhMuc) ?></em>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if (count($monAnHienThi) === 0): ?>
            <p>
                Không tìm thấy món ăn nào thuộc danh mục này.
            </p>
        <?php endif; ?>
    </section>

    <!-- CHỨC NĂNG 2: ĐÁNH GIÁ MÓN ĂN -->
    <section
        class="chuc-nang-php"
        aria-labelledby="tieu-de-danh-gia"
    >
        <h2 id="tieu-de-danh-gia">
            2. Đánh giá công thức món ăn (PHP POST)
        </h2>

        <p>
            Chia sẻ cảm nhận và đánh giá chất lượng
            các công thức món ăn.
        </p>

        <form method="post" action="gioithieu.php">
            <div>
                <label for="id_mon">
                    Chọn món ăn muốn đánh giá:
                </label>

                <select name="id_mon" id="id_mon" required>
                    <option value="">
                        -- Chọn món ăn --
                    </option>

                    <?php foreach ($danhSachTatCa as $mon): ?>
                        <option value="<?= e($mon->id) ?>">
                            <?= e($mon->ten) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="so_sao">
                    Chấm điểm chất lượng:
                </label>

                <select name="so_sao" id="so_sao" required>
                    <option value="">
                        -- Chọn số sao --
                    </option>
                    <option value="5">
                        ⭐⭐⭐⭐⭐ (5 sao - Tuyệt vời)
                    </option>
                    <option value="4">
                        ⭐⭐⭐⭐ (4 sao - Rất ngon)
                    </option>
                    <option value="3">
                        ⭐⭐⭐ (3 sao - Tạm ổn)
                    </option>
                    <option value="2">
                        ⭐⭐ (2 sao - Cần cải thiện)
                    </option>
                    <option value="1">
                        ⭐ (1 sao - Không đạt)
                    </option>
                </select>
            </div>

            <div>
                <label for="nhan_xet">
                    Nhận xét chi tiết (5–500 ký tự):
                </label>

                <textarea
                    name="nhan_xet"
                    id="nhan_xet"
                    rows="4"
                    maxlength="500"
                    placeholder="Viết cảm nhận về hương vị, nguyên liệu, cách làm..."
                    required
                ></textarea>
            </div>

            <button
                type="submit"
                name="gui_danh_gia"
                value="1"
            >
                Gửi đánh giá
            </button>
        </form>

        <h3>Lịch sử đánh giá gần đây</h3>

        <?php if (count($danhSachDanhGia) === 0): ?>
            <p>Chưa có đánh giá nào được ghi nhận.</p>
        <?php else: ?>
            <ul class="danh-sach-danh-gia">
                <?php foreach (array_reverse($danhSachDanhGia) as $dg): ?>
                    <li>
                        <strong>
                            <?= e($dg['ten_mon'] ?? '') ?>
                        </strong>

                        — Đánh giá:
                        <strong>
                            <?= e($dg['so_sao'] ?? '') ?>/5 ⭐
                        </strong>

                        <p>
                            <?= nl2br(e($dg['nhan_xet'] ?? '')) ?>
                        </p>

                        <small>
                            <?= e($dg['thoi_gian'] ?? '') ?>
                        </small>
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
