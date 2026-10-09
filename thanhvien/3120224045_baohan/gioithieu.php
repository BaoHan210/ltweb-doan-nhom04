<?php
/*
 * Chức năng: Hiển thị thông tin cá nhân và tra cứu thông tin website.
 * Dữ liệu: Đọc lịch sử phiên bản và công nghệ từ các tệp JSON.
 * Kiểm thử: Mở trang, lọc theo nhóm và thử gửi tham số GET không hợp lệ.
 */
require_once __DIR__ . '/../../inc/config.php';

$goc = '../../';
$tieuDe = 'Thông tin cá nhân - Bảo Hân';
$trang = 'gioi-thieu';

// CSS riêng của trang cá nhân
$cssRieng = $goc . 'thanhvien/3120224045_baohan/trang-ca-nhan.css';
?>

<?php require __DIR__ . '/../../inc/header.php'; ?>

<?php
// Đường dẫn đến thư mục storage ở thư mục gốc dự án.
$thuMucStorage = dirname(__DIR__, 2) . '/storage';

// Đọc dữ liệu JSON từ tệp.
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

// CHỨC NĂNG 1: Đọc lịch sử phiên bản từ storage.
$cacPhienBan = docDuLieuJson(
    $thuMucStorage . '/3120224045_phienban.json'
);

$nhomPhienBanHopLe = [
    'tat-ca',
    'giao-dien',
    'tinh-nang',
    'sua-loi'
];

$nhomPhienBan = $_GET['nhom_phien_ban'] ?? 'tat-ca';

if (
    !is_string($nhomPhienBan)
    || !in_array($nhomPhienBan, $nhomPhienBanHopLe, true)
) {
    $nhomPhienBan = 'tat-ca';
}

$phienBanHienThi = array_filter(
    $cacPhienBan,
    function ($phienBan) use ($nhomPhienBan) {
        return is_array($phienBan)
            && isset($phienBan['nhom'])
            && (
                $nhomPhienBan === 'tat-ca'
                || $phienBan['nhom'] === $nhomPhienBan
            );
    }
);

// CHỨC NĂNG 2: Đọc danh sách công nghệ từ storage.
$cacCongNghe = docDuLieuJson(
    $thuMucStorage . '/3120224045_congnghe.json'
);

$nhomCongNgheHopLe = [
    'tat-ca',
    'frontend',
    'backend',
    'co-so-du-lieu',
    'cong-cu'
];

$nhomCongNghe = $_GET['nhom_cong_nghe'] ?? 'tat-ca';

if (
    !is_string($nhomCongNghe)
    || !in_array($nhomCongNghe, $nhomCongNgheHopLe, true)
) {
    $nhomCongNghe = 'tat-ca';
}

$congNgheHienThi = array_filter(
    $cacCongNghe,
    function ($congNghe) use ($nhomCongNghe) {
        return is_array($congNghe)
            && isset($congNghe['nhom'])
            && (
                $nhomCongNghe === 'tat-ca'
                || $congNghe['nhom'] === $nhomCongNghe
            );
    }
);
?>

  <!-- NỘI DUNG CHÍNH -->
  <main class="ho-so-trang">

    <h1 class="tieu-de-ho-so">
      Hồ sơ thành viên: Bảo Hân
    </h1>


    <!-- KHU VỰC TƯƠNG TÁC TRANG CÁ NHÂN -->
    <div class="khu-vuc-thao-tac-ca-nhan">

      <button
        type="button"
        class="nut-chinh-sua"
      >
        Chỉnh sửa
      </button>

      <button
        type="button"
        class="nut-chuyen-giao-dien"
        aria-pressed="false"
      >
        Chế độ tối
      </button>

    </div>


    <!-- KHU VỰC EMAIL -->
    <div class="khu-vuc-email-ca-nhan">

      <p class="email-ca-nhan">
        Email:
        <span class="dia-chi-email">baohanphan205@gmail.com</span>
      </p>

      <button
        type="button"
        class="nut-sao-chep-email"
      >
        Sao chép email
      </button>

      <p
        class="thong-bao-sao-chep"
        aria-live="polite"
      ></p>

    </div>


    <!-- THÔNG TIN CHUNG -->
    <section class="thong-tin-chung">

      <h2>
        Thông tin chung
      </h2>

      <figure class="anh-dai-dien">

        <img
          src="../../images/avatar-baohan.jpg"
          alt="Ảnh chân dung thành viên Phan Thị Bảo Hân"
          width="200"
          height="200"
        >

        <figcaption>
          Ảnh chân dung thành viên Phan Thị Bảo Hân - Nhóm 04.
        </figcaption>

      </figure>


      <ul class="thong-tin-ca-nhan">

        <li>
          <strong>Họ và tên:</strong>
          Phan Thị Bảo Hân
        </li>

        <li>
          <strong>Vai trò:</strong>
          Nhóm trưởng
        </li>

        <li>
          <strong>Nhiệm vụ chính:</strong>
          Quản lý kho mã nguồn GitHub, thiết lập GitHub Pages,
          xây dựng khung trang chủ và biểu mẫu liên hệ.
        </li>

      </ul>

    </section>


    <!-- DỰ ÁN VÀ SỞ THÍCH -->
    <article class="du-an-so-thich">

      <h2>
        Dự án và sở thích
      </h2>

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
<!-- LỊCH SỬ PHIÊN BẢN WEBSITE -->
<section class="lich-su-phien-ban">

  <h2>Lịch sử phiên bản Cook with me</h2>

  <p>
    Theo dõi các thay đổi và cải tiến trong quá trình phát triển website.
  </p>

  <form method="GET">
    <label for="nhom-phien-ban">Lọc theo nhóm cập nhật:</label>

    <select id="nhom-phien-ban" name="nhom_phien_ban">
      <option value="tat-ca"
        <?= $nhomPhienBan === 'tat-ca' ? 'selected' : '' ?>>
        Tất cả phiên bản
      </option>

      <option value="giao-dien"
        <?= $nhomPhienBan === 'giao-dien' ? 'selected' : '' ?>>
        Giao diện
      </option>

      <option value="tinh-nang"
        <?= $nhomPhienBan === 'tinh-nang' ? 'selected' : '' ?>>
        Tính năng
      </option>

      <option value="sua-loi"
        <?= $nhomPhienBan === 'sua-loi' ? 'selected' : '' ?>>
        Sửa lỗi
      </option>
    </select>

     <input
  type="hidden"
  name="nhom_cong_nghe"
  value="<?= e($nhomCongNghe) ?>"
>

    <button type="submit">Lọc phiên bản</button>
  </form>

  <?php if (empty($phienBanHienThi)): ?>
    <p>Không tìm thấy phiên bản phù hợp.</p>
  <?php else: ?>
    <?php foreach ($phienBanHienThi as $phienBan): ?>
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

        <p><?= e($phienBan['mo_ta']) ?></p>

      </article>
    <?php endforeach; ?>
  <?php endif; ?>

</section>


<!-- TRA CỨU CÔNG NGHỆ -->
<section class="tra-cuu-cong-nghe">

  <h2>Công nghệ sử dụng</h2>

  <p>
    Các công nghệ và công cụ được sử dụng trong quá trình xây dựng Cook with me.
  </p>

  <form method="GET">
    <label for="nhom-cong-nghe">Lọc theo nhóm công nghệ:</label>

    <select id="nhom-cong-nghe" name="nhom_cong_nghe">
      <option value="tat-ca"
        <?= $nhomCongNghe === 'tat-ca' ? 'selected' : '' ?>>
        Tất cả công nghệ
      </option>

      <option value="frontend"
        <?= $nhomCongNghe === 'frontend' ? 'selected' : '' ?>>
        Frontend
      </option>

      <option value="backend"
        <?= $nhomCongNghe === 'backend' ? 'selected' : '' ?>>
        Backend
      </option>

      <option value="co-so-du-lieu"
        <?= $nhomCongNghe === 'co-so-du-lieu' ? 'selected' : '' ?>>
        Cơ sở dữ liệu
      </option>

      <option value="cong-cu"
        <?= $nhomCongNghe === 'cong-cu' ? 'selected' : '' ?>>
        Công cụ
      </option>
    </select>

      <input
  type="hidden"
  name="nhom_phien_ban"
  value="<?= e($nhomPhienBan) ?>"
>

    <button type="submit">Tra cứu</button>
  </form>

  <?php if (empty($congNgheHienThi)): ?>
    <p>Không tìm thấy công nghệ phù hợp.</p>
  <?php else: ?>
    <ul class="danh-sach-cong-nghe">
      <?php foreach ($congNgheHienThi as $congNghe): ?>
        <li>
          <strong><?= e($congNghe['ten']) ?></strong>
          <p><?= e($congNghe['mo_ta']) ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

</section>

    <!-- KỸ NĂNG -->
    <section class="ky-nang">

      <h2>
        Kỹ năng
      </h2>

      <ul class="danh-sach-ky-nang">

        <li>
          HTML5
        </li>

        <li>
          Git và GitHub
        </li>

        <li>
          Thiết kế cấu trúc website
        </li>

        <li>
          Làm việc nhóm
        </li>

        <li>
          Quản lý mã nguồn
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
            Thời khóa biểu học tập và hoạt động trong tuần
          </caption>

          <thead>

            <tr>

              <th scope="col">
                Ngày
              </th>

              <th scope="col">
                Buổi sáng
              </th>

              <th scope="col">
                Buổi chiều
              </th>

              <th scope="col">
                Buổi tối
              </th>

            </tr>

          </thead>


          <tbody>

            <tr>

              <th scope="row">
                Thứ Hai
              </th>

              <td>
                Học tập
              </td>

              <td>
                Học tập
              </td>

              <td>
                Làm đồ án
              </td>

            </tr>


            <tr>

              <th scope="row">
                Thứ Ba
              </th>

              <td>
                Học tập
              </td>

              <td>
                Thực hành
              </td>

              <td>
                Tự học
              </td>

            </tr>


            <tr>

              <th scope="row">
                Thứ Tư
              </th>

              <td>
                Học tập
              </td>

              <td>
                Học tập
              </td>

              <td>
                Làm đồ án
              </td>

            </tr>


            <tr>

              <th scope="row">
                Thứ Năm
              </th>

              <td>
                Học tập
              </td>

              <td>
                Thực hành
              </td>

              <td>
                Tự học
              </td>

            </tr>


            <tr>

              <th scope="row">
                Thứ Sáu
              </th>

              <td>
                Học tập
              </td>

              <td>
                Học tập
              </td>

              <td>
                Làm đồ án
              </td>

            </tr>


            <tr>

              <th scope="row">
                Thứ Bảy
              </th>

              <td>
                Tự học
              </td>

              <td>
                Hoạt động cá nhân
              </td>

              <td>
                Ôn tập
              </td>

            </tr>


            <tr>

              <th scope="row">
                Chủ Nhật
              </th>

              <td>
                Nghỉ ngơi
              </td>

              <td>
                Đọc sách
              </td>

              <td>
                Lên kế hoạch tuần
              </td>

            </tr>

          </tbody>

        </table>

      </div>

    </section>


    <!-- QUAY LẠI -->
        <p class="quay-lai">
      <a href="<?= e($goc) ?>index.php">
        Quay lại trang chủ
      </a>
    </p>

  </main>

  <script type="module" src="js/canhan.js"></script>

<?php require __DIR__ . '/../../inc/footer.php'; ?>