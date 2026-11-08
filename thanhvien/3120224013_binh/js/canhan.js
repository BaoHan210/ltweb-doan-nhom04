/*
 * Tệp tạo tương tác cho trang cá nhân Ngọc Bình.
 * Có chức năng tìm kiếm kỹ năng và thu gọn/mở rộng nội dung.
 * Cách thử: nhập từ khóa vào ô tìm kiếm hoặc bấm nút Thu gọn.
 */

function khoiTaoTuongTacTrang() {
    // 1. TƯƠNG TÁC THU GỌN / MỞ RỘNG DỰ ÁN VÀ SỞ THÍCH
    const nutMoRong = document.getElementById('nut-mo-rong');
    const noiDungDuAn = document.getElementById('noi-dung-du-an');

    if (nutMoRong && noiDungDuAn) {
        nutMoRong.addEventListener('click', () => {
            const dangMo = !noiDungDuAn.classList.contains('noi-dung-an');

            noiDungDuAn.classList.toggle('noi-dung-an', dangMo);
            nutMoRong.setAttribute('aria-expanded', String(!dangMo));
            nutMoRong.textContent = dangMo ? '▼ Mở rộng' : '▲ Thu gọn';
        });
    }

    // 2. TƯƠNG TÁC TÌM KIẾM / LỌC KỸ NĂNG
    const oTimKyNang = document.getElementById('tim-ky-nang');
    const danhSachKyNang = document.querySelectorAll('.danh-sach-ky-nang li');
    const thongBaoKhongCo = document.getElementById('khong-co-ky-nang');

    if (oTimKyNang && danhSachKyNang.length > 0) {
        oTimKyNang.addEventListener('input', () => {
            const tuKhoa = oTimKyNang.value.toLowerCase().trim();
            let soLuongKhop = 0;

            danhSachKyNang.forEach((item) => {
                const text = item.textContent.toLowerCase();
                const khop = text.includes(tuKhoa);

                item.classList.toggle('an-ky-nang', !khop);

                if (khop) {
                    soLuongKhop++;
                }
            });

            if (thongBaoKhongCo) {
                thongBaoKhongCo.hidden = soLuongKhop > 0;
            }
        });
    }
}

// Đảm bảo mã luôn chạy dù nạp qua module hay script thông thường
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', khoiTaoTuongTacTrang);
} else {
    khoiTaoTuongTacTrang();
}