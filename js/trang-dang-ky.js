/*
 * trang-dang-ky.js
 * Xử lý biểu mẫu đăng ký tài khoản.
 * Kiểm tra dữ liệu và tạo tài khoản mới cho người dùng.
 */

import {
    timTaiKhoanTheoEmail,
    taoTaiKhoan
} from './tai-khoan.js';


/* =========================================================
   1. LẤY CÁC PHẦN TỬ FORM
   ========================================================= */

const formDangKy =
    document.querySelector(
        '.form-dang-ky'
    );

const hoTen =
    document.querySelector(
        '#ho-ten'
    );

const email =
    document.querySelector(
        '#email-dang-ky'
    );

const matKhau =
    document.querySelector(
        '#mat-khau'
    );

const xacNhanMatKhau =
    document.querySelector(
        '#xac-nhan-mat-khau'
    );


/* =========================================================
   2. HIỂN THỊ LỖI
   ========================================================= */

const hienThiLoi = (
    phanTu,
    noiDung
) => {

    if (
        phanTu === null
    ) {
        return;
    }


    phanTu.classList.add(
        'truong-co-loi'
    );


    let thongBao =
        phanTu.parentElement?.querySelector(
            '.thong-bao-loi-truong'
        );


    if (
        thongBao === null
    ) {

        thongBao =
            document.createElement(
                'p'
            );

        thongBao.className =
            'thong-bao-loi-truong';

        thongBao.setAttribute(
            'role',
            'alert'
        );

        phanTu.parentElement?.appendChild(
            thongBao
        );
    }


    thongBao.textContent =
        noiDung;
};


/* =========================================================
   3. XÓA LỖI
   ========================================================= */

const xoaLoi = (
    phanTu
) => {

    if (
        phanTu === null
    ) {
        return;
    }


    phanTu.classList.remove(
        'truong-co-loi'
    );


    const thongBao =
        phanTu.parentElement?.querySelector(
            '.thong-bao-loi-truong'
        );


    if (
        thongBao !== null
    ) {
        thongBao.remove();
    }
};


/* =========================================================
   4. KIỂM TRA HỌ TÊN
   ========================================================= */

const kiemTraHoTen = () => {

    if (
        hoTen === null
    ) {
        return false;
    }


    const giaTri =
        hoTen.value.trim();


    if (
        giaTri === ''
    ) {

        hienThiLoi(
            hoTen,
            'Vui lòng nhập họ và tên.'
        );

        return false;
    }


    if (
        giaTri.length < 2
    ) {

        hienThiLoi(
            hoTen,
            'Họ và tên phải có ít nhất 2 ký tự.'
        );

        return false;
    }


    xoaLoi(
        hoTen
    );

    return true;
};


/* =========================================================
   5. KIỂM TRA EMAIL
   ========================================================= */

const kiemTraEmail = () => {

    if (
        email === null
    ) {
        return false;
    }


    const giaTri =
        email.value
            .trim()
            .toLowerCase();


    const mauEmail =
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


    if (
        giaTri === ''
    ) {

        hienThiLoi(
            email,
            'Vui lòng nhập email.'
        );

        return false;
    }


    if (
        mauEmail.test(
            giaTri
        ) === false
    ) {

        hienThiLoi(
            email,
            'Email không hợp lệ.'
        );

        return false;
    }


    xoaLoi(
        email
    );

    return true;
};


/* =========================================================
   6. KIỂM TRA MẬT KHẨU
   ========================================================= */

const kiemTraMatKhau = () => {

    if (
        matKhau === null
    ) {
        return false;
    }


    const giaTri =
        matKhau.value;


    if (
        giaTri === ''
    ) {

        hienThiLoi(
            matKhau,
            'Vui lòng nhập mật khẩu.'
        );

        return false;
    }


    if (
        giaTri.length < 6
    ) {

        hienThiLoi(
            matKhau,
            'Mật khẩu phải có ít nhất 6 ký tự.'
        );

        return false;
    }


    xoaLoi(
        matKhau
    );

    return true;
};


/* =========================================================
   7. KIỂM TRA XÁC NHẬN MẬT KHẨU
   ========================================================= */

const kiemTraXacNhanMatKhau = () => {

    if (
        xacNhanMatKhau === null
        ||
        matKhau === null
    ) {
        return false;
    }


    if (
        xacNhanMatKhau.value === ''
    ) {

        hienThiLoi(
            xacNhanMatKhau,
            'Vui lòng xác nhận mật khẩu.'
        );

        return false;
    }


    if (
        xacNhanMatKhau.value
        !==
        matKhau.value
    ) {

        hienThiLoi(
            xacNhanMatKhau,
            'Mật khẩu xác nhận không khớp.'
        );

        return false;
    }


    xoaLoi(
        xacNhanMatKhau
    );

    return true;
};


/* =========================================================
   8. HIỂN THỊ THÔNG BÁO CHUNG
   ========================================================= */

const hienThiThongBao = (
    noiDung,
    laLoi = false
) => {

    if (
        formDangKy === null
    ) {
        return;
    }


    let thongBao =
        formDangKy.querySelector(
            '.thong-bao-dang-ky'
        );


    if (
        thongBao === null
    ) {

        thongBao =
            document.createElement(
                'p'
            );

        thongBao.className =
            'thong-bao-dang-ky';

        thongBao.setAttribute(
            'aria-live',
            'polite'
        );

        formDangKy.appendChild(
            thongBao
        );
    }


    thongBao.textContent =
        noiDung;


    thongBao.classList.toggle(
        'thong-bao-dang-ky-loi',
        laLoi
    );
};


/* =========================================================
   9. TẠO ID NGƯỜI DÙNG
   ========================================================= */

const taoIdNguoiDung = () => {

    return (
        `user-${Date.now()}`
    );
};


/* =========================================================
   10. ĐĂNG KÝ TÀI KHOẢN
   ========================================================= */

const dangKyTaiKhoan = () => {

    if (
        hoTen === null
        ||
        email === null
        ||
        matKhau === null
    ) {
        return false;
    }


    const emailNguoiDung =
        email.value
            .trim()
            .toLowerCase();


    /*
     * Kiểm tra email đã tồn tại.
     */
    const taiKhoanTonTai =
        timTaiKhoanTheoEmail(
            emailNguoiDung
        );


    if (
        taiKhoanTonTai !== undefined
    ) {

        hienThiLoi(
            email,
            'Email này đã được đăng ký.'
        );


        hienThiThongBao(
            'Email này đã được đăng ký. Vui lòng sử dụng email khác.',
            true
        );


        email.focus();

        return false;
    }


    /*
     * Tạo thông tin tài khoản.
     */
    const taiKhoanMoi = {

        id:
            taoIdNguoiDung(),

        hoTen:
            hoTen.value.trim(),

        email:
            emailNguoiDung,

        matKhau:
            matKhau.value,

        ngayTao:
            new Date().toISOString()
    };


    /*
     * Lưu tài khoản.
     */
    const taiKhoanDaTao =
        taoTaiKhoan(
            taiKhoanMoi
        );


    /*
     * Không lưu được tài khoản.
     */
    if (
        taiKhoanDaTao === null
    ) {

        hienThiThongBao(
            'Không thể lưu tài khoản. Vui lòng thử lại.',
            true
        );

        return false;
    }


    return true;
};


/* =========================================================
   11. GẮN KIỂM TRA KHI RỜI KHỎI TRƯỜNG
   ========================================================= */

if (
    hoTen !== null
) {

    hoTen.addEventListener(
        'blur',
        kiemTraHoTen
    );
}


if (
    email !== null
) {

    email.addEventListener(
        'blur',
        kiemTraEmail
    );
}


if (
    matKhau !== null
) {

    matKhau.addEventListener(
        'blur',
        kiemTraMatKhau
    );
}


if (
    xacNhanMatKhau !== null
) {

    xacNhanMatKhau.addEventListener(
        'blur',
        kiemTraXacNhanMatKhau
    );
}


/*
 * Khi mật khẩu thay đổi,
 * kiểm tra lại phần xác nhận nếu người dùng
 * đã nhập trước đó.
 */
if (
    matKhau !== null
    &&
    xacNhanMatKhau !== null
) {

    matKhau.addEventListener(
        'input',
        () => {

            if (
                xacNhanMatKhau.value !== ''
            ) {
                kiemTraXacNhanMatKhau();
            }
        }
    );
}


/* =========================================================
   12. XỬ LÝ SUBMIT
   ========================================================= */

if (
    formDangKy !== null
) {

    formDangKy.addEventListener(
        'submit',
        (event) => {

            event.preventDefault();


            /*
             * Kiểm tra toàn bộ trường.
             */
            const hopLeHoTen =
                kiemTraHoTen();

            const hopLeEmail =
                kiemTraEmail();

            const hopLeMatKhau =
                kiemTraMatKhau();

            const hopLeXacNhan =
                kiemTraXacNhanMatKhau();


            if (
                hopLeHoTen === false
                ||
                hopLeEmail === false
                ||
                hopLeMatKhau === false
                ||
                hopLeXacNhan === false
            ) {

                hienThiThongBao(
                    'Vui lòng kiểm tra lại thông tin đăng ký.',
                    true
                );

                return;
            }


            /*
             * Tạo tài khoản.
             */
            const dangKyThanhCong =
                dangKyTaiKhoan();


            if (
                dangKyThanhCong === false
            ) {
                return;
            }


            /*
             * Thông báo thành công.
             */
            hienThiThongBao(
                'Đăng ký tài khoản thành công.'
            );


            /*
             * Xóa dữ liệu form.
             */
            formDangKy.reset();


            /*
             * Xóa trạng thái lỗi còn sót lại.
             */
            xoaLoi(
                hoTen
            );

            xoaLoi(
                email
            );

            xoaLoi(
                matKhau
            );

            xoaLoi(
                xacNhanMatKhau
            );


            /*
             * Đưa con trỏ về ô họ tên
             * để người dùng có thể tiếp tục thao tác.
             */
            if (
                hoTen !== null
            ) {
                hoTen.focus();
            }
        }
    );
}