/**
 * Tệp kịch bản: canhan.js - Nguyễn Thị Trinh (Nhóm 04 - Cook with me)
 * Chức năng: 
 *   1. Gợi ý từ khóa: Nhấp tag gợi ý để tự động điền vào thanh tìm kiếm.
 *   2. Modal đăng nhập: Bật / tắt cửa sổ đăng nhập thành viên cộng đồng bếp (hỗ trợ phím Escape).
 */

document.addEventListener("DOMContentLoaded", () => {
  // 1. Tương tác gợi ý nhanh từ khóa nấu ăn
  const searchInput = document.getElementById("search");
  const searchForm = searchInput ? searchInput.closest("form") : null;
  const quickTags = document.querySelectorAll(".tag-mon-an");

  quickTags.forEach((tag) => {
    tag.addEventListener("click", () => {
      if (searchInput) {
        const tuKhoa = tag.textContent.replace("#", "").trim();
        searchInput.value = tuKhoa;
        searchInput.focus();

        // Nếu có form tìm kiếm thì gửi form để chuyển trang sang danh-sach.php
        if (searchForm) {
          searchForm.submit();
        }
      }
    });
  });

  // 2. Tương tác bật / tắt Modal đăng nhập
  const loginBtn = document.getElementById("btn-open-login");
  const loginModal = document.getElementById("modal-auth");
  const closeLoginBtn = document.getElementById("btn-close-login");

  const moModal = () => {
    if (!loginModal) return;
    loginModal.style.display = "flex";
    
    requestAnimationFrame(() => {
      setTimeout(() => {
        const firstInput = loginModal.querySelector("input");
        if (firstInput) {
          firstInput.focus();
          try {
            firstInput.setSelectionRange(0, 0);
          } catch (e) {
            // Phòng ngừa đối với các type input không hỗ trợ setSelectionRange
          }
        }
      }, 50);
    });
  };

  const dongModal = () => {
    if (!loginModal) return;
    loginModal.style.display = "none";
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

  if (loginModal) {
    loginModal.addEventListener("click", (event) => {
      if (event.target === loginModal) {
        dongModal();
      }
    });
  }

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && loginModal && loginModal.style.display === "flex") {
      dongModal();
    }
  });
});