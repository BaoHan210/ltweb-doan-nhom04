/*
 * trang-dang-nhap.js
 * Xử lý kiểm tra dữ liệu biểu mẫu đăng nhập phía Client.
 * Việc xác thực tài khoản và tạo phiên làm việc chính thức do máy chủ PHP xử lý.
 */

/* =========================================================
   1. LẤY CÁC PHẦN TỬ TRONG FORM
   ========================================================= */
const formDangNhap = document.querySelector('.form-dang-nhap');
const email = document.querySelector('#email-dang-nhap');
const matKhau = document.querySelector('#mat-khau-dang-nhap');

/* =========================================================
   2. HIỂN THỊ LỖI CHO TỪNG TRƯỜNG
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
   4. KIỂM TRA EMAIL
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
   5. KIỂM TRA MẬT KHẨU
   ========================================================= */
const kiemTraMatKhau = () => {
    if (matKhau === null) return false;

    const giaTri = matKhau.value;

    if (giaTri === '') {
        hienThiLoi(matKhau, 'Vui lòng nhập mật khẩu.');
        return false;
    }

    xoaLoi(matKhau);
    return true;
};

/* =========================================================
   6. HIỂN THỊ THÔNG BÁO CHUNG
   ========================================================= */
const hienThiThongBao = (noiDung, laLoi = false) => {
    if (formDangNhap === null) return;

    let thongBao = formDangNhap.querySelector('.thong-bao-dang-nhap');

    if (thongBao === null) {
        thongBao = document.createElement('p');
        thongBao.className = 'thong-bao-dang-nhap';
        thongBao.setAttribute('aria-live', 'polite');
        formDangNhap.appendChild(thongBao);
    }

    thongBao.textContent = noiDung;
    thongBao.classList.toggle('thong-bao-dang-nhap-loi', laLoi);
};

/* =========================================================
   7. GẮN KIỂM TRA KHI NGƯỜI DÙNG RỜI KHỎI TRƯỜNG
   ========================================================= */
const khoiTaoKiemTra = () => {
    if (email !== null) {
        email.addEventListener('blur', kiemTraEmail);
    }

    if (matKhau !== null) {
        matKhau.addEventListener('blur', kiemTraMatKhau);
    }
};

/* =========================================================
   8. XỬ LÝ FORM ĐĂNG NHẬP (GỬI DỮ LIỆU VỀ PHP)
   ========================================================= */
if (formDangNhap !== null) {
    khoiTaoKiemTra();

    formDangNhap.addEventListener('submit', (event) => {
        /*
         * Kiểm tra dữ liệu nhập phía Client
         */
        const emailHopLe = kiemTraEmail();
        const matKhauHopLe = kiemTraMatKhau();

        if (!emailHopLe || !matKhauHopLe) {
            // Chặn submit nếu chưa nhập đủ/đúng thông tin
            event.preventDefault();
            hienThiThongBao('Vui lòng kiểm tra lại thông tin đăng nhập.', true);
            return;
        }

        // Khi dữ liệu hợp lệ, để trình duyệt submit tự nhiên sang dang-nhap.php
    });
}