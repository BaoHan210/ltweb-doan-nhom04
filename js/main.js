document.documentElement.classList.add('js');

/*
 * main.js
 * Xử lý các chức năng dùng chung trên toàn bộ website.
 * Cập nhật trạng thái tài khoản, yêu thích và menu mobile.
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

const dongMenuMobile = (menu, nutMenu) => {
    menu.classList.remove('mo');
    nutMenu.setAttribute('aria-expanded', 'false');
    nutMenu.setAttribute(
        'aria-label',
        'Mở menu điều hướng'
    );
};

const khoiTaoMenuMobile = () => {
    const thanhDieuHuong = document.querySelector('.thanh-dieu-huong');

    if (thanhDieuHuong === null) {
        return;
    }

    const menu = thanhDieuHuong.querySelector(':scope > .menu');

    if (menu === null) {
        return;
    }

    let nutMenu = thanhDieuHuong.querySelector('.nut-menu');

    if (nutMenu === null) {
        nutMenu = document.createElement('button');
        nutMenu.type = 'button';
        nutMenu.className = 'nut-menu';
        nutMenu.setAttribute('aria-expanded', 'false');
        nutMenu.setAttribute('aria-label', 'Mở menu điều hướng');
        nutMenu.textContent = '☰';

        thanhDieuHuong.insertBefore(nutMenu, menu);
    }

    if (menu.id === '') {
        menu.id = 'menu-dieu-huong-chinh';
    }

    nutMenu.setAttribute('aria-controls', menu.id);

    nutMenu.addEventListener('click', () => {
        const dangMo = menu.classList.toggle('mo');

        nutMenu.setAttribute(
            'aria-expanded',
            dangMo ? 'true' : 'false'
        );

        nutMenu.setAttribute(
            'aria-label',
            dangMo ? 'Đóng menu điều hướng' : 'Mở menu điều hướng'
        );
    });

    menu.addEventListener('click', (event) => {
        const lienKet = event.target.closest('a');

        if (lienKet === null) {
            return;
        }

        dongMenuMobile(menu, nutMenu);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') {
            return;
        }

        dongMenuMobile(menu, nutMenu);
    });
};

/* ================================
   KHỞI TẠO TRANG
   ================================ */

const khoiTaoTrang = () => {
    khoiTaoMenuMobile();
    capNhatSoLuongYeuThich();
    khoiTaoTimKiemMonAn();

    const nguoiDung = docNguoiDungHienTai();
    taoKhuVucTaiKhoan(nguoiDung);

    window.addEventListener(
        'yeuThichThayDoi',
        capNhatSoLuongYeuThich
    );
};


khoiTaoTrang();