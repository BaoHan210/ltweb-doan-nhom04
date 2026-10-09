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
            const dangMo = noiDungDuAn.style.display !== 'none' && !noiDungDuAn.classList.contains('noi-dung-an');
            
            if (dangMo) {
                noiDungDuAn.style.display = 'none';
                noiDungDuAn.classList.add('noi-dung-an');
                nutMoRong.setAttribute('aria-expanded', 'false'); 
                nutMoRong.textContent = '▼ Mở rộng'; 
            } else {
                noiDungDuAn.style.display = '';
                noiDungDuAn.classList.remove('noi-dung-an');
                nutMoRong.setAttribute('aria-expanded', 'true'); 
                nutMoRong.textContent = '▲ Thu gọn'; 
            }
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
                if (text.includes(tuKhoa)) { 
                    item.style.display = '';
                    item.classList.remove('an-ky-nang'); 
                    soLuongKhop++; 
                } else { 
                    item.style.display = 'none';
                    item.classList.add('an-ky-nang'); 
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