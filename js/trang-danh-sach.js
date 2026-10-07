/*
 * trang-danh-sach.js
 * Xử lý tương tác phía Client cho trang Danh sách / Khám phá (Nút Yêu thích).
 * Việc hiển thị, tìm kiếm, lọc và phân trang món ăn đã do máy chủ PHP đảm nhận.
 */

import {
    kiemTraYeuThich,
    doiTrangThaiYeuThich
} from './yeu-thich.js';

/* =========================================================
   XỬ LÝ YÊU THÍCH TRÊN DANH SÁCH MÓN ĂN
   ========================================================= */
const xuLyYeuThich = (event) => {
    const nutYeuThich = event.target.closest('.nut-yeu-thich');
    if (nutYeuThich === null) return;

    // Lấy ID món ăn từ data attribute do PHP in ra
    const idMonAn = nutYeuThich.dataset.idMonAn || nutYeuThich.getAttribute('data-id');
    if (!idMonAn) return;

    const daYeuThich = doiTrangThaiYeuThich(idMonAn);

    if (daYeuThich) {
        nutYeuThich.textContent = '♥';
        nutYeuThich.classList.add('da-luu');
        nutYeuThich.setAttribute('aria-label', 'Bỏ khỏi yêu thích');
    } else {
        nutYeuThich.textContent = '♡';
        nutYeuThich.classList.remove('da-luu');
        nutYeuThich.setAttribute('aria-label', 'Thêm vào yêu thích');
    }
};

/* =========================================================
   CẬP NHẬT TRẠNG THÁI NÚT YÊU THÍCH BAN ĐẦU
   ========================================================= */
const capNhatTrangThaiBanDau = () => {
    const dsNutYeuThich = document.querySelectorAll('.nut-yeu-thich');
    dsNutYeuThich.forEach((nut) => {
        const idMonAn = nut.dataset.idMonAn || nut.getAttribute('data-id');
        if (!idMonAn) return;

        if (kiemTraYeuThich(idMonAn)) {
            nut.textContent = '♥';
            nut.classList.add('da-luu');
        } else {
            nut.textContent = '♡';
            nut.classList.remove('da-luu');
        }
    });
};

/* =========================================================
   KHỞI TẠO TRANG DANH SÁCH
   ========================================================= */
const khoiTaoTrangDanhSach = () => {
    const khuVucDanhSach = document.querySelector('#danh-sach-mon-an, .danh-sach-mon-an');

    if (khuVucDanhSach !== null) {
        khuVucDanhSach.addEventListener('click', xuLyYeuThich);
    }

    capNhatTrangThaiBanDau();
};

document.addEventListener('DOMContentLoaded', khoiTaoTrangDanhSach);