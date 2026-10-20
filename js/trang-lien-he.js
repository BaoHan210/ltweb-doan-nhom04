/*
 * trang-lien-he.js
 * Xử lý kiểm tra dữ liệu biểu mẫu liên hệ và đăng công thức phía Client.
 * Việc nhận và lưu trữ dữ liệu chính thức do máy chủ PHP xử lý.
 */

/* =========================================================
 * 1. LẤY CÁC PHẦN TỬ HTML
 * ========================================================= */
const formLienHe = document.querySelector('.form-lien-he');
const tenNguoiGui = document.querySelector('#full-name');
const email = document.querySelector('#email');
const tenMon = document.querySelector('#dish-name');
const soNguoiAn = document.querySelector('#servings');
const danhMuc = document.querySelector('#category');
const noiDungCongThuc = document.querySelector('#recipe-content');
const chuDe = document.querySelector('#subject');
const khuVucCongThuc = document.querySelector('.khu-vuc-cong-thuc');
const noiDung = document.querySelector('#message');
const thoiGianNau = document.querySelector('#cooking-time');

/* =========================================================
 * 2. XÁC ĐỊNH CHẾ ĐỘ TRANG
 * ========================================================= */
const layCheDoTrang = () => {
    const thamSo = new URLSearchParams(window.location.search);
    return thamSo.get('loai');
};

/* =========================================================
 * 3. HIỂN THỊ CHẾ ĐỘ ĐĂNG CÔNG THỨC
 * ========================================================= */
const thietLapCheDoDangCongThuc = () => {
    const cheDoTrang = layCheDoTrang();
    if (cheDoTrang !== 'cong-thuc') return;

    const tieuDe = document.querySelector('.tieu-de-lien-he');
    const tieuDePhu = document.querySelector('.tieu-de-phu-lien-he');
    const moTa = document.querySelector('.mo-ta-lien-he');

    if (tieuDe !== null) tieuDe.textContent = 'Đăng công thức';
    if (tieuDePhu !== null) tieuDePhu.textContent = 'Chia sẻ công thức cùng Cook with me';
    if (moTa !== null) moTa.textContent = 'Đăng công thức nấu ăn để chia sẻ món ăn và kinh nghiệm của bạn với cộng đồng.';

    if (chuDe !== null) chuDe.value = 'gui-cong-thuc';
    if (khuVucCongThuc !== null) khuVucCongThuc.hidden = false;
};

/* =========================================================
 * 4. HIỂN THỊ / XÓA LỖI CỦA TỪNG TRƯỜNG
 * ========================================================= */
const hienThiLoiTruong = (truong, noiDungLoi) => {
    if (truong === null) return;

    truong.setCustomValidity(noiDungLoi);
    truong.classList.add('co-loi');

    let thongBao = truong.parentElement.querySelector('.thong-bao-loi-truong');
    if (thongBao === null) {
        thongBao = document.createElement('p');
        thongBao.className = 'thong-bao-loi-truong';
        truong.parentElement.appendChild(thongBao);
    }
    thongBao.textContent = noiDungLoi;
};

const xoaLoiTruong = (truong) => {
    if (truong === null) return;

    truong.setCustomValidity('');
    truong.classList.remove('co-loi');

    const thongBao = truong.parentElement.querySelector('.thong-bao-loi-truong');
    if (thongBao !== null) thongBao.remove();
};

/* =========================================================
 * 5. CÁC HÀM KIỂM TRA RÀNG BUỘC PHÍA CLIENT
 * ========================================================= */
const kiemTraHoTen = () => {
    if (tenNguoiGui === null) return true;
    const giaTri = tenNguoiGui.value.trim();
    if (giaTri === '') {
        hienThiLoiTruong(tenNguoiGui, 'Vui lòng nhập họ và tên.');
        return false;
    }
    if (!/^[A-Za-zÀ-ỹĐđ\s]{2,50}$/.test(giaTri)) {
        hienThiLoiTruong(tenNguoiGui, 'Họ tên chỉ được chứa chữ cái và khoảng trắng.');
        return false;
    }
    xoaLoiTruong(tenNguoiGui);
    return true;
};

const kiemTraEmail = () => {
    if (email === null) return true;
    const giaTri = email.value.trim();
    if (giaTri === '') {
        hienThiLoiTruong(email, 'Vui lòng nhập email.');
        return false;
    }
    if (email.validity.typeMismatch === true) {
        hienThiLoiTruong(email, 'Email không đúng định dạng.');
        return false;
    }
    xoaLoiTruong(email);
    return true;
};

const kiemTraChuDe = () => {
    if (chuDe === null) return true;
    if (chuDe.value === '') {
        hienThiLoiTruong(chuDe, 'Vui lòng chọn chủ đề.');
        return false;
    }
    xoaLoiTruong(chuDe);
    return true;
};

const kiemTraTenMon = () => {
    if (tenMon === null) return true;
    const giaTri = tenMon.value.trim();
    if (giaTri === '') {
        hienThiLoiTruong(tenMon, 'Vui lòng nhập tên món ăn.');
        return false;
    }
    xoaLoiTruong(tenMon);
    return true;
};

const kiemTraSoNguoiAn = () => {
    if (soNguoiAn === null) return true;
    const giaTri = Number(soNguoiAn.value);
    if (soNguoiAn.value === '' || giaTri < 1 || giaTri > 20) {
        hienThiLoiTruong(soNguoiAn, 'Số người ăn phải từ 1 đến 20.');
        return false;
    }
    xoaLoiTruong(soNguoiAn);
    return true;
};

const kiemTraDanhMuc = () => {
    if (danhMuc === null) return true;
    if (danhMuc.value === '') {
        hienThiLoiTruong(danhMuc, 'Vui lòng chọn danh mục món ăn.');
        return false;
    }
    xoaLoiTruong(danhMuc);
    return true;
};

const kiemTraNoiDungCongThuc = () => {
    if (noiDungCongThuc === null) return true;
    if (noiDungCongThuc.value.trim() === '') {
        hienThiLoiTruong(noiDungCongThuc, 'Vui lòng nhập nội dung công thức.');
        return false;
    }
    xoaLoiTruong(noiDungCongThuc);
    return true;
};

const kiemTraThoiGianNau = () => {
    if (thoiGianNau === null) return true;
    const giaTri = Number(thoiGianNau.value);
    if (thoiGianNau.value === '' || giaTri < 1 || giaTri > 300) {
        hienThiLoiTruong(thoiGianNau, 'Thời gian nấu phải từ 1 đến 300 phút.');
        return false;
    }
    xoaLoiTruong(thoiGianNau);
    return true;
};

const kiemTraNoiDung = () => {
    if (noiDung === null) return true;
    if (noiDung.value.trim() === '') {
        hienThiLoiTruong(noiDung, 'Vui lòng nhập nội dung.');
        return false;
    }
    xoaLoiTruong(noiDung);
    return true;
};

/* =========================================================
 * 6. KIỂM TRA TOÀN BỘ BIỂU MẪU
 * ========================================================= */
const kiemTraBieuMau = () => {
    const ketQuaHoTen = kiemTraHoTen();
    const ketQuaEmail = kiemTraEmail();
    const ketQuaChuDe = kiemTraChuDe();
    const ketQuaNoiDung = kiemTraNoiDung();

    if (!ketQuaHoTen || !ketQuaEmail || !ketQuaChuDe || !ketQuaNoiDung) {
        return false;
    }

    if (chuDe !== null && chuDe.value === 'gui-cong-thuc') {
        const ketQuaTenMon = kiemTraTenMon();
        const ketQuaSoNguoiAn = kiemTraSoNguoiAn();
        const ketQuaDanhMuc = kiemTraDanhMuc();
        const ketQuaNoiDungCongThuc = kiemTraNoiDungCongThuc();
        const ketQuaThoiGianNau = kiemTraThoiGianNau();

        return (
            ketQuaTenMon &&
            ketQuaSoNguoiAn &&
            ketQuaDanhMuc &&
            ketQuaNoiDungCongThuc &&
            ketQuaThoiGianNau
        );
    }

    return true;
};

/* =========================================================
 * 7. XỬ LÝ SUBMIT (BỎ FETCH JSONPLACEHOLDER -> GỬI VỀ PHP)
 * ========================================================= */
const xuLyGuiBieuMau = (event) => {
    const hopLe = kiemTraBieuMau();

    if (!hopLe) {
        // Nếu form không hợp lệ, chặn submit
        event.preventDefault();
        return;
    }

    // Nếu form hợp lệ, để trình duyệt submit tự nhiên sang PHP xử lý
};

/* =========================================================
 * 8. HIỂN THỊ / ẨN KHU VỰC CÔNG THỨC
 * ========================================================= */
const capNhatKhuVucCongThuc = () => {
    if (chuDe === null || khuVucCongThuc === null) return;
    khuVucCongThuc.hidden = (chuDe.value !== 'gui-cong-thuc');
};

/* =========================================================
 * 9. GẮN VALIDATION VÀ KHỞI TẠO
 * ========================================================= */
const khoiTaoKiemTra = () => {
    if (tenNguoiGui !== null) {
        tenNguoiGui.addEventListener('blur', kiemTraHoTen);
        tenNguoiGui.addEventListener('input', kiemTraHoTen);
    }
    if (email !== null) {
        email.addEventListener('blur', kiemTraEmail);
        email.addEventListener('input', kiemTraEmail);
    }
    if (chuDe !== null) {
        chuDe.addEventListener('blur', kiemTraChuDe);
        chuDe.addEventListener('change', kiemTraChuDe);
    }
    if (tenMon !== null) {
        tenMon.addEventListener('blur', kiemTraTenMon);
        tenMon.addEventListener('input', kiemTraTenMon);
    }
    if (soNguoiAn !== null) {
        soNguoiAn.addEventListener('blur', kiemTraSoNguoiAn);
        soNguoiAn.addEventListener('input', kiemTraSoNguoiAn);
    }
    if (danhMuc !== null) {
        danhMuc.addEventListener('blur', kiemTraDanhMuc);
        danhMuc.addEventListener('change', kiemTraDanhMuc);
    }
    if (noiDungCongThuc !== null) {
        noiDungCongThuc.addEventListener('blur', kiemTraNoiDungCongThuc);
        noiDungCongThuc.addEventListener('input', kiemTraNoiDungCongThuc);
    }
    if (thoiGianNau !== null) {
        thoiGianNau.addEventListener('blur', kiemTraThoiGianNau);
        thoiGianNau.addEventListener('input', kiemTraThoiGianNau);
    }
    if (noiDung !== null) {
        noiDung.addEventListener('blur', kiemTraNoiDung);
        noiDung.addEventListener('input', kiemTraNoiDung);
    }
};

const khoiTaoTrang = () => {
    if (formLienHe === null) return;

    if (chuDe !== null) {
        chuDe.addEventListener('change', capNhatKhuVucCongThuc);
    }

    khoiTaoKiemTra();
    formLienHe.addEventListener('submit', xuLyGuiBieuMau);
    capNhatKhuVucCongThuc();
};

thietLapCheDoDangCongThuc();
document.addEventListener('DOMContentLoaded', khoiTaoTrang);
