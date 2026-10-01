/*
 * trang-nguoi-dung.js
 * Xử lý chức năng theo dõi người dùng trên trang
 * Khám phá người dùng.
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
    const cacTheNguoiDung = document.querySelectorAll(
        '.the-nguoi-dung'
    );

    const danhSachTheoDoi = docDanhSachTheoDoi();

    cacTheNguoiDung.forEach((theNguoiDung) => {

        const tenNguoiDungElement =
            theNguoiDung.querySelector('h2');

        const nutTheoDoi =
            theNguoiDung.querySelector('.nut-phu');

        if (
            tenNguoiDungElement === null ||
            nutTheoDoi === null
        ) {
            return;
        }

        const tenNguoiDung =
            tenNguoiDungElement.textContent.trim();

        if (danhSachTheoDoi.includes(tenNguoiDung)) {

            nutTheoDoi.textContent = 'Đang theo dõi';

            nutTheoDoi.classList.add(
                'dang-theo-doi'
            );

        } else {

            nutTheoDoi.textContent = 'Theo dõi';

            nutTheoDoi.classList.remove(
                'dang-theo-doi'
            );
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

    const theNguoiDung =
        nutTheoDoi.closest('.the-nguoi-dung');

    if (theNguoiDung === null) {
        return;
    }

    const tenNguoiDungElement =
        theNguoiDung.querySelector('h2');

    if (tenNguoiDungElement === null) {
        return;
    }

    const tenNguoiDung =
        tenNguoiDungElement.textContent.trim();

    let danhSachTheoDoi =
        docDanhSachTheoDoi();

    if (danhSachTheoDoi.includes(tenNguoiDung)) {

        danhSachTheoDoi =
            danhSachTheoDoi.filter(
                (ten) => ten !== tenNguoiDung
            );

    } else {

        danhSachTheoDoi.push(tenNguoiDung);
    }

    luuDanhSachTheoDoi(danhSachTheoDoi);

    capNhatTrangThaiTheoDoi();
};

const khoiTaoTrangNguoiDung = () => {

    const danhSachNguoiDung =
        document.querySelector(
            '.danh-sach-nguoi-dung'
        );

    if (danhSachNguoiDung === null) {
        return;
    }

    danhSachNguoiDung.addEventListener(
        'click',
        xuLyTheoDoi
    );

    capNhatTrangThaiTheoDoi();
};

khoiTaoTrangNguoiDung();