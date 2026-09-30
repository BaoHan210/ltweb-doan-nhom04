/*
 * trang-chi-tiet.js
 * Tải dữ liệu món ăn từ file JSON và hiển thị
 * thông tin chi tiết của món ăn theo id trên URL.
 */

import { taiJSON } from './api.js';

import {
    kiemTraYeuThich,
    doiTrangThaiYeuThich
} from './yeu-thich.js';


const layIdMonAn = () => {
    const thamSo = new URLSearchParams(
        window.location.search
    );

    return thamSo.get('id');
};


const taoDanhSachNguyenLieu = (danhSachNguyenLieu) => {
    const danhSach = document.querySelector(
        '.danh-sach-nguyen-lieu'
    );

    if (danhSach === null) {
        return;
    }

    danhSach.replaceChildren();

    if (Array.isArray(danhSachNguyenLieu) === false) {
        return;
    }

    danhSachNguyenLieu.forEach((nguyenLieu) => {
        const item = document.createElement('li');

        item.className = 'nguyen-lieu-item';
        item.textContent = nguyenLieu.ten;

        if (nguyenLieu.icon !== '') {
            item.style.setProperty(
    '--icon-nguyen-lieu',
    `url("../images/icons/${nguyenLieu.icon}")`
);
        }

        danhSach.appendChild(item);
    });
};

const taoDanhSachCacBuoc = (danhSachCacBuoc) => {
    const danhSach = document.querySelector(
        '.cac-buoc-che-bien'
    );

    if (danhSach === null) {
        return;
    }

    danhSach.replaceChildren();

    if (Array.isArray(danhSachCacBuoc) === false) {
        return;
    }

    danhSachCacBuoc.forEach((buoc) => {
        const item = document.createElement('li');

        const moTa = document.createElement('p');

        moTa.textContent = buoc;

        item.appendChild(moTa);
        danhSach.appendChild(item);
    });
};

const taoVideoHuongDan = (maVideo) => {
    const khuVucVideo = document.querySelector(
        '.video-huong-dan'
    );

    const khungVideo = document.querySelector(
        '.khung-video'
    );

    if (khuVucVideo === null || khungVideo === null) {
        return;
    }

    if (maVideo === '') {
        khuVucVideo.style.display = 'none';

        return;
    }

    const iframe = document.createElement('iframe');

    iframe.width = '560';
    iframe.height = '315';

    iframe.src =
        `https://www.youtube-nocookie.com/embed/${maVideo}`;

    iframe.title = 'Video hướng dẫn món ăn';

    iframe.allowFullscreen = true;

    khungVideo.innerHTML = '';

    khungVideo.appendChild(iframe);
};

const thietLapNutYeuThich = (idMonAn) => {
    const nutYeuThich = document.querySelector(
        '.nut-yeu-thich'
    );

    if (nutYeuThich === null) {
        return;
    }

    const capNhatTrangThaiNut = () => {
        const daYeuThich = kiemTraYeuThich(idMonAn);

        if (daYeuThich === true) {
            nutYeuThich.textContent = '♥ Đã lưu';
            nutYeuThich.classList.add('da-luu');
        } else {
            nutYeuThich.textContent = '♡ Lưu công thức';
            nutYeuThich.classList.remove('da-luu');
        }
    };

    nutYeuThich.addEventListener(
        'click',
        () => {
            doiTrangThaiYeuThich(idMonAn);

            capNhatTrangThaiNut();
        }
    );

    capNhatTrangThaiNut();
};


const hienThiThongTinMonAn = (monAn) => {
    const tieuDe = document.querySelector(
        '.tieu-de-mon-an'
    );

    if (tieuDe !== null) {
        tieuDe.textContent = monAn.ten;
    }


    const hinhAnh = document.querySelector(
        '.hinh-anh-mon-an img'
    );

    if (hinhAnh !== null) {
        hinhAnh.src = monAn.hinhAnh;
        hinhAnh.alt = monAn.ten;
    }


    const danhGia = document.querySelector(
        '.so-luot-danh-gia'
    );

    if (danhGia !== null) {
        danhGia.textContent =
            `${monAn.danhGia} (${monAn.soLuotDanhGia} đánh giá)`;
    }


    const thongTinCoBan = document.querySelectorAll(
        '.thong-tin-item strong'
    );

    if (thongTinCoBan.length >= 4) {
        thongTinCoBan[0].textContent =
            `${monAn.thoiGian} phút`;

        thongTinCoBan[1].textContent =
            `${monAn.khauPhan} người`;

        thongTinCoBan[2].textContent =
            monAn.doKho;

        thongTinCoBan[3].textContent =
            `${monAn.nganSach.toLocaleString('vi-VN')} đồng`;
    }


    const moTa = document.querySelector(
        '.mo-ta-mon-an p'
    );

    if (moTa !== null) {
        moTa.textContent = monAn.moTa;
    }

    taoDanhSachNguyenLieu(
        monAn.nguyenLieu
    );

    taoDanhSachCacBuoc(
    monAn.cacBuoc
    );

    taoVideoHuongDan(
    monAn.video
    );

    thietLapNutYeuThich(
    monAn.id
    );
};


const hienThiLoi = (noiDung) => {
    const khuVuc = document.querySelector(
        '.chi-tiet-mon-an'
    );

    if (khuVuc === null) {
        return;
    }

    khuVuc.innerHTML = `
        <p class="thong-bao-loi">
            ${noiDung}
        </p>
    `;
};


const taiVaHienThiMonAn = async () => {
    const idMonAn = layIdMonAn();

    if (idMonAn === null) {

        hienThiLoi(
            'Không tìm thấy mã món ăn.'
        );

        return;
    }

    try {

        const danhSachMonAn = await taiJSON(
            'data/mon-an.json'
        );
        (
            'Bước 4 - dữ liệu JSON:',
            danhSachMonAn
        );

(
            'Bước 5 - số lượng món:',
            danhSachMonAn.length
        );

        const monAn = danhSachMonAn.find((item) => {
            return item.id === idMonAn;
        });

(
            'Bước 6 - món tìm được:',
            monAn
        );

        if (monAn === undefined) {
            hienThiLoi(
                'Không tìm thấy món ăn cần xem.'
            );

            return;
        }

('Bước 7: bắt đầu hiển thị');

        hienThiThongTinMonAn(monAn);

('Bước 8: hiển thị xong');

    } catch (error) {
        console.error(
            'LỖI:',
            error
        );

        hienThiLoi(
            'Không thể tải dữ liệu món ăn.'
        );
    }
};

taiVaHienThiMonAn();