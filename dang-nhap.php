<?php
// 1. PHẦN XỬ LÝ LÝ THUYẾT / LOGIC (Không echo)
require __DIR__ . '/inc/config.php';

use App\Data\KhoMonAn; // (Nếu trang cần lấy dữ liệu món ăn)

// Thực hiện khai báo dữ liệu, lấy danh sách từ JSON
$kho      = new KhoMonAn(__DIR__ . '/data/mon-an.json');
$danhSach = $kho->tatCa(); 

// Thiết lập thông số header
$tieuDe   = 'Đăng nhập'; 
$trang    = 'dang-nhap'; // Đánh dấu class active trên Menu (ví dụ: 'index', 'danh-sach', 'lien-he'...)
$customJS = 'js/trang-dang-nhap.js'; // Nạp JS riêng (nếu có)

// Nhúng Header (đã bao gồm Nav)
require __DIR__ . '/inc/header.php';
?>


<main class="dang-nhap-trang">

  <h1>Đăng nhập</h1>

    <div class="khung-dang-nhap">

        <div class="the-dang-nhap">

    <header class="tieu-de-dang-nhap">
        <p>
            Đăng nhập để quản lý tài khoản
            và chia sẻ công thức của bạn.
        </p>
    </header>


            <form
                class="form-dang-nhap"
                action="#"
                method="post"
                novalidate
            >

                <div class="nhom-truong">

                    <label for="email-dang-nhap">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email-dang-nhap"
                        name="email"
                        autocomplete="email"
                        required
                        placeholder="Nhập email"
                    >

                </div>


                <div class="nhom-truong">

                    <label for="mat-khau-dang-nhap">
                        Mật khẩu
                    </label>

                    <input
                        type="password"
                        id="mat-khau-dang-nhap"
                        name="mat_khau"
                        autocomplete="current-password"
                        required
                        placeholder="Nhập mật khẩu"
                    >

                </div>


                <button
                    type="submit"
                    class="nut nut-dang-nhap"
                >
                    Đăng nhập
                </button>


                <p class="thong-tin-chuyen-trang">

                    Chưa có tài khoản?

                    <a href="dang-ky.php">
                        Đăng ký
                    </a>

                </p>

            </form>

        </div>

    </div>

</main>


<?php
require __DIR__ . '/inc/footer.php';
?>