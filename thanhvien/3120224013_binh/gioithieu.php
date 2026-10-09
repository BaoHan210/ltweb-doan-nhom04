<?php
// Tệp: gioithieu.php - Trang cá nhân Nguyễn Thị Ngọc Bình (Nhóm 04)
// Chức năng PHP:
//   1. Lọc công thức món ăn theo danh mục bằng GET.
//   2. Gửi và lưu đánh giá công thức món ăn bằng POST (áp dụng PRG).
// Tái sử dụng: nạp header.php, footer.php và KhoMonAn qua Composer PSR-4.

$goc = '../../';
require_once __DIR__ . '/../../inc/config.php';

use App\Data\KhoMonAn;

// 1. Đọc dữ liệu món ăn từ data/mon-an.json thông qua KhoMonAn
$tepJson = __DIR__ . '/../../data/mon-an.json';
$danhSachTatCa = [];

if (class_exists(KhoMonAn::class) && is_file($tepJson)) {
    $kho = new KhoMonAn($tepJson);
    $danhSachTatCa = $kho->layTatCa();
} else {
    // Dữ liệu dự phòng nếu chưa nạp được KhoMonAn
    $danhSachTatCa = [
        (object)['id' => 'pho-bo', 'ten' => 'Phở bò', 'danhMuc' => 'Món chính', 'thoiGian' => 60],
        (object)['id' => 'goi-cuon', 'ten' => 'Gỏi cuốn', 'danhMuc' => 'Món khai vị', 'thoiGian' => 30],
        (object)['id' => 'che-dau-xanh', 'ten' => 'Chè đậu xanh', 'danhMuc' => 'Món tráng miệng', 'thoiGian' => 45],
        (object)['id' => 'tra-dao', 'ten' => 'Trà đào', 'danhMuc' => 'Đồ uống', 'thoiGian' => 15],
        (object)['id' => 'com-chien', 'ten' => 'Cơm chiên', 'danhMuc' => 'Món chính', 'thoiGian' => 25],
    ];
}

$danhMucChuan = [
    'tat-ca'         => 'Tất cả danh mục',
    'Món chính'      => 'Món chính',
    'Món khai vị'    => 'Món khai vị',
    'Món canh'       => 'Món canh',
    'Món xào'        => 'Món xào',
    'Món rau'        => 'Món rau',
    'Món tráng miệng'=> 'Món tráng miệng',
    'Đồ uống'        => 'Đồ uống',
    'Món chay'       => 'Món chay'
];

// CHỨC NĂNG 1: LỌC MÓN ĂN THEO DANH MỤC BẰNG GET
$chonDanhMuc = trim($_GET['danh_muc'] ?? 'tat-ca');
if (!array_key_exists($chonDanhMuc, $danhMucChuan)) {
    $chonDanhMuc = 'tat-ca';
}

$monAnHienThi = array_filter(
    $danhSachTatCa,
    static function ($mon) use ($chonDanhMuc): bool {
        if ($chonDanhMuc === 'tat-ca') {
            return true;
        }
        $dm = is_object($mon) ? ($mon->danhMuc ?? '') : ($mon['danhMuc'] ?? $mon['loai'] ?? '');
        return $dm === $chonDanhMuc;
    }
);

// CHỨC NĂNG 2: TIẾP NHẬN VÀ LƯU ĐÁNH GIÁ BẰNG POST (MÔ HÌNH PRG)
$thuMucLuu = __DIR__ . '/../../storage';
$tepDanhGia = $thuMucLuu . '/3120224013_binh_danhgia.json';

if (!is_dir($thuMucLuu)) {
    @mkdir($thuMucLuu, 0755, true);
}

// Xử lý POST gửi đánh giá
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && isset($_POST['gui_danh_gia'])) {
    $idMon   = trim($_POST['id_mon'] ?? '');
    $soSao   = filter_var($_POST['so_sao'] ?? 0, FILTER_VALIDATE_INT);
    $nhanXet = trim($_POST['nhan_xet'] ?? '');
    $doDai   = mb_strlen($nhanXet, 'UTF-8');

    // Tìm tên món ăn hợp lệ từ ID
    $tenMonDuocChon = null;
    foreach ($danhSachTatCa as $m) {
        $mId = is_object($m) ? (string)$m->id : (string)$m['id'];
        $mTen = is_object($m) ? $m->ten : $m['ten'];
        if ($mId === $idMon) {
            $tenMonDuocChon = $mTen;
            break;
        }
    }

    if ($tenMonDuocChon === null) {
        gan_thong_bao('error', 'Vui lòng chọn món ăn hợp lệ từ danh sách!');
    } elseif ($soSao === false || $soSao < 1 || $soSao > 5) {
        gan_thong_bao('error', 'Số sao đánh giá phải từ 1 đến 5 sao!');
    } elseif ($nhanXet === '' || $doDai < 5 || $doDai > 500) {
        gan_thong_bao('error', 'Nội dung nhận xét phải từ 5 đến 500 ký tự!');
    } else {
        $danhGiaMoi = [
            'id_mon'    => $idMon,
            'ten_mon'   => $tenMonDuocChon,
            'so_sao'    => $soSao,
            'nhan_xet'  => $nhanXet,
            'thoi_gian' => date('d/m/Y H:i')
        ];

        $fp = @fopen($tepDanhGia, 'c+');
        if ($fp && flock($fp, LOCK_EX)) {
            $noiDungHienTai = stream_get_contents($fp);
            $duLieuCu = [];
            if (is_string($noiDungHienTai) && trim($noiDungHienTai) !== '') {
                $jsonCu = json_decode($noiDungHienTai, true);
                if (is_array($jsonCu)) {
                    $duLieuCu = $jsonCu;
                }
            }

            $duLieuCu[] = $danhGiaMoi;
            $jsonMoi = json_encode($duLieuCu, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            rewind($fp);
            ftruncate($fp, 0);
            fwrite($fp, $jsonMoi);
            fflush($fp);
            flock($fp, LOCK_UN);
            fclose($fp);

            gan_thong_bao('success', 'Đánh giá món ăn của bạn đã được lưu thành công!');
        } else {
            if ($fp) {
                fclose($fp);
            }
            gan_thong_bao('error', 'Hệ thống bận, không thể lưu đánh giá lúc này.');
        }

        // Chuyển hướng PRG để chống gửi lặp dữ liệu khi F5
        chuyen_huong('gioithieu.php' . ($chonDanhMuc !== 'tat-ca' ? '?danh_muc=' . urlencode($chonDanhMuc) : ''));
    }
}

// Đọc danh sách đánh giá đã lưu
$danhSachDanhGia = [];
if (is_file($tepDanhGia) && is_readable($tepDanhGia)) {
    $noiDungFile = file_get_contents($tepDanhGia);
    $arr = json_decode($noiDungFile, true);
    if (is_array($arr)) {
        $danhSachDanhGia = $arr;
    }
}

// Cấu hình tiêu đề trang và nạp Header dùng chung
$tieuDe = 'Thông tin cá nhân - Nguyễn Thị Ngọc Bình';
$trang = 'gioi-thieu';
$customJS = 'thanhvien/3120224013_binh/js/canhan.js';

require_once __DIR__ . '/../../inc/header.php';
?>

<link rel="stylesheet" href="trang-ca-nhan.css">

<style>
    .chuc-nang-php {
        margin: 24px 0;
        padding: 20px;
        border: 1px solid var(--mau-vien, #ddd);
        border-radius: var(--bo-goc, 12px);
        background: var(--mau-nen, #fff);
        overflow-wrap: anywhere;
    }
    .chuc-nang-php form > div {
        margin: 12px 0;
    }
    .chuc-nang-php label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
    }
    .chuc-nang-php select,
    .chuc-nang-php textarea {
        max-width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 6px;
        box-sizing: border-box;
    }
    .chuc-nang-php textarea {
        width: 100%;
        resize: vertical;
    }
    .chuc-nang-php button {
        margin-top: 8px;
        padding: 9px 16px;
        cursor: pointer;
        background-color: #2e7d32;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-weight: bold;
    }
    .chuc-nang-php button:hover {
        background-color: #1b5e20;
    }
    .ket-qua-mon-an, .danh-sach-danh-gia {
        list-style: none;
        padding-left: 0;
    }
    .ket-qua-mon-an li, .danh-sach-danh-gia li {
        margin: 12px 0;
        padding: 12px;
        background: #f9f9f9;
        border-radius: 8px;
        border-left: 4px solid #2e7d32;
    }
</style>

<main class="ho-so-trang container">
    <h1 class="tieu-de-ho-so">Hồ sơ thành viên: Nguyễn Thị Ngọc Bình</h1>

    <?php if (function_exists('hien_thi_thong_bao')): ?>
        <?= hien_thi_thong_bao() ?>
    <?php endif; ?>

    <!-- CHỨC NĂNG 1: LỌC MÓN ĂN THEO DANH MỤC BẰNG PHP -->
    <section class="chuc-nang-php" aria-labelledby="tieu-de-loc-mon">
        <h2 id="tieu-de-loc-mon">1. Khám phá món ăn theo danh mục (PHP GET)</h2>
        <p>Chọn danh mục để lọc các món ăn từ kho dữ liệu máy chủ.</p>

        <form method="get" action="gioithieu.php">
            <div>
                <label for="danh_muc">Chọn danh mục món ăn:</label>
                <select name="danh_muc" id="danh_muc">
                    <?php foreach ($danhMucChuan as $ma => $ten): ?>
                        <option value="<?= e($ma) ?>" <?= $chonDanhMuc === $ma ? 'selected' : '' ?>>
                            <?= e($ten) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Lọc món ăn</button>
            </div>
        </form>

        <ul class="ket-qua-mon-an">
            <?php foreach ($monAnHienThi as $mon): ?>
                <?php 
                    $mTen = is_object($mon) ? $mon->ten : $mon['ten'];
                    $mDm  = is_object($mon) ? ($mon->danhMuc ?? '') : ($mon['danhMuc'] ?? $mon['loai'] ?? '');
                    $mId  = is_object($mon) ? $mon->id : $mon['id'];
                ?>
                <li>
                    <strong>
                        <a href="<?= $goc ?>chi-tiet.php?id=<?= e($mId) ?>" style="color: inherit; text-decoration: none;">
                            <?= e($mTen) ?>
                        </a>
                    </strong>
                    — Danh mục: <em><?= e($mDm) ?></em>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if (count($monAnHienThi) === 0): ?>
            <p>Không tìm thấy món ăn nào thuộc danh mục này.</p>
        <?php endif; ?>
    </section>

    <!-- CHỨC NĂNG 2: ĐÁNH GIÁ CÔNG THỨC MÓN ĂN BẰNG PHP -->
    <section class="chuc-nang-php" aria-labelledby="tieu-de-danh-gia">
        <h2 id="tieu-de-danh-gia">2. Đánh giá công thức món ăn (PHP POST)</h2>
        <p>Chia sẻ cảm nhận và đánh giá chất lượng các công thức món ăn.</p>

        <form method="post" action="gioithieu.php">
            <div>
                <label for="id_mon">Chọn món ăn muốn đánh giá:</label>
                <select name="id_mon" id="id_mon" required>
                    <option value="">-- Chọn món ăn --</option>
                    <?php foreach ($danhSachTatCa as $m): ?>
                        <?php 
                            $mId  = is_object($m) ? $m->id : $m['id'];
                            $mTen = is_object($m) ? $m->ten : $m['ten'];
                        ?>
                        <option value="<?= e($mId) ?>"><?= e($mTen) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="so_sao">Chấm điểm chất lượng:</label>
                <select name="so_sao" id="so_sao" required>
                    <option value="">-- Chọn số sao --</option>
                    <option value="5">⭐⭐⭐⭐⭐ (5 sao - Tuyệt vời)</option>
                    <option value="4">⭐⭐⭐⭐ (4 sao - Rất ngon)</option>
                    <option value="3">⭐⭐⭐ (3 sao - Tạm ổn)</option>
                    <option value="2">⭐⭐ (2 sao - Cần cải thiện)</option>
                    <option value="1">⭐ (1 sao - Không đạt)</option>
                </select>
            </div>

            <div>
                <label for="nhan_xet">Nhận xét chi tiết (5–500 ký tự):</label>
                <textarea name="nhan_xet" id="nhan_xet" rows="4" maxlength="500" placeholder="Viết cảm nhận về hương vị, nguyên liệu, cách làm..." required></textarea>
            </div>

            <button type="submit" name="gui_danh_gia" value="1">Gửi đánh giá</button>
        </form>

        <h3 style="margin-top: 24px;">Lịch sử đánh giá gần đây</h3>

        <?php if (count($danhSachDanhGia) === 0): ?>
            <p>Chưa có đánh giá nào được ghi nhận.</p>
        <?php else: ?>
            <ul class="danh-sach-danh-gia">
                <?php foreach (array_reverse($danhSachDanhGia) as $dg): ?>
                    <li>
                        <strong><?= e($dg['ten_mon']) ?></strong>
                        — Đánh giá: <strong><?= e($dg['so_sao']) ?>/5 ⭐</strong>
                        <p style="margin: 8px 0;"><?= nl2br(e($dg['nhan_xet'])) ?></p>
                        <small style="color: #666;"><?= e($dg['thoi_gian']) ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>

    <!-- THÔNG TIN CÁ NHÂN -->
    <section class="thong-tin-chung">
        <h2>Thông tin chung</h2>
        <figure class="anh-dai-dien">
            <img src="../../images/avatar-binh.jpg" alt="Ảnh chân dung thành viên Nguyễn Thị Ngọc Bình" width="200" height="200">
            <figcaption>Ảnh chân dung thành viên Nguyễn Thị Ngọc Bình - Nhóm 04.</figcaption>
        </figure>

        <ul class="thong-tin-ca-nhan">
            <li><strong>Họ và tên:</strong> Nguyễn Thị Ngọc Bình</li>
            <li><strong>Vai trò:</strong> Thành viên thực hiện</li>
            <li><strong>Nhiệm vụ chính:</strong> Xây dựng biểu mẫu liên hệ backend, xử lý upload ảnh an toàn, kiểm tra W3C Validator và Lighthouse, hoàn thiện nội dung đồ án nhóm.</li>
        </ul>
    </section>

    <article class="du-an-so-thich">
        <h2>Dự án và sở thích</h2>
        <button type="button" id="nut-mo-rong" class="nut-mo-rong" aria-controls="noi-dung-du-an" aria-expanded="true">▲ Thu gọn</button>
        <div id="noi-dung-du-an">
            <p>Nguyễn Thị Ngọc Bình tham gia phát triển website Cook with me, nền tảng chia sẻ công thức nấu ăn tiện lợi và gần gũi.</p>
            <p>Công việc tập trung vào xây dựng trang cá nhân, hoàn thiện giao diện, kiểm thử bảo mật và kiểm tra chất lượng mã nguồn website.</p>
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
            <li>Lập trình Web động với PHP và Xử lý Form</li>
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

    <p class="quay-lai"><a href="<?= $goc ?>index.php">Quay lại trang chủ</a></p>
</main>

<script type="module" src="js/canhan.js"></script>

<?php 
require_once __DIR__ . '/../../inc/footer.php'; 
?>