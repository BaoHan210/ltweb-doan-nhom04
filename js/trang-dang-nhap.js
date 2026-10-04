/*
 * trang-dang-nhap.js
 * Xử lý biểu mẫu đăng nhập tài khoản.
 * Kiểm tra thông tin và tạo phiên người dùng hiện tại.
 */

import {
    dangNhap
} from './tai-khoan.js';


/* =========================================================
   1. LẤY CÁC PHẦN TỬ TRONG FORM
   ========================================================= */

const formDangNhap =
    document.querySelector(
        '.form-dang-nhap'
    );

const email =
    document.querySelector(
        '#email-dang-nhap'
    );

const matKhau =
    document.querySelector(
        '#mat-khau-dang-nhap'
    );


/* =========================================================
   2. HIỂN THỊ LỖI CHO TỪNG TRƯỜNG
   ========================================================= */

const hienThiLoi = (
    phanTu,
    noiDung
) => {

    if (
        phanTu === null
    ) {
        return;
    }


    phanTu.classList.add(
        'truong-co-loi'
    );


    let thongBao =
        phanTu.parentElement?.querySelector(
            '.thong-bao-loi-truong'
        );


    if (
        thongBao === null
    ) {

        thongBao =
            document.createElement(
                'p'
            );

        thongBao.className =
            'thong-bao-loi-truong';

        thongBao.setAttribute(
            'role',
            'alert'
        );


        phanTu.parentElement?.appendChild(
            thongBao
        );
    }


    thongBao.textContent =
        noiDung;
};


/* =========================================================
   3. XÓA LỖI
   ========================================================= */

const xoaLoi = (
    phanTu
) => {

    if (
        phanTu === null
    ) {
        return;
    }


    phanTu.classList.remove(
        'truong-co-loi'
    );


    const thongBao =
        phanTu.parentElement?.querySelector(
            '.thong-bao-loi-truong'
        );


    if (
        thongBao !== null
    ) {
        thongBao.remove();
    }
};


/* =========================================================
   4. KIỂM TRA EMAIL
   ========================================================= */

const kiemTraEmail = () => {

    if (
        email === null
    ) {
        return false;
    }


    const giaTri =
        email.value
            .trim()
            .toLowerCase();


    const mauEmail =
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


    if (
        giaTri === ''
    ) {

        hienThiLoi(
            email,
            'Vui lòng nhập email.'
        );

        return false;
    }


    if (
        mauEmail.test(
            giaTri
        ) === false
    ) {

        hienThiLoi(
            email,
            'Email không hợp lệ.'
        );

        return false;
    }


    xoaLoi(
        email
    );

    return true;
};


/* =========================================================
   5. KIỂM TRA MẬT KHẨU
   ========================================================= */

const kiemTraMatKhau = () => {

    if (
        matKhau === null
    ) {
        return false;
    }


    const giaTri =
        matKhau.value;


    if (
        giaTri === ''
    ) {

        hienThiLoi(
            matKhau,
            'Vui lòng nhập mật khẩu.'
        );

        return false;
    }


    xoaLoi(
        matKhau
    );

    return true;
};


/* =========================================================
   6. HIỂN THỊ THÔNG BÁO CHUNG
   ========================================================= */

const hienThiThongBao = (
    noiDung,
    laLoi = false
) => {

    if (
        formDangNhap === null
    ) {
        return;
    }


    let thongBao =
        formDangNhap.querySelector(
            '.thong-bao-dang-nhap'
        );


    if (
        thongBao === null
    ) {

        thongBao =
            document.createElement(
                'p'
            );

        thongBao.className =
            'thong-bao-dang-nhap';

        thongBao.setAttribute(
            'aria-live',
            'polite'
        );


        formDangNhap.appendChild(
            thongBao
        );
    }


    thongBao.textContent =
        noiDung;


    thongBao.classList.toggle(
        'thong-bao-dang-nhap-loi',
        laLoi
    );
};


/* =========================================================
   7. KIỂM TRA KHI NGƯỜI DÙNG RỜI KHỎI TRƯỜNG
   ========================================================= */

if (
    email !== null
) {

    email.addEventListener(
        'blur',
        kiemTraEmail
    );
}


if (
    matKhau !== null
) {

    matKhau.addEventListener(
        'blur',
        kiemTraMatKhau
    );
}


/* =========================================================
   8. XỬ LÝ FORM ĐĂNG NHẬP
   ========================================================= */

if (
    formDangNhap !== null
) {

    formDangNhap.addEventListener(
        'submit',
        (event) => {

            event.preventDefault();


            /*
             * Kiểm tra dữ liệu nhập.
             */
            const emailHopLe =
                kiemTraEmail();

            const matKhauHopLe =
                kiemTraMatKhau();


            if (
                emailHopLe === false
                ||
                matKhauHopLe === false
            ) {

                hienThiThongBao(
                    'Vui lòng kiểm tra lại thông tin đăng nhập.',
                    true
                );

                return;
            }


            /*
             * Chuẩn hóa email trước khi đăng nhập.
             */
            const emailNguoiDung =
                email.value
                    .trim()
                    .toLowerCase();


            /*
             * Gọi hàm đăng nhập từ tai-khoan.js.
             *
             * Hàm này:
             * - tìm tài khoản theo email;
             * - kiểm tra mật khẩu;
             * - tạo localStorage "nguoiDungHienTai".
             */
            const dangNhapThanhCong =
                dangNhap(
                    emailNguoiDung,
                    matKhau.value
                );


            /*
             * Đăng nhập thất bại.
             */
            if (
                dangNhapThanhCong === false
            ) {

                hienThiThongBao(
                    'Email hoặc mật khẩu không chính xác.',
                    true
                );

                return;
            }


            /*
             * Đăng nhập thành công.
             */
            hienThiThongBao(
                'Đăng nhập thành công.'
            );


            /*
             * Khóa nút submit trong thời gian
             * chuyển trang để tránh thao tác nhiều lần.
             */
            const nutSubmit =
                formDangNhap.querySelector(
                    'button[type="submit"], input[type="submit"]'
                );


            if (
                nutSubmit !== null
            ) {

                nutSubmit.disabled =
                    true;
            }


            /*
             * Chuyển về trang chủ.
             */
            window.setTimeout(
                () => {

                    window.location.href =
                        'index.html';

                },
                500
            );
        }
    );
}