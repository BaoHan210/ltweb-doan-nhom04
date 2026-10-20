/*
 * trang-dang-ky.js
 * Xử lý kiểm tra dữ liệu biểu mẫu đăng ký phía Client.
 * Việc tạo và lưu tài khoản chính thức do máy chủ PHP xử lý.
 */

/* =========================================================
   1. LẤY CÁC PHẦN TỬ FORM
   ========================================================= */
const formDangKy = document.querySelector('.form-dang-ky');
const hoTen = document.querySelector('#ho-ten');
const email = document.querySelector('#email-dang-ky');
const matKhau = document.querySelector('#mat-khau');
const xacNhanMatKhau = document.querySelector('#xac-nhan-mat-khau');

/* =========================================================
   2. HIỂN THỊ LỖI
   ========================================================= */
const hienThiLoi = (phanTu, noiDung) => {
    if (phanTu === null) return;

    phanTu.classList.add('truong-co-loi');

    let thongBao = phanTu.parentElement?.querySelector('.thong-bao-loi-truong');

    if (thongBao === null || thongBao === undefined) {
        thongBao = document.createElement('p');
        thongBao.className = 'thong-bao-loi-truong';
        thongBao.setAttribute('role', 'alert');
        phanTu.parentElement?.appendChild(thongBao);
    }

    thongBao.textContent = noiDung;
};

/* =========================================================
   3. XÓA LỖI
   ========================================================= */
const xoaLoi = (phanTu) => {
    if (phanTu === null) return;

    phanTu.classList.remove('truong-co-loi');

    const thongBao = phanTu.parentElement?.querySelector('.thong-bao-loi-truong');

    if (thongBao !== null && thongBao !== undefined) {
        thongBao.remove();
    }
};

/* =========================================================
   4. KIỂM TRA HỌ TÊN
   ========================================================= */
const kiemTraHoTen = () => {
    if (hoTen === null) return false;

    const giaTri = hoTen.value.trim();

    if (giaTri === '') {
        hienThiLoi(hoTen, 'Vui lòng nhập họ và tên.');
        return false;
    }

    if (giaTri.length < 2) {
        hienThiLoi(hoTen, 'Họ và tên phải có ít nhất 2 ký tự.');
        return false;
    }

    xoaLoi(hoTen);
    return true;
};

/* =========================================================
   5. KIỂM TRA EMAIL
   ========================================================= */
const kiemTraEmail = () => {
    if (email === null) return false;

    const giaTri = email.value.trim().toLowerCase();
    const mauEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (giaTri === '') {
        hienThiLoi(email, 'Vui lòng nhập email.');
        return false;
    }

    if (mauEmail.test(giaTri) === false) {
        hienThiLoi(email, 'Email không hợp lệ.');
        return false;
    }

    xoaLoi(email);
    return true;
};

/* =========================================================
   6. KIỂM TRA MẬT KHẨU
   ========================================================= */
const kiemTraMatKhau = () => {
    if (matKhau === null) return false;

    const giaTri = matKhau.value;

    if (giaTri === '') {
        hienThiLoi(matKhau, 'Vui lòng nhập mật khẩu.');
        return false;
    }

    if (giaTri.length < 6) {
        hienThiLoi(matKhau, 'Mật khẩu phải có ít nhất 6 ký tự.');
        return false;
    }

    xoaLoi(matKhau);
    return true;
};

/* =========================================================
   7. KIỂM TRA XÁC NHẬN MẬT KHẨU
   ========================================================= */
const kiemTraXacNhanMatKhau = () => {
    if (xacNhanMatKhau === null || matKhau === null) return false;

    if (xacNhanMatKhau.value === '') {
        hienThiLoi(xacNhanMatKhau, 'Vui lòng xác nhận mật khẩu.');
        return false;
    }

    if (xacNhanMatKhau.value !== matKhau.value) {
        hienThiLoi(xacNhanMatKhau, 'Mật khẩu xác nhận không khớp.');
        return false;
    }

    xoaLoi(xacNhanMatKhau);
    return true;
};

/* =========================================================
   8. HIỂN THỊ THÔNG BÁO CHUNG
   ========================================================= */
const hienThiThongBao = (noiDung, laLoi = false) => {
    if (formDangKy === null) return;

    let thongBao = formDangKy.querySelector('.thong-bao-dang-ky');

    if (thongBao === null) {
        thongBao = document.createElement('p');
        thongBao.className = 'thong-bao-dang-ky';
        thongBao.setAttribute('aria-live', 'polite');
        formDangKy.appendChild(thongBao);
    }

    thongBao.textContent = noiDung;
    thongBao.classList.toggle('thong-bao-dang-ky-loi', laLoi);
};

/* =========================================================
   9. GẮN KIỂM TRA KHI RỜI KHỎI TRƯỜNG
   ========================================================= */
const khoiTaoKiemTra = () => {
    if (hoTen !== null) {
        hoTen.addEventListener('blur', kiemTraHoTen);
    }

    if (email !== null) {
        email.addEventListener('blur', kiemTraEmail);
    }

    if (matKhau !== null) {
        matKhau.addEventListener('blur', kiemTraMatKhau);
        matKhau.addEventListener('input', () => {
            if (xacNhanMatKhau && xacNhanMatKhau.value !== '') {
                kiemTraXacNhanMatKhau();
            }
        });
    }

    if (xacNhanMatKhau !== null) {
        xacNhanMatKhau.addEventListener('blur', kiemTraXacNhanMatKhau);
    }
};

/* =========================================================
   10. XỬ LÝ SUBMIT (BỎ LƯU LOCALSTORAGE -> GỬI VỀ PHP)
   ========================================================= */
if (formDangKy !== null) {
    khoiTaoKiemTra();

    formDangKy.addEventListener('submit', (event) => {
        /*
         * Kiểm tra toàn bộ các trường dữ liệu
         */
        const hopLeHoTen = kiemTraHoTen();
        const hopLeEmail = kiemTraEmail();
        const hopLeMatKhau = kiemTraMatKhau();
        const hopLeXacNhan = kiemTraXacNhanMatKhau();

        if (!hopLeHoTen || !hopLeEmail || !hopLeMatKhau || !hopLeXacNhan) {
            // Chặn gửi form nếu thông tin chưa hợp lệ
            event.preventDefault();
            hienThiThongBao('Vui lòng kiểm tra lại thông tin đăng ký.', true);
            return;
        }

        // Nếu thông tin hợp lệ, để trình duyệt tự động submit về trang dang-ky.php
    });

    // Thêm khai báo element ô checkbox điều khoản
const chkDongY = document.querySelector('#dong-y-dieu-khoan');

// Thêm hàm kiểm tra
const kiemTraDongY = () => {
    if (chkDongY === null) return true;
    if (!chkDongY.checked) {
        hienThiLoi(chkDongY, 'Bạn cần đồng ý với Điều khoản sử dụng.');
        return false;
    }
    xoaLoi(chkDongY);
    return true;
};

// Gọi kiemTraDongY() bên trong sự kiện 'submit' của formDangKy
}