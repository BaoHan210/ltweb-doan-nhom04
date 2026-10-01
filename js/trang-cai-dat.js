/*
 * trang-cai-dat.js
 * Xử lý trang cài đặt tài khoản người dùng.
 * Lưu thông tin cá nhân, sở thích và tùy chọn thông báo bằng localStorage.
 */

import {
    docNguoiDungHienTai,
    docDanhSachTaiKhoan,
    ghiDanhSachTaiKhoan,
    dangXuat,
    doiMatKhau,
    xoaTaiKhoan
} from './tai-khoan.js';

const tenKhoaCaiDat = 'caiDatNguoiDung';


const layKhoaNguoiDung = (
    nguoiDung
) => {

    if (nguoiDung === null) {
        return '';
    }

    return String(nguoiDung.id);
};


const docCaiDat = (
    nguoiDung
) => {

    const khoaNguoiDung =
        layKhoaNguoiDung(
            nguoiDung
        );

    if (khoaNguoiDung === '') {
        return {};
    }

    const duLieu =
        localStorage.getItem(
            tenKhoaCaiDat
        );

    if (duLieu === null) {
        return {};
    }

    try {

        const danhSachCaiDat =
            JSON.parse(
                duLieu
            );

        if (
            typeof danhSachCaiDat !== 'object'
            || danhSachCaiDat === null
        ) {
            return {};
        }

        return (
            danhSachCaiDat[khoaNguoiDung]
            || {}
        );

    } catch (error) {

        return {};
    }
};


const ghiCaiDat = (
    nguoiDung,
    caiDat
) => {

    const khoaNguoiDung =
        layKhoaNguoiDung(
            nguoiDung
        );

    if (khoaNguoiDung === '') {
        return;
    }

    let danhSachCaiDat = {};

    const duLieu =
        localStorage.getItem(
            tenKhoaCaiDat
        );

    if (duLieu !== null) {

        try {

            const duLieuDaLuu =
                JSON.parse(
                    duLieu
                );

            if (
                typeof duLieuDaLuu === 'object'
                && duLieuDaLuu !== null
            ) {
                danhSachCaiDat =
                    duLieuDaLuu;
            }

        } catch (error) {

            danhSachCaiDat = {};
        }
    }

    danhSachCaiDat[khoaNguoiDung] =
        caiDat;

    localStorage.setItem(
        tenKhoaCaiDat,
        JSON.stringify(
            danhSachCaiDat
        )
    );
};


const timTaiKhoanHienTai = (
    nguoiDung
) => {

    const danhSachTaiKhoan =
        docDanhSachTaiKhoan();

    return danhSachTaiKhoan.find(
        (taiKhoan) => {
            return taiKhoan.id === nguoiDung.id;
        }
    );
};


const hienThiThongBao = (
    noiDung
) => {

    const thongBao =
        document.querySelector(
            '#thong-bao-cai-dat'
        );

    if (thongBao === null) {
        window.alert(noiDung);
        return;
    }

    thongBao.textContent =
        noiDung;

    thongBao.hidden = false;
};


const dienThongTinTaiKhoan = (
    taiKhoan
) => {

    const oHoTen =
        document.querySelector(
            '#fullname'
        );

    const oEmail =
        document.querySelector(
            '#email'
        );

    const oSoDienThoai =
        document.querySelector(
            '#phone'
        );

    if (oHoTen !== null) {
        oHoTen.value =
            taiKhoan.hoTen || '';
    }

    if (oEmail !== null) {
        oEmail.value =
            taiKhoan.email || '';
    }

    if (oSoDienThoai !== null) {
        oSoDienThoai.value =
            taiKhoan.soDienThoai || '';
    }
};


const dienCaiDat = (
    caiDat
) => {

    const danhMuc =
        document.querySelector(
            '#favorite-category'
        );

    const nganSach =
        document.querySelector(
            '#preferred-budget'
        );

    const thoiGian =
        document.querySelector(
            '#preferred-time'
        );

    const khauPhan =
        document.querySelector(
            '#preferred-servings'
        );

    const thongBaoBinhLuan =
        document.querySelector(
            '[name="comment_notification"]'
        );

    const thongBaoLuotThich =
        document.querySelector(
            '[name="like_notification"]'
        );

    const thongBaoTheoDoi =
        document.querySelector(
            '[name="follow_notification"]'
        );

    const thongBaoCongThuc =
        document.querySelector(
            '[name="recipe_notification"]'
        );

    if (danhMuc !== null) {
        danhMuc.value =
            caiDat.danhMuc || '';
    }

    if (nganSach !== null) {
        nganSach.value =
            caiDat.nganSach || '';
    }

    if (thoiGian !== null) {
        thoiGian.value =
            caiDat.thoiGian || '';
    }

    if (khauPhan !== null) {
        khauPhan.value =
            caiDat.khauPhan || '';
    }

    if (thongBaoBinhLuan !== null) {
        thongBaoBinhLuan.checked =
            caiDat.thongBaoBinhLuan !== false;
    }

    if (thongBaoLuotThich !== null) {
        thongBaoLuotThich.checked =
            caiDat.thongBaoLuotThich !== false;
    }

    if (thongBaoTheoDoi !== null) {
        thongBaoTheoDoi.checked =
            caiDat.thongBaoTheoDoi === true;
    }

    if (thongBaoCongThuc !== null) {
        thongBaoCongThuc.checked =
            caiDat.thongBaoCongThuc === true;
    }
};


const capNhatThongTinTaiKhoan = (
    taiKhoan
) => {

    const oHoTen =
        document.querySelector(
            '#fullname'
        );

    const oEmail =
        document.querySelector(
            '#email'
        );

    const oSoDienThoai =
        document.querySelector(
            '#phone'
        );

    const hoTenMoi =
        oHoTen === null
            ? taiKhoan.hoTen
            : oHoTen.value.trim();

    const emailMoi =
        oEmail === null
            ? taiKhoan.email
            : oEmail.value.trim();

    const soDienThoaiMoi =
        oSoDienThoai === null
            ? taiKhoan.soDienThoai || ''
            : oSoDienThoai.value.trim();

    if (hoTenMoi === '') {

    hienThiThongBao(
        'Vui lòng nhập họ và tên.'
    );

    return false;
}

if (emailMoi === '') {

    hienThiThongBao(
        'Vui lòng nhập email.'
    );

    return false;
}

if (soDienThoaiMoi === '') {

    hienThiThongBao(
        'Vui lòng nhập số điện thoại.'
    );

    return false;
}

const mauSoDienThoai =
    /^[0-9]{10}$/;

if (
    mauSoDienThoai.test(
        soDienThoaiMoi
    ) === false
) {

    hienThiThongBao(
        'Số điện thoại phải gồm đúng 10 chữ số.'
    );

    return false;
}

    const danhSachTaiKhoan =
        docDanhSachTaiKhoan();

    const emailDaTonTai =
        danhSachTaiKhoan.some(
            (item) => {
                return (
                    item.email === emailMoi
                    && item.id !== taiKhoan.id
                );
            }
        );

    if (emailDaTonTai) {

        hienThiThongBao(
            'Email này đã được sử dụng bởi tài khoản khác.'
        );

        return false;
    }

    taiKhoan.hoTen =
        hoTenMoi;

    taiKhoan.email =
        emailMoi;

    taiKhoan.soDienThoai =
        soDienThoaiMoi;

    const danhSachMoi =
        danhSachTaiKhoan.map(
            (item) => {

                if (item.id === taiKhoan.id) {
                    return taiKhoan;
                }

                return item;
            }
        );

    ghiDanhSachTaiKhoan(
        danhSachMoi
    );

    localStorage.setItem(
        'nguoiDungHienTai',
        JSON.stringify({
            id: taiKhoan.id,
            hoTen: taiKhoan.hoTen,
            email: taiKhoan.email
        })
    );

    return true;
};


const luuCaiDat = (
    event
) => {

    event.preventDefault();

    const nguoiDung =
        docNguoiDungHienTai();

    if (nguoiDung === null) {

        hienThiThongBao(
            'Bạn cần đăng nhập để sử dụng trang cài đặt.'
        );

        return;
    }

    const taiKhoan =
        timTaiKhoanHienTai(
            nguoiDung
        );

    if (taiKhoan === undefined) {

        hienThiThongBao(
            'Không tìm thấy thông tin tài khoản.'
        );

        return;
    }

    const capNhatThanhCong =
        capNhatThongTinTaiKhoan(
            taiKhoan
        );

    if (capNhatThanhCong === false) {
        return;
    }

    const danhMuc =
        document.querySelector(
            '#favorite-category'
        );

    const nganSach =
        document.querySelector(
            '#preferred-budget'
        );

    const thoiGian =
        document.querySelector(
            '#preferred-time'
        );

    const khauPhan =
        document.querySelector(
            '#preferred-servings'
        );

    const thongBaoBinhLuan =
        document.querySelector(
            '[name="comment_notification"]'
        );

    const thongBaoLuotThich =
        document.querySelector(
            '[name="like_notification"]'
        );

    const thongBaoTheoDoi =
        document.querySelector(
            '[name="follow_notification"]'
        );

    const thongBaoCongThuc =
        document.querySelector(
            '[name="recipe_notification"]'
        );

    const caiDat = {
        danhMuc:
            danhMuc === null
                ? ''
                : danhMuc.value,

        nganSach:
            nganSach === null
                ? ''
                : nganSach.value,

        thoiGian:
            thoiGian === null
                ? ''
                : thoiGian.value,

        khauPhan:
            khauPhan === null
                ? ''
                : khauPhan.value,

        thongBaoBinhLuan:
            thongBaoBinhLuan !== null
            && thongBaoBinhLuan.checked,

        thongBaoLuotThich:
            thongBaoLuotThich !== null
            && thongBaoLuotThich.checked,

        thongBaoTheoDoi:
            thongBaoTheoDoi !== null
            && thongBaoTheoDoi.checked,

        thongBaoCongThuc:
            thongBaoCongThuc !== null
            && thongBaoCongThuc.checked
    };

    ghiCaiDat(
        nguoiDung,
        caiDat
    );

    hienThiThongBao(
        'Đã lưu cài đặt thành công.'
    );
};


const khoiPhucCaiDat = () => {

    const nguoiDung =
        docNguoiDungHienTai();

    if (nguoiDung === null) {
        return;
    }

    const taiKhoan =
        timTaiKhoanHienTai(
            nguoiDung
        );

    if (taiKhoan !== undefined) {

        dienThongTinTaiKhoan(
            taiKhoan
        );
    }

    const caiDat =
        docCaiDat(
            nguoiDung
        );

    dienCaiDat(
        caiDat
    );

    hienThiThongBao(
        'Đã khôi phục cài đặt đã lưu.'
    );
};


/*
 * Tạo form đổi mật khẩu.
 */
const taoFormDoiMatKhau = () => {

    const formCu =
        document.querySelector(
            '#form-doi-mat-khau'
        );

    if (formCu !== null) {
        return formCu;
    }

    const khuVucBaoMat =
        document.querySelector(
            '.khung-tai-khoan'
        );

    if (khuVucBaoMat === null) {
        return null;
    }

    const form =
        document.createElement(
            'form'
        );

    form.id =
        'form-doi-mat-khau';

    form.className =
    'form-doi-mat-khau';

form.noValidate = true;

    form.innerHTML = `
        <h3>Đổi mật khẩu</h3>

        <p class="dong-cai-dat">
            <label for="mat-khau-cu">
                Mật khẩu hiện tại
            </label>
            <input
                type="password"
                id="mat-khau-cu"
                name="mat_khau_cu"
                autocomplete="current-password"
                required
            >
        </p>

        <p class="dong-cai-dat">
            <label for="mat-khau-moi">
                Mật khẩu mới
            </label>
            <input
                type="password"
                id="mat-khau-moi"
                name="mat_khau_moi"
                autocomplete="new-password"
                minlength="6"
                required
            >
        </p>

        <p class="dong-cai-dat">
            <label for="xac-nhan-mat-khau">
                Nhập lại mật khẩu mới
            </label>
            <input
                type="password"
                id="xac-nhan-mat-khau"
                name="xac_nhan_mat_khau"
                autocomplete="new-password"
                minlength="6"
                required
            >
        </p>

        <p class="hanh-dong-cai-dat">
            <button
                class="nut nut-chinh"
                type="submit"
            >
                Xác nhận đổi mật khẩu
            </button>

            <button
                class="nut nut-phu"
                id="nut-huy-doi-mat-khau"
                type="button"
            >
                Hủy
            </button>
        </p>
    `;

    khuVucBaoMat.appendChild(
        form
    );

    form.addEventListener(
        'submit',
        xuLyDoiMatKhau
    );

    const nutHuy =
        document.querySelector(
            '#nut-huy-doi-mat-khau'
        );

    if (nutHuy !== null) {

        nutHuy.addEventListener(
            'click',
            () => {
                form.remove();
            }
        );
    }

    return form;
};


/*
 * Xử lý khi người dùng xác nhận đổi mật khẩu.
 */
const xuLyDoiMatKhau = (
    event
) => {

    event.preventDefault();

    const nguoiDung =
        docNguoiDungHienTai();

    if (nguoiDung === null) {

        hienThiThongBao(
            'Bạn cần đăng nhập để đổi mật khẩu.'
        );

        return;
    }

    const oMatKhauCu =
        document.querySelector(
            '#mat-khau-cu'
        );

    const oMatKhauMoi =
        document.querySelector(
            '#mat-khau-moi'
        );

    const oXacNhanMatKhau =
        document.querySelector(
            '#xac-nhan-mat-khau'
        );

    if (
        oMatKhauCu === null
        || oMatKhauMoi === null
        || oXacNhanMatKhau === null
    ) {

        hienThiThongBao(
            'Không tìm thấy biểu mẫu đổi mật khẩu.'
        );

        return;
    }

    const matKhauCu =
        oMatKhauCu.value.trim();

    const matKhauMoi =
        oMatKhauMoi.value.trim();

    const xacNhanMatKhau =
        oXacNhanMatKhau.value.trim();

    if (matKhauCu === '') {

        hienThiThongBao(
            'Vui lòng nhập mật khẩu hiện tại.'
        );

        oMatKhauCu.focus();

        return;
    }

    if (matKhauMoi === '') {

        hienThiThongBao(
            'Vui lòng nhập mật khẩu mới.'
        );

        oMatKhauMoi.focus();

        return;
    }

    if (xacNhanMatKhau === '') {

        hienThiThongBao(
            'Vui lòng nhập lại mật khẩu mới.'
        );

        oXacNhanMatKhau.focus();

        return;
    }

    if (matKhauMoi.length < 6) {

        hienThiThongBao(
            'Mật khẩu mới phải có ít nhất 6 ký tự.'
        );

        oMatKhauMoi.focus();

        return;
    }

    if (
        matKhauMoi !== xacNhanMatKhau
    ) {

        hienThiThongBao(
            'Mật khẩu mới và mật khẩu xác nhận không giống nhau.'
        );

        oXacNhanMatKhau.focus();

        return;
    }

    if (matKhauCu === matKhauMoi) {

        hienThiThongBao(
            'Mật khẩu mới phải khác mật khẩu hiện tại.'
        );

        oMatKhauMoi.focus();

        return;
    }

    const doiMatKhauThanhCong =
        doiMatKhau(
            nguoiDung.id,
            matKhauCu,
            matKhauMoi
        );

    if (
        doiMatKhauThanhCong === false
    ) {

        hienThiThongBao(
            'Mật khẩu hiện tại không chính xác.'
        );

        oMatKhauCu.focus();

        return;
    }

    hienThiThongBao(
        'Đổi mật khẩu thành công.'
    );

    const form =
        document.querySelector(
            '#form-doi-mat-khau'
        );

    if (form !== null) {
        form.reset();
        form.remove();
    }
};


/*
 * Đăng xuất tài khoản.
 */
const xuLyDangXuat = () => {

    const dongY =
        window.confirm(
            'Bạn có chắc muốn đăng xuất không?'
        );

    if (dongY === false) {
        return;
    }

    dangXuat();

    window.location.href =
        'index.html';
};


/*
 * Xóa tài khoản.
 */
const xuLyXoaTaiKhoan = () => {

    const nguoiDung =
        docNguoiDungHienTai();

    if (nguoiDung === null) {

        hienThiThongBao(
            'Bạn cần đăng nhập để xóa tài khoản.'
        );

        return;
    }

    const dongY =
        window.confirm(
            'Bạn có chắc muốn xóa tài khoản? Dữ liệu tài khoản sẽ bị xóa và không thể khôi phục.'
        );

    if (dongY === false) {
        return;
    }

    const xoaThanhCong =
        xoaTaiKhoan(
            nguoiDung.id
        );

    if (xoaThanhCong === false) {

        hienThiThongBao(
            'Không thể xóa tài khoản.'
        );

        return;
    }

    window.alert(
        'Tài khoản đã được xóa.'
    );

    window.location.href =
        'index.html';
};


const khoiTaoTrangCaiDat = () => {

    const nguoiDung =
        docNguoiDungHienTai();

    if (nguoiDung === null) {

        hienThiThongBao(
            'Bạn chưa đăng nhập. Vui lòng đăng nhập để sử dụng cài đặt.'
        );

        return;
    }

    const taiKhoan =
        timTaiKhoanHienTai(
            nguoiDung
        );

    if (taiKhoan === undefined) {

        hienThiThongBao(
            'Không tìm thấy thông tin tài khoản.'
        );

        return;
    }

    dienThongTinTaiKhoan(
        taiKhoan
    );

    const caiDat =
        docCaiDat(
            nguoiDung
        );

    dienCaiDat(
        caiDat
    );

    const formCaiDat =
        document.querySelector(
            '#form-cai-dat'
        );

    if (formCaiDat !== null) {

        formCaiDat.addEventListener(
            'submit',
            luuCaiDat
        );

        formCaiDat.addEventListener(
            'reset',
            () => {

                window.setTimeout(
                    khoiPhucCaiDat,
                    0
                );
            }
        );
    }

    const nutDangXuat =
        document.querySelector(
            '#nut-dang-xuat'
        );

    if (nutDangXuat !== null) {

        nutDangXuat.addEventListener(
            'click',
            xuLyDangXuat
        );
    }

    const nutDoiMatKhau =
        document.querySelector(
            '#nut-doi-mat-khau'
        );

    if (nutDoiMatKhau !== null) {

        nutDoiMatKhau.addEventListener(
            'click',
            () => {
                taoFormDoiMatKhau();
            }
        );
    }

    const nutXoaTaiKhoan =
        document.querySelector(
            '#nut-xoa-tai-khoan'
        );

    if (nutXoaTaiKhoan !== null) {

        nutXoaTaiKhoan.addEventListener(
            'click',
            xuLyXoaTaiKhoan
        );
    }
};


khoiTaoTrangCaiDat();