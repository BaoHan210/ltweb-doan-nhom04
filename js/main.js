/*
 * main.js
 * Xử lý các chức năng dùng chung trên toàn bộ website.
 * Cập nhật trạng thái tài khoản và số lượng món ăn yêu thích.
 */

import {
    docYeuThich
} from './yeu-thich.js';

import {
    docNguoiDungHienTai,
    dangXuat
} from './tai-khoan.js';


/* ================================
   CẬP NHẬT SỐ LƯỢNG YÊU THÍCH
   ================================ */

const capNhatSoLuongYeuThich = () => {

    const danhSachYeuThich =
        docYeuThich();

    const soLuongYeuThich =
        document.querySelector(
            '.so-luong-yeu-thich'
        );

    if (soLuongYeuThich === null) {
        return;
    }

    soLuongYeuThich.textContent =
        danhSachYeuThich.length;
};


/* ================================
   TẠO KHU VỰC TÀI KHOẢN
   ================================ */

const taoKhuVucTaiKhoan = (
    nguoiDung
) => {

    const khuVuc =
        document.querySelector(
            '.khu-vuc-tai-khoan'
        );

    if (khuVuc === null) {
        return;
    }


    khuVuc.innerHTML = '';


    if (nguoiDung === null) {

        const nutDangKy =
            document.createElement('a');

        nutDangKy.href =
            'dang-ky.html';

        nutDangKy.className =
            'nut nut-dang-ky';

        nutDangKy.textContent =
            'Đăng ký';


        const nutDangNhap =
            document.createElement('a');

        nutDangNhap.href =
            'dang-nhap.html';

        nutDangNhap.className =
            'nut nut-dang-nhap';

        nutDangNhap.textContent =
            'Đăng nhập';


        khuVuc.appendChild(
            nutDangKy
        );

        khuVuc.appendChild(
            nutDangNhap
        );

        return;
    }


    const nutTrangCaNhan =
        document.createElement('a');

    nutTrangCaNhan.href =
        'ca-nhan.html';

    nutTrangCaNhan.className =
        'nut nut-tai-khoan';

    nutTrangCaNhan.textContent =
        nguoiDung.hoTen;


    const nutDangXuat =
        document.createElement('button');

    nutDangXuat.type =
        'button';

    nutDangXuat.className =
        'nut nut-dang-xuat';

    nutDangXuat.textContent =
        'Đăng xuất';


    nutDangXuat.addEventListener(
        'click',
        () => {

            dangXuat();

            window.location.href =
                'index.html';
        }
    );


    khuVuc.appendChild(
        nutTrangCaNhan
    );

    khuVuc.appendChild(
        nutDangXuat
    );
};

/* ================================
   XỬ LÝ TÌM KIẾM MÓN ĂN
   ================================ */

const xuLyTimKiemMonAn = (event) => {

    event.preventDefault();

    const oTimKiem =
        document.querySelector('#search');

    if (oTimKiem === null) {
        return;
    }

    const tuKhoa =
        oTimKiem.value.trim();

    const url =
        new URL(
            'danh-sach.html',
            window.location.href
        );

    if (tuKhoa !== '') {

        url.searchParams.set(
            'keyword',
            tuKhoa
        );
    }

    window.location.href =
        url.toString();
};


const khoiTaoTimKiemMonAn = () => {

    const formTimKiem =
        document.querySelector('.o-tim-kiem');

    if (formTimKiem === null) {
        return;
    }

    formTimKiem.addEventListener(
        'submit',
        xuLyTimKiemMonAn
    );
};

/* ================================
   KHỞI TẠO TRANG
   ================================ */

const khoiTaoTrang = () => {

    capNhatSoLuongYeuThich();

    khoiTaoTimKiemMonAn();

    const nguoiDung =
        docNguoiDungHienTai();

    taoKhuVucTaiKhoan(
        nguoiDung
    );

    window.addEventListener(
        'yeuThichThayDoi',
        capNhatSoLuongYeuThich
    );
};


khoiTaoTrang();