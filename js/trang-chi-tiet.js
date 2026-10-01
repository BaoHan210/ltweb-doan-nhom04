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

const taoDanhSachNguyenLieu = (
    danhSachNguyenLieu
) => {
    const danhSach = document.querySelector(
        '.danh-sach-nguyen-lieu'
    );

    if (danhSach === null) {
        return;
    }

    danhSach.replaceChildren();

    if (
        Array.isArray(danhSachNguyenLieu) === false
    ) {
        return;
    }

    danhSachNguyenLieu.forEach((nguyenLieu) => {
        const item =
            document.createElement('li');

        item.className =
            'nguyen-lieu-item';

        item.textContent =
            nguyenLieu.ten;

        if (nguyenLieu.icon !== '') {
            item.style.setProperty(
                '--icon-nguyen-lieu',
                `url("images/icons/${nguyenLieu.icon}")`
            );
        }

        danhSach.appendChild(item);
    });
};

const taoDanhSachCacBuoc = (
    danhSachCacBuoc
) => {
    const danhSach = document.querySelector(
        '.cac-buoc-che-bien'
    );

    if (danhSach === null) {
        return;
    }

    danhSach.replaceChildren();

    if (
        Array.isArray(danhSachCacBuoc) === false
    ) {
        return;
    }

    danhSachCacBuoc.forEach((buoc) => {
        const item =
            document.createElement('li');

        const moTa =
            document.createElement('p');

        moTa.textContent = buoc;

        item.appendChild(moTa);
        danhSach.appendChild(item);
    });
};

const taoVideoHuongDan = (maVideo) => {
    const khuVucVideo =
        document.querySelector(
            '.video-huong-dan'
        );

    const khungVideo =
        document.querySelector(
            '.khung-video'
        );

    if (
        khuVucVideo === null ||
        khungVideo === null
    ) {
        return;
    }

    if (maVideo === '') {
        khuVucVideo.style.display = 'none';

        return;
    }

    const iframe =
        document.createElement('iframe');

    iframe.width = '560';
    iframe.height = '315';

    iframe.src =
        `https://www.youtube-nocookie.com/embed/${maVideo}`;

    iframe.title =
        'Video hướng dẫn món ăn';

    iframe.allowFullscreen = true;

    khungVideo.replaceChildren();

    khungVideo.appendChild(iframe);
};

const thietLapNutYeuThich = (
    idMonAn
) => {
    const khuVucHanhDong =
        document.querySelector(
            '.khu-vuc-hanh-dong'
        );

    if (
        khuVucHanhDong === null
    ) {
        return;
    }

    const capNhatTrangThaiNut = () => {
        const nutYeuThich =
            khuVucHanhDong.querySelector(
                '.nut-yeu-thich'
            );

        if (
            nutYeuThich === null
        ) {
            return;
        }

        const daYeuThich =
            kiemTraYeuThich(idMonAn);

        if (daYeuThich === true) {
            nutYeuThich.textContent =
                '♥ Đã lưu';

            nutYeuThich.classList.add(
                'da-luu'
            );

            nutYeuThich.setAttribute(
                'aria-label',
                'Bỏ khỏi yêu thích'
            );
        } else {
            nutYeuThich.textContent =
                '♡ Lưu công thức';

            nutYeuThich.classList.remove(
                'da-luu'
            );

            nutYeuThich.setAttribute(
                'aria-label',
                'Thêm vào yêu thích'
            );
        }
    };

    khuVucHanhDong.addEventListener(
        'click',
        (event) => {
            const nutYeuThich =
                event.target.closest(
                    '.nut-yeu-thich'
                );

            if (
                nutYeuThich === null
            ) {
                return;
            }

            doiTrangThaiYeuThich(
                idMonAn
            );

            capNhatTrangThaiNut();
        }
    );

    capNhatTrangThaiNut();
};

const hienThiThongTinMonAn = (
    monAn
) => {
    
    const khuVucTrangThai =
    document.querySelector(
        '.trang-thai-chi-tiet'
    );

const khuVucChiTiet =
    document.querySelector(
        '.chi-tiet-mon-an'
    );

if (
    khuVucTrangThai !== null
) {
    khuVucTrangThai.replaceChildren();
}

if (
    khuVucChiTiet !== null
) {
    khuVucChiTiet.hidden = false;
}

document.title =
        `${monAn.ten} | Cook with me`;

    const tieuDe =
        document.querySelector(
            '.tieu-de-mon-an'
        );

    if (tieuDe !== null) {
        tieuDe.textContent =
            monAn.ten;
    }

    const hinhAnh =
        document.querySelector(
            '.hinh-anh-mon-an img'
        );

    if (hinhAnh !== null) {
        hinhAnh.src =
            monAn.hinhAnh;

        hinhAnh.alt =
            monAn.ten;
    }

    const danhGia =
        document.querySelector(
            '.so-luot-danh-gia'
        );

    if (danhGia !== null) {
        danhGia.textContent =
            `${monAn.danhGia} (${monAn.soLuotDanhGia} đánh giá)`;
    }

    const thongTinCoBan =
        document.querySelectorAll(
            '.thong-tin-item strong'
        );

    if (
        thongTinCoBan.length >= 4
    ) {
        thongTinCoBan[0].textContent =
            `${monAn.thoiGian} phút`;

        thongTinCoBan[1].textContent =
            `${monAn.khauPhan} người`;

        thongTinCoBan[2].textContent =
            monAn.doKho;

        thongTinCoBan[3].textContent =
            `${monAn.nganSach.toLocaleString('vi-VN')} đồng`;
    }

    const moTa =
        document.querySelector(
            '.mo-ta-mon-an p'
        );

    if (moTa !== null) {
        moTa.textContent =
            monAn.moTa;
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

const hienThiDangTai = () => {
    const khuVucTrangThai =
        document.querySelector(
            '.trang-thai-chi-tiet'
        );

    const khuVucChiTiet =
        document.querySelector(
            '.chi-tiet-mon-an'
        );

    if (
        khuVucTrangThai === null
        || khuVucChiTiet === null
    ) {
        return;
    }

    khuVucChiTiet.hidden = true;
    khuVucTrangThai.replaceChildren();

    const thongBao =
        document.createElement('p');

    thongBao.className =
        'thong-bao-dang-tai';

    thongBao.textContent =
        'Đang tải thông tin món ăn...';

    khuVucTrangThai.appendChild(
        thongBao
    );
};

const hienThiLoi = (
    noiDung,
    coThuLai = false
) => {
    const khuVucTrangThai =
        document.querySelector(
            '.trang-thai-chi-tiet'
        );

    const khuVucChiTiet =
        document.querySelector(
            '.chi-tiet-mon-an'
        );

    if (
        khuVucTrangThai === null
        || khuVucChiTiet === null
    ) {
        return;
    }

    khuVucChiTiet.hidden = true;
    khuVucTrangThai.replaceChildren();

    const thongBao =
        document.createElement('p');

    thongBao.className =
        'thong-bao-loi';

    thongBao.textContent =
        noiDung;

    khuVucTrangThai.appendChild(
        thongBao
    );

    if (coThuLai === true) {
        const nutThuLai =
            document.createElement('button');

        nutThuLai.type = 'button';
        nutThuLai.className = 'nut';
        nutThuLai.textContent = 'Thử lại';

        nutThuLai.addEventListener(
            'click',
            taiVaHienThiMonAn
        );

        khuVucTrangThai.appendChild(
            nutThuLai
        );
    }
};

const taiVaHienThiMonAn = async () => {
    hienThiDangTai();

    const idMonAn =
        layIdMonAn();

    if (idMonAn === null) {
        hienThiLoi(
            'Không tìm thấy mã món ăn.'
        );

        return;
    }

    try {
        const danhSachMonAn =
            await taiJSON(
                'data/mon-an.json'
            );

        if (
            Array.isArray(danhSachMonAn) === false
        ) {
            throw new Error(
                'Dữ liệu món ăn không đúng định dạng.'
            );
        }

        const monAn =
            danhSachMonAn.find((item) => {
            return String(item.id) === idMonAn;
        });

        if (
            monAn === undefined
        ) {
            hienThiLoi(
                'Không tìm thấy món ăn cần xem.'
            );

            return;
        }

        hienThiThongTinMonAn(
            monAn
        );
    } catch (error) {
        console.error(
            'Lỗi tải dữ liệu món ăn:',
            error
        );

        hienThiLoi(
            'Không thể tải dữ liệu món ăn. Vui lòng thử lại.',
            true
        );
    }
};

taiVaHienThiMonAn();