<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta
    name="description"
    content="Trang thông tin cá nhân của Phan Thị Bảo Hân, thành viên Nhóm 04 thực hiện đồ án Cook with me."
  >

  <title>Thông tin cá nhân - Bảo Hân | Cook with me</title>

  <!-- CSS chung của nhóm -->
  <link rel="stylesheet" href="../../css/01-bien.css">
  <link rel="stylesheet" href="../../css/02-chuan-hoa.css">
  <link rel="stylesheet" href="../../css/03-bo-cuc.css">
  <link rel="stylesheet" href="../../css/04-thanh-phan.css">
  <link rel="stylesheet" href="../../css/05-tien-ich.css">

  <!-- CSS riêng cho trang cá nhân -->
  <link rel="stylesheet" href="trang-ca-nhan.css">

  <!-- JavaScript riêng cho trang cá nhân -->
  <script type="module" src="js/canhan.js"></script>

</head>

<body class="trang">

  <!-- HEADER ĐỒNG BỘ CHUẨN ĐƯỜNG DẪN -->
  <header class="dau-trang">

    <p class="thuong-hieu">
      <img src="../../images/icons/chef.svg" alt="Cook with me" class="logo-icon">
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

  <!-- ĐIỀU HƯỚNG CHÍNH -->
  <nav class="thanh-dieu-huong" aria-label="Điều hướng chính">

    <ul class="menu">

      <li>
        <a href="../../index.php">
          Trang chủ
        </a>
      </li>

      <li>
        <a href="../../danh-sach.php">
          Khám phá
        </a>
      </li>

      <li>
        <a href="../../chi-tiet.php">
          Chi tiết công thức
        </a>
      </li>

      <li>
        <a href="../../goi-y-mon-an.php">
          Gợi ý món ăn
        </a>
      </li>

      <li>
        <a href="../../cai-dat.php">
          Cài đặt
        </a>
      </li>

      <li>
        <a class="dang-chon" href="../../gioi-thieu.php">
          Giới thiệu
        </a>
      </li>

      <li>
        <a href="../../lien-he.php">
          Liên hệ
        </a>
      </li>

    </ul>

    <!-- BỔ SUNG KHỐI YÊU THÍCH -->
    <div class="khu-vuc-yeu-thich">

      <span class="nhan-yeu-thich">
        Yêu thích
      </span>

      <span
        class="so-luong-yeu-thich"
        role="status"
        aria-label="Số món ăn yêu thích"
      >
        0
      </span>

    </div>

  </nav>


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

      <a href="../../index.php">
        Quay lại trang chủ
      </a>

    </p>

  </main>


  <!-- FOOTER -->
  <footer>

    <p>
      &copy; 2026 Cook with me - Nhóm 04
    </p>

    <nav aria-label="Điều hướng phụ">

      <ul class="menu">

        <li>
          <a href="../../gioi-thieu.php">
            Giới thiệu
          </a>
        </li>

        <li>
          <a href="../../lien-he.php">
            Liên hệ
          </a>
        </li>

      </ul>

    </nav>

  </footer>

    <!-- JavaScript chung của nhóm -->
  <script type="module" src="../../js/main.js"></script>

  <!-- JavaScript riêng cho trang cá nhân -->
  <script type="module" src="js/canhan.js"></script>

</body>

</html>