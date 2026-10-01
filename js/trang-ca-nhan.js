/*
 * trang-ca-nhan.js
 * Hiển thị thông tin tài khoản, bài viết của người dùng
 * và danh sách món ăn đã lưu trên trang cá nhân.
 */

import {
    docNguoiDungHienTai
} from './tai-khoan.js';

import {
    docBaiViet,
    xoaBaiViet
} from './bai-viet.js';

import {
    docYeuThich
} from './yeu-thich.js';

import {
    taiJSON
} from './api.js';


/* ================================
   LẤY CÁC PHẦN TỬ HTML
   ================================ */

const tenNguoiDung = document.querySelector(
    '.ten-nguoi-dung'
);

const emailNguoiDung = document.querySelector(
    '.email-nguoi-dung'
);

const chuCaiDaiDien = document.querySelector(
    '.chu-cai-dai-dien'
);

const danhSachBaiViet = document.querySelector(
    '.danh-sach-bai-viet-cua-toi'
);

const khuVucCongThuc = document.querySelector(
    '.khu-vuc-cong-thuc-ca-nhan'
);

const khuVucMonDaLuu = document.querySelector(
    '.khu-vuc-mon-da-luu'
);

const cacTab = document.querySelectorAll(
    '.tab-ca-nhan'
);


/* ================================
   HIỂN THỊ THÔNG TIN NGƯỜI DÙNG
   ================================ */

const hienThiThongTinNguoiDung = (
    nguoiDung
) => {

    if (nguoiDung === null) {
        return;
    }


    if (tenNguoiDung !== null) {
        tenNguoiDung.textContent =
            nguoiDung.hoTen;
    }


    if (emailNguoiDung !== null) {
        emailNguoiDung.textContent =
            nguoiDung.email;
    }


    if (
        chuCaiDaiDien !== null
        && nguoiDung.hoTen !== ''
    ) {
        chuCaiDaiDien.textContent =
            nguoiDung.hoTen
                .charAt(0)
                .toUpperCase();
    }
};


/* ================================
   TẠO THẺ BÀI VIẾT CỦA NGƯỜI DÙNG
   ================================ */

const taoTheBaiVietNguoiDung = (
    baiViet,
    nguoiDung
) => {

    const baiVietItem =
    document.createElement('article');

baiVietItem.className =
    'the-bai-viet-cua-toi';


/* ================================
   HIỂN THỊ HÌNH ẢNH BÀI VIẾT
   ================================ */

if (
    Array.isArray(baiViet.hinhAnh) === true
    && baiViet.hinhAnh.length > 0
) {

    const khuVucHinhAnh =
        document.createElement('div');

    khuVucHinhAnh.className =
        'anh-bai-viet';


    const hinhAnh =
        document.createElement('img');

    hinhAnh.src =
        baiViet.hinhAnh[0];

    hinhAnh.alt =
        baiViet.tenMon;

    khuVucHinhAnh.appendChild(
        hinhAnh
    );

    baiVietItem.appendChild(
        khuVucHinhAnh
    );
}


const noiDung =
    document.createElement('div');

    noiDung.className =
        'noi-dung-the-bai-viet';


    const tieuDe =
        document.createElement('h3');

    tieuDe.textContent =
        baiViet.tenMon;


    const moTa =
        document.createElement('p');

    moTa.className =
        'mo-ta-bai-viet';

    moTa.textContent =
        baiViet.moTa;


    const thongTin =
        document.createElement('p');

    thongTin.className =
        'thong-tin-bai-viet';

    thongTin.textContent =
        `${baiViet.thoiGianNau} phút · `
        + `${baiViet.soNguoiAn} người`;


    const nutXem =
        document.createElement('a');

    nutXem.href =
        `chi-tiet.html?id=${baiViet.id}`;

    nutXem.className =
        'nut-xem-bai-viet';

    nutXem.textContent =
        'Xem bài viết';


    noiDung.appendChild(
        tieuDe
    );

    noiDung.appendChild(
        moTa
    );

    noiDung.appendChild(
        thongTin
    );

    const khuVucThaoTac =
    document.createElement('div');

khuVucThaoTac.className =
    'khu-vuc-thao-tac-bai-viet';


const nutSua =
    document.createElement('a');

nutSua.href =
    `dang-bai-viet.html?id=${baiViet.id}&cheDo=sua`;

nutSua.className =
    'nut-sua-bai-viet';

nutSua.textContent =
    'Sửa';


const nutXoa =
    document.createElement('button');

nutXoa.type =
    'button';

nutXoa.className =
    'nut-xoa-bai-viet';

nutXoa.textContent =
    'Xóa';

nutXoa.addEventListener(
    'click',
    () => {

        const xacNhan =
            window.confirm(
                'Bạn có chắc muốn xóa bài viết này không?'
            );

        if (xacNhan === false) {
            return;
        }

        xoaBaiViet(
    baiViet.id
);

hienThiBaiVietCuaToi(
    nguoiDung
);
    }
);


khuVucThaoTac.appendChild(
    nutXem
);

khuVucThaoTac.appendChild(
    nutSua
);

khuVucThaoTac.appendChild(
    nutXoa
);


noiDung.appendChild(
    khuVucThaoTac
);


baiVietItem.appendChild(
    noiDung
);


    return baiVietItem;
};


/* ================================
   HIỂN THỊ BÀI VIẾT CỦA TÔI
   ================================ */

const hienThiBaiVietCuaToi = (
    nguoiDung
) => {

    if (danhSachBaiViet === null) {
        return;
    }


    danhSachBaiViet.innerHTML = '';


    const tatCaBaiViet =
        docBaiViet();


    const baiVietCuaToi =
        tatCaBaiViet.filter(
            (baiViet) => {
                return (
                    baiViet.userId ===
                    nguoiDung.id
                );
            }
        );


    const soBaiDang =
        document.querySelector(
            '.so-bai-dang'
        );

    if (soBaiDang !== null) {
        soBaiDang.textContent =
            baiVietCuaToi.length;
    }


    if (baiVietCuaToi.length === 0) {

        const thongBao =
            document.createElement('p');

        thongBao.className =
            'thong-bao-chua-co-bai-viet';

        thongBao.textContent =
            'Bạn chưa có bài viết nào.';

        danhSachBaiViet.appendChild(
            thongBao
        );

        return;
    }


    baiVietCuaToi.forEach(
        (baiViet) => {

            const baiVietItem =
    taoTheBaiVietNguoiDung(
        baiViet,
        nguoiDung
    );

            danhSachBaiViet.appendChild(
                baiVietItem
            );
        }
    );
};


/* ================================
   TẠO THẺ MÓN ĂN ĐÃ LƯU
   ================================ */

const taoTheMonDaLuu = (
    monAn
) => {

    const monAnItem =
        document.createElement('article');

    monAnItem.className =
        'the-bai-viet-cua-toi';


    const hinhAnh =
        document.createElement('img');

    hinhAnh.className =
        'anh-bai-viet';

    hinhAnh.src =
        monAn.hinhAnh;

    hinhAnh.alt =
        monAn.ten;


    const noiDung =
        document.createElement('div');

    noiDung.className =
        'noi-dung-the-bai-viet';


    const tieuDe =
        document.createElement('h3');

    tieuDe.textContent =
        monAn.ten;


    const thongTin =
        document.createElement('p');

    thongTin.className =
        'thong-tin-bai-viet';

    thongTin.textContent =
        `${monAn.thoiGian} phút · `
        + `${monAn.khauPhan} người`;


    const nutXem =
        document.createElement('a');

    nutXem.href =
        `chi-tiet.html?id=${monAn.id}`;

    nutXem.className =
        'nut-xem-bai-viet';

    nutXem.textContent =
        'Xem công thức';


    noiDung.appendChild(
        tieuDe
    );

    noiDung.appendChild(
        thongTin
    );

    noiDung.appendChild(
        nutXem
    );


    monAnItem.appendChild(
        hinhAnh
    );

    monAnItem.appendChild(
        noiDung
    );


    return monAnItem;
};

const hienThiDangTaiMonDaLuu = () => {
    if (khuVucMonDaLuu === null) {
        return;
    }

    khuVucMonDaLuu.innerHTML = '';

    const thongBao = document.createElement('p');

    thongBao.className =
        'thong-bao-mon-da-luu';

    thongBao.textContent =
        'Đang tải danh sách món đã lưu...';

    khuVucMonDaLuu.appendChild(
        thongBao
    );
};

const hienThiLoiMonDaLuu = () => {
    if (khuVucMonDaLuu === null) {
        return;
    }

    khuVucMonDaLuu.innerHTML = '';

    const thongBao = document.createElement('p');

    thongBao.className =
        'thong-bao-mon-da-luu';

    thongBao.textContent =
        'Không thể tải danh sách món đã lưu.';

    const nutThuLai = document.createElement('button');

    nutThuLai.type = 'button';

    nutThuLai.className =
        'nut nut-phu';

    nutThuLai.textContent =
        'Thử lại';

    nutThuLai.addEventListener(
        'click',
        async () => {
            await hienThiMonDaLuu();
        }
    );

    khuVucMonDaLuu.appendChild(
        thongBao
    );

    khuVucMonDaLuu.appendChild(
        nutThuLai
    );
};


/* ================================
   HIỂN THỊ MÓN ĐÃ LƯU
   ================================ */

const hienThiMonDaLuu = async () => {

    if (khuVucMonDaLuu === null) {
        return;
    }

    hienThiDangTaiMonDaLuu();

    const tieuDe =
        document.createElement('h2');

    tieuDe.textContent =
        'Món đã lưu';

    khuVucMonDaLuu.appendChild(
        tieuDe
    );

    const danhSachYeuThich =
        docYeuThich();


    if (danhSachYeuThich.length === 0) {

        const thongBao =
            document.createElement('p');

        thongBao.className =
            'thong-bao-mon-da-luu';

        thongBao.textContent =
            'Bạn chưa lưu món ăn nào.';

        khuVucMonDaLuu.appendChild(
            thongBao
        );

        return;
    }


    try {

        const danhSachMonAn =
            await taiJSON(
                'data/mon-an.json'
            );


        const monAnDaLuu =
    danhSachMonAn.filter(
        (monAn) => {
            return danhSachYeuThich.some(
                (idMonAn) => {
                    return String(idMonAn) ===
                        String(monAn.id);
                }
            );
        }
    );


        if (monAnDaLuu.length === 0) {

            const thongBao =
                document.createElement('p');

            thongBao.className =
                'thong-bao-mon-da-luu';

            thongBao.textContent =
                'Không tìm thấy món ăn đã lưu.';

            khuVucMonDaLuu.appendChild(
                thongBao
            );

            return;
        }


        const danhSach =
            document.createElement('div');

        danhSach.className =
            'danh-sach-bai-viet-cua-toi';


        monAnDaLuu.forEach(
            (monAn) => {

                const monAnItem =
                    taoTheMonDaLuu(
                        monAn
                    );

                danhSach.appendChild(
                    monAnItem
                );
            }
        );


        khuVucMonDaLuu.appendChild(
            danhSach
        );

    }     catch (error) {

        console.error(
            'Lỗi tải món ăn đã lưu:',
            error
        );

        hienThiLoiMonDaLuu();
    }
    
};


/* ================================
   CHUYỂN TAB
   ================================ */

const chuyenTab = (
    tabDuocChon
) => {

    cacTab.forEach(
        (tab) => {

            tab.classList.remove(
                'dang-chon'
            );
        }
    );


    tabDuocChon.classList.add(
        'dang-chon'
    );


    const tenTab =
        tabDuocChon.textContent.trim();


    if (
        tenTab === 'Công thức của tôi'
    ) {

        if (khuVucCongThuc !== null) {
            khuVucCongThuc.hidden =
                false;
        }

        if (khuVucMonDaLuu !== null) {
            khuVucMonDaLuu.hidden =
                true;
        }

        return;
    }


    if (
        tenTab === 'Món đã lưu'
    ) {

        if (khuVucCongThuc !== null) {
            khuVucCongThuc.hidden =
                true;
        }

        if (khuVucMonDaLuu !== null) {
            khuVucMonDaLuu.hidden =
                false;
        }
    }
};


/* ================================
   GẮN SỰ KIỆN CHO TAB
   ================================ */

const khoiTaoTab =
    () => {

        cacTab.forEach(
            (tab) => {

                tab.addEventListener(
                    'click',
                    () => {

                        chuyenTab(
                            tab
                        );

                    }
                );
            }
        );
    };


/* ================================
   KIỂM TRA ĐĂNG NHẬP
   ================================ */

const khoiTaoTrangCaNhan =
    async () => {

        const nguoiDung =
            docNguoiDungHienTai();


        if (nguoiDung === null) {

            window.location.href =
                'dang-nhap.html';

            return;
        }


        hienThiThongTinNguoiDung(
            nguoiDung
        );


        hienThiBaiVietCuaToi(
            nguoiDung
        );


        await hienThiMonDaLuu();


        khoiTaoTab();
    };


khoiTaoTrangCaNhan();