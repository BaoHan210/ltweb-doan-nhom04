/*
 * tai-khoan.js
 * Quản lý thông tin tài khoản người dùng.
 * Dữ liệu tài khoản được lưu trong localStorage.
 */

const tenKhoaTaiKhoan = 'taiKhoanNguoiDung';


export const docDanhSachTaiKhoan = () => {

    const duLieu =
        localStorage.getItem(
            tenKhoaTaiKhoan
        );

    if (duLieu === null) {
        return [];
    }

    try {

        const danhSach =
            JSON.parse(duLieu);

        if (Array.isArray(danhSach) === false) {
            return [];
        }

        return danhSach;

    } catch (error) {

        return [];
    }
};


export const ghiDanhSachTaiKhoan = (
    danhSachTaiKhoan
) => {

    localStorage.setItem(
        tenKhoaTaiKhoan,
        JSON.stringify(
            danhSachTaiKhoan
        )
    );
};


export const timTaiKhoanTheoEmail = (
    email
) => {

    const danhSach =
        docDanhSachTaiKhoan();

    return danhSach.find(
        (taiKhoan) => {
            return taiKhoan.email === email;
        }
    );
};


export const taoTaiKhoan = (
    thongTinTaiKhoan
) => {

    const danhSach =
        docDanhSachTaiKhoan();

    danhSach.push(
        thongTinTaiKhoan
    );

    ghiDanhSachTaiKhoan(
        danhSach
    );

    return thongTinTaiKhoan;
};

const tenKhoaNguoiDungHienTai =
    'nguoiDungHienTai';


export const dangNhap = (
    email,
    matKhau
) => {

    const danhSachTaiKhoan =
        docDanhSachTaiKhoan();

    const taiKhoan =
        danhSachTaiKhoan.find(
            (item) => {
                return (
                    item.email === email
                    && item.matKhau === matKhau
                );
            }
        );

    if (taiKhoan === undefined) {
        return false;
    }

    localStorage.setItem(
        tenKhoaNguoiDungHienTai,
        JSON.stringify({
            id: taiKhoan.id,
            hoTen: taiKhoan.hoTen,
            email: taiKhoan.email
        })
    );

    return true;
};


export const docNguoiDungHienTai = () => {

    const duLieu =
        localStorage.getItem(
            tenKhoaNguoiDungHienTai
        );

    if (duLieu === null) {
        return null;
    }

    try {

        return JSON.parse(
            duLieu
        );

    } catch (error) {

        return null;
    }
};


export const dangXuat = () => {

    localStorage.removeItem(
        tenKhoaNguoiDungHienTai
    );
};


export const daDangNhap = () => {

    return (
        docNguoiDungHienTai() !== null
    );
};