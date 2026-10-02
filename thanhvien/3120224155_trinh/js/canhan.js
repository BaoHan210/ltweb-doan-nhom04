/**
 * Tệp kịch bản: canhan.js - Nguyễn Thị Trinh (Nhóm 04 - Cook with me)
 * Chức năng: 
 *   1. Gợi ý từ khóa: Nhấp tag gợi ý để tự động điền vào thanh tìm kiếm.
 *   2. Modal đăng nhập: Bật / tắt cửa sổ đăng nhập thành viên cộng đồng bếp.
 * Cách thử: Nhấp vào các thẻ #Món chay, #Eat clean... hoặc nhấp nút 'Đăng nhập'.
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

  if (loginBtn && loginModal) {
    loginBtn.addEventListener("click", () => {
      loginModal.style.display = "flex";
    });
  }

  if (closeLoginBtn && loginModal) {
    closeLoginBtn.addEventListener("click", () => {
      loginModal.style.display = "none";
    });
  }

  if (loginModal) {
    loginModal.addEventListener("click", (event) => {
      if (event.target === loginModal) {
        loginModal.style.display = "none";
      }
    });
  }
});
