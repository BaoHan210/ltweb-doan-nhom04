<?php
require_once __DIR__ . '/../../inc/config.php';

$goc = '../../';
$tieuDe = 'Thông tin cá nhân - Bảo Hân';
$trang = 'gioi-thieu';

// CSS riêng của trang cá nhân
$cssRieng = 'trang-ca-nhan.css';
?>

<?php require __DIR__ . '/../../inc/header.php'; ?>

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