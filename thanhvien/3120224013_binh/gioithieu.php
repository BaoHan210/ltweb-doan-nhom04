
<?php
// Trang cá nhân Nguyễn Thị Ngọc Bình - Cook with me.
$goc = '../../';

// Danh sách công thức mẫu để thực hiện chức năng lọc.
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

// CHỨC NĂNG 1: Lọc công thức bằng tham số GET.
$chonDanhMuc = $_GET['danh_muc'] ?? 'tat-ca';

if (!is_string($chonDanhMuc) || !isset($danhMuc[$chonDanhMuc])) {
    $chonDanhMuc = 'tat-ca';
}

$monAnHienThi = array_filter(
    $monAn,
    function ($mon) use ($chonDanhMuc) {
        return $chonDanhMuc === 'tat-ca'
            || $mon['loai'] === $chonDanhMuc;
    }
);

// Nơi lưu đánh giá trong thư mục storage ở gốc dự án.
$thuMucLuu = dirname(__DIR__, 2) . '/storage';
$tepDanhGia = $thuMucLuu . '/3120224013_binh_danhgia.json';

if (!is_dir($thuMucLuu)) {
    @mkdir($thuMucLuu, 0755, true);
}

// Đọc dữ liệu đánh giá đã lưu.
$danhGia = [];

if (is_file($tepDanhGia)) {
    $noiDungCu = file_get_contents($tepDanhGia);
    $duLieuCu = json_decode($noiDungCu, true);

    if (is_array($duLieuCu)) {
        $danhGia = $duLieuCu;
    }
}

$thongBaoDanhGia = '';
$loiDanhGia = '';

// CHỨC NĂNG 2: Kiểm tra và lưu đánh giá bằng POST.
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
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
            || mb_strlen($nhanXet) > 500
        ) {
            $loiDanhGia = 'Nhận xét không được để trống và tối đa 500 ký tự.';
        } elseif (!is_dir($thuMucLuu) || !is_writable($thuMucLuu)) {
            $loiDanhGia = 'Không thể ghi dữ liệu vào thư mục storage.';
        } else {
            $danhGia[] = [
                'ten_mon' => $monDuocChon['ten'],
                'so_sao' => $soSaoHopLe,
                'nhan_xet' => $nhanXet,
                'thoi_gian' => date('d/m/Y H:i'),
            ];

            $duLieuGhi = json_encode(
                $danhGia,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            );

            $ketQuaGhi = file_put_contents(
                $tepDanhGia,
                $duLieuGhi,
                LOCK_EX
            );

            if ($ketQuaGhi === false) {
                array_pop($danhGia);
                $loiDanhGia = 'Lưu đánh giá thất bại. Hãy kiểm tra quyền ghi thư mục.';
            } else {
                $thongBaoDanhGia = 'Đánh giá đã được lưu thành công!';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta
    name="description"
    content="Trang cá nhân Nguyễn Thị Ngọc Bình, thành viên Nhóm 04 thực hiện website Cook with me."
  >

  <title>Thông tin cá nhân - Nguyễn Thị Ngọc Bình | Cook with me</title>

  <!-- CSS chung của nhóm -->
  <link rel="stylesheet" href="../../css/01-bien.css">
  <link rel="stylesheet" href="../../css/02-chuan-hoa.css">
  <link rel="stylesheet" href="../../css/03-bo-cuc.css">
  <link rel="stylesheet" href="../../css/04-thanh-phan.css">
  <link rel="stylesheet" href="../../css/05-tien-ich.css">

  <!-- CSS riêng của trang cá nhân -->
  <link rel="stylesheet" href="trang-ca-nhan.css">

  <!-- CSS bổ sung cho hai chức năng PHP -->
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

  <!-- HEADER -->
  <header class="dau-trang">
    <p class="thuong-hieu">
      <img
        src="../../images/icons/chef.svg"
        alt=""
        class="logo-icon"
      >
      <span class="khoi-chu-logo">
        <span class="ten-website">Cook with me</span>
        <span class="slogan">Khơi nguồn cảm hứng vào bếp</span>
      </span>
    </p>

    <form
      class="o-tim-kiem"
      action="../../danh-sach.php"
      method="get"
    >
      <label for="search">Tìm kiếm</label>
      <input
        type="search"
        id="search"
        name="keyword"
        placeholder="Tìm kiếm món ăn, công thức..."
        autocomplete="off"
      >
      <button class="nut" type="submit">Tìm kiếm</button>
    </form>

    <div class="khu-vuc-tai-khoan"></div>
  </header>

  <!-- ĐIỀU HƯỚNG CHÍNH -->
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
      <span
        class="so-luong-yeu-thich"
        role="status"
        aria-label="Số món ăn yêu thích"
      >0</span>
    </div>
  </nav>

  <!-- NỘI DUNG CHÍNH -->
  <main class="ho-so-trang">

    <h1 class="tieu-de-ho-so">
      Hồ sơ thành viên: Nguyễn Thị Ngọc Bình
    </h1>

    <!-- CHỨC NĂNG PHP 1: LỌC MÓN ĂN -->
    <section class="chuc-nang-php">
      <h2>Khám phá món ăn theo danh mục</h2>
      <p>Chọn danh mục để lọc các món ăn phù hợp.</p>

      <form method="get" action="">
        <label for="danh_muc">Danh mục món ăn:</label>

        <select name="danh_muc" id="danh_muc">
          <?php foreach ($danhMuc as $ma => $ten): ?>
            <option
              value="<?= htmlspecialchars($ma, ENT_QUOTES, 'UTF-8') ?>"
              <?= $chonDanhMuc === $ma ? 'selected' : '' ?>
            >
              <?= htmlspecialchars($ten, ENT_QUOTES, 'UTF-8') ?>
            </option>
          <?php endforeach; ?>
        </select>

        <button type="submit">Lọc món ăn</button>
      </form>

      <ul class="ket-qua-mon-an">
        <?php foreach ($monAnHienThi as $mon): ?>
          <li>
            <strong>
              <?= htmlspecialchars($mon['ten'], ENT_QUOTES, 'UTF-8') ?>
            </strong>
            — <?= htmlspecialchars($danhMuc[$mon['loai']], ENT_QUOTES, 'UTF-8') ?>
          </li>
        <?php endforeach; ?>
      </ul>

      <?php if (count($monAnHienThi) === 0): ?>
        <p>Không tìm thấy món ăn phù hợp.</p>
      <?php endif; ?>
    </section>

    <!-- CHỨC NĂNG PHP 2: ĐÁNH GIÁ MÓN ĂN -->
    <section class="chuc-nang-php">
      <h2>Đánh giá món ăn</h2>
      <p>Chia sẻ cảm nhận của bạn về món ăn yêu thích.</p>

      <?php if ($thongBaoDanhGia !== ''): ?>
        <p class="thong-bao-thanh-cong" role="status">
          <?= htmlspecialchars($thongBaoDanhGia, ENT_QUOTES, 'UTF-8') ?>
        </p>
      <?php endif; ?>

      <?php if ($loiDanhGia !== ''): ?>
        <p class="thong-bao-loi" role="alert">
          <?= htmlspecialchars($loiDanhGia, ENT_QUOTES, 'UTF-8') ?>
        </p>
      <?php endif; ?>

      <form method="post" action="">
        <div>
          <label for="ten_mon">Chọn món ăn:</label>
          <select name="ten_mon" id="ten_mon" required>
            <?php foreach ($monAn as $mon): ?>
              <option value="<?= $mon['id'] ?>">
                <?= htmlspecialchars($mon['ten'], ENT_QUOTES, 'UTF-8') ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div>
          <label for="so_sao">Số sao (1–5):</label>
          <select name="so_sao" id="so_sao" required>
            <option value="5">5 sao</option>
            <option value="4">4 sao</option>
            <option value="3">3 sao</option>
            <option value="2">2 sao</option>
            <option value="1">1 sao</option>
          </select>
        </div>

        <div>
          <label for="nhan_xet">Nhận xét (tối đa 500 ký tự):</label>
          <textarea
            name="nhan_xet"
            id="nhan_xet"
            rows="4"
            maxlength="500"
            required
          ></textarea>
        </div>

        <button type="submit" name="gui_danh_gia" value="1">
          Gửi đánh giá
        </button>
      </form>

      <h3>Đánh giá đã gửi</h3>

      <?php if (count($danhGia) === 0): ?>
        <p>Chưa có đánh giá nào.</p>
      <?php else: ?>
        <ul class="danh-sach-danh-gia">
          <?php foreach (array_reverse($danhGia) as $dg): ?>
            <li>
              <strong>
                <?= htmlspecialchars($dg['ten_mon'] ?? '', ENT_QUOTES, 'UTF-8') ?>
              </strong>
              — <?= (int) ($dg['so_sao'] ?? 0) ?>/5 sao

              <p>
                <?= nl2br(htmlspecialchars($dg['nhan_xet'] ?? '', ENT_QUOTES, 'UTF-8')) ?>
              </p>

              <small>
                <?= htmlspecialchars($dg['thoi_gian'] ?? '', ENT_QUOTES, 'UTF-8') ?>
              </small>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </section>

    <!-- THÔNG TIN CHUNG -->
    <section class="thong-tin-chung">
      <h2>Thông tin chung</h2>

      <figure class="anh-dai-dien">
        <img
          src="../../images/avatar-binh.jpg"
          alt="Ảnh chân dung thành viên Nguyễn Thị Ngọc Bình"
          width="200"
          height="200"
        >
        <figcaption>
          Ảnh chân dung thành viên Nguyễn Thị Ngọc Bình - Nhóm 04.
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
          Xây dựng trang cá nhân, kiểm tra W3C Validator và Lighthouse,
          phối hợp hoàn thiện nội dung đồ án nhóm.
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
          Nguyễn Thị Ngọc Bình tham gia phát triển website Cook with me,
          nền tảng chia sẻ công thức nấu ăn tiện lợi và gần gũi.
        </p>
        <p>
          Công việc tập trung vào xây dựng trang cá nhân, hoàn thiện
          giao diện và kiểm tra chất lượng mã nguồn website.
        </p>
        <p>
          Sở thích cá nhân bao gồm tìm hiểu công nghệ web, ăn, ngủ,
          đọc sách và khám phá các công thức nấu ăn mới.
        </p>
      </div>
    </article>

    <!-- KỸ NĂNG -->
    <section class="ky-nang">
      <h2>Kỹ năng</h2>

      <label for="tim-ky-nang">Tìm kiếm kỹ năng:</label>
      <input
        type="search"
        id="tim-ky-nang"
        placeholder="Nhập tên kỹ năng..."
        autocomplete="off"
      >

      <ul class="danh-sach-ky-nang">
        <li>HTML5 cơ bản và nâng cao</li>
        <li>Kiểm tra lỗi W3C Validator</li>
        <li>Tối ưu Google Lighthouse (Accessibility)</li>
        <li>Sử dụng Git và GitHub quản lý mã nguồn</li>
        <li>Làm việc nhóm và thiết kế nội dung</li>
      </ul>

      <p id="khong-co-ky-nang" class="khong-co-ky-nang" hidden>
        Không tìm thấy kỹ năng phù hợp.
      </p>
    </section>

    <!-- THỜI KHÓA BIỂU -->
    <section class="thoi-khoa-bieu">
      <h2>Thời khóa biểu tuần</h2>
      <p>Bảng thời khóa biểu có thể cuộn ngang trên màn hình nhỏ.</p>

      <div class="khung-bang">
        <table>
          <caption>
            Thời khóa biểu học tập và thực hiện đồ án trong tuần
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
      <a href="../../index.php">Quay lại trang chủ</a>
    </p>

  </main>

  <!-- FOOTER -->
  <footer>
    <p>&copy; 2026 Cook with me - Nhóm 04</p>
    <nav aria-label="Điều hướng phụ">
      <ul class="menu">
        <li><a href="../../gioi-thieu.php">Giới thiệu</a></li>
        <li><a href="../../lien-he.php">Liên hệ</a></li>
      </ul>
    </nav>
  </footer>

  <!-- JavaScript chung và riêng -->
  <script type="module" src="../../js/main.js"></script>
  <script type="module" src="js/canhan.js"></script>

</body>
</html>
