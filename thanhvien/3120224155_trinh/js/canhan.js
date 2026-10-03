/**
 * Tệp kịch bản: canhan.js - Nguyễn Thị Trinh (Nhóm 04 - Cook with me)
 * Chức năng: 
 *   1. Gợi ý từ khóa: Nhấp tag gợi ý để tự động điền vào thanh tìm kiếm.
 *   2. Modal đăng nhập: Bật / tắt cửa sổ đăng nhập thành viên cộng đồng bếp (hỗ trợ phím Escape).
 * Cách thử: Nhấp/Tab chọn các thẻ #Món chay, #Eat clean... hoặc mở Modal và nhấn phím Escape để đóng.
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
      }
    });
  });

  // 2. Tương tác bật / tắt Modal đăng nhập
  const loginBtn = document.getElementById("btn-open-login");
  const loginModal = document.getElementById("modal-auth");
  const closeLoginBtn = document.getElementById("btn-close-login");

  // Hàm mở modal
  const moModal = () => {
    if (!loginModal) return;
    loginModal.style.display = "flex";
    
    // Đặt khoảng trễ ngắn để DOM kịp hiển thị xong rồi mới kích hoạt tiêu điểm
    setTimeout(() => {
      const firstInput = loginModal.querySelector("input");
      if (firstInput) {
        firstInput.focus();
        firstInput.select(); // Hỗ trợ nhấp nháy con trỏ rõ ràng trên mọi trình duyệt
      }
    }, 50);
  };

  // Hàm đóng modal
  const dongModal = () => {
    if (!loginModal) return;
    loginModal.style.display = "none";
    // Trả lại tiêu điểm cho nút mở modal để tiếp tục duyệt phím
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
