/*
 * trang-chu.js
 * Tải dữ liệu từ Public REST API và hiển thị lên bảng tin.
 * Xử lý tương tác thích, bình luận, chia sẻ, lưu và xem bài viết.
 */

import { taiJSON } from './api.js';


const khuVucDuLieuApi = document.querySelector(
    '.noi-dung-api'
);

/* ================================
   TẠO THẺ MÓN ĂN TỪ API
   ================================ */

const taoTheMonAnApi = (monAn) => {
    const theMonAn = document.createElement('article');

    theMonAn.className = 'bai-viet-api';

    const tieuDe = document.createElement('h3');
    tieuDe.textContent = monAn.strMeal;

    const thongTin = document.createElement('p');

thongTin.className =
    'thong-tin-mon-api';

thongTin.textContent =
    `${monAn.strCategory || 'Món ăn'} · ${monAn.strArea || 'Ẩm thực quốc tế'}`;

    if (monAn.strMealThumb) {
        const hinhAnh = document.createElement('img');
        hinhAnh.src = monAn.strMealThumb;
        hinhAnh.alt = monAn.strMeal;
        hinhAnh.loading = 'lazy';
        theMonAn.appendChild(hinhAnh);
    }

    theMonAn.appendChild(tieuDe);
    theMonAn.appendChild(thongTin);

    return theMonAn;
};


/* ================================
   HIỂN THỊ DỮ LIỆU API
   ================================ */

const hienThiDuLieuApi = (danhSachMonAn) => {
    if (khuVucDuLieuApi === null) {
        return;
    }

    khuVucDuLieuApi.replaceChildren();

    if (
        Array.isArray(danhSachMonAn) === false
        || danhSachMonAn.length === 0
    ) {
        hienThiTrangThaiApi(
            'Chưa có món ăn để hiển thị.'
        );

        return;
    }

    danhSachMonAn.forEach((monAn) => {
        const theMonAn = taoTheMonAnApi(monAn);
        khuVucDuLieuApi.appendChild(theMonAn);
    });
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
        '.thong-tin-mon-api'
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

const hienThiTrangThaiApi = (
    noiDung,
    laLoi = false
) => {

    if (khuVucDuLieuApi === null) {
        return;
    }

    khuVucDuLieuApi.replaceChildren();

    const thongBao =
        document.createElement('p');

    thongBao.className =
        laLoi
            ? 'thong-bao-loi'
            : 'thong-bao';

    thongBao.textContent =
        noiDung;

    khuVucDuLieuApi.appendChild(
        thongBao
    );
};

const hienThiLoiApi = () => {
    if (khuVucDuLieuApi === null) {
        return;
    }

    khuVucDuLieuApi.replaceChildren();

    const thongBao = document.createElement('p');
    thongBao.className = 'thong-bao-loi';
    thongBao.textContent =
        'Không thể tải dữ liệu món ăn lúc này.';

    const nutThuLai = document.createElement('button');
    nutThuLai.type = 'button';
    nutThuLai.className = 'nut';
    nutThuLai.textContent = 'Thử lại';
    nutThuLai.addEventListener('click', taiDuLieuApi);

    khuVucDuLieuApi.appendChild(thongBao);
    khuVucDuLieuApi.appendChild(nutThuLai);
};


/* ================================
   TẢI DỮ LIỆU API
   ================================ */

const taiDuLieuApi = async () => {
    hienThiTrangThaiApi(
        'Đang tải món ăn từ Public REST API...'
    );

    try {
        const duLieu = await taiJSON(
            'https://www.themealdb.com/api/json/v1/1/random.php'
        );

        const danhSachMonAn =
            Array.isArray(duLieu.meals)
                ? duLieu.meals
                : [];

        hienThiDuLieuApi(danhSachMonAn);
    } catch (error) {
        console.error(
            'Lỗi tải dữ liệu API:',
            error
        );

        hienThiLoiApi();
    }
};

/*
 * Xử lý chức năng theo dõi người dùng.
 * Trạng thái theo dõi được lưu trong localStorage.
 */

const KHOA_THEO_DOI = 'nguoiDungDangTheoDoi';

const docDanhSachTheoDoi = () => {
    const duLieu = localStorage.getItem(KHOA_THEO_DOI);

    if (duLieu === null) {
        return [];
    }

    try {
        const danhSach = JSON.parse(duLieu);

        if (!Array.isArray(danhSach)) {
            return [];
        }

        return danhSach;
    } catch (loi) {
        return [];
    }
};

const luuDanhSachTheoDoi = (danhSach) => {
    localStorage.setItem(
        KHOA_THEO_DOI,
        JSON.stringify(danhSach)
    );
};

const capNhatTrangThaiTheoDoi = () => {
    const cacNutTheoDoi = document.querySelectorAll(
        '.the-nguoi-dung .nut-phu'
    );

    const danhSachTheoDoi = docDanhSachTheoDoi();

    cacNutTheoDoi.forEach((nut) => {
        const theNguoiDung = nut.closest('.the-nguoi-dung');

        if (theNguoiDung === null) {
            return;
        }

        const nguoiDung = theNguoiDung.querySelector('h3');

        if (nguoiDung === null) {
            return;
        }

        const tenNguoiDung = nguoiDung.textContent.trim();

        if (danhSachTheoDoi.includes(tenNguoiDung)) {
            nut.textContent = 'Đang theo dõi';
            nut.classList.add('dang-theo-doi');
        } else {
            nut.textContent = 'Theo dõi';
            nut.classList.remove('dang-theo-doi');
        }
    });
};

const xuLyTheoDoi = (event) => {
    const nutTheoDoi = event.target.closest(
        '.the-nguoi-dung .nut-phu'
    );

    if (nutTheoDoi === null) {
        return;
    }

    const theNguoiDung = nutTheoDoi.closest('.the-nguoi-dung');

    if (theNguoiDung === null) {
        return;
    }

    const nguoiDung = theNguoiDung.querySelector('h3');

    if (nguoiDung === null) {
        return;
    }

    const tenNguoiDung = nguoiDung.textContent.trim();

    let danhSachTheoDoi = docDanhSachTheoDoi();

    if (danhSachTheoDoi.includes(tenNguoiDung)) {
        danhSachTheoDoi = danhSachTheoDoi.filter(
            (ten) => ten !== tenNguoiDung
        );
    } else {
        danhSachTheoDoi.push(tenNguoiDung);
    }

    luuDanhSachTheoDoi(danhSachTheoDoi);

    capNhatTrangThaiTheoDoi();
};

const khoiTaoTheoDoi = () => {
    const khuVucTheoDoi = document.querySelector(
        '.goi-y-theo-doi'
    );

    if (khuVucTheoDoi === null) {
        return;
    }

    khuVucTheoDoi.addEventListener(
        'click',
        xuLyTheoDoi
    );

    capNhatTrangThaiTheoDoi();
};

/* ================================
   KHỞI TẠO
   ================================ */

khoiTaoTuongTacBangTin();
khoiTaoTheoDoi();
taiDuLieuApi();