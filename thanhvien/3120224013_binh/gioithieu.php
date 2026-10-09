
<?php
// Tệp: Trang cá nhân Nguyễn Thị Ngọc Bình và hai chức năng PHP.
// Chức năng: lọc món ăn bằng GET, nhận và lưu đánh giá bằng POST.
// An toàn: kiểm tra dữ liệu phía máy chủ, xuất dữ liệu động qua e().
// Cách thử: lọc danh mục, gửi đánh giá hợp lệ/không hợp lệ và thử XSS.
// Kiểm tra: mở bằng PHP server, sau đó chạy W3C Validator trên HTML sinh ra.

$goc = '../../';

if (!function_exists('e')) {
    function e($value): string
    {
        return htmlspecialchars(
            (string) $value,
            ENT_QUOTES | ENT_SUBSTITUTE,
            'UTF-8'
        );
    }
}

$monAn = [
    ['id' => 1, 'ten' => 'Phở bò', 'loai' => 'mon-chinh'],
    ['id' => 2, 'ten' => 'Gỏi cuốn', 'loai' => 'mon-khai-vi'],
    ['id' => 3, 'ten' => 'Chè đậu xanh', 'loai' => 'trang-mieng'],
    ['id' => 4, 'ten' => 'Trà đào', 'loai' => 'do-uong'],
    ['id' => 5, 'ten' => 'Cơm chiên', 'loai' => 'mon-chinh'],
];

$danhMuc = [
    'tat-ca' => 'Tất cả món ăn',
    'mon-chinh' => 'Món chính',
    'mon-khai-vi' => 'Món khai vị',
    'trang-mieng' => 'Món tráng miệng',
    'do-uong' => 'Đồ uống',
];

// Chức năng 1: lọc món ăn bằng GET.
$chonDanhMuc = $_GET['danh_muc'] ?? 'tat-ca';

if (
    !is_string($chonDanhMuc)
    || !array_key_exists($chonDanhMuc, $danhMuc)
) {
    $chonDanhMuc = 'tat-ca';
}

$monAnHienThi = array_filter(
    $monAn,
    static function (array $mon) use ($chonDanhMuc): bool {
        return $chonDanhMuc === 'tat-ca'
            || $mon['loai'] === $chonDanhMuc;
    }
);

// Nơi lưu dữ liệu đánh giá.
$thuMucLuu = dirname(__DIR__, 2) . '/storage';
$tepDanhGia = $thuMucLuu . '/3120224013_binh_danhgia.json';

$thongBaoDanhGia = '';
$loiDanhGia = '';
$danhGia = [];

if (!is_dir($thuMucLuu)) {
    if (!@mkdir($thuMucLuu, 0755, true) && !is_dir($thuMucLuu)) {
        $loiDanhGia = 'Không thể tạo thư mục lưu dữ liệu.';
    }
}

// Hàm đọc dữ liệu đánh giá có kiểm tra cấu trúc.
$docDanhGia = static function (string $tep): array {
    if (!is_file($tep) || !is_readable($tep)) {
        return [];
    }

    $noiDung = @file_get_contents($tep);

    if (!is_string($noiDung) || trim($noiDung) === '') {
        return [];
    }

    $duLieu = json_decode($noiDung, true);

    if (!is_array($duLieu)) {
        return [];
    }

    $ketQua = [];

    foreach ($duLieu as $dg) {
        if (
            is_array($dg)
            && isset(
                $dg['ten_mon'],
                $dg['so_sao'],
                $dg['nhan_xet'],
                $dg['thoi_gian']
            )
            && is_scalar($dg['ten_mon'])
            && is_scalar($dg['so_sao'])
            && is_scalar($dg['nhan_xet'])
            && is_scalar($dg['thoi_gian'])
        ) {
            $ketQua[] = [
                'ten_mon' => (string) $dg['ten_mon'],
                'so_sao' => (int) $dg['so_sao'],
                'nhan_xet' => (string) $dg['nhan_xet'],
                'thoi_gian' => (string) $dg['thoi_gian'],
            ];
        }
    }

    return $ketQua;
};

$danhGia = $docDanhGia($tepDanhGia);

// Thông báo sau khi chuyển hướng theo PRG.
if (($_GET['danh_gia'] ?? '') === 'thanh-cong') {
    $thongBaoDanhGia = 'Đánh giá đã được lưu thành công!';
}

// Chức năng 2: nhận và kiểm tra đánh giá bằng POST.
if (
    ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST'
    && isset($_POST['gui_danh_gia'])
) {
    $idMon = $_POST['ten_mon'] ?? '';
    $soSao = $_POST['so_sao'] ?? '';
    $nhanXet = $_POST['nhan_xet'] ?? '';

    if (
        !is_string($idMon)
        || !is_string($soSao)
        || !is_string($nhanXet)
    ) {
        $loiDanhGia = 'Dữ liệu gửi lên không hợp lệ.';
    } else {
        $monDuocChon = null;

        foreach ($monAn as $mon) {
            if ((string) $mon['id'] === $idMon) {
                $monDuocChon = $mon;
                break;
            }
        }

        $soSaoHopLe = filter_var($soSao, FILTER_VALIDATE_INT);
        $nhanXet = trim($nhanXet);

        $doDaiNhanXet = function_exists('mb_strlen')
            ? mb_strlen($nhanXet, 'UTF-8')
            : strlen($nhanXet);

        if ($monDuocChon === null) {
            $loiDanhGia = 'Vui lòng chọn món ăn hợp lệ.';
        } elseif (
            $soSaoHopLe === false
            || $soSaoHopLe < 1
            || $soSaoHopLe > 5
        ) {
            $loiDanhGia = 'Số sao phải từ 1 đến 5.';
        } elseif (
            $nhanXet === ''
            || !preg_match('//u', $nhanXet)
            || $doDaiNhanXet > 500
        ) {
            $loiDanhGia = 'Nhận xét không được để trống và tối đa 500 ký tự.';
        } elseif (!is_dir($thuMucLuu) || !is_writable($thuMucLuu)) {
            $loiDanhGia = 'Không thể ghi dữ liệu vào thư mục storage.';
        } else {
            $danhGiaMoi = [
                'ten_mon' => $monDuocChon['ten'],
                'so_sao' => $soSaoHopLe,
                'nhan_xet' => $nhanXet,
                'thoi_gian' => date('d/m/Y H:i'),
            ];

            $fp = @fopen($tepDanhGia, 'c+');

            if ($fp === false) {
                $loiDanhGia = 'Không thể mở tệp lưu đánh giá.';
            } else {
                if (flock($fp, LOCK_EX)) {
                    $noiDungHienTai = stream_get_contents($fp);
                    $duLieuHienTai = [];

                    if (
                        is_string($noiDungHienTai)
                        && trim($noiDungHienTai) !== ''
                    ) {
                        $jsonHienTai = json_decode($noiDungHienTai, true);

                        if (is_array($jsonHienTai)) {
                            $duLieuHienTai = $jsonHienTai;
                        }
                    }

                    $duLieuHienTai[] = $danhGiaMoi;

                    $jsonMoi = json_encode(
                        $duLieuHienTai,
                        JSON_PRETTY_PRINT
                        | JSON_UNESCAPED_UNICODE
                        | JSON_INVALID_UTF8_SUBSTITUTE
                    );

                    rewind($fp);

                    $ghiThanhCong = is_string($jsonMoi)
                        && ftruncate($fp, 0)
                        && fwrite($fp, $jsonMoi) !== false
                        && fflush($fp);

                    flock($fp, LOCK_UN);
                    fclose($fp);

                    if ($ghiThanhCong) {
                        // PRG: chuyển hướng sau POST thành công.
                        $duongDan = parse_url(
                            $_SERVER['REQUEST_URI'] ?? '',
                            PHP_URL_PATH
                        );

                        if (!is_string($duongDan) || $duongDan === '') {
                            $duongDan = 'gioithieu.php';
                        }

                        header(
                            'Location: ' . $duongDan . '?danh_gia=thanh-cong',
                            true,
                            303
                        );
                        exit;
                    }

                    $loiDanhGia = 'Không thể lưu đánh giá. Vui lòng thử lại.';
                } else {
                    fclose($fp);
                    $loiDanhGia = 'Không thể khóa tệp lưu đánh giá.';
                }
            }
        }
    }
}

$danhGia = $docDanhGia($tepDanhGia);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Trang cá nhân Nguyễn Thị Ngọc Bình, thành viên Nhóm 04 thực hiện website Cook with me.">
    <title>Thông tin cá nhân - Nguyễn Thị Ngọc Bình | Cook with me</title>

    <link rel="stylesheet" href="../../css/01-bien.css">
    <link rel="stylesheet" href="../../css/02-chuan-hoa.css">
    <link rel="stylesheet" href="../../css/03-bo-cuc.css">
    <link rel="stylesheet" href="../../css/04-thanh-phan.css">
    <link rel="stylesheet" href="../../css/05-tien-ich.css">
    <link rel="stylesheet" href="trang-ca-nhan.css">

    <style>
        .chuc-nang-php {
            margin: 24px 0;
            padding: 20px;
            border: 1px solid var(--mau-vien, #ddd);
            border-radius: var(--bo-goc, 12px);
            background: var(--mau-nen, #fff);
            min-width: 0;
            overflow-wrap: anywhere;
        }

        .chuc-nang-php form > div {
            margin: 12px 0;
        }

        .chuc-nang-php label {
            display: block;
            margin-bottom: 6px;
        }

        .chuc-nang-php select,
        .chuc-nang-php textarea {
            max-width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .chuc-nang-php textarea {
            width: 100%;
            resize: vertical;
        }

        .chuc-nang-php button {
            margin-top: 8px;
            padding: 9px 14px;
            cursor: pointer;
        }

        .thong-bao-thanh-cong {
            color: #176b35;
            font-weight: bold;
        }

        .thong-bao-loi {
            color: #b00020;
            font-weight: bold;
        }

        .ket-qua-mon-an li,
        .danh-sach-danh-gia li {
            margin: 10px 0;
        }
    </style>
</head>
<body class="trang">
    <header class="dau-trang">
        <p class="thuong-hieu">
            <img src="../../images/icons/chef.svg" alt="" class="logo-icon">
            <span class="khoi-chu-logo">
                <span class="ten-website">Cook with me</span>
                <span class="slogan">Khơi nguồn cảm hứng vào bếp</span>
            </span>
        </p>

        <form class="o-tim-kiem" action="../../danh-sach.php" method="get">
            <label for="search">Tìm kiếm</label>
            <input type="search" id="search" name="keyword" placeholder="Tìm kiếm món ăn, công thức..." autocomplete="off">
            <button class="nut" type="submit">Tìm kiếm</button>
        </form>

        <div class="khu-vuc-tai-khoan"></div>
    </header>

    <nav class="thanh-dieu-huong" aria-label="Điều hướng chính">
        <ul class="menu">
            <li><a href="../../index.php">Trang chủ</a></li>
            <li><a href="../../danh-sach.php">Khám phá</a></li>
            <li><a href="../../chi-tiet.php">Chi tiết công thức</a></li>
            <li><a href="../../goi-y-mon-an.php">Gợi ý món ăn</a></li>
            <li><a href="../../cai-dat.php">Cài đặt</a></li>
            <li><a href="../../gioi-thieu.php">Giới thiệu</a></li>
            <li><a href="../../lien-he.php">Liên hệ</a></li>
        </ul>

        <div class="khu-vuc-yeu-thich">
            <span class="nhan-yeu-thich">Yêu thích</span>
            <span class="so-luong-yeu-thich" role="status" aria-label="Số món ăn yêu thích">0</span>
        </div>
    </nav>

    <main class="ho-so-trang">
        <h1 class="tieu-de-ho-so">Hồ sơ thành viên: Nguyễn Thị Ngọc Bình</h1>

        <section class="chuc-nang-php" aria-labelledby="tieu-de-loc-mon">
            <h2 id="tieu-de-loc-mon">Khám phá món ăn theo danh mục</h2>
            <p>Chọn danh mục để lọc các món ăn phù hợp.</p>

            <form method="get">
                <label for="danh_muc">Danh mục món ăn:</label>
                <select name="danh_muc" id="danh_muc">
                    <?php foreach ($danhMuc as $ma => $ten): ?>
                        <option value="<?= e($ma) ?>" <?= $chonDanhMuc === $ma ? 'selected' : '' ?>>
                            <?= e($ten) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Lọc món ăn</button>
            </form>

            <ul class="ket-qua-mon-an">
                <?php foreach ($monAnHienThi as $mon): ?>
                    <li>
                        <strong><?= e($mon['ten']) ?></strong>
                        — <?= e($danhMuc[$mon['loai']] ?? 'Danh mục khác') ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <?php if (count($monAnHienThi) === 0): ?>
                <p>Không tìm thấy món ăn phù hợp.</p>
            <?php endif; ?>
        </section>

        <section class="chuc-nang-php" aria-labelledby="tieu-de-danh-gia">
            <h2 id="tieu-de-danh-gia">Đánh giá món ăn</h2>
            <p>Chia sẻ cảm nhận của bạn về món ăn yêu thích.</p>

            <?php if ($thongBaoDanhGia !== ''): ?>
                <p class="thong-bao-thanh-cong" role="status"><?= e($thongBaoDanhGia) ?></p>
            <?php endif; ?>

            <?php if ($loiDanhGia !== ''): ?>
                <p class="thong-bao-loi" role="alert"><?= e($loiDanhGia) ?></p>
            <?php endif; ?>

            <form method="post">
                <div>
                    <label for="ten_mon">Chọn món ăn:</label>
                    <select name="ten_mon" id="ten_mon" required>
                        <option value="">-- Chọn món ăn --</option>
                        <?php foreach ($monAn as $mon): ?>
                            <option value="<?= e($mon['id']) ?>"><?= e($mon['ten']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="so_sao">Số sao (1–5):</label>
                    <select name="so_sao" id="so_sao" required>
                        <option value="">-- Chọn số sao --</option>
                        <option value="5">5 sao</option>
                        <option value="4">4 sao</option>
                        <option value="3">3 sao</option>
                        <option value="2">2 sao</option>
                        <option value="1">1 sao</option>
                    </select>
                </div>

                <div>
                    <label for="nhan_xet">Nhận xét (tối đa 500 ký tự):</label>
                    <textarea name="nhan_xet" id="nhan_xet" rows="4" maxlength="500" required></textarea>
                </div>

                <button type="submit" name="gui_danh_gia" value="1">Gửi đánh giá</button>
            </form>

            <h3>Đánh giá đã gửi</h3>

            <?php if (count($danhGia) === 0): ?>
                <p>Chưa có đánh giá nào.</p>
            <?php else: ?>
                <ul class="danh-sach-danh-gia">
                    <?php foreach (array_reverse($danhGia) as $dg): ?>
                        <li>
                            <strong><?= e($dg['ten_mon']) ?></strong>
                            — <?= e($dg['so_sao']) ?>/5 sao
                            <p><?= nl2br(e($dg['nhan_xet'])) ?></p>
                            <small><?= e($dg['thoi_gian']) ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <section class="thong-tin-chung">
            <h2>Thông tin chung</h2>

            <figure class="anh-dai-dien">
                <img src="../../images/avatar-binh.jpg" alt="Ảnh chân dung thành viên Nguyễn Thị Ngọc Bình" width="200" height="200">
                <figcaption>Ảnh chân dung thành viên Nguyễn Thị Ngọc Bình - Nhóm 04.</figcaption>
            </figure>

            <ul class="thong-tin-ca-nhan">
                <li><strong>Họ và tên:</strong> Nguyễn Thị Ngọc Bình</li>
                <li><strong>Vai trò:</strong> Thành viên thực hiện</li>
                <li><strong>Nhiệm vụ chính:</strong> Xây dựng trang cá nhân, kiểm tra W3C Validator và Lighthouse, phối hợp hoàn thiện nội dung đồ án nhóm.</li>
            </ul>
        </section>

        <article class="du-an-so-thich">
            <h2>Dự án và sở thích</h2>
            <button type="button" id="nut-mo-rong" class="nut-mo-rong" aria-controls="noi-dung-du-an" aria-expanded="true">▲ Thu gọn</button>
            <div id="noi-dung-du-an">
                <p>Nguyễn Thị Ngọc Bình tham gia phát triển website Cook with me, nền tảng chia sẻ công thức nấu ăn tiện lợi và gần gũi.</p>
                <p>Công việc tập trung vào xây dựng trang cá nhân, hoàn thiện giao diện và kiểm tra chất lượng mã nguồn website.</p>
                <p>Sở thích cá nhân bao gồm tìm hiểu công nghệ web, ăn, ngủ, đọc sách và khám phá các công thức nấu ăn mới.</p>
            </div>
        </article>

        <section class="ky-nang">
            <h2>Kỹ năng</h2>
            <label for="tim-ky-nang">Tìm kiếm kỹ năng:</label>
            <input type="search" id="tim-ky-nang" placeholder="Nhập tên kỹ năng..." autocomplete="off">

            <ul class="danh-sach-ky-nang">
                <li>HTML5 cơ bản và nâng cao</li>
                <li>Kiểm tra lỗi W3C Validator</li>
                <li>Tối ưu Google Lighthouse (Accessibility)</li>
                <li>Sử dụng Git và GitHub quản lý mã nguồn</li>
                <li>Làm việc nhóm và thiết kế nội dung</li>
            </ul>

            <p id="khong-co-ky-nang" class="khong-co-ky-nang" hidden>Không tìm thấy kỹ năng phù hợp.</p>
        </section>

        <section class="thoi-khoa-bieu">
            <h2>Thời khóa biểu tuần</h2>
            <p>Bảng thời khóa biểu có thể cuộn ngang trên màn hình nhỏ.</p>

            <div class="khung-bang">
                <table>
                    <caption>Thời khóa biểu học tập và thực hiện đồ án trong tuần</caption>
                    <thead>
                        <tr>
                            <th scope="col">Ngày</th>
                            <th scope="col">Buổi sáng</th>
                            <th scope="col">Buổi chiều</th>
                            <th scope="col">Buổi tối</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><th scope="row">Thứ Hai</th><td>Học tập</td><td>Thực hành chuyên môn</td><td>Làm đồ án web</td></tr>
                        <tr><th scope="row">Thứ Ba</th><td>Học tập</td><td>Nghiên cứu tài liệu</td><td>Tự học</td></tr>
                        <tr><th scope="row">Thứ Tư</th><td>Học tập</td><td>Thực hành chuyên môn</td><td>Làm đồ án web</td></tr>
                        <tr><th scope="row">Thứ Năm</th><td>Học tập</td><td>Hoạt động cá nhân</td><td>Tự học</td></tr>
                        <tr><th scope="row">Thứ Sáu</th><td>Học tập</td><td>Thực hành chuyên môn</td><td>Làm đồ án web</td></tr>
                        <tr><th scope="row">Thứ Bảy</th><td>Thể thao</td><td>Hoạt động ngoại khóa</td><td>Ôn tập</td></tr>
                        <tr><th scope="row">Chủ Nhật</th><td>Nghỉ ngơi</td><td>Đọc sách</td><td>Lên kế hoạch tuần mới</td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        <p class="quay-lai"><a href="../../index.php">Quay lại trang chủ</a></p>
    </main>

    <footer>
        <p>&copy; 2026 Cook with me - Nhóm 04</p>
        <nav aria-label="Điều hướng phụ">
            <ul class="menu">
                <li><a href="../../gioi-thieu.php">Giới thiệu</a></li>
                <li><a href="../../lien-he.php">Liên hệ</a></li>
            </ul>
        </nav>
    </footer>

    <script type="module" src="../../js/main.js"></script>
    <script type="module" src="js/canhan.js"></script>
</body>
</html>