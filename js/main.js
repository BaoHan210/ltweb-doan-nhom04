/*
 * main.js
 * Xử lý các chức năng dùng chung trên toàn bộ website.
 * Cập nhật trạng thái tài khoản, yêu thích và menu mobile.
 */


/*
 * Thêm class js vào <html>.
 * CSS dùng class này để chỉ hiển thị nút menu mobile
 * khi JavaScript đang hoạt động.
 */
document.documentElement.classList.add('js');


import {
    docYeuThich
} from './yeu-thich.js';

import {
    docNguoiDungHienTai,
    dangXuat
} from './tai-khoan.js';


/* =========================================================
   CẬP NHẬT SỐ LƯỢNG YÊU THÍCH
   ========================================================= */

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
        String(danhSachYeuThich.length);
};


/* =========================================================
   TẠO KHU VỰC TÀI KHOẢN
   ========================================================= */

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

    /*
     * Xóa giao diện cũ.
     * Không dùng innerHTML để đưa dữ liệu người dùng
     * vào DOM.
     */
    khuVuc.replaceChildren();


    /* =====================================================
       CHƯA ĐĂNG NHẬP
       ===================================================== */

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


        khuVuc.append(
            nutDangKy,
            nutDangNhap
        );

        return;
    }


    /* =====================================================
   ĐÃ ĐĂNG NHẬP (TRANG CÁ NHÂN NGƯỜI DÙNG / KHÁCH HÀNG)
   ===================================================== */

// Nếu người dùng đang duyệt ở thư mục con (thanhvien/...) thì lùi ra gốc, ngược lại gọi ca-nhan.html
const đangỞThưMụcThànhViên = window.location.pathname.includes('/thanhvien/');

const duongDanTrangCaNhan = đangỞThưMụcThànhViên
    ? '../../ca-nhan.html'
    : 'ca-nhan.html';

    // Avatar mặc định nếu người dùng chưa đặt hoặc không có ảnh
    const duongDanAvatar =
        nguoiDung.avatar ||
        (đangỞThưMụcThànhViên ? '../../images/icons/avt-default.svg' : 'images/icons/avt-default.svg');

    const hoTen =
        String(
            nguoiDung.hoTen || 'Người dùng'
        );

    /*
     * Khối người dùng.
     */
    const khuVucNguoiDung =
        document.createElement('div');

    khuVucNguoiDung.className =
        'khu-vuc-nguoi-dung-logged';


    /* =====================================================
       KHỐI THÔNG BÁO
       ===================================================== */

    const khoiThongBao =
        document.createElement('div');

    khoiThongBao.className =
        'khoi-thong-bao-header';

    khoiThongBao.id =
        'khoi-thong-bao-header';


    const nutThongBao =
        document.createElement('button');

    nutThongBao.className =
        'nut-thong-bao';

    nutThongBao.id =
        'nut-thong-bao';

    nutThongBao.type =
        'button';

    nutThongBao.setAttribute(
        'aria-label',
        'Thông báo'
    );


    /*
     * SVG chuông.
     * Tạo bằng DOM thay vì innerHTML.
     */
    const svg =
        document.createElementNS(
            'http://www.w3.org/2000/svg',
            'svg'
        );

    svg.setAttribute(
        'width',
        '20'
    );

    svg.setAttribute(
        'height',
        '20'
    );

    svg.setAttribute(
        'viewBox',
        '0 0 24 24'
    );

    svg.setAttribute(
        'fill',
        'none'
    );

    svg.setAttribute(
        'stroke',
        'currentColor'
    );

    svg.setAttribute(
        'stroke-width',
        '2'
    );


    const path1 =
        document.createElementNS(
            'http://www.w3.org/2000/svg',
            'path'
        );

    path1.setAttribute(
        'd',
        'M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9'
    );


    const path2 =
        document.createElementNS(
            'http://www.w3.org/2000/svg',
            'path'
        );

    path2.setAttribute(
        'd',
        'M13.73 21a2 2 0 0 1-3.46 0'
    );


    svg.append(
        path1,
        path2
    );


    const chamThongBao =
        document.createElement('span');

    chamThongBao.className =
        'cham-thong-bao';


    nutThongBao.append(
        svg,
        chamThongBao
    );


    /* =====================================================
       BẢNG THÔNG BÁO
       ===================================================== */

    const bangThongBao =
        document.createElement('div');

    bangThongBao.className =
        'bang-thong-bao-drop';

    bangThongBao.id =
        'bang-thong-bao-drop';


    const tieuDeBang =
        document.createElement('div');

    tieuDeBang.className =
        'tieu-de-bang-tb';


    const tieuDeThongBao =
        document.createElement('strong');

    tieuDeThongBao.textContent =
        'Thông báo';


    const lienKetDaDoc =
        document.createElement('a');

    lienKetDaDoc.href =
        '#';

    lienKetDaDoc.textContent =
        'Đánh dấu đã đọc';


    tieuDeBang.append(
        tieuDeThongBao,
        lienKetDaDoc
    );


    const danhSachThongBao =
        document.createElement('ul');

    danhSachThongBao.className =
        'danh-sach-thong-bao';


    const taoThongBao = (
        noiDung,
        thoiGian,
        chuaDoc = false
    ) => {

        const item =
            document.createElement('li');

        item.className =
            'item-thong-bao';

        if (chuaDoc === true) {
            item.classList.add(
                'chua-doc'
            );
        }


        const doanVan =
            document.createElement('p');

        doanVan.textContent =
            noiDung;


        const thoiGianElement =
            document.createElement('span');

        thoiGianElement.className =
            'thoi-gian-tb';

        thoiGianElement.textContent =
            thoiGian;


        item.append(
            doanVan,
            thoiGianElement
        );

        return item;
    };


    danhSachThongBao.append(
        taoThongBao(
            'Minh Anh đã thích công thức món ăn của bạn.',
            '5 phút trước',
            true
        ),
        taoThongBao(
            'Gợi ý món ăn mới trong tuần đã được cập nhật!',
            '1 giờ trước',
            true
        ),
        taoThongBao(
            'Chào mừng bạn đã quay trở lại Cook with me.',
            '1 ngày trước'
        )
    );


    bangThongBao.append(
        tieuDeBang,
        danhSachThongBao
    );


    khoiThongBao.append(
        nutThongBao,
        bangThongBao
    );


    /* =====================================================
       KHỐI AVATAR
       ===================================================== */

    const khoiAvatar =
        document.createElement('div');

    khoiAvatar.className =
        'khoi-avatar-header';

    khoiAvatar.id =
        'khoi-avatar-header';


    const lienKetAvatar =
        document.createElement('a');

    
    lienKetAvatar.href = duongDanTrangCaNhan;

    lienKetAvatar.title =
        `Trang cá nhân của ${hoTen}`;


    const avatar =
        document.createElement('img');

    avatar.src =
        duongDanAvatar;

    avatar.alt =
        hoTen;

    avatar.className =
        'avatar-header';

    // Tự động quay về avatar mặc định nếu ảnh bị hỏng
    avatar.onerror = () => {
        avatar.src = đangỞThưMụcThànhViên
            ? '../../images/icons/avt-default.svg'
            : 'images/icons/avt-default.svg';
    };


    lienKetAvatar.append(
        avatar
    );


    const muiTen =
        document.createElement('span');

    muiTen.className =
        'mui-ten-down';

    muiTen.textContent =
        '❯';


    /* =====================================================
       MENU TÀI KHOẢN
       ===================================================== */

    const menuDrop =
        document.createElement('div');

    menuDrop.className =
        'menu-drop-tai-khoan';

    menuDrop.id =
        'menu-drop-tai-khoan';


    const lienKetCaNhan =
        document.createElement('a');

    lienKetCaNhan.href = duongDanTrangCaNhan;

    lienKetCaNhan.className =
        'item-menu-drop';

    lienKetCaNhan.textContent =
        `Trang cá nhân (${hoTen})`;


    const nutDangXuatDrop =
        document.createElement('button');

    nutDangXuatDrop.type =
        'button';

    nutDangXuatDrop.className =
        'item-menu-drop nut-dang-xuat-drop';

    nutDangXuatDrop.id =
        'nut-dang-xuat-drop';

    nutDangXuatDrop.textContent =
        'Đăng xuất';


    menuDrop.append(
        lienKetCaNhan,
        nutDangXuatDrop
    );


    khoiAvatar.append(
        lienKetAvatar,
        muiTen,
        menuDrop
    );


    khuVucNguoiDung.append(
        khoiThongBao,
        khoiAvatar
    );

    khuVuc.append(
        khuVucNguoiDung
    );


    /* =====================================================
       ĐĂNG XUẤT
       ===================================================== */

    nutDangXuatDrop.addEventListener(
        'click',
        () => {

            dangXuat();

            const duongDanHienTai =
                window.location.pathname;

            if (
                duongDanHienTai.endsWith('index.html')
                ||
                duongDanHienTai === '/'
            ) {
                window.location.reload();
            } else {
                window.location.href =
                    'index.html';
            }
        }
    );


    /* =====================================================
       MỞ / ĐÓNG THÔNG BÁO
       ===================================================== */

    nutThongBao.addEventListener(
        'click',
        (event) => {

            event.stopPropagation();

            menuDrop.classList.remove(
                'hien-thi'
            );

            bangThongBao.classList.toggle(
                'hien-thi'
            );

            chamThongBao.style.display =
                'none';
        }
    );


    /* =====================================================
       MỞ / ĐÓNG MENU AVATAR
       ===================================================== */

    khoiAvatar.addEventListener(
        'click',
        (event) => {

            if (
                event.target.closest(
                    '#nut-dang-xuat-drop'
                )
            ) {
                return;
            }

            event.stopPropagation();

            bangThongBao.classList.remove(
                'hien-thi'
            );

            menuDrop.classList.toggle(
                'hien-thi'
            );
        }
    );


    /* =====================================================
       CLICK RA NGOÀI → ĐÓNG POPUP
       ===================================================== */

    document.addEventListener(
        'click',
        (event) => {

            if (
                !khoiThongBao.contains(
                    event.target
                )
            ) {
                bangThongBao.classList.remove(
                    'hien-thi'
                );
            }

            if (
                !khoiAvatar.contains(
                    event.target
                )
            ) {
                menuDrop.classList.remove(
                    'hien-thi'
                );
            }
        }
    );
};


/* =========================================================
   XỬ LÝ TÌM KIẾM MÓN ĂN
   ========================================================= */

const xuLyTimKiemMonAn = (
    event
) => {

    event.preventDefault();

    const oTimKiem =
        document.querySelector(
            '#search'
        );

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
        document.querySelector(
            '.o-tim-kiem'
        );

    if (formTimKiem === null) {
        return;
    }

    formTimKiem.addEventListener(
        'submit',
        xuLyTimKiemMonAn
    );
};


/* =========================================================
   MENU MOBILE
   ========================================================= */

const dongMenuMobile = (
    menu,
    nutMenu
) => {

    menu.classList.remove(
        'mo'
    );

    nutMenu.setAttribute(
        'aria-expanded',
        'false'
    );

    nutMenu.setAttribute(
        'aria-label',
        'Mở menu điều hướng'
    );
};


const khoiTaoMenuMobile = () => {

    const thanhDieuHuong =
        document.querySelector(
            '.thanh-dieu-huong'
        );

    if (thanhDieuHuong === null) {
        return;
    }


    const menu =
        thanhDieuHuong.querySelector(
            ':scope > .menu'
        );

    if (menu === null) {
        return;
    }


    let nutMenu =
        thanhDieuHuong.querySelector(
            '.nut-menu'
        );


    if (nutMenu === null) {

        nutMenu =
            document.createElement(
                'button'
            );

        nutMenu.type =
            'button';

        nutMenu.className =
            'nut-menu';

        nutMenu.setAttribute(
            'aria-expanded',
            'false'
        );

        nutMenu.setAttribute(
            'aria-label',
            'Mở menu điều hướng'
        );

        nutMenu.textContent =
            '☰';


        thanhDieuHuong.insertBefore(
            nutMenu,
            menu
        );
    }


    if (menu.id === '') {

        menu.id =
            'menu-dieu-huong-chinh';
    }


    nutMenu.setAttribute(
        'aria-controls',
        menu.id
    );


    nutMenu.addEventListener(
        'click',
        () => {

            const dangMo =
                menu.classList.toggle(
                    'mo'
                );


            nutMenu.setAttribute(
                'aria-expanded',
                dangMo
                    ? 'true'
                    : 'false'
            );


            nutMenu.setAttribute(
                'aria-label',
                dangMo
                    ? 'Đóng menu điều hướng'
                    : 'Mở menu điều hướng'
            );
        }
    );


    menu.addEventListener(
        'click',
        (event) => {

            const lienKet =
                event.target.closest(
                    'a'
                );

            if (lienKet === null) {
                return;
            }

            dongMenuMobile(
                menu,
                nutMenu
            );
        }
    );


    document.addEventListener(
        'keydown',
        (event) => {

            if (
                event.key !== 'Escape'
            ) {
                return;
            }

            dongMenuMobile(
                menu,
                nutMenu
            );
        }
    );
};


/* =========================================================
   KHỞI TẠO TRANG
   ========================================================= */

const khoiTaoTrang = () => {

    khoiTaoMenuMobile();

    capNhatSoLuongYeuThich();

    khoiTaoTimKiemMonAn();


    const nguoiDung =
        docNguoiDungHienTai();

    taoKhuVucTaiKhoan(
        nguoiDung
    );


    /*
     * Khi yêu thích thay đổi ở trang hiện tại,
     * cập nhật số lượng trên header.
     */
    window.addEventListener(
        'yeuThichThayDoi',
        capNhatSoLuongYeuThich
    );
};


khoiTaoTrang();