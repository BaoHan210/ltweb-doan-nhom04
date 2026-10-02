/*
 * Tệp tạo tương tác cho trang cá nhân Ngọc Bình.
 * Có chức năng tìm kiếm kỹ năng và thu gọn/mở rộng nội dung.
 * Cách thử: nhập từ khóa vào ô tìm kiếm hoặc bấm nút Thu gọn.
 */

// ========================================
// 1. TÌM KIẾM / LỌC DANH SÁCH KỸ NĂNG
// ========================================

const oTimKyNang = document.getElementById("tim-ky-nang");
const danhSachKyNang = document.querySelectorAll(
  ".danh-sach-ky-nang li"
);
const khungKyNang = document.querySelector(".danh-sach-ky-nang");

if (oTimKyNang && khungKyNang) {

  oTimKyNang.addEventListener("input", function () {

    const tuKhoa = oTimKyNang.value
      .toLowerCase()
      .trim();

    let soKyNangHienThi = 0;

    danhSachKyNang.forEach(function (kyNang) {

      const noiDungKyNang = kyNang.textContent
        .toLowerCase();

      if (noiDungKyNang.includes(tuKhoa)) {

        kyNang.classList.remove("an-ky-nang");
        soKyNangHienThi++;

      } else {

        kyNang.classList.add("an-ky-nang");

      }
    });


    // Xóa thông báo cũ nếu có
    const thongBaoCu = document.getElementById(
      "khong-co-ky-nang"
    );

    if (thongBaoCu) {
      thongBaoCu.remove();
    }


    // Tạo thông báo nếu không tìm thấy kỹ năng
    if (soKyNangHienThi === 0) {

      const thongBaoMoi = document.createElement("p");

      thongBaoMoi.textContent =
        "Không tìm thấy kỹ năng phù hợp.";

      thongBaoMoi.id = "khong-co-ky-nang";

      thongBaoMoi.classList.add("khong-co-ky-nang");

      khungKyNang.parentElement.appendChild(
        thongBaoMoi
      );
    }
  });
}


// ========================================
// 2. THU GỌN / MỞ RỘNG
// ========================================

const nutMoRong = document.getElementById(
  "nut-mo-rong"
);

const noiDungDuAn = document.getElementById(
  "noi-dung-du-an"
);

if (nutMoRong && noiDungDuAn) {

  nutMoRong.addEventListener("click", function () {

    noiDungDuAn.classList.toggle("noi-dung-an");

    if (
      noiDungDuAn.classList.contains("noi-dung-an")
    ) {

      nutMoRong.textContent = "▼ Xem thêm";

      nutMoRong.setAttribute(
        "aria-expanded",
        "false"
      );

    } else {

      nutMoRong.textContent = "▲ Thu gọn";

      nutMoRong.setAttribute(
        "aria-expanded",
        "true"
      );
    }
  });
}
