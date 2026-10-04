/*
 * trang-danh-sach.js
 * Tải danh sách món ăn từ file JSON và hiển thị
 * các món ăn lên trang Khám phá.
 */

import { taiJSON } from './api.js';

import {
    kiemTraYeuThich,
    doiTrangThaiYeuThich
} from './yeu-thich.js';

const soMonMoiTrang = 9;

let trangHienTai = 1;
let danhSachMonAn = [];
let danhSachMonAnHienThi = [];
let danhMucDangChon = 'tat-ca';

const layPhanTuTrang = () => {
    return {
        danhSachMonAn: document.querySelector(
            '#danh-sach-mon-an'
        ),
        soLuongMonAn: document.querySelector(
            '#so-luong-mon-an'
        )
    };
};

const boDauTiengViet = (chuoi) => {
    return chuoi
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLowerCase();
};

const layTuKhoaTrenUrl = () => {
    const thamSoUrl = new URLSearchParams(
        window.location.search
    );

    return thamSoUrl.get('keyword') || '';
};

const timKiemVaLocMonAn = () => {
    const oTimKiem =
        document.querySelector('#tim-mon-an');

    if (oTimKiem === null) {
        danhSachMonAnHienThi = [
            ...danhSachMonAn
        ];

        return;
    }

    const tuKhoa = boDauTiengViet(
        oTimKiem.value.trim()
    );

    danhSachMonAnHienThi =
        danhSachMonAn.filter((monAn) => {
            const tenMonAn =
                boDauTiengViet(monAn.ten);

            const phuHopTuKhoa =
                tuKhoa === '' ||
                tenMonAn.includes(tuKhoa);

            const phuHopDanhMuc =
                danhMucDangChon === 'tat-ca' ||
                monAn.danhMuc === danhMucDangChon;

            return (
                phuHopTuKhoa &&
                phuHopDanhMuc
            );
        });
};

const sapXepMonAn = () => {
    const oSapXep =
        document.querySelector('#sap-xep');

    if (oSapXep === null) {
        return;
    }

    const kieuSapXep = oSapXep.value;

    if (kieuSapXep === '') {
        danhSachMonAnHienThi.sort(
            (monAnA, monAnB) => {
                return (
                    danhSachMonAn.indexOf(monAnA) -
                    danhSachMonAn.indexOf(monAnB)
                );
            }
        );

        return;
    }

    danhSachMonAnHienThi.sort(
        (monAnA, monAnB) => {
            if (kieuSapXep === 'danhGiaGiam') {
                return (
                    monAnB.danhGia -
                    monAnA.danhGia
                );
            }

            if (kieuSapXep === 'thoiGianTang') {
                return (
                    monAnA.thoiGian -
                    monAnB.thoiGian
                );
            }

            if (kieuSapXep === 'nganSachTang') {
                return (
                    monAnA.nganSach -
                    monAnB.nganSach
                );
            }

            if (kieuSapXep === 'tenTang') {
                return monAnA.ten.localeCompare(
                    monAnB.ten,
                    'vi'
                );
            }

            return 0;
        }
    );
};

const layMonAnTheoTrang = () => {
    const viTriBatDau =
        (trangHienTai - 1) *
        soMonMoiTrang;

    const viTriKetThuc =
        viTriBatDau +
        soMonMoiTrang;

    return danhSachMonAnHienThi.slice(
        viTriBatDau,
        viTriKetThuc
    );
};

const dinhDangNganSach = (nganSach) => {
    return (
        new Intl.NumberFormat('vi-VN').format(
            nganSach
        ) + ' đồng'
    );
};

const taoTheMonAn = (monAn) => {
    const theMonAn =
        document.createElement('article');

    theMonAn.className = 'the-mon-an';

    const lienKet =
        document.createElement('a');

    lienKet.href =
        `chi-tiet.html?id=${monAn.id}`;

    const hinhAnh =
        document.createElement('img');

    hinhAnh.src = monAn.hinhAnh;
    hinhAnh.alt = monAn.ten;
    hinhAnh.width = 280;
    hinhAnh.height = 190;
    hinhAnh.loading = 'lazy';

    const thongTin =
        document.createElement('div');

    thongTin.className =
        'thong-tin-the-mon-an';

    const tenMonAn =
        document.createElement('h3');

    tenMonAn.textContent = monAn.ten;

    const thongTinCoBan =
        document.createElement('div');

    thongTinCoBan.className =
        'thong-tin-co-ban';

    const thoiGian =
        document.createElement('span');

    thoiGian.textContent =
        `${monAn.thoiGian} phút`;

    const danhGia =
        document.createElement('span');

    danhGia.textContent =
        `★ ${monAn.danhGia}`;

    const soLuotDanhGia =
        document.createElement('span');

    soLuotDanhGia.textContent =
        `${monAn.soLuotDanhGia} đánh giá`;

    const nganSach =
        document.createElement('span');

    nganSach.textContent =
        dinhDangNganSach(monAn.nganSach);

    const nhanDanhMuc =
        document.createElement('span');

    nhanDanhMuc.className =
        'nhan-danh-muc';

    nhanDanhMuc.textContent =
        monAn.danhMuc;

    thongTinCoBan.append(
        thoiGian,
        danhGia,
        soLuotDanhGia,
        nganSach
    );

    thongTin.append(
        tenMonAn,
        thongTinCoBan,
        nhanDanhMuc
    );

    lienKet.append(
        hinhAnh,
        thongTin
    );

    const nutYeuThich =
        document.createElement('button');

    nutYeuThich.type = 'button';
    nutYeuThich.className =
        'nut-yeu-thich';

    nutYeuThich.dataset.idMonAn =
        monAn.id;

    const daYeuThich =
        kiemTraYeuThich(monAn.id);

    if (daYeuThich === true) {
        nutYeuThich.textContent = '♥';

        nutYeuThich.classList.add(
            'da-luu'
        );

        nutYeuThich.setAttribute(
            'aria-label',
            `Bỏ ${monAn.ten} khỏi yêu thích`
        );
    } else {
        nutYeuThich.textContent = '♡';

        nutYeuThich.setAttribute(
            'aria-label',
            `Thêm ${monAn.ten} vào yêu thích`
        );
    }

    theMonAn.append(
        lienKet,
        nutYeuThich
    );

    return theMonAn;
};

const hienThiDanhSachMonAn = () => {
    const phanTu =
        layPhanTuTrang();

    if (
        phanTu.danhSachMonAn === null ||
        phanTu.soLuongMonAn === null
    ) {
        return;
    }

    phanTu.danhSachMonAn.replaceChildren();

    phanTu.soLuongMonAn.textContent =
        `${danhSachMonAnHienThi.length} món ăn`;

    if (
        danhSachMonAnHienThi.length === 0
    ) {
        const thongBao =
            document.createElement('p');

        thongBao.className =
            'thong-bao-khong-co-mon';

        thongBao.textContent =
            'Không tìm thấy món ăn phù hợp.';

        phanTu.danhSachMonAn.append(
            thongBao
        );

        capNhatPhanTrang();

        return;
    }

    const danhSachTheoTrang =
        layMonAnTheoTrang();

    danhSachTheoTrang.forEach((monAn) => {
        const theMonAn =
            taoTheMonAn(monAn);

        phanTu.danhSachMonAn.append(
            theMonAn
        );
    });

    capNhatPhanTrang();
};

const capNhatPhanTrang = () => {
    const khuVucPhanTrang =
        document.querySelector(
            '#phan-trang'
        );

    if (khuVucPhanTrang === null) {
        return;
    }

    khuVucPhanTrang.replaceChildren();

    const tongSoTrang =
        Math.ceil(
            danhSachMonAnHienThi.length /
            soMonMoiTrang
        );

    if (tongSoTrang <= 1) {
        khuVucPhanTrang.hidden = true;

        return;
    }

    khuVucPhanTrang.hidden = false;

    const nutTrangTruoc =
        taoNutPhanTrang(
            '‹',
            'truoc'
        );

    nutTrangTruoc.disabled =
        trangHienTai === 1;

    khuVucPhanTrang.append(
        nutTrangTruoc
    );

    for (
        let soTrang = 1;
        soTrang <= tongSoTrang;
        soTrang += 1
    ) {
        const nutTrang =
            taoNutPhanTrang(
                soTrang,
                soTrang
            );

        if (
            soTrang === trangHienTai
        ) {
            nutTrang.classList.add(
                'dang-chon'
            );
        }

        khuVucPhanTrang.append(
            nutTrang
        );
    }

    const nutTrangSau =
        taoNutPhanTrang(
            '›',
            'sau'
        );

    nutTrangSau.disabled =
        trangHienTai === tongSoTrang;

    khuVucPhanTrang.append(
        nutTrangSau
    );
};

const taoNutPhanTrang = (
    noiDung,
    giaTri
) => {
    const nut =
        document.createElement('button');

    nut.className =
        'nut-phan-trang';

    nut.type = 'button';

    nut.textContent =
        noiDung;

    if (giaTri === 'truoc') {
        nut.setAttribute(
            'aria-label',
            'Trang trước'
        );
    } else if (giaTri === 'sau') {
        nut.setAttribute(
            'aria-label',
            'Trang sau'
        );
    } else {
        nut.setAttribute(
            'aria-label',
            `Trang ${giaTri}`
        );
    }

    nut.addEventListener(
        'click',
        () => {
            xuLyChuyenTrang(giaTri);
        }
    );

    return nut;
};

const xuLyChuyenTrang = (
    giaTri
) => {
    const tongSoTrang =
        Math.ceil(
            danhSachMonAnHienThi.length /
            soMonMoiTrang
        );

    if (giaTri === 'truoc') {
        if (trangHienTai > 1) {
            trangHienTai -= 1;
        }
    } else if (giaTri === 'sau') {
        if (trangHienTai < tongSoTrang) {
            trangHienTai += 1;
        }
    } else {
        trangHienTai =
            Number(giaTri);
    }

    hienThiDanhSachMonAn();
};

const hienThiTrangThaiTaiDuLieu = () => {
    const phanTu =
        layPhanTuTrang();

    if (
        phanTu.danhSachMonAn === null
    ) {
        return;
    }

    phanTu.danhSachMonAn.replaceChildren();

    const thongBao =
        document.createElement('p');

    thongBao.className =
        'thong-bao-dang-tai';

    thongBao.textContent =
        'Đang tải danh sách món ăn...';

    phanTu.danhSachMonAn.append(
        thongBao
    );

    if (
        phanTu.soLuongMonAn !== null
    ) {
        phanTu.soLuongMonAn.textContent =
            'Đang tải món ăn...';
    }
};

const hienThiLoiTaiDuLieu = (
    loi
) => {
    const phanTu =
        layPhanTuTrang();

    if (
        phanTu.danhSachMonAn === null
    ) {
        return;
    }

    phanTu.danhSachMonAn.replaceChildren();

    const thongBao =
        document.createElement('p');

    thongBao.className =
        'thong-bao-loi';

    thongBao.textContent =
        'Không thể tải danh sách món ăn. Vui lòng thử lại.';

    const nutThuLai =
        document.createElement('button');

    nutThuLai.type = 'button';

    nutThuLai.className = 'nut';

    nutThuLai.textContent =
        'Thử lại';

    nutThuLai.addEventListener(
        'click',
        () => {
            taiDuLieuMonAn();
        }
    );

    phanTu.danhSachMonAn.append(
        thongBao,
        nutThuLai
    );

    if (
        phanTu.soLuongMonAn !== null
    ) {
        phanTu.soLuongMonAn.textContent =
            'Không thể tải dữ liệu';
    }

    console.error(loi);
};

const taiDuLieuMonAn = async () => {
    hienThiTrangThaiTaiDuLieu();

    try {
        const duLieu =
            await taiJSON(
                'data/mon-an.json'
            );

        if (
            Array.isArray(duLieu) === false
        ) {
            throw new Error(
                'Dữ liệu món ăn không đúng định dạng.'
            );
        }

        danhSachMonAn =
            duLieu;

        danhSachMonAnHienThi =
            [...danhSachMonAn];

        timKiemVaLocMonAn();
        sapXepMonAn();

        trangHienTai = 1;

        hienThiDanhSachMonAn();
    } catch (error) {
        hienThiLoiTaiDuLieu(
            error
        );
    }
};

const xuLyChonDanhMuc = (
    event
) => {
    const nutBoLoc =
        event.currentTarget;

    danhMucDangChon =
        nutBoLoc.dataset.danhMuc;

    document
        .querySelectorAll(
            '.nut-bo-loc'
        )
        .forEach((nut) => {
            nut.classList.remove(
                'dang-loc'
            );
        });

    nutBoLoc.classList.add(
        'dang-loc'
    );

    timKiemVaLocMonAn();
    sapXepMonAn();

    trangHienTai = 1;

    hienThiDanhSachMonAn();
};

const xuLyYeuThich = (
    event
) => {
    const nutYeuThich =
        event.target.closest(
            '.nut-yeu-thich'
        );

    if (
        nutYeuThich === null
    ) {
        return;
    }

    const idMonAn =
        nutYeuThich.dataset.idMonAn;

    if (
        idMonAn === undefined
    ) {
        return;
    }

    const daYeuThich =
        doiTrangThaiYeuThich(
            idMonAn
        );

    if (
        daYeuThich === true
    ) {
        nutYeuThich.textContent =
            '♥';

        nutYeuThich.classList.add(
            'da-luu'
        );

        nutYeuThich.setAttribute(
            'aria-label',
            'Bỏ khỏi yêu thích'
        );
    } else {
        nutYeuThich.textContent =
            '♡';

        nutYeuThich.classList.remove(
            'da-luu'
        );

        nutYeuThich.setAttribute(
            'aria-label',
            'Thêm vào yêu thích'
        );
    }
};

const khoiTaoTrangDanhSach = () => {
    // LẮNG NGHE SỰ KIỆN SUBMIT FORM TÌM KIẾM TẠI ĐÂY
    const formTimMonAn =
        document.querySelector('#o-tim-mon-an');

    if (formTimMonAn !== null) {
        formTimMonAn.addEventListener('submit', (event) => {
            event.preventDefault();
        });
    }

    const oTimKiem =
        document.querySelector(
            '#tim-mon-an'
        );

    if (
        oTimKiem !== null
    ) {
        const tuKhoaTrenUrl =
            layTuKhoaTrenUrl();

        oTimKiem.value =
            tuKhoaTrenUrl;

        oTimKiem.addEventListener(
            'input',
            () => {
                timKiemVaLocMonAn();
                sapXepMonAn();

                trangHienTai = 1;

                hienThiDanhSachMonAn();
            }
        );
    }

    const danhSachNutBoLoc =
        document.querySelectorAll(
            '.nut-bo-loc'
        );

    danhSachNutBoLoc.forEach(
        (nutBoLoc) => {
            nutBoLoc.addEventListener(
                'click',
                xuLyChonDanhMuc
            );
        }
    );

    const oSapXep =
        document.querySelector(
            '#sap-xep'
        );

    if (
        oSapXep !== null
    ) {
        oSapXep.addEventListener(
            'change',
            () => {
                timKiemVaLocMonAn();
                sapXepMonAn();

                trangHienTai = 1;

                hienThiDanhSachMonAn();
            }
        );
    }

    const khuVucDanhSach =
        document.querySelector(
            '#danh-sach-mon-an'
        );

    if (
        khuVucDanhSach !== null
    ) {
        khuVucDanhSach.addEventListener(
            'click',
            xuLyYeuThich
        );
    }

    taiDuLieuMonAn();
};

khoiTaoTrangDanhSach();