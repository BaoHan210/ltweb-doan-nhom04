/*
 * trang-ca-nhan.js
 */

import { docNguoiDungHienTai } from './tai-khoan.js';
import { docBaiViet } from './bai-viet.js';

/* 1. LẤY PHẦN TỬ HTML */
const tenNguoiDung = document.querySelector('.ten-nguoi-dung');
const emailNguoiDung = document.querySelector('.email-nguoi-dung');
const chuCaiDaiDien = document.querySelector('.chu-cai-dai-dien');
const danhSachBaiViet = document.querySelector('.danh-sach-bai-viet-cua-toi');
const khuVucCongThuc = document.querySelector('.khu-vuc-cong-thuc-ca-nhan');
const khuVucMonDaLuu = document.querySelector('.khu-vuc-mon-da-luu');
const cacTab = document.querySelectorAll('.tab-ca-nhan');

/* 2. HIỂN THỊ THÔNG TIN NGƯỜI DÙNG */
const hienThiThongTinNguoiDung = (nguoiDung) => {
    if (!nguoiDung || typeof nguoiDung !== 'object') return;
    const hoTen = String(nguoiDung.hoTen || '').trim();
    
    // Chỉ cập nhật lại bằng JS nếu localStorage có lưu tên, tránh ghi đè chữ "Người dùng" khi rỗng
    if (hoTen && tenNguoiDung) {
        tenNguoiDung.textContent = hoTen;
    }
    if (emailNguoiDung) emailNguoiDung.textContent = String(nguoiDung.email || '');
    if (chuCaiDaiDien && hoTen) chuCaiDaiDien.textContent = hoTen.charAt(0).toUpperCase();
};

/* 3. TẠO THẺ BÀI VIẾT / MÓN ĂN */
const taoTheBaiVietNguoiDung = (baiViet) => {
    const article = document.createElement('article');
    article.className = 'the-mon-an-cn';

    const id = baiViet.id || '';
    const ten = baiViet.tenMon || baiViet.ten || 'Món ăn';
    
    let hinhAnh = 'images/cao-lau.jpg';
    if (Array.isArray(baiViet.hinhAnh) && baiViet.hinhAnh.length > 0) {
        hinhAnh = baiViet.hinhAnh[0];
    } else if (typeof baiViet.hinhAnh === 'string' && baiViet.hinhAnh) {
        hinhAnh = baiViet.hinhAnh;
    }

    const thoiGian = baiViet.thoiGianNau || baiViet.thoiGian || 30;
    const khauPhan = baiViet.soNguoiAn || baiViet.khauPhan || 2;

    article.innerHTML = `
        <div class="khung-anh-mon-cn">
            <a href="chi-tiet.php?id=${encodeURIComponent(id)}">
                <img src="${hinhAnh}" alt="${ten}" onerror="this.src='images/cao-lau.jpg'">
            </a>
            <button class="nut-yeu-thich-cn" type="button" aria-label="Yêu thích">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
            </button>
        </div>
        <div class="noi-dung-mon-cn">
            <h3 class="tieu-de-mon-cn">
                <a href="chi-tiet.php?id=${encodeURIComponent(id)}" style="color:inherit;text-decoration:none;">${ten}</a>
            </h3>
            <div class="thong-tin-meta-cn">
                <span class="item-meta-cn">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    ${thoiGian} phút
                </span>
                <span class="item-meta-cn">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 1 0 7.75"/></svg>
                    ${khauPhan} người
                </span>
            </div>
        </div>
    `;

    return article;
};

/* 4. HIỂN THỊ BÀI VIẾT CỦA TÔI */
const hienThiBaiVietCuaToi = (nguoiDung) => {
    if (!danhSachBaiViet) return;
    danhSachBaiViet.replaceChildren();

    const tatCaBaiViet = docBaiViet();
    const baiVietCuaToi = tatCaBaiViet.filter((baiViet) => {
        if (!baiViet || typeof baiViet !== 'object') return false;
        return String(baiViet.userId) === String(nguoiDung?.id);
    });

    const soBaiDang = document.querySelector('.so-bai-dang');
    if (soBaiDang) soBaiDang.textContent = String(baiVietCuaToi.length);

    if (baiVietCuaToi.length === 0) {
        const thongBao = document.createElement('p');
        thongBao.style.padding = '0 28px 28px';
        thongBao.textContent = 'Bạn chưa có bài viết nào.';
        danhSachBaiViet.appendChild(thongBao);
        return;
    }

    baiVietCuaToi.forEach((baiViet) => {
        danhSachBaiViet.appendChild(taoTheBaiVietNguoiDung(baiViet));
    });
};

/* 6. CHUYỂN TAB */
const chuyenTab = (tabDuocChon) => {
    cacTab.forEach((tab) => {
        const dangChon = tab === tabDuocChon;
        tab.classList.toggle('dang-chon', dangChon);
        tab.setAttribute('aria-selected', String(dangChon));
    });

    const viTriTab = Array.from(cacTab).indexOf(tabDuocChon);

    if (viTriTab === 0) {
        if (khuVucCongThuc) khuVucCongThuc.hidden = false;
        if (khuVucMonDaLuu) khuVucMonDaLuu.hidden = true;
    } else if (viTriTab === 1) {
        if (khuVucCongThuc) khuVucCongThuc.hidden = true;
        if (khuVucMonDaLuu) khuVucMonDaLuu.hidden = false;
    }
};

/* 7. KHỞI TẠO TAB */
const khoiTaoTab = () => {
    cacTab.forEach((tab) => {
        tab.addEventListener('click', () => chuyenTab(tab));
    });

    if (cacTab.length > 0) {
        chuyenTab(cacTab[0]);
    }
};

/* 8. KHỞI TẠO TRANG */
const khoiTaoTrangCaNhan = () => {
    const nguoiDung = docNguoiDungHienTai();
    hienThiThongTinNguoiDung(nguoiDung);
    hienThiBaiVietCuaToi(nguoiDung);
    khoiTaoTab();
};

document.addEventListener('DOMContentLoaded', khoiTaoTrangCaNhan);