/*
 * trang-chu.js
 * Tải dữ liệu từ Public REST API và hiển thị lên bảng tin.
 * Xử lý tương tác thích, bình luận, chia sẻ, lưu và xem bài viết.
 */

import { taiJSON } from './api.js';


const khuVucDuLieuApi = document.querySelector(
    '.du-lieu-api'
);


/* ================================
   TẠO NÚT TƯƠNG TÁC
   ================================ */

const taoNutTuongTac = (
    tenClass,
    bieuTuong,
    moTa
) => {

    const nut =
        document.createElement('button');

    nut.type = 'button';

    nut.className =
        `nut-tuong-tac ${tenClass}`;

    nut.textContent =
        bieuTuong;

    nut.setAttribute(
        'aria-label',
        moTa
    );

    nut.title =
        moTa;

    return nut;
};


/* ================================
   TẠO KHU VỰC BÌNH LUẬN
   ================================ */

const taoKhuVucBinhLuan = (
    idBaiViet
) => {

    const khuVuc =
        document.createElement('div');

    khuVuc.className =
        'khu-vuc-binh-luan';

    khuVuc.hidden = true;


    const form =
        document.createElement('form');

    form.className =
        'form-binh-luan';


    const nhan =
        document.createElement('label');

    nhan.textContent =
        'Bình luận';


    const oNhap =
        document.createElement('input');

    oNhap.type = 'text';

    oNhap.name =
        'comment';

    oNhap.placeholder =
        'Viết bình luận...';

    oNhap.maxLength = 200;

    oNhap.autocomplete =
        'off';


    const nutGui =
        document.createElement('button');

    nutGui.type =
        'submit';

    nutGui.className =
        'nut';

    nutGui.textContent =
        'Gửi';


    const danhSach =
        document.createElement('div');

    danhSach.className =
        'danh-sach-binh-luan';


    form.dataset.baiVietId =
        idBaiViet;

    form.appendChild(nhan);
    form.appendChild(oNhap);
    form.appendChild(nutGui);

    khuVuc.appendChild(form);
    khuVuc.appendChild(danhSach);

    return khuVuc;
};


/* ================================
   TẠO BÀI VIẾT TỪ API
   ================================ */

const taoTheBangTin = (
    baiViet
) => {

    const idBaiViet =
        `api-${baiViet.id}`;


    const baiVietItem =
        document.createElement('article');

    baiVietItem.className =
        'bai-viet-api';

    baiVietItem.dataset.baiVietId =
        idBaiViet;


    const tieuDe =
        document.createElement('h3');

    tieuDe.textContent =
        baiViet.title;


    const noiDung =
        document.createElement('p');

    noiDung.className =
        'noi-dung-api';

    noiDung.textContent =
        baiViet.body;


    const hanhDong =
        document.createElement('div');

    hanhDong.className =
        'hanh-dong-bai-dang';


    const nutThich =
        taoNutTuongTac(
            'nut-thich',
            '♡',
            'Thích bài viết'
        );

    nutThich.dataset.baiVietId =
        idBaiViet;


    const nutBinhLuan =
        taoNutTuongTac(
            'nut-binh-luan',
            '💬',
            'Bình luận'
        );


    const nutChiaSe =
        taoNutTuongTac(
            'nut-chia-se',
            '↗',
            'Chia sẻ bài viết'
        );


    const nutLuu =
        taoNutTuongTac(
            'nut-luu',
            '🔖',
            'Lưu bài viết'
        );

    nutLuu.dataset.baiVietId =
        idBaiViet;


    const nutXem =
        taoNutTuongTac(
            'nut-xem',
            '⋯',
            'Xem nội dung'
        );


    hanhDong.appendChild(
        nutThich
    );

    hanhDong.appendChild(
        nutBinhLuan
    );

    hanhDong.appendChild(
        nutChiaSe
    );

    hanhDong.appendChild(
        nutLuu
    );

    hanhDong.appendChild(
        nutXem
    );


    baiVietItem.appendChild(
        tieuDe
    );

    baiVietItem.appendChild(
        noiDung
    );

    baiVietItem.appendChild(
        hanhDong
    );

    baiVietItem.appendChild(
        taoKhuVucBinhLuan(
            idBaiViet
        )
    );


    return baiVietItem;
};


/* ================================
   HIỂN THỊ DỮ LIỆU API
   ================================ */

const hienThiDuLieuApi = (
    danhSachBaiViet
) => {

    if (khuVucDuLieuApi === null) {
        return;
    }

    khuVucDuLieuApi.replaceChildren();


    danhSachBaiViet.forEach(
        (baiViet) => {

            const baiVietItem =
                taoTheBangTin(
                    baiViet
                );

            khuVucDuLieuApi.appendChild(
                baiVietItem
            );
        }
    );

    capNhatTrangThaiTuongTac();
};


/* ================================
   THÍCH BÀI VIẾT
   ================================ */

const xuLyThichBaiViet = (
    nutThich
) => {

    const idBaiViet =
        nutThich.dataset.baiVietId;

    const khoa =
        `baiVietDaThich_${idBaiViet}`;

    const daThich =
        localStorage.getItem(khoa) === 'true';


    if (daThich === true) {

        localStorage.removeItem(khoa);

        nutThich.textContent =
            '♡';

        nutThich.classList.remove(
            'da-thich'
        );

        nutThich.setAttribute(
            'aria-label',
            'Thích bài viết'
        );

        nutThich.title =
            'Thích';

        return;
    }


    localStorage.setItem(
        khoa,
        'true'
    );

    nutThich.textContent =
        '♥';

    nutThich.classList.add(
        'da-thich'
    );

    nutThich.setAttribute(
        'aria-label',
        'Bỏ thích bài viết'
    );

    nutThich.title =
        'Bỏ thích';
};


/* ================================
   LƯU BÀI VIẾT
   ================================ */

const xuLyLuuBaiViet = (
    nutLuu
) => {

    const idBaiViet =
        nutLuu.dataset.baiVietId;

    const khoa =
        `baiVietDaLuu_${idBaiViet}`;

    const daLuu =
        localStorage.getItem(khoa) === 'true';


    if (daLuu === true) {

        localStorage.removeItem(khoa);

        nutLuu.textContent =
            '🔖';

        nutLuu.classList.remove(
            'da-luu'
        );

        nutLuu.setAttribute(
            'aria-label',
            'Lưu bài viết'
        );

        nutLuu.title =
            'Lưu';

        return;
    }


    localStorage.setItem(
        khoa,
        'true'
    );

    nutLuu.textContent =
        '📌';

    nutLuu.classList.add(
        'da-luu'
    );

    nutLuu.setAttribute(
        'aria-label',
        'Bỏ lưu bài viết'
    );

    nutLuu.title =
        'Bỏ lưu';
};


/* ================================
   HIỆN / ẨN NỘI DUNG
   ================================ */

const xuLyXemBaiViet = (
    nutXem
) => {

    const baiViet =
        nutXem.closest(
            '.the-bai-dang, .bai-viet-api'
        );

    if (baiViet === null) {
        return;
    }


    const noiDungMoRong =
        baiViet.querySelector(
            '.noi-dung-mo-rong'
        );


    if (noiDungMoRong !== null) {

        noiDungMoRong.hidden =
            noiDungMoRong.hidden === true
                ? false
                : true;

        if (
            noiDungMoRong.hidden === true
        ) {

            nutXem.textContent =
                '⋯';

            nutXem.setAttribute(
                'aria-label',
                'Xem nội dung'
            );

            nutXem.title =
                'Xem';

        } else {

            nutXem.textContent =
                '⌃';

            nutXem.setAttribute(
                'aria-label',
                'Thu gọn nội dung'
            );

            nutXem.title =
                'Thu gọn';
        }

        return;
    }


    const noiDungApi =
        baiViet.querySelector(
            '.noi-dung-api'
        );

    if (noiDungApi === null) {
        return;
    }


    noiDungApi.hidden =
        noiDungApi.hidden === true
            ? false
            : true;


    if (noiDungApi.hidden === true) {

        nutXem.textContent =
            '⋯';

    } else {

        nutXem.textContent =
            '⌃';
    }
};


/* ================================
   HIỆN / ẨN BÌNH LUẬN
   ================================ */

const xuLyNutBinhLuan = (
    nutBinhLuan
) => {

    const baiViet =
        nutBinhLuan.closest(
            '.the-bai-dang, .bai-viet-api'
        );

    if (baiViet === null) {
        return;
    }


    const khuVuc =
        baiViet.querySelector(
            '.khu-vuc-binh-luan'
        );

    if (khuVuc === null) {
        return;
    }


    khuVuc.hidden =
        khuVuc.hidden === true
            ? false
            : true;


    if (khuVuc.hidden === false) {

        const oNhap =
            khuVuc.querySelector(
                'input[name="comment"]'
            );

        if (oNhap !== null) {
            oNhap.focus();
        }
    }
};


/* ================================
   GỬI BÌNH LUẬN
   ================================ */

const xuLyGuiBinhLuan = (
    formBinhLuan
) => {

    const oNhap =
        formBinhLuan.querySelector(
            'input[name="comment"]'
        );

    const danhSach =
        formBinhLuan.parentElement
            .querySelector(
                '.danh-sach-binh-luan'
            );

    if (
        oNhap === null
        || danhSach === null
    ) {
        return;
    }


    const noiDung =
        oNhap.value.trim();


    if (noiDung === '') {

        oNhap.setCustomValidity(
            'Vui lòng nhập bình luận.'
        );

        oNhap.reportValidity();

        return;
    }


    oNhap.setCustomValidity('');


    const binhLuan =
        document.createElement('p');

    binhLuan.className =
        'binh-luan-item';

    binhLuan.textContent =
        noiDung;


    danhSach.appendChild(
        binhLuan
    );


    oNhap.value =
        '';
};


/* ================================
   CHIA SẺ BÀI VIẾT
   ================================ */

const xuLyChiaSe = async (
    nutChiaSe
) => {

    const baiViet =
        nutChiaSe.closest(
            '.the-bai-dang, .bai-viet-api'
        );

    if (baiViet === null) {
        return;
    }


    const tieuDe =
        baiViet.querySelector('h3');


    const tenBaiViet =
        tieuDe === null
            ? 'Bài viết Cook with me'
            : tieuDe.textContent;


    const duLieuChiaSe = {
        title: tenBaiViet,
        text:
            `Xem bài viết: ${tenBaiViet}`,
        url:
            window.location.href
    };


    if (
        navigator.share !== undefined
    ) {

        try {

            await navigator.share(
                duLieuChiaSe
            );

            return;

        } catch (error) {

            return;
        }
    }


    if (
        navigator.clipboard === undefined
    ) {
        return;
    }


    try {

        await navigator.clipboard.writeText(
            window.location.href
        );

        nutChiaSe.textContent =
            '✓';

        nutChiaSe.setAttribute(
            'aria-label',
            'Đã sao chép liên kết'
        );

        nutChiaSe.title =
            'Đã sao chép';

        window.setTimeout(
            () => {

                nutChiaSe.textContent =
                    '↗';

                nutChiaSe.setAttribute(
                    'aria-label',
                    'Chia sẻ bài viết'
                );

                nutChiaSe.title =
                    'Chia sẻ';

            },
            2000
        );

    } catch (error) {

        console.error(
            'Không thể sao chép liên kết:',
            error
        );
    }
};


/* ================================
   CẬP NHẬT TRẠNG THÁI
   ================================ */

const capNhatTrangThaiTuongTac = () => {

    const danhSachNutThich =
        document.querySelectorAll(
            '.nut-thich'
        );


    danhSachNutThich.forEach(
        (nutThich) => {

            const idBaiViet =
                nutThich.dataset.baiVietId;

            if (idBaiViet === undefined) {
                return;
            }

            const khoa =
                `baiVietDaThich_${idBaiViet}`;

            const daThich =
                localStorage.getItem(khoa)
                === 'true';


            if (daThich === true) {

                nutThich.textContent =
                    '♥';

                nutThich.classList.add(
                    'da-thich'
                );

                return;
            }


            nutThich.textContent =
                '♡';

            nutThich.classList.remove(
                'da-thich'
            );
        }
    );


    const danhSachNutLuu =
        document.querySelectorAll(
            '.nut-luu'
        );


    danhSachNutLuu.forEach(
        (nutLuu) => {

            const idBaiViet =
                nutLuu.dataset.baiVietId;

            if (idBaiViet === undefined) {
                return;
            }

            const khoa =
                `baiVietDaLuu_${idBaiViet}`;

            const daLuu =
                localStorage.getItem(khoa)
                === 'true';


            if (daLuu === true) {

                nutLuu.textContent =
                    '📌';

                nutLuu.classList.add(
                    'da-luu'
                );

                return;
            }


            nutLuu.textContent =
                '🔖';

            nutLuu.classList.remove(
                'da-luu'
            );
        }
    );
};


/* ================================
   GẮN SỰ KIỆN
   ================================ */

const khoiTaoTuongTacBangTin = () => {

    document.addEventListener(
        'click',
        (event) => {

            const nutThich =
                event.target.closest(
                    '.nut-thich'
                );

            if (nutThich !== null) {

                xuLyThichBaiViet(
                    nutThich
                );

                return;
            }


            const nutBinhLuan =
                event.target.closest(
                    '.nut-binh-luan'
                );

            if (nutBinhLuan !== null) {

                xuLyNutBinhLuan(
                    nutBinhLuan
                );

                return;
            }


            const nutChiaSe =
                event.target.closest(
                    '.nut-chia-se'
                );

            if (nutChiaSe !== null) {

                xuLyChiaSe(
                    nutChiaSe
                );

                return;
            }


            const nutLuu =
                event.target.closest(
                    '.nut-luu'
                );

            if (nutLuu !== null) {

                xuLyLuuBaiViet(
                    nutLuu
                );

                return;
            }


            const nutXem =
                event.target.closest(
                    '.nut-xem'
                );

            if (nutXem !== null) {

                xuLyXemBaiViet(
                    nutXem
                );
            }
        }
    );


    document.addEventListener(
        'submit',
        (event) => {

            const formBinhLuan =
                event.target.closest(
                    '.form-binh-luan'
                );

            if (formBinhLuan === null) {
                return;
            }

            event.preventDefault();

            xuLyGuiBinhLuan(
                formBinhLuan
            );
        }
    );
};


/* ================================
   HIỂN THỊ LỖI API
   ================================ */

const hienThiLoiApi = () => {

    if (khuVucDuLieuApi === null) {
        return;
    }


    khuVucDuLieuApi.replaceChildren();


    const thongBao =
        document.createElement('p');

    thongBao.className =
        'thong-bao-loi';

    thongBao.textContent =
        'Không thể tải dữ liệu bảng tin lúc này.';


    khuVucDuLieuApi.appendChild(
        thongBao
    );
};


/* ================================
   TẢI DỮ LIỆU API
   ================================ */

const taiDuLieuApi = async () => {

    try {

        const danhSachBaiViet =
            await taiJSON(
                'https://jsonplaceholder.typicode.com/posts?_limit=3'
            );

        hienThiDuLieuApi(
            danhSachBaiViet
        );

    } catch (error) {

        console.error(
            'Lỗi tải dữ liệu API:',
            error
        );

        hienThiLoiApi();
    }
};


/* ================================
   KHỞI TẠO
   ================================ */

khoiTaoTuongTacBangTin();

taiDuLieuApi();