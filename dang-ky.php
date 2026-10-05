<?php
// 1. PHẦN XỬ LÝ LÝ THUYẾT / LOGIC (Không echo)
require __DIR__ . '/inc/config.php';

use App\Data\KhoMonAn; // (Nếu trang cần lấy dữ liệu món ăn)

// Thực hiện khai báo dữ liệu, lấy danh sách từ JSON
$kho      = new KhoMonAn(__DIR__ . '/data/mon-an.json');
$danhSach = $kho->tatCa(); 

// Thiết lập thông số header
$tieuDe   = 'Đăng ký'; 
$trang    = 'dang-ky'; // Đánh dấu class active trên Menu (ví dụ: 'index', 'danh-sach', 'lien-he'...)
$customJS = 'js/trang-dang-ky.js'; // Nạp JS riêng (nếu có)

// Nhúng Header (đã bao gồm Nav)
require __DIR__ . '/inc/header.php';
?>


<main class="dang-ky-trang">

    <div class="khung-dang-ky">

        <article class="the-dang-ky">

            <header class="tieu-de-dang-ky">

                <h1>Tạo tài khoản</h1>

                <p>
                    Tham gia Cook with me và chia sẻ
                    công thức của bạn.
                </p>

            </header>


            <form
                class="form-dang-ky"
                action="#"
                method="post"
                novalidate
            >

                <div class="nhom-truong">

                    <label for="ho-ten">
                        Họ và tên
                    </label>

                    <input
                        type="text"
                        id="ho-ten"
                        name="ho_ten"
                        autocomplete="name"
                        required
                        placeholder="Nhập họ và tên"
                    >

                </div>


                <div class="nhom-truong">

                    <label for="email-dang-ky">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email-dang-ky"
                        name="email"
                        autocomplete="email"
                        required
                        placeholder="Nhập email"
                    >

                </div>


                <div class="nhom-truong">

                    <label for="mat-khau">
                        Mật khẩu
                    </label>

                    <input
                        type="password"
                        id="mat-khau"
                        name="mat_khau"
                        autocomplete="new-password"
                        required
                        placeholder="Nhập mật khẩu"
                    >

                </div>


                <div class="nhom-truong">

                    <label for="xac-nhan-mat-khau">
                        Xác nhận mật khẩu
                    </label>

                    <input
                        type="password"
                        id="xac-nhan-mat-khau"
                        name="xac_nhan_mat_khau"
                        autocomplete="new-password"
                        required
                        placeholder="Nhập lại mật khẩu"
                    >

                </div>


                <button
                    type="submit"
                    class="nut nut-dang-ky"
                >
                    Đăng ký
                </button>


                <p class="thong-tin-chuyen-trang">

                    Đã có tài khoản?

                    <a href="dang-nhap.php">
                        Đăng nhập
                    </a>

                </p>

            </form>

        </article>

    </div>

</main>


<?php
require __DIR__ . '/inc/footer.php';
?>