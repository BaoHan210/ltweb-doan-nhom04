/*
 * trang-danh-sach.js
 * Xử lý tương tác nút Yêu thích và Lọc món ăn theo danh mục.
 */

/* =========================================================
<<<<<<< HEAD
   1. XỬ LÝ CLICK NÚT YÊU THÍCH
   ========================================================= */
const xuLyYeuThich = (event) => {
    const nutYeuThich = event.target.closest('.nut-yeu-thich');
    if (!nutYeuThich) return;

    event.preventDefault();
    event.stopPropagation();

    const idMonAn = nutYeuThich.dataset.idMonAn || nutYeuThich.getAttribute('data-id');
    if (!idMonAn) return;
=======
   3. XỬ LÝ LỌC DANH MỤC TRÊN CLIENT
   ========================================================= */
const khoiTaoBoLocDanhMuc = () => {
    const dsNutBoLoc = document.querySelectorAll('.nut-bo-loc');
    const dsTheMonAn = document.querySelectorAll('.danh-sach-mon-an .the-mon-an');

    if (dsNutBoLoc.length === 0) return;
>>>>>>> e6e0155 (Update part A)

    dsNutBoLoc.forEach((nut) => {
        nut.addEventListener('click', () => {
            dsNutBoLoc.forEach((n) => n.classList.remove('dang-loc', 'active'));
            nut.classList.add('dang-loc');

            const danhMucChon = nut.getAttribute('data-danh-muc');

<<<<<<< HEAD
/* =========================================================
   2. CẬP NHẬT TRẠNG THÁI TIM BAN ĐẦU
   ========================================================= */
const capNhatTrangThaiBanDau = () => {
    const dsNutYeuThich = document.querySelectorAll('.nut-yeu-thich');
    dsNutYeuThich.forEach((nut) => {
        const idMonAn = nut.dataset.idMonAn || nut.getAttribute('data-id');
        if (!idMonAn) return;

        if (kiemTraYeuThich(idMonAn)) {
            nut.textContent = '♥';
            nut.classList.add('da-luu');
            nut.setAttribute('aria-label', 'Bỏ khỏi yêu thích');
        } else {
            nut.textContent = '♡';
            nut.classList.remove('da-luu');
            nut.setAttribute('aria-label', 'Thêm vào yêu thích');
        }
=======
            dsTheMonAn.forEach((theMon) => {
                const danhMucMon = theMon.getAttribute('data-danh-muc');

                if (danhMucChon === 'tat-ca' || danhMucMon === danhMucChon) {
                    theMon.style.display = '';
                } else {
                    theMon.style.display = 'none';
                }
            });
        });
>>>>>>> e6e0155 (Update part A)
    });
};

/* =========================================================
<<<<<<< HEAD
   3. XỬ LÝ LỌC DANH MỤC TRÊN CLIENT
   ========================================================= */
const khoiTaoBoLocDanhMuc = () => {
    const dsNutBoLoc = document.querySelectorAll('.nut-bo-loc');
    const dsTheMonAn = document.querySelectorAll('.danh-sach-mon-an .the-mon-an');

    if (dsNutBoLoc.length === 0) return;

    dsNutBoLoc.forEach((nut) => {
        nut.addEventListener('click', () => {
            // Đổi trạng thái hiển thị nút active
            dsNutBoLoc.forEach((n) => n.classList.remove('dang-loc', 'active'));
            nut.classList.add('dang-loc');

            const danhMucChon = nut.getAttribute('data-danh-muc');

            // Ẩn / hiện món ăn tương ứng
            dsTheMonAn.forEach((theMon) => {
                const danhMucMon = theMon.getAttribute('data-danh-muc');

                if (danhMucChon === 'tat-ca' || danhMucMon === danhMucChon) {
                    theMon.style.display = '';
                } else {
                    theMon.style.display = 'none';
                }
            });
        });
    });
};

/* =========================================================
   4. KHỞI TẠO TRANG DANH SÁCH
   ========================================================= */
const khoiTaoTrangDanhSach = () => {
    const khuVucDanhSach = document.querySelector('#danh-sach-mon-an, .danh-sach-mon-an');

    if (khuVucDanhSach !== null) {
        khuVucDanhSach.addEventListener('click', xuLyYeuThich);
    }

    capNhatTrangThaiBanDau();
=======
   4. KHỞI TẠO TRANG DANH SÁCH
   ========================================================= */
const khoiTaoTrangDanhSach = () => {
>>>>>>> e6e0155 (Update part A)
    khoiTaoBoLocDanhMuc();
};

document.addEventListener('DOMContentLoaded', khoiTaoTrangDanhSach);
