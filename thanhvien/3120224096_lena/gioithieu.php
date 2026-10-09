

<?php
/*
 * Tệp hiển thị hồ sơ cá nhân và tính khẩu phần nguyên liệu.
 * Cách thử: nhập số người ăn rồi nhấn Tính khẩu phần.
 * Kiểm tra dữ liệu hợp lệ và giới hạn số người từ 1 đến 20.
 * Sử dụng session và PRG để xử lý kết quả sau khi gửi biểu mẫu.
 */

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../../inc/config.php';

$tieuDe = 'Thông tin cá nhân - Lê Thị A Na';
$trang = 'gioi-thieu';
$goc = '../../';
$customJS = 'thanhvien/3120224096_lena/js/canhan.js';

$congThuc = [
    'thit-kho' => [
        'ten' => 'Thịt kho trứng',
        'nguyenLieu' => [
            ['ten' => 'Thịt heo', 'luong' => 300, 'donVi' => 'g'],
            ['ten' => 'Trứng', 'luong' => 2, 'donVi' => 'quả'],
            ['ten' => 'Nước dừa', 'luong' => 200, 'donVi' => 'ml'],
            ['ten' => 'Nước mắm', 'luong' => 2, 'donVi' => 'muỗng canh']
        ]
    ],
    'canh-rau' => [
        'ten' => 'Canh rau nấu tôm',
        'nguyenLieu' => [
            ['ten' => 'Rau xanh', 'luong' => 300, 'donVi' => 'g'],
            ['ten' => 'Tôm', 'luong' => 100, 'donVi' => 'g'],
            ['ten' => 'Nước', 'luong' => 800, 'donVi' => 'ml']
        ]
    ],
    'com-chien' => [
        'ten' => 'Cơm chiên trứng',
        'nguyenLieu' => [
            ['ten' => 'Cơm chín', 'luong' => 400, 'donVi' => 'g'],
            ['ten' => 'Trứng', 'luong' => 2, 'donVi' => 'quả'],
            ['ten' => 'Cà rốt', 'luong' => 100, 'donVi' => 'g'],
            ['ten' => 'Đậu Hà Lan', 'luong' => 100, 'donVi' => 'g']
        ]
    ]
    ,    'ga-kho-gung' => [
        'ten' => 'Gà kho gừng',
        'nguyenLieu' => [
            ['ten' => 'Thịt gà', 'luong' => 500, 'donVi' => 'g'],
            ['ten' => 'Gừng', 'luong' => 30, 'donVi' => 'g'],
            ['ten' => 'Nước mắm', 'luong' => 2, 'donVi' => 'muỗng canh'],
            ['ten' => 'Đường', 'luong' => 1, 'donVi' => 'muỗng cà phê']
        ]
    ],
    'bo-xao-rau-cu' => [
        'ten' => 'Bò xào rau củ',
        'nguyenLieu' => [
            ['ten' => 'Thịt bò', 'luong' => 300, 'donVi' => 'g'],
            ['ten' => 'Bông cải xanh', 'luong' => 200, 'donVi' => 'g'],
            ['ten' => 'Cà rốt', 'luong' => 100, 'donVi' => 'g'],
            ['ten' => 'Tỏi', 'luong' => 2, 'donVi' => 'tép'],
            ['ten' => 'Dầu ăn', 'luong' => 2, 'donVi' => 'muỗng canh']
        ]
    ],
    'ca-sot-ca-chua' => [
        'ten' => 'Cá sốt cà chua',
        'nguyenLieu' => [
            ['ten' => 'Cá', 'luong' => 400, 'donVi' => 'g'],
            ['ten' => 'Cà chua', 'luong' => 300, 'donVi' => 'g'],
            ['ten' => 'Hành tím', 'luong' => 2, 'donVi' => 'củ'],
            ['ten' => 'Nước mắm', 'luong' => 2, 'donVi' => 'muỗng canh'],
            ['ten' => 'Dầu ăn', 'luong' => 2, 'donVi' => 'muỗng canh']
        ]
    ],
    'dau-hu-sot-ca' => [
        'ten' => 'Đậu hũ sốt cà chua',
        'nguyenLieu' => [
            ['ten' => 'Đậu hũ', 'luong' => 400, 'donVi' => 'g'],
            ['ten' => 'Cà chua', 'luong' => 250, 'donVi' => 'g'],
            ['ten' => 'Hành lá', 'luong' => 20, 'donVi' => 'g'],
            ['ten' => 'Tỏi', 'luong' => 2, 'donVi' => 'tép'],
            ['ten' => 'Dầu ăn', 'luong' => 1, 'donVi' => 'muỗng canh']
        ]
    ],
    'canh-chua-ca' => [
        'ten' => 'Canh chua cá',
        'nguyenLieu' => [
            ['ten' => 'Cá', 'luong' => 300, 'donVi' => 'g'],
            ['ten' => 'Cà chua', 'luong' => 200, 'donVi' => 'g'],
            ['ten' => 'Dứa', 'luong' => 150, 'donVi' => 'g'],
            ['ten' => 'Giá đỗ', 'luong' => 100, 'donVi' => 'g'],
            ['ten' => 'Nước', 'luong' => 1000, 'donVi' => 'ml']
        ]
    ]
];

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['tinh_khau_phan'])
) {
    $soNguoi = filter_input(
        INPUT_POST,
        'so_nguoi',
        FILTER_VALIDATE_INT
    );

    $maMon = $_POST['ma_mon'] ?? '';

    if (!is_string($maMon) || !isset($congThuc[$maMon])) {
        $_SESSION['khauPhanLoi'] = 'Vui lòng chọn món ăn hợp lệ.';
        unset($_SESSION['khauPhanKetQua']);
    } elseif ($soNguoi === false || $soNguoi === null) {
        $_SESSION['khauPhanLoi'] = 'Vui lòng nhập số người ăn hợp lệ.';
        unset($_SESSION['khauPhanKetQua']);
    } elseif ($soNguoi < 1 || $soNguoi > 20) {
        $_SESSION['khauPhanLoi'] = 'Số người ăn phải từ 1 đến 20.';
        unset($_SESSION['khauPhanKetQua']);
    } else {
        $monAn = $congThuc[$maMon];
        $heSo = $soNguoi / 2;
        $danhSachNguyenLieu = [];

        foreach ($monAn['nguyenLieu'] as $nguyenLieu) {
            $danhSachNguyenLieu[] = [
                'ten' => $nguyenLieu['ten'],
                'luong' => $nguyenLieu['luong'] * $heSo,
                'donVi' => $nguyenLieu['donVi']
            ];
        }

        $_SESSION['khauPhanKetQua'] = [
            'maMon' => $maMon,
            'tenMon' => $monAn['ten'],
            'soNguoi' => $soNguoi,
            'nguyenLieu' => $danhSachNguyenLieu
        ];

        unset($_SESSION['khauPhanLoi']);
    }

    $duongDan = $_SERVER['SCRIPT_NAME'];

    if (!empty($_SERVER['QUERY_STRING'])) {
        $duongDan .= '?' . $_SERVER['QUERY_STRING'];
    }

    header('Location: ' . $duongDan . '#tinh-khau-phan');
    exit;
}

$khauPhanLoi = $_SESSION['khauPhanLoi'] ?? '';
$khauPhanKetQua = $_SESSION['khauPhanKetQua'] ?? null;

unset($_SESSION['khauPhanLoi'], $_SESSION['khauPhanKetQua']);

require_once __DIR__ . '/../../inc/header.php';
?>

<link rel="stylesheet" href="<?= $goc ?>thanhvien/3120224096_lena/trang-ca-nhan.css">

<main class="ho-so-trang">

  <h1 class="tieu-de-ho-so">
    Hồ sơ thành viên: Lê Thị A Na
  </h1>

  <!-- THÔNG TIN CHUNG -->
  <section class="thong-tin-chung">

    <h2>
      Thông tin chung
    </h2>

    <figure class="anh-dai-dien">

      <img
        src="<?= $goc ?>images/avatar-lena.jpg"
        alt="Ảnh chân dung thành viên Lê Thị A Na"
        width="200"
        height="200"
      >

      <figcaption>
        Ảnh chân dung thành viên Lê Thị A Na - Nhóm 04.
      </figcaption>

    </figure>

    <p>
      Xin chào! Tôi là Lê Thị A Na, thành viên của Nhóm 04.
      Trong dự án này, tôi cùng các thành viên xây dựng website
      Cook with me - mạng xã hội chia sẻ công thức, hình ảnh
      và trải nghiệm nấu ăn dành cho người đam mê ẩm thực.
    </p>

    <ul class="thong-tin-ca-nhan">

      <li>
        <strong>Họ và tên:</strong>
        Lê Thị A Na
      </li>

      <li>
        <strong>Vai trò:</strong>
        Thành viên
      </li>

      <li>
        <strong>Tham gia dự án:</strong>
        Cùng các thành viên xây dựng website Cook with me,
        mạng xã hội chia sẻ công thức, hình ảnh và trải nghiệm nấu ăn.
      </li>

    </ul>

  </section>

  <!-- DỰ ÁN VÀ SỞ THÍCH -->
  <article class="du-an-so-thich">

    <h2>
      Dự án và sở thích
    </h2>

    <p>
      Lê Thị A Na cùng các thành viên xây dựng website Cook with me,
      mạng xã hội chia sẻ công thức, hình ảnh và trải nghiệm nấu ăn
      dành cho người đam mê ẩm thực.
    </p>

    <p>
      Dự án hướng đến việc giúp người dùng khám phá món ăn,
      chia sẻ công thức và kết nối với cộng đồng yêu thích ẩm thực.
    </p>

    <p>
      Sở thích cá nhân gồm nghiên cứu công nghệ web,
      tìm hiểu các công thức nấu ăn mới và khám phá ẩm thực.
    </p>

  </article>

  <!-- KỸ NĂNG -->
  <section class="ky-nang">

    <h2>
      Kỹ năng
    </h2>

    <ul class="danh-sach-ky-nang">

      <li>
        HTML5 và xây dựng trang web theo cấu trúc ngữ nghĩa
      </li>

      <li>
        Sử dụng Git và GitHub
      </li>

      <li>
        Kiểm tra website bằng W3C Validator
      </li>

      <li>
        Kiểm tra Accessibility và SEO bằng Google Lighthouse
      </li>

      <li>
        Làm việc nhóm và thiết kế giao diện web cơ bản
      </li>

    </ul>

  </section>

  <!-- THỜI KHÓA BIỂU -->
  <section class="thoi-khoa-bieu">

    <h2>
      Thời khóa biểu tuần
    </h2>

    <p>
      Bảng thời khóa biểu có thể cuộn ngang trên màn hình nhỏ.
    </p>

    <div class="khung-bang">

      <table>

        <caption>
          Thời khóa biểu học tập và nghiên cứu đồ án trong tuần
        </caption>

        <thead>

          <tr>

            <th scope="col">
              Thời gian
            </th>

            <th scope="col">
              Thứ Hai
            </th>

            <th scope="col">
              Thứ Tư
            </th>

            <th scope="col">
              Thứ Sáu
            </th>

          </tr>

        </thead>

        <tbody>

          <tr>

            <th scope="row">
              Buổi sáng
            </th>

            <td>
              Lập trình Web
            </td>

            <td>
              Tự học HTML5
            </td>

            <td>
              Nghiên cứu cơ sở dữ liệu
            </td>

          </tr>

          <tr>

            <th scope="row">
              Buổi chiều
            </th>

            <td>
              Thực hành Web
            </td>

            <td>
              Họp tiến độ nhóm
            </td>

            <td>
              Thực hành Web
            </td>

          </tr>

          <tr>

            <th scope="row">
              Buổi tối
            </th>

            <td>
              Ôn tập
            </td>

            <td>
              Kiểm tra W3C
            </td>

            <td>
              Kiểm tra Lighthouse
            </td>

          </tr>

        </tbody>

      </table>

    </div>

  </section>



<!-- TÍNH KHẨU PHẦN NGUYÊN LIỆU -->

<section class="may-tinh-diem" id="tinh-khau-phan">
    <h2>Tính khẩu phần nguyên liệu</h2>

    <p>
        Chọn món ăn và nhập số người để tính lượng nguyên liệu
        cần chuẩn bị. Lượng nguyên liệu mẫu được tính cho 2 người.
    </p>

    <form method="post" action="#tinh-khau-phan">
        <div>
            <label for="ma_mon">Chọn món ăn:</label>
            <select id="ma_mon" name="ma_mon" required>
                <option value="thit-kho">Thịt kho trứng</option>
                <option value="canh-rau">Canh rau nấu tôm</option>
                <option value="com-chien">Cơm chiên trứng</option>
                <option value="ga-kho-gung">Gà kho gừng</option>
                <option value="bo-xao-rau-cu">Bò xào rau củ</option>
                <option value="ca-sot-ca-chua">Cá sốt cà chua</option>
                <option value="dau-hu-sot-ca">Đậu hũ sốt cà chua</option>
                <option value="canh-chua-ca">Canh chua cá</option>
            </select>
        </div>

        <div>
            <label for="so_nguoi">Số người ăn:</label>
            <input
                type="number"
                id="so_nguoi"
                name="so_nguoi"
                min="1"
                max="20"
                step="1"
                required
            >
        </div>

        <button type="submit" name="tinh_khau_phan" value="1">
            Tính khẩu phần
        </button>
    </form>

    <?php if ($khauPhanLoi !== ''): ?>
        <p class="thong-bao-loi">
            <?= e($khauPhanLoi) ?>
        </p>
    <?php endif; ?>

    <?php if ($khauPhanKetQua !== null): ?>
        <div class="ket-qua-diem">
            <h3>
                <?= e($khauPhanKetQua['tenMon']) ?>
                — khẩu phần cho
                <?= e((string) $khauPhanKetQua['soNguoi']) ?>
                người
            </h3>

            <ul>
                <?php foreach ($khauPhanKetQua['nguyenLieu'] as $nguyenLieu): ?>
                    <li>
                        <?= e($nguyenLieu['ten']) ?>:
                        <?= e((string) $nguyenLieu['luong']) ?>
                        <?= e($nguyenLieu['donVi']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</section>

<!-- DANH SÁCH KỸ NĂNG VÀ DỰ ÁN -->
<?php
$danhSachKyNang = [
    'HTML5 và xây dựng trang web theo cấu trúc ngữ nghĩa',
    'Sử dụng Git và GitHub',
    'Kiểm tra website bằng W3C Validator',
    'Kiểm tra Accessibility và SEO bằng Google Lighthouse',
    'Làm việc nhóm và thiết kế giao diện web cơ bản'
];

$danhSachDuAn = [
    'Website Cook with me - mạng xã hội chia sẻ công thức nấu ăn',
    'Thiết kế giao diện trang cá nhân thành viên',
    'Xây dựng chức năng tương tác cho trang cá nhân'
];

$nhom = $_GET['nhom'] ?? 'tat-ca';

if (!in_array($nhom, ['tat-ca', 'ky-nang', 'du-an'], true)) {
    $nhom = 'tat-ca';
}
?>

<section class="danh-sach-ca-nhan">

  <h2>
    Kỹ năng và dự án
  </h2>

  <p>
    Lựa chọn nhóm nội dung muốn xem:
  </p>

  <nav aria-label="Lọc kỹ năng và dự án">

    <a href="?nhom=tat-ca">
      Tất cả
    </a>

    <a href="?nhom=ky-nang">
      Kỹ năng
    </a>

    <a href="?nhom=du-an">
      Dự án
    </a>

  </nav>

  <?php if ($nhom === 'tat-ca' || $nhom === 'ky-nang'): ?>

    <section>

      <h3>
        Danh sách kỹ năng
      </h3>

      <ul>

        <?php foreach ($danhSachKyNang as $kyNang): ?>

          <li>
            <?= e($kyNang) ?>
          </li>

        <?php endforeach; ?>

      </ul>

    </section>

  <?php endif; ?>

  <?php if ($nhom === 'tat-ca' || $nhom === 'du-an'): ?>

    <section>

      <h3>
        Danh sách dự án
      </h3>

      <ul>

        <?php foreach ($danhSachDuAn as $duAn): ?>

          <li>
            <?= e($duAn) ?>
          </li>

        <?php endforeach; ?>

      </ul>

    </section>

  <?php endif; ?>

</section>

<!-- QUAY LẠI -->
<p class="quay-lai">

  <a href="<?= $goc ?>index.php">
    Quay lại trang chủ
  </a>

</p>

</main>

<?php
require_once __DIR__ . '/../../inc/footer.php';
?>