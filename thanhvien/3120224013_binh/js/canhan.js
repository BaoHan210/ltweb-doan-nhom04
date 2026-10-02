/* ========================================
   canhan.js
   JavaScript riêng cho trang cá nhân
   Nguyễn Thị Ngọc Bình - 3120224013
   ======================================== */


// ========================================
// 1. TÌM KIẾM / LỌC DANH SÁCH KỸ NĂNG
// ========================================

const oTimKyNang = document.getElementById("tim-ky-nang");

const danhSachKyNang = document.querySelectorAll(
  ".danh-sach-ky-nang li"
);

const thongBaoKhongCo = document.getElementById(
  "khong-co-ky-nang"
);


// Khi người dùng nhập từ khóa
if (oTimKyNang) {

  oTimKyNang.addEventListener("input", function () {

    const tuKhoa = oTimKyNang.value
      .toLowerCase()
      .trim();

    let soKyNangHienThi = 0;


    danhSachKyNang.forEach(function (kyNang) {

      const noiDungKyNang = kyNang.textContent
        .toLowerCase();

      if (noiDungKyNang.includes(tuKhoa)) {

        kyNang.style.display = "";

        soKyNangHienThi++;

      } else {

        kyNang.style.display = "none";

      }

    });


    // Hiện thông báo nếu không có kết quả
    if (thongBaoKhongCo) {

      if (soKyNangHienThi === 0) {

        thongBaoKhongCo.hidden = false;

      } else {

        thongBaoKhongCo.hidden = true;

      }

    }

  });

}


// ========================================
// 2. THU GỌN / MỞ RỘNG
//    PHẦN DỰ ÁN VÀ SỞ THÍCH
// ========================================

const nutMoRong = document.getElementById(
  "nut-mo-rong"
);

const noiDungDuAn = document.getElementById(
  "noi-dung-du-an"
);


if (nutMoRong && noiDungDuAn) {

  nutMoRong.addEventListener("click", function () {

    // Kiểm tra nội dung đang ẩn hay đang hiện
    const dangAn = noiDungDuAn.hidden;


    if (dangAn) {

      // MỞ NỘI DUNG
      noiDungDuAn.hidden = false;

      nutMoRong.textContent = "▲ Thu gọn";

      nutMoRong.setAttribute(
        "aria-expanded",
        "true"
      );

    } else {

      // THU GỌN NỘI DUNG
      noiDungDuAn.hidden = true;

      nutMoRong.textContent = "▼ Xem thêm";

      nutMoRong.setAttribute(
        "aria-expanded",
        "false"
      );

    }

  });

}
