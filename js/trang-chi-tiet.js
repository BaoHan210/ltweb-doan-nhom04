/*
 * trang-chi-tiet.js
<<<<<<< HEAD
 * Xử lý tương tác phía Client cho trang chi tiết món ăn (Nút Yêu thích).
 * Việc hiển thị dữ liệu chi tiết đã do PHP Server-Side Rendering đảm nhận.
 */

import {
    kiemTraYeuThich,
    doiTrangThaiYeuThich
} from './yeu-thich.js';

/* =========================================================
   CẬP NHẬT TRẠNG THÁI NÚT YÊU THÍCH TRÊN TRANG CHI TIẾT
   ========================================================= */
const capNhatTrangThaiNutYeuThich = (nutYeuThich, idMonAn) => {
    if (!nutYeuThich) return;

    const daYeuThich = kiemTraYeuThich(idMonAn);

    if (daYeuThich) {
        nutYeuThich.textContent = '♥ Đã lưu';
        nutYeuThich.classList.add('da-luu');
        nutYeuThich.setAttribute('aria-label', 'Bỏ khỏi yêu thích');
    } else {
        nutYeuThich.textContent = '♡ Lưu công thức';
        nutYeuThich.classList.remove('da-luu');
        nutYeuThich.setAttribute('aria-label', 'Thêm vào yêu thích');
    }
};

/* =========================================================
   KHỞI TẠO TƯƠNG TÁC YÊU THÍCH PHÍA CLIENT
   ========================================================= */
const khoiTaoYeuThichTrangChiTiet = () => {
    const nutYeuThich = document.querySelector('.nut-yeu-thich');
    if (!nutYeuThich) return;

    // Lấy ID món ăn được PHP gắn sẵn vào attribute data-id của nút
    const idMonAn = nutYeuThich.getAttribute('data-id');
    if (!idMonAn) return;

    // Cập nhật trạng thái hiển thị ban đầu
    capNhatTrangThaiNutYeuThich(nutYeuThich, idMonAn);

    // Gán sự kiện click toggle trạng thái yêu thích
    nutYeuThich.addEventListener('click', () => {
        doiTrangThaiYeuThich(idMonAn);
        capNhatTrangThaiNutYeuThich(nutYeuThich, idMonAn);
    });
};

// Khởi chạy khi DOM sẵn sàng
document.addEventListener('DOMContentLoaded', khoiTaoYeuThichTrangChiTiet);
=======
 * Các chức năng phía Client riêng của trang chi tiết.
 *
 * Nút yêu thích được xử lý hoàn toàn bằng PHP Server-Side Rendering
 * và PHP Session, nên không xử lý bằng JavaScript tại đây.
 */
>>>>>>> e6e0155 (Update part A)
