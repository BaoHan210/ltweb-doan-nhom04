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


const tenKhoaCaiDat =
    'caiDatNguoiDung';


/*
 * Lấy khóa cài đặt theo ID người dùng.
 */
const layKhoaNguoiDung = (
    nguoiDung
) => {

    if (
        nguoiDung === null
        || typeof nguoiDung !== 'object'
        || nguoiDung.id === undefined
        || nguoiDung.id === null
    ) {
        return '';
    }

    return String(
        nguoiDung.id
    );
};


/*
 * Đọc cài đặt của người dùng hiện tại.
 */
const docCaiDat = (
    nguoiDung
) => {

    const khoaNguoiDung =
        layKhoaNguoiDung(
            nguoiDung
        );

    if (
        khoaNguoiDung === ''
    ) {
        return {};
    }

    const duLieu =
        localStorage.getItem(
            tenKhoaCaiDat
        );

    if (
        duLieu === null
    ) {
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
            || Array.isArray(
                danhSachCaiDat
            )
        ) {
            return {};
        }

        const caiDat =
            danhSachCaiDat[
                khoaNguoiDung
            ];

        if (
            caiDat === null
            || typeof caiDat !== 'object'
        ) {
            return {};
        }

        return caiDat;

    } catch (error) {

        return {};
    }
};


/*
 * Ghi cài đặt của người dùng.
 */
const ghiCaiDat = (
    nguoiDung,
    caiDat
) => {

    const khoaNguoiDung =
        layKhoaNguoiDung(
            nguoiDung
        );

    if (
        khoaNguoiDung === ''
    ) {
        return;
    }

    let danhSachCaiDat = {};

    const duLieu =
        localStorage.getItem(
            tenKhoaCaiDat
        );

    if (
        duLieu !== null
    ) {

        try {

            const duLieuDaLuu =
                JSON.parse(
                    duLieu
                );

            if (
                typeof duLieuDaLuu === 'object'
                && duLieuDaLuu !== null
                && Array.isArray(
                    duLieuDaLuu
                ) === false
            ) {
                danhSachCaiDat =
                    duLieuDaLuu;
            }

        } catch (error) {

            danhSachCaiDat = {};
        }
    }

    danhSachCaiDat[
        khoaNguoiDung
    ] =
        caiDat;

    localStorage.setItem(
        tenKhoaCaiDat,
        JSON.stringify(
            danhSachCaiDat
        )
    );
};


/*
 * Tìm tài khoản hiện tại trong danh sách tài khoản.
 */
const timTaiKhoanHienTai = (
    nguoiDung
) => {

    if (
        nguoiDung === null
    ) {
        return undefined;
    }

    const danhSachTaiKhoan =
        docDanhSachTaiKhoan();

    return danhSachTaiKhoan.find(
        (taiKhoan) => {

            return (
                String(
                    taiKhoan.id
                )
                ===
                String(
                    nguoiDung.id
                )
            );
        }
    );
};


/*
 * Hiển thị thông báo trên trang.
 */
const hienThiThongBao = (
    noiDung
) => {

    const thongBao =
        document.querySelector(
            '#thong-bao-cai-dat'
        );

    if (
        thongBao === null
    ) {
        window.alert(
            noiDung
        );

        return;
    }

    thongBao.textContent =
        noiDung;

    thongBao.hidden =
        false;
};


/*
 * Ẩn thông báo.
 */
const anThongBao = () => {

    const thongBao =
        document.querySelector(
            '#thong-bao-cai-dat'
        );

    if (
        thongBao !== null
    ) {
        thongBao.hidden =
            true;

        thongBao.textContent =
            '';
    }
};


/*
 * Điền thông tin tài khoản vào form.
 */
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

    if (
        oHoTen !== null
    ) {
        oHoTen.value =
            taiKhoan.hoTen || '';
    }

    if (
        oEmail !== null
    ) {
        oEmail.value =
            taiKhoan.email || '';
    }

    if (
        oSoDienThoai !== null
    ) {
        oSoDienThoai.value =
            taiKhoan.soDienThoai || '';
    }
};


/*
 * Điền cài đặt sở thích và thông báo.
 */
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

    if (
        danhMuc !== null
    ) {
        danhMuc.value =
            caiDat.danhMuc || '';
    }

    if (
        nganSach !== null
    ) {
        nganSach.value =
            caiDat.nganSach || '';
    }

    if (
        thoiGian !== null
    ) {
        thoiGian.value =
            caiDat.thoiGian || '';
    }

    if (
        khauPhan !== null
    ) {
        khauPhan.value =
            caiDat.khauPhan || '';
    }

    if (
        thongBaoBinhLuan !== null
    ) {
        thongBaoBinhLuan.checked =
            caiDat.thongBaoBinhLuan !== false;
    }

    if (
        thongBaoLuotThich !== null
    ) {
        thongBaoLuotThich.checked =
            caiDat.thongBaoLuotThich !== false;
    }

    if (
        thongBaoTheoDoi !== null
    ) {
        thongBaoTheoDoi.checked =
            caiDat.thongBaoTheoDoi === true;
    }

    if (
        thongBaoCongThuc !== null
    ) {
        thongBaoCongThuc.checked =
            caiDat.thongBaoCongThuc === true;
    }
};


/*
 * Cập nhật họ tên, email và số điện thoại.
 */
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
            ? taiKhoan.hoTen || ''
            : oHoTen.value.trim();

    const emailMoi =
        oEmail === null
            ? taiKhoan.email || ''
            : oEmail.value.trim();

    const soDienThoaiMoi =
        oSoDienThoai === null
            ? taiKhoan.soDienThoai || ''
            : oSoDienThoai.value.trim();


    if (
        hoTenMoi === ''
    ) {

        hienThiThongBao(
            'Vui lòng nhập họ và tên.'
        );

        if (
            oHoTen !== null
        ) {
            oHoTen.focus();
        }

        return false;
    }


    if (
        emailMoi === ''
    ) {

        hienThiThongBao(
            'Vui lòng nhập email.'
        );

        if (
            oEmail !== null
        ) {
            oEmail.focus();
        }

        return false;
    }


    const mauEmail =
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (
        mauEmail.test(
            emailMoi
        ) === false
    ) {

        hienThiThongBao(
            'Vui lòng nhập email đúng định dạng.'
        );

        if (
            oEmail !== null
        ) {
            oEmail.focus();
        }

        return false;
    }


    if (
        soDienThoaiMoi === ''
    ) {

        hienThiThongBao(
            'Vui lòng nhập số điện thoại.'
        );

        if (
            oSoDienThoai !== null
        ) {
            oSoDienThoai.focus();
        }

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

        if (
            oSoDienThoai !== null
        ) {
            oSoDienThoai.focus();
        }

        return false;
    }


    const danhSachTaiKhoan =
        docDanhSachTaiKhoan();

    const emailDaTonTai =
        danhSachTaiKhoan.some(
            (item) => {

                return (
                    String(
                        item.email || ''
                    ).trim().toLowerCase()
                    ===
                    emailMoi.toLowerCase()
                    &&
                    String(
                        item.id
                    )
                    !==
                    String(
                        taiKhoan.id
                    )
                );
            }
        );


    if (
        emailDaTonTai
    ) {

        hienThiThongBao(
            'Email này đã được sử dụng bởi tài khoản khác.'
        );

        if (
            oEmail !== null
        ) {
            oEmail.focus();
        }

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

                if (
                    String(
                        item.id
                    )
                    ===
                    String(
                        taiKhoan.id
                    )
                ) {
                    return taiKhoan;
                }

                return item;
            }
        );


    ghiDanhSachTaiKhoan(
        danhSachMoi
    );


    /*
     * Cập nhật phiên đăng nhập hiện tại.
     */
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


/*
 * Lưu toàn bộ cài đặt.
 */
const luuCaiDat = (
    event
) => {

    event.preventDefault();

    anThongBao();

    const nguoiDung =
        docNguoiDungHienTai();


    if (
        nguoiDung === null
    ) {

        hienThiThongBao(
            'Bạn cần đăng nhập để sử dụng trang cài đặt.'
        );

        return;
    }


    const taiKhoan =
        timTaiKhoanHienTai(
            nguoiDung
        );


    if (
        taiKhoan === undefined
    ) {

        hienThiThongBao(
            'Không tìm thấy thông tin tài khoản.'
        );

        return;
    }


    const capNhatThanhCong =
        capNhatThongTinTaiKhoan(
            taiKhoan
        );


    if (
        capNhatThanhCong === false
    ) {
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


/*
 * Khôi phục dữ liệu đã lưu vào form.
 */
const khoiPhucCaiDat = (
    hienThiThongBaoThanhCong = true
) => {

    const nguoiDung =
        docNguoiDungHienTai();

    if (
        nguoiDung === null
    ) {
        return;
    }


    const taiKhoan =
        timTaiKhoanHienTai(
            nguoiDung
        );


    if (
        taiKhoan !== undefined
    ) {

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


    if (
        hienThiThongBaoThanhCong
    ) {

        hienThiThongBao(
            'Đã khôi phục cài đặt đã lưu.'
        );
    }
};


/*
 * Tạo form đổi mật khẩu.
 */
const taoFormDoiMatKhau = () => {

    const formCu =
        document.querySelector(
            '#form-doi-mat-khau'
        );


    if (
        formCu !== null
    ) {
        formCu.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

        const oMatKhauCu =
            document.querySelector(
                '#mat-khau-cu'
            );

        if (
            oMatKhauCu !== null
        ) {
            oMatKhauCu.focus();
        }

        return formCu;
    }


    const khuVucBaoMat =
        document.querySelector(
            '.khung-tai-khoan'
        );


    if (
        khuVucBaoMat === null
    ) {
        hienThiThongBao(
            'Không tìm thấy khu vực đổi mật khẩu.'
        );

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

    form.noValidate =
        true;


    /*
     * Form này chỉ chứa HTML tĩnh.
     * Không nối dữ liệu người dùng/API vào innerHTML.
     */
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
        form.querySelector(
            '#nut-huy-doi-mat-khau'
        );


    if (
        nutHuy !== null
    ) {

        nutHuy.addEventListener(
            'click',
            () => {

                form.remove();

                hienThiThongBao(
                    'Đã hủy thao tác đổi mật khẩu.'
                );
            }
        );
    }


    const oMatKhauCu =
        form.querySelector(
            '#mat-khau-cu'
        );


    if (
        oMatKhauCu !== null
    ) {
        oMatKhauCu.focus();
    }


    return form;
};


/*
 * Xử lý đổi mật khẩu.
 */
const xuLyDoiMatKhau = (
    event
) => {

    event.preventDefault();

    anThongBao();


    const nguoiDung =
        docNguoiDungHienTai();


    if (
        nguoiDung === null
    ) {

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
        oMatKhauCu.value;

    const matKhauMoi =
        oMatKhauMoi.value;

    const xacNhanMatKhau =
        oXacNhanMatKhau.value;


    if (
        matKhauCu.trim() === ''
    ) {

        hienThiThongBao(
            'Vui lòng nhập mật khẩu hiện tại.'
        );

        oMatKhauCu.focus();

        return;
    }


    if (
        matKhauMoi.trim() === ''
    ) {

        hienThiThongBao(
            'Vui lòng nhập mật khẩu mới.'
        );

        oMatKhauMoi.focus();

        return;
    }


    if (
        xacNhanMatKhau.trim() === ''
    ) {

        hienThiThongBao(
            'Vui lòng nhập lại mật khẩu mới.'
        );

        oXacNhanMatKhau.focus();

        return;
    }


    if (
        matKhauMoi.length < 6
    ) {

        hienThiThongBao(
            'Mật khẩu mới phải có ít nhất 6 ký tự.'
        );

        oMatKhauMoi.focus();

        return;
    }


    if (
        matKhauMoi
        !==
        xacNhanMatKhau
    ) {

        hienThiThongBao(
            'Mật khẩu mới và mật khẩu xác nhận không giống nhau.'
        );

        oXacNhanMatKhau.focus();

        return;
    }


    if (
        matKhauCu
        ===
        matKhauMoi
    ) {

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
        doiMatKhauThanhCong
        ===
        false
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


    if (
        form !== null
    ) {

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


    if (
        dongY === false
    ) {
        return;
    }


    dangXuat();

    window.location.href =
        'index.php';
};


/*
 * Xóa tài khoản.
 */
const xuLyXoaTaiKhoan = () => {

    const nguoiDung =
        docNguoiDungHienTai();


    if (
        nguoiDung === null
    ) {

        hienThiThongBao(
            'Bạn cần đăng nhập để xóa tài khoản.'
        );

        return;
    }


    const dongY =
        window.confirm(
            'Bạn có chắc muốn xóa tài khoản? Dữ liệu tài khoản và cài đặt liên quan sẽ bị xóa và không thể khôi phục.'
        );


    if (
        dongY === false
    ) {
        return;
    }


    const xoaThanhCong =
        xoaTaiKhoan(
            nguoiDung.id
        );


    if (
        xoaThanhCong === false
    ) {

        hienThiThongBao(
            'Không thể xóa tài khoản.'
        );

        return;
    }


    window.alert(
        'Tài khoản đã được xóa.'
    );


    window.location.href =
        'index.php';
};


/*
 * Khởi tạo trang cài đặt.
 */
const khoiTaoTrangCaiDat = () => {

    const nguoiDung =
        docNguoiDungHienTai();


    if (
        nguoiDung === null
    ) {

        hienThiThongBao(
            'Bạn chưa đăng nhập. Vui lòng đăng nhập để sử dụng cài đặt.'
        );

        return;
    }


    const taiKhoan =
        timTaiKhoanHienTai(
            nguoiDung
        );


    if (
        taiKhoan === undefined
    ) {

        hienThiThongBao(
            'Không tìm thấy thông tin tài khoản.'
        );

        return;
    }


    /*
     * Điền dữ liệu hiện tại.
     */
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


    /*
     * Form cài đặt.
     */
    const formCaiDat =
        document.querySelector(
            '#form-cai-dat'
        );


    if (
        formCaiDat !== null
    ) {

        formCaiDat.addEventListener(
            'submit',
            luuCaiDat
        );


        formCaiDat.addEventListener(
            'reset',
            () => {

                window.setTimeout(
                    () => {
                        khoiPhucCaiDat(
                            false
                        );
                    },
                    0
                );
            }
        );
    }


    /*
     * Nút đăng xuất.
     */
    const nutDangXuat =
        document.querySelector(
            '#nut-dang-xuat'
        );


    if (
        nutDangXuat !== null
    ) {

        nutDangXuat.addEventListener(
            'click',
            xuLyDangXuat
        );
    }


    /*
     * Nút đổi mật khẩu.
     */
    const nutDoiMatKhau =
        document.querySelector(
            '#nut-doi-mat-khau'
        );


    if (
        nutDoiMatKhau !== null
    ) {

        nutDoiMatKhau.addEventListener(
            'click',
            () => {

                taoFormDoiMatKhau();
            }
        );
    }


    /*
     * Nút xóa tài khoản.
     */
    const nutXoaTaiKhoan =
        document.querySelector(
            '#nut-xoa-tai-khoan'
        );


    if (
        nutXoaTaiKhoan !== null
    ) {

        nutXoaTaiKhoan.addEventListener(
            'click',
            xuLyXoaTaiKhoan
        );
    }
};


khoiTaoTrangCaiDat();