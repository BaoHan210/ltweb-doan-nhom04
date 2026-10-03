/**
 * Tệp kịch bản: canhan.js - Nguyễn Thị Trinh (Nhóm 04 - Cook with me)
 * Chức năng: 
 *   1. Gợi ý từ khóa: Nhấp tag gợi ý để tự động điền vào thanh tìm kiếm.
 *   2. Modal đăng nhập: Bật / tắt cửa sổ đăng nhập thành viên cộng đồng bếp (hỗ trợ phím Escape).
 * Cách thử: Dùng phím Tab duyệt qua các thẻ gợi ý/nút Đăng nhập rồi nhấn Enter; nhấn Escape để đóng Modal.
 */

document.addEventListener("DOMContentLoaded", () => {
  // 1. Tương tác gợi ý nhanh từ khóa nấu ăn
  const searchInput = document.getElementById("search");
  const quickTags = document.querySelectorAll(".tag-mon-an");

  quickTags.forEach((tag) => {
    tag.addEventListener("click", () => {
      if (searchInput) {
        searchInput.value = tag.textContent.replace("#", "").trim();
        searchInput.focus();
        const len = searchInput.value.length;
        searchInput.setSelectionRange(len, len);
      }
    });
  });

  // 2. Tương tác bật / tắt Modal đăng nhập
  const loginBtn = document.getElementById("btn-open-login");
  const loginModal = document.getElementById("modal-auth");
  const closeLoginBtn = document.getElementById("btn-close-login");

  // Hàm mở modal: tự động kích hoạt vạch con trỏ nhấp nháy ngay lập tức bằng phím
  const moModal = () => {
    if (!loginModal) return;
    loginModal.style.display = "flex";
    
    // Sử dụng requestAnimationFrame kết hợp setTimeout để đảm bảo modal đã render xong trên màn hình
    requestAnimationFrame(() => {
      setTimeout(() => {
        const firstInput = loginModal.querySelector("input");
        if (firstInput) {
          firstInput.focus();
          // Đặt con trỏ vào vị trí 0 để ép trình duyệt bật ngay vạch nhấp nháy (|) mà không cần chuột
          try {
            firstInput.setSelectionRange(0, 0);
          } catch (e) {
            // Phòng ngừa đối với các type input không hỗ trợ setSelectionRange
          }
        }
      }, 50);
    });
  };

  // Hàm đóng modal
  const dongModal = () => {
    if (!loginModal) return;
    loginModal.style.display = "none";
    // Trả lại tiêu điểm cho nút mở modal để tiếp tục duyệt phím Tab
    if (loginBtn) {
      loginBtn.focus();
    }
  };

  if (loginBtn) {
    loginBtn.addEventListener("click", moModal);
  }

  if (closeLoginBtn) {
    closeLoginBtn.addEventListener("click", dongModal);
  }

  // Đóng modal khi nhấp chuột ra ngoài vùng nền mờ
  if (loginModal) {
    loginModal.addEventListener("click", (event) => {
      if (event.target === loginModal) {
        dongModal();
      }
    });
  }

  // Bổ sung xử lý bàn phím: Nhấn phím Escape để đóng Modal ngay lập tức
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && loginModal && loginModal.style.display === "flex") {
      dongModal();
    }
  });
});
