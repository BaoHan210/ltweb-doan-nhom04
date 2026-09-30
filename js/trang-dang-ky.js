/*
 * trang-dang-ky.js
 * Xử lý biểu mẫu đăng ký tài khoản.
 * Kiểm tra dữ liệu và tạo tài khoản mới cho người dùng.
 */

import {
    timTaiKhoanTheoEmail,
    taoTaiKhoan
} from './tai-khoan.js';


const formDangKy =
    document.querySelector(
        '.form-dang-ky'
    );

const hoTen =
    document.querySelector(
        '#ho-ten'
    );

const email =
    document.querySelector(
        '#email-dang-ky'
    );

const matKhau =
    document.querySelector(
        '#mat-khau'
    );

const xacNhanMatKhau =
    document.querySelector(
        '#xac-nhan-mat-khau'
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


const kiemTraHoTen = () => {

    const giaTri =
        hoTen.value.trim();

    if (giaTri === '') {

        hienThiLoi(
            hoTen,
            'Vui lòng nhập họ và tên.'
        );

        return false;
    }

    if (giaTri.length < 2) {

        hienThiLoi(
            hoTen,
            'Họ và tên phải có ít nhất 2 ký tự.'
        );

        return false;
    }

    xoaLoi(hoTen);

    return true;
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

    const giaTri =
        matKhau.value;

    if (giaTri === '') {

        hienThiLoi(
            matKhau,
            'Vui lòng nhập mật khẩu.'
        );

        return false;
    }

    if (giaTri.length < 6) {

        hienThiLoi(
            matKhau,
            'Mật khẩu phải có ít nhất 6 ký tự.'
        );

        return false;
    }

    xoaLoi(matKhau);

    return true;
};


const kiemTraXacNhanMatKhau = () => {

    if (
        xacNhanMatKhau.value === ''
    ) {

        hienThiLoi(
            xacNhanMatKhau,
            'Vui lòng xác nhận mật khẩu.'
        );

        return false;
    }

    if (
        xacNhanMatKhau.value !==
        matKhau.value
    ) {

        hienThiLoi(
            xacNhanMatKhau,
            'Mật khẩu xác nhận không khớp.'
        );

        return false;
    }

    xoaLoi(xacNhanMatKhau);

    return true;
};


const hienThiThongBao = (
    noiDung,
    laLoi = false
) => {

    let thongBao =
        document.querySelector(
            '.thong-bao-dang-ky'
        );

    if (thongBao === null) {

        thongBao =
            document.createElement('p');

        thongBao.className =
            'thong-bao-dang-ky';

        formDangKy.appendChild(
            thongBao
        );
    }

    thongBao.textContent =
        noiDung;

    thongBao.classList.toggle(
        'thong-bao-dang-ky-loi',
        laLoi
    );
};


const taoIdNguoiDung = () => {

    return `user-${Date.now()}`;
};


const dangKyTaiKhoan = () => {

    const emailNguoiDung =
        email.value.trim()
            .toLowerCase();

    const taiKhoanTonTai =
        timTaiKhoanTheoEmail(
            emailNguoiDung
        );

    if (taiKhoanTonTai !== undefined) {

        hienThiThongBao(
            'Email này đã được đăng ký.',
            true
        );

        return false;
    }


    const taiKhoanMoi = {

        id: taoIdNguoiDung(),

        hoTen:
            hoTen.value.trim(),

        email:
            emailNguoiDung,

        matKhau:
            matKhau.value,

        ngayTao:
            new Date().toISOString()
    };


    taoTaiKhoan(
        taiKhoanMoi
    );


    return true;
};


if (formDangKy !== null) {

    formDangKy.addEventListener(
        'submit',
        (event) => {

            event.preventDefault();


            const hopLeHoTen =
                kiemTraHoTen();

            const hopLeEmail =
                kiemTraEmail();

            const hopLeMatKhau =
                kiemTraMatKhau();

            const hopLeXacNhan =
                kiemTraXacNhanMatKhau();


            if (
                hopLeHoTen === false
                || hopLeEmail === false
                || hopLeMatKhau === false
                || hopLeXacNhan === false
            ) {
                return;
            }


            const dangKyThanhCong =
                dangKyTaiKhoan();


            if (
                dangKyThanhCong === false
            ) {
                return;
            }


            hienThiThongBao(
                'Đăng ký tài khoản thành công.'
            );


            formDangKy.reset();
        }
    );
}