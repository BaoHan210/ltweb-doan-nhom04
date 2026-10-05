<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta
    name="description"
    content="Trang thông tin cá nhân của Nguyễn Thị Trinh, thành viên Nhóm 04 thực hiện đồ án Cook with me."
  >

  <title>Thông tin cá nhân - Nguyễn Thị Trinh | Cook with me</title>

  <!-- CSS chung của nhóm -->
  <link rel="stylesheet" href="../../css/01-bien.css">
  <link rel="stylesheet" href="../../css/02-chuan-hoa.css">
  <link rel="stylesheet" href="../../css/03-bo-cuc.css">
  <link rel="stylesheet" href="../../css/04-thanh-phan.css">
  <link rel="stylesheet" href="../../css/05-tien-ich.css">

  <!-- CSS dùng riêng cho trang cá nhân của Thị Trinh-->
  <link rel="stylesheet" href="trang-ca-nhan.css">
</head>

<body class="trang">

  <!-- HEADER ĐÃ TỐI ƯU (CÓ HÀNG GỢI Ý TÌM NHANH) -->
  <header class="dau-trang">

    <p class="thuong-hieu">
      <img src="../../images/icons/chef.svg" alt="Cook with me" class="logo-icon">
      <span class="khoi-chu-logo">
        <span class="ten-website">Cook with me</span>
        <span class="slogan">Khơi nguồn cảm hứng vào bếp</span>
      </span>
    </p>

    <!-- KHỐI TÌM KIẾM KÈM GỢI Ý -->
    <div class="khoi-tim-kiem-header">

      <form class="o-tim-kiem" action="../../danh-sach.php" method="get">
        <label for="search">Tìm kiếm</label>
        <input type="search" id="search" name="keyword" placeholder="Tìm kiếm món ăn, công thức..." autocomplete="off">
        <button class="nut" type="submit">Tìm kiếm</button>
      </form>

      <!-- Hàng gợi ý nhanh từ khóa nấu ăn -->
      <div style="font-size: 13px; margin-top: 6px; color: #555;">
        Gợi ý tìm nhanh: 
        <span class="tag-mon-an" style="cursor: pointer; color: #d35400; text-decoration: underline; margin-right: 8px;">#Món chay</span>
        <span class="tag-mon-an" style="cursor: pointer; color: #d35400; text-decoration: underline; margin-right: 8px;">#Eat clean</span>
        <span class="tag-mon-an" style="cursor: pointer; color: #d35400; text-decoration: underline; margin-right: 8px;">#Bánh ngọt</span>
        <span class="tag-mon-an" style="cursor: pointer; color: #d35400; text-decoration: underline;">#Canh chua</span>
      </div>

    </div>

    <!-- KHU VỰC TÀI KHỎAN TỰ ĐỘNG CỦA MAIN.JS -->
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

    <!-- KHỐI YÊU THÍCH ĐỒNG BỘ -->
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
      Hồ sơ thành viên: Nguyễn Thị Trinh
    </h1>


    <!-- THÔNG TIN CHUNG -->
    <section class="thong-tin-chung">

      <h2>
        Thông tin chung
      </h2>

      <figure class="anh-dai-dien">

        <img
          src="../../images/avatar-trinh.jpg"
          alt="Ảnh chân dung thành viên Nguyễn Thị Trinh"
          width="200"
          height="200"
        >
        <figcaption>
          Ảnh chân dung thành viên Nguyễn Thị Trinh - Nhóm 04.
        </figcaption>

      </figure>


      <ul class="thong-tin-ca-nhan">

        <li>
          <strong>Họ và tên:</strong>
          Nguyễn Thị Trinh
        </li>

        <li>
          <strong>Vai trò:</strong>
          Thành viên
        </li>

        <li>
          <strong>Nhiệm vụ chính:</strong>
          Xây dựng cấu trúc HTML5 ngữ nghĩa
          và thực hiện kiểm chuẩn chất lượng mã nguồn.
        </li>

      </ul>

    </section>


    <!-- DỰ ÁN VÀ SỞ THÍCH -->
    <article class="du-an-so-thich">

      <h2>
        Dự án và sở thích
      </h2>

      <p>
        Nguyễn Thị Trinh cùng các thành viên xây dựng website Cook with me,
        một mạng xã hội chia sẻ công thức ẩm thực.
      </p>

      <p>
        Trong dự án, công việc tập trung vào xây dựng cấu trúc HTML5
        theo hướng ngữ nghĩa và kiểm chuẩn chất lượng mã nguồn,
        giúp nội dung được tổ chức rõ ràng và dễ tiếp cận.
      </p>

      <p>
        Sở thích cá nhân gồm nghiên cứu công nghệ web,
        trải nghiệm ẩm thực các vùng miền và chạy bộ thể thao.
      </p>

    </article>


    <!-- KỸ NĂNG -->
    <section class="ky-nang">

      <h2>
        Kỹ năng
      </h2>

      <ul class="danh-sach-ky-nang">

        <li>
          Ngôn ngữ HTML5 chuẩn ngữ nghĩa W3C
        </li>

        <li>
          Sử dụng hệ thống quản lý mã nguồn Git và GitHub
        </li>

        <li>
          Kiểm thử khả năng tiếp cận (Accessibility)
          và SEO bằng Google Lighthouse
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
                Khung giờ
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
                Lập trình Web (Lý thuyết)
              </td>

              <td>
                Tự học HTML5 ngữ nghĩa và Cơ sở dữ liệu
              </td>

              <td>
                Nghiên cứu tài liệu đồ án
              </td>

            </tr>


            <tr>

              <th scope="row">
                Buổi chiều
              </th>

              <td>
                Họp tiến độ Nhóm 04
              </td>

              <td>
                Thực hành Lập trình Web - Kiểm thử W3C và Lighthouse
              </td>

              <td>
                Tổng hợp báo cáo tuần
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

  <!-- ================= POPUP MODAL ĐĂNG NHẬP (TƯƠNG TÁC 2) ================= -->
  <div id="modal-auth" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 99999; justify-content: center; align-items: center;">
    <div style="background: #ffffff; padding: 25px; border-radius: 8px; width: 320px; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.25);">
      
      <!-- ĐÃ ĐỔI TỪ SPAN SANG BUTTON NÚT ĐÓNG -->
      <button type="button" id="btn-close-login" aria-label="Đóng hộp thoại" style="position: absolute; top: 8px; right: 12px; cursor: pointer; font-size: 24px; font-weight: bold; color: #666; background: none; border: none;">&times;</button>
      
      <h3 style="margin-top: 0; color: #d35400; text-align: center;">Đăng nhập Cook with me</h3>
      <form style="display: flex; flex-direction: column; gap: 12px; margin-top: 15px;">
        <input type="text" placeholder="Email hoặc tên đăng nhập" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
        <input type="password" placeholder="Mật khẩu" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
        <button class="nut" type="button" style="padding: 9px; background: #e67e22; color: #ffffff; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Đăng nhập</button>
      </form>
    </div>
  </div>

  <!-- JavaScript chung của nhóm -->
  <script type="module" src="../../js/main.js"></script>

  <!-- JavaScript riêng cho trang cá nhân -->
  <script type="module" src="js/canhan.js"></script>

</body>
</html>
