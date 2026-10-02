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


/* ================================
   LẤY ID MÓN ĂN TRÊN URL
   ================================ */

const layIdMonAn = () => {
    const thamSo =
        new URLSearchParams(
            window.location.search
        );

    return thamSo.get('id');
};


/* ================================
   HIỂN THỊ DANH SÁCH NGUYÊN LIỆU
   ================================ */

const taoDanhSachNguyenLieu = (
    danhSachNguyenLieu
) => {
    const danhSach =
        document.querySelector(
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

    danhSachNguyenLieu.forEach(
        (nguyenLieu) => {
            const item =
                document.createElement('li');

            if (
                nguyenLieu.type
            ) {
                item.classList.add(
                    `nguyen-lieu-${nguyenLieu.type}`
                );
            } else {
                item.classList.add(
                    'nguyen-lieu-gia-vi'
                );
            }

            const ten =
                document.createElement('span');

            ten.textContent =
                nguyenLieu.ten || '';

            const soLuong =
                document.createElement('strong');

            soLuong.textContent =
                nguyenLieu.soLuong || '';

            item.append(
                ten,
                soLuong
            );

            danhSach.appendChild(
                item
            );
        }
    );
};


/* ================================
   HIỂN THỊ CÁC BƯỚC CHẾ BIẾN
   ================================ */

const taoDanhSachCacBuoc = (
    danhSachCacBuoc
) => {
    const danhSach =
        document.querySelector(
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

    danhSachCacBuoc.forEach(
        (buoc) => {
            const item =
                document.createElement('li');

            const moTa =
                document.createElement('p');

            moTa.textContent =
                buoc;

            item.appendChild(
                moTa
            );

            danhSach.appendChild(
                item
            );
        }
    );
};


/* ================================
   HIỂN THỊ VIDEO HƯỚNG DẪN
   ================================ */

const taoVideoHuongDan = (
    maVideo
) => {
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

    khungVideo.replaceChildren();

    if (
        typeof maVideo !== 'string' ||
        maVideo.trim() === ''
    ) {
        khuVucVideo.hidden = true;

        return;
    }

    khuVucVideo.hidden = false;

    const iframe =
        document.createElement('iframe');

    iframe.width = '560';
    iframe.height = '315';

    iframe.src =
        `https://www.youtube-nocookie.com/embed/${encodeURIComponent(maVideo)}`;

    iframe.title =
        'Video hướng dẫn món ăn';

    iframe.loading = 'lazy';

    iframe.setAttribute(
        'allow',
        'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share'
    );

    iframe.allowFullscreen = true;

    khungVideo.appendChild(
        iframe
    );
};


/* ================================
   CẬP NHẬT TRẠNG THÁI NÚT YÊU THÍCH
   ================================ */

const capNhatTrangThaiNutYeuThich = (
    khuVucHanhDong,
    idMonAn
) => {
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
        kiemTraYeuThich(
            idMonAn
        );

    if (
        daYeuThich === true
    ) {
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


/* ================================
   XỬ LÝ YÊU THÍCH BẰNG EVENT DELEGATION
   ================================ */

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

    khuVucHanhDong.dataset.idMonAn =
        idMonAn;

    if (
        khuVucHanhDong.dataset.daGanSuKien ===
        'true'
    ) {
        capNhatTrangThaiNutYeuThich(
            khuVucHanhDong,
            idMonAn
        );

        return;
    }

    khuVucHanhDong.dataset.daGanSuKien =
        'true';

    khuVucHanhDong.addEventListener(
        'click',
        (event) => {
            const nutYeuThich =
                event.target.closest(
                    '.nut-yeu-thich'
                );

            if (
                nutYeuThich === null ||
                khuVucHanhDong.contains(
                    nutYeuThich
                ) === false
            ) {
                return;
            }

            const id =
                khuVucHanhDong.dataset.idMonAn;

            if (
                id === undefined ||
                id === ''
            ) {
                return;
            }

            doiTrangThaiYeuThich(
                id
            );

            capNhatTrangThaiNutYeuThich(
                khuVucHanhDong,
                id
            );
        }
    );

    capNhatTrangThaiNutYeuThich(
        khuVucHanhDong,
        idMonAn
    );
};


/* ================================
   HIỂN THỊ THÔNG TIN MÓN ĂN
   ================================ */

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


    /* ---------- Tên món ---------- */

    const tieuDe =
        document.querySelector(
            '.tieu-de-mon-an'
        );

    if (
        tieuDe !== null
    ) {
        tieuDe.textContent =
            monAn.ten;
    }


    /* ---------- Hình ảnh ---------- */

    const hinhAnh =
        document.querySelector(
            '.hinh-anh-mon-an img'
        );

    if (
        hinhAnh !== null
    ) {
        hinhAnh.src =
            monAn.hinhAnh;

        hinhAnh.alt =
            monAn.ten;
    }


    /* ---------- Đánh giá ---------- */

    const danhGia =
        document.querySelector(
            '.so-luot-danh-gia'
        );

    if (
        danhGia !== null
    ) {
        danhGia.textContent =
            `${monAn.danhGia} (${monAn.soLuotDanhGia} đánh giá)`;
    }


    /* ---------- Thông tin cơ bản ---------- */

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
            `${Number(monAn.nganSach).toLocaleString('vi-VN')} đồng`;
    }


    /* ---------- Mô tả ---------- */

    const moTa =
        document.querySelector(
            '.mo-ta-mon-an p'
        );

    if (
        moTa !== null
    ) {
        moTa.textContent =
            monAn.moTa;
    }


    /* ---------- Nguyên liệu ---------- */

    taoDanhSachNguyenLieu(
        monAn.nguyenLieu
    );


    /* ---------- Các bước chế biến ---------- */

    taoDanhSachCacBuoc(
        monAn.cacBuoc
    );


    /* ---------- Video ---------- */

    taoVideoHuongDan(
        monAn.video
    );


    /* ---------- Yêu thích ---------- */

    thietLapNutYeuThich(
        monAn.id
    );
};


/* ================================
   TRẠNG THÁI ĐANG TẢI
   ================================ */

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
        khuVucTrangThai === null ||
        khuVucChiTiet === null
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


/* ================================
   HIỂN THỊ LỖI
   ================================ */

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
        khuVucTrangThai === null ||
        khuVucChiTiet === null
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


    if (
        coThuLai === true
    ) {
        const nutThuLai =
            document.createElement('button');

        nutThuLai.type =
            'button';

        nutThuLai.className =
            'nut';

        nutThuLai.textContent =
            'Thử lại';

        nutThuLai.addEventListener(
            'click',
            taiVaHienThiMonAn
        );

        khuVucTrangThai.appendChild(
            nutThuLai
        );
    }
};


/* ================================
   TẢI VÀ HIỂN THỊ MÓN ĂN
   ================================ */

const taiVaHienThiMonAn = async () => {
    hienThiDangTai();

    const idMonAn =
        layIdMonAn();


    /* ---------- Kiểm tra id ---------- */

    if (
        idMonAn === null ||
        idMonAn.trim() === ''
    ) {
        hienThiLoi(
            'Không tìm thấy mã món ăn.'
        );

        return;
    }


    try {
        /* ---------- Tải JSON ---------- */

        const danhSachMonAn =
            await taiJSON(
                'data/mon-an.json'
            );


        /* ---------- Kiểm tra dữ liệu ---------- */

        if (
            Array.isArray(danhSachMonAn) === false
        ) {
            throw new Error(
                'Dữ liệu món ăn không đúng định dạng.'
            );
        }


        /* ---------- Tìm món theo id ---------- */

        const monAn =
            danhSachMonAn.find(
                (item) => {
                    return (
                        String(item.id) ===
                        idMonAn
                    );
                }
            );


        /* ---------- Không tìm thấy ---------- */

        if (
            monAn === undefined
        ) {
            hienThiLoi(
                'Không tìm thấy món ăn cần xem.'
            );

            return;
        }


        /* ---------- Hiển thị ---------- */

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


/* ================================
   KHỞI CHẠY
   ================================ */

taiVaHienThiMonAn();