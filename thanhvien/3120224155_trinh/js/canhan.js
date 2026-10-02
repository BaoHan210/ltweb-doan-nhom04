document.addEventListener("DOMContentLoaded", () => {
  /* ========================================================
   * 1. GỢI Ý NHANH TỪ KHÓA NẤU ĂN VÀO Ô TÌM KIẾM
   * ======================================================== */
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

  /* ========================================================
   * 2. BẬT / TẮT POPUP ĐĂNG NHẬP CỘNG ĐỒNG BẾP
   * ======================================================== */
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
    loginModal.addEventListener("click", (e) => {
      if (e.target === loginModal) {
        loginModal.style.display = "none";
      }
    });
  }
});
