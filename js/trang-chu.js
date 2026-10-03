/*
 * trang-chu.js
 *
 * Chức năng:
 * 1. Tải món ăn từ Public REST API TheMealDB.
 * 2. Hiển thị trạng thái loading, error và empty.
 * 3. Thích bài viết.
 * 4. Lưu bài viết.
 * 5. Xem / thu gọn nội dung bài viết.
 * 6. Bình luận bài viết.
 * 7. Chia sẻ bài viết.
 * 8. Theo dõi người dùng.
 */

import { taiJSON } from './api.js';


/* =========================================================
   1. CẤU HÌNH API
   ========================================================= */

const URL_API_MON_AN =
    'https://www.themealdb.com/api/json/v1/1/random.php';


/* =========================================================
   2. PHẦN DỮ LIỆU API
   ========================================================= */

const khuVucDuLieuApi = document.querySelector(
    '.noi-dung-api'
);


/*
 * Tạo thẻ món ăn từ dữ liệu API.
 *
 * Chỉ sử dụng những trường cần thiết:
 * - strMeal
 * - strCategory
 * - strArea
 * - strMealThumb
 */
const taoTheMonAnApi = (monAn) => {
    const theMonAn = document.createElement('article');

    theMonAn.className = 'bai-viet-api';

    /*
     * Hình ảnh món ăn.
     */
    if (monAn.strMealThumb) {
        const hinhAnh = document.createElement('img');

        hinhAnh.src = monAn.strMealThumb;

        hinhAnh.alt =
            monAn.strMeal || 'Món ăn từ API';

        hinhAnh.loading = 'lazy';

        theMonAn.appendChild(
            hinhAnh
        );
    }


    /*
     * Tên món ăn.
     */
    const tieuDe = document.createElement('h3');

    tieuDe.textContent =
        monAn.strMeal || 'Chưa có tên món ăn';

    theMonAn.appendChild(
        tieuDe
    );


    /*
     * Thông tin danh mục và khu vực.
     */
    const thongTin = document.createElement('p');

    thongTin.className =
        'thong-tin-mon-api';

    thongTin.textContent =
        `${monAn.strCategory || 'Món ăn'} · ${monAn.strArea || 'Ẩm thực quốc tế'}`;

    theMonAn.appendChild(
        thongTin
    );


    return theMonAn;
};


/*
 * Hiển thị trạng thái loading / empty.
 */
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

    thongBao.setAttribute(
        'aria-live',
        'polite'
    );

    thongBao.textContent =
        noiDung;

    khuVucDuLieuApi.appendChild(
        thongBao
    );
};


/*
 * Hiển thị lỗi API và nút thử lại.
 */
const hienThiLoiApi = () => {
    if (khuVucDuLieuApi === null) {
        return;
    }

    khuVucDuLieuApi.replaceChildren();


    const thongBao =
        document.createElement('p');

    thongBao.className =
        'thong-bao-loi';

    thongBao.setAttribute(
        'role',
        'alert'
    );

    thongBao.textContent =
        'Không thể tải dữ liệu món ăn lúc này.';


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
        taiDuLieuApi
    );


    khuVucDuLieuApi.appendChild(
        thongBao
    );

    khuVucDuLieuApi.appendChild(
        nutThuLai
    );
};


/*
 * Hiển thị món ăn từ Public REST API.
 */
const hienThiDuLieuApi = (
    danhSachMonAn
) => {
    if (khuVucDuLieuApi === null) {
        return;
    }


    khuVucDuLieuApi.replaceChildren();


    /*
     * Kiểm tra dữ liệu rỗng.
     */
    if (
        Array.isArray(danhSachMonAn) === false
        || danhSachMonAn.length === 0
    ) {
        hienThiTrangThaiApi(
            'Chưa có món ăn để hiển thị.'
        );

        return;
    }


    /*
     * Chỉ hiển thị các thẻ món ăn.
     */
    danhSachMonAn.forEach(
        (monAn) => {
            const theMonAn =
                taoTheMonAnApi(monAn);

            khuVucDuLieuApi.appendChild(
                theMonAn
            );
        }
    );
};


/*
 * Tải dữ liệu từ Public REST API.
 */
const taiDuLieuApi = async () => {
    if (khuVucDuLieuApi === null) {
        return;
    }


    hienThiTrangThaiApi(
        'Đang tải món ăn từ Public REST API...'
    );


    try {
        const duLieu =
            await taiJSON(
                URL_API_MON_AN
            );


        const danhSachMonAn =
            Array.isArray(duLieu.meals)
                ? duLieu.meals
                : [];


        hienThiDuLieuApi(
            danhSachMonAn
        );

    } catch (error) {

        console.error(
            'Lỗi tải dữ liệu API:',
            error
        );


        hienThiLoiApi();
    }
};


/* =========================================================
   3. THÍCH BÀI VIẾT
   ========================================================= */

const xuLyThichBaiViet = (
    nutThich
) => {

    const idBaiViet =
        nutThich.dataset.baiVietId;


    if (idBaiViet === undefined) {
        return;
    }


    const khoa =
        `baiVietDaThich_${idBaiViet}`;


    const daThich =
        localStorage.getItem(khoa) === 'true';


    if (daThich === true) {

        localStorage.removeItem(
            khoa
        );


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


/* =========================================================
   4. LƯU BÀI VIẾT
   ========================================================= */

const xuLyLuuBaiViet = (
    nutLuu
) => {

    const idBaiViet =
        nutLuu.dataset.baiVietId;


    if (idBaiViet === undefined) {
        return;
    }


    const khoa =
        `baiVietDaLuu_${idBaiViet}`;


    const daLuu =
        localStorage.getItem(khoa) === 'true';


    if (daLuu === true) {

        localStorage.removeItem(
            khoa
        );


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


/* =========================================================
   5. HIỆN / ẨN NỘI DUNG
   ========================================================= */

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


    /*
     * Bài viết tĩnh.
     */
    const noiDungMoRong =
        baiViet.querySelector(
            '.noi-dung-mo-rong'
        );


    if (noiDungMoRong !== null) {

        noiDungMoRong.hidden =
            !noiDungMoRong.hidden;


        if (
            noiDungMoRong.hidden === true
        ) {

            nutXem.textContent =
                '⋯';

            nutXem.setAttribute(
                'aria-label',
                'Xem nội dung bài viết'
            );

            nutXem.title =
                'Xem';

        } else {

            nutXem.textContent =
                '⌃';

            nutXem.setAttribute(
                'aria-label',
                'Thu gọn nội dung bài viết'
            );

            nutXem.title =
                'Thu gọn';
        }


        return;
    }


    /*
     * Bài viết API.
     */
    const noiDungApi =
        baiViet.querySelector(
            '.thong-tin-mon-api'
        );


    if (noiDungApi === null) {
        return;
    }


    noiDungApi.hidden =
        !noiDungApi.hidden;


    nutXem.textContent =
        noiDungApi.hidden
            ? '⋯'
            : '⌃';
};


/* =========================================================
   6. HIỆN / ẨN BÌNH LUẬN
   ========================================================= */

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
        !khuVuc.hidden;


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


/* =========================================================
   7. GỬI BÌNH LUẬN
   ========================================================= */

const xuLyGuiBinhLuan = (
    formBinhLuan
) => {

    const oNhap =
        formBinhLuan.querySelector(
            'input[name="comment"]'
        );


    const danhSach =
        formBinhLuan.parentElement.querySelector(
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


    oNhap.setCustomValidity(
        ''
    );


    const binhLuan =
        document.createElement('p');


    binhLuan.className =
        'binh-luan-item';


    /*
     * Dùng textContent để nội dung
     * người dùng không được diễn giải
     * thành HTML.
     */
    binhLuan.textContent =
        noiDung;


    danhSach.appendChild(
        binhLuan
    );


    oNhap.value =
        '';
};


/* =========================================================
   8. CHIA SẺ BÀI VIẾT
   ========================================================= */

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
        baiViet.querySelector(
            'h3'
        );


    const tenBaiViet =
        tieuDe === null
            ? 'Bài viết Cook with me'
            : tieuDe.textContent;


    const duLieuChiaSe = {
        title:
            tenBaiViet,

        text:
            `Xem bài viết: ${tenBaiViet}`,

        url:
            window.location.href
    };


    /*
     * Ưu tiên Web Share API.
     */
    if (
        navigator.share !== undefined
    ) {

        try {

            await navigator.share(
                duLieuChiaSe
            );

            return;

        } catch (error) {

            /*
             * Người dùng có thể đóng
             * hộp thoại chia sẻ.
             */
            return;
        }
    }


    /*
     * Nếu không hỗ trợ navigator.share,
     * thử sao chép URL.
     */
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


/* =========================================================
   9. CẬP NHẬT TRẠNG THÁI THÍCH / LƯU
   ========================================================= */

const capNhatTrangThaiTuongTac = () => {

    const danhSachNutThich =
        document.querySelectorAll(
            '.nut-thich'
        );


    danhSachNutThich.forEach(
        (nutThich) => {

            const idBaiViet =
                nutThich.dataset.baiVietId;


            if (
                idBaiViet === undefined
            ) {
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

                nutThich.setAttribute(
                    'aria-label',
                    'Bỏ thích bài viết'
                );

                nutThich.title =
                    'Bỏ thích';

                return;
            }


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


            if (
                idBaiViet === undefined
            ) {
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

                nutLuu.setAttribute(
                    'aria-label',
                    'Bỏ lưu bài viết'
                );

                nutLuu.title =
                    'Bỏ lưu';

                return;
            }


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
        }
    );
};


/* =========================================================
   10. GẮN SỰ KIỆN CHO BẢNG TIN
   ========================================================= */

const khoiTaoTuongTacBangTin = () => {

    /*
     * Event delegation cho các nút tương tác.
     */
    document.addEventListener(
        'click',
        (event) => {

            const phanTuDich =
                event.target;


            if (
                !(phanTuDich instanceof Element)
            ) {
                return;
            }


            const nutThich =
                phanTuDich.closest(
                    '.nut-thich'
                );


            if (nutThich !== null) {

                xuLyThichBaiViet(
                    nutThich
                );

                return;
            }


            const nutBinhLuan =
                phanTuDich.closest(
                    '.nut-binh-luan'
                );


            if (nutBinhLuan !== null) {

                xuLyNutBinhLuan(
                    nutBinhLuan
                );

                return;
            }


            const nutChiaSe =
                phanTuDich.closest(
                    '.nut-chia-se'
                );


            if (nutChiaSe !== null) {

                xuLyChiaSe(
                    nutChiaSe
                );

                return;
            }


            const nutLuu =
                phanTuDich.closest(
                    '.nut-luu'
                );


            if (nutLuu !== null) {

                xuLyLuuBaiViet(
                    nutLuu
                );

                return;
            }


            const nutXem =
                phanTuDich.closest(
                    '.nut-xem'
                );


            if (nutXem !== null) {

                xuLyXemBaiViet(
                    nutXem
                );
            }
        }
    );


    /*
     * Event delegation cho form bình luận.
     */
    document.addEventListener(
        'submit',
        (event) => {

            const phanTuDich =
                event.target;


            if (
                !(phanTuDich instanceof Element)
            ) {
                return;
            }


            const formBinhLuan =
                phanTuDich.closest(
                    '.form-binh-luan'
                );


            if (
                formBinhLuan === null
            ) {
                return;
            }


            event.preventDefault();


            xuLyGuiBinhLuan(
                formBinhLuan
            );
        }
    );
};


/* =========================================================
   11. THEO DÕI NGƯỜI DÙNG
   ========================================================= */

const khoaTheoDoi =
    'nguoiDungDangTheoDoi';


const docDanhSachTheoDoi = () => {

    const duLieu =
        localStorage.getItem(
            khoaTheoDoi
        );


    if (duLieu === null) {
        return [];
    }


    try {

        const danhSach =
            JSON.parse(duLieu);


        if (
            Array.isArray(danhSach) === false
        ) {
            return [];
        }


        return danhSach;

    } catch (loi) {

        return [];
    }
};


const luuDanhSachTheoDoi = (
    danhSach
) => {

    localStorage.setItem(
        khoaTheoDoi,
        JSON.stringify(danhSach)
    );
};


const capNhatTrangThaiTheoDoi = () => {

    const cacNutTheoDoi =
        document.querySelectorAll(
            '.the-nguoi-dung .nut-phu'
        );


    const danhSachTheoDoi =
        docDanhSachTheoDoi();


    cacNutTheoDoi.forEach(
        (nut) => {

            const theNguoiDung =
                nut.closest(
                    '.the-nguoi-dung'
                );


            if (
                theNguoiDung === null
            ) {
                return;
            }


            const nguoiDung =
                theNguoiDung.querySelector(
                    'h3'
                );


            if (
                nguoiDung === null
            ) {
                return;
            }


            const tenNguoiDung =
                nguoiDung.textContent.trim();


            if (
                danhSachTheoDoi.includes(
                    tenNguoiDung
                )
            ) {

                nut.textContent =
                    'Đang theo dõi';

                nut.classList.add(
                    'dang-theo-doi'
                );

                nut.setAttribute(
                    'aria-pressed',
                    'true'
                );

            } else {

                nut.textContent =
                    'Theo dõi';

                nut.classList.remove(
                    'dang-theo-doi'
                );

                nut.setAttribute(
                    'aria-pressed',
                    'false'
                );
            }
        }
    );
};


const xuLyTheoDoi = (
    event
) => {

    const phanTuDich =
        event.target;


    if (
        !(phanTuDich instanceof Element)
    ) {
        return;
    }


    const nutTheoDoi =
        phanTuDich.closest(
            '.the-nguoi-dung .nut-phu'
        );


    if (
        nutTheoDoi === null
    ) {
        return;
    }


    const theNguoiDung =
        nutTheoDoi.closest(
            '.the-nguoi-dung'
        );


    if (
        theNguoiDung === null
    ) {
        return;
    }


    const nguoiDung =
        theNguoiDung.querySelector(
            'h3'
        );


    if (
        nguoiDung === null
    ) {
        return;
    }


    const tenNguoiDung =
        nguoiDung.textContent.trim();


    let danhSachTheoDoi =
        docDanhSachTheoDoi();


    if (
        danhSachTheoDoi.includes(
            tenNguoiDung
        )
    ) {

        danhSachTheoDoi =
            danhSachTheoDoi.filter(
                (ten) =>
                    ten !== tenNguoiDung
            );

    } else {

        danhSachTheoDoi.push(
            tenNguoiDung
        );
    }


    luuDanhSachTheoDoi(
        danhSachTheoDoi
    );


    capNhatTrangThaiTheoDoi();
};


const khoiTaoTheoDoi = () => {

    const khuVucTheoDoi =
        document.querySelector(
            '.goi-y-theo-doi'
        );


    if (
        khuVucTheoDoi === null
    ) {
        return;
    }


    khuVucTheoDoi.addEventListener(
        'click',
        xuLyTheoDoi
    );


    capNhatTrangThaiTheoDoi();
};


/* =========================================================
   12. KHỞI TẠO TRANG CHỦ
   ========================================================= */

const khoiTaoTrangChu = () => {

    /*
     * Chức năng API.
     */
    if (
        khuVucDuLieuApi !== null
    ) {
        taiDuLieuApi();
    }


    /*
     * Chức năng tương tác bảng tin.
     */
    khoiTaoTuongTacBangTin();


    /*
     * Chức năng theo dõi người dùng.
     */
    khoiTaoTheoDoi();


    /*
     * Khôi phục trạng thái thích / lưu
     * sau khi tải lại trang.
     */
    capNhatTrangThaiTuongTac();
};


if (
    document.readyState === 'loading'
) {

    document.addEventListener(
        'DOMContentLoaded',
        khoiTaoTrangChu
    );

} else {

    khoiTaoTrangChu();
}