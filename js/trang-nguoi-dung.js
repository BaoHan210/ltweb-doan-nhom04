/*
 * trang-nguoi-dung.js
 * Xử lý chức năng theo dõi người dùng trên trang Khám phá người dùng.
 * Lưu và quản lý trạng thái theo dõi bằng localStorage.
 */

const khoaTheoDoi = 'nguoiDungDangTheoDoi';

const docDanhSachTheoDoi = () => {
    const duLieu = localStorage.getItem(khoaTheoDoi);

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
        khoaTheoDoi,
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
            theNguoiDung.querySelector('h2, h3'); // Hỗ trợ cả thẻ h2 và h3 do PHP render

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
        theNguoiDung.querySelector('h2, h3');

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
            '.danh-sach-nguoi-dung, main'
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

document.addEventListener('DOMContentLoaded', khoiTaoTrangNguoiDung);