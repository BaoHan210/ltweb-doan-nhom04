/*
 * trang-dang-nhap.js
 * Xử lý biểu mẫu đăng nhập tài khoản.
 * Kiểm tra thông tin và tạo phiên người dùng hiện tại.
 */

import {
    dangNhap
} from './tai-khoan.js';


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


const hienThiLoi = (
    phanTu,
    noiDung
) => {

    if (phanTu === null) {
        return;
    }

    phanTu.classList.add(
        'truong-co-loi'
    );

    let thongBao =
        phanTu.parentElement.querySelector(
            '.thong-bao-loi-truong'
        );

    if (thongBao === null) {

        thongBao =
            document.createElement('p');

        thongBao.className =
            'thong-bao-loi-truong';

        phanTu.parentElement.appendChild(
            thongBao
        );
    }

    thongBao.textContent =
        noiDung;
};


const xoaLoi = (
    phanTu
) => {

    if (phanTu === null) {
        return;
    }

    phanTu.classList.remove(
        'truong-co-loi'
    );

    const thongBao =
        phanTu.parentElement.querySelector(
            '.thong-bao-loi-truong'
        );

    if (thongBao !== null) {
        thongBao.remove();
    }
};


const kiemTraEmail = () => {

    const giaTri =
        email.value.trim();

    const mauEmail =
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (giaTri === '') {

        hienThiLoi(
            email,
            'Vui lòng nhập email.'
        );

        return false;
    }

    if (
        mauEmail.test(giaTri) === false
    ) {

        hienThiLoi(
            email,
            'Email không hợp lệ.'
        );

        return false;
    }

    xoaLoi(email);

    return true;
};


const kiemTraMatKhau = () => {

    if (matKhau.value === '') {

        hienThiLoi(
            matKhau,
            'Vui lòng nhập mật khẩu.'
        );

        return false;
    }

    xoaLoi(matKhau);

    return true;
};


const hienThiThongBao = (
    noiDung,
    laLoi = false
) => {

    let thongBao =
        document.querySelector(
            '.thong-bao-dang-nhap'
        );

    if (thongBao === null) {

        thongBao =
            document.createElement('p');

        thongBao.className =
            'thong-bao-dang-nhap';

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


if (formDangNhap !== null) {

    formDangNhap.addEventListener(
        'submit',
        (event) => {

            event.preventDefault();


            const emailHopLe =
                kiemTraEmail();

            const matKhauHopLe =
                kiemTraMatKhau();


            if (
                emailHopLe === false
                || matKhauHopLe === false
            ) {
                return;
            }


            const dangNhapThanhCong =
                dangNhap(
                    email.value.trim().toLowerCase(),
                    matKhau.value
                );


            if (
                dangNhapThanhCong === false
            ) {

                hienThiThongBao(
                    'Email hoặc mật khẩu không chính xác.',
                    true
                );

                return;
            }


            hienThiThongBao(
                'Đăng nhập thành công.'
            );


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