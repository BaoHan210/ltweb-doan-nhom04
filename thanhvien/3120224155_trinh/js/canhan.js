
/**
 * canhan.js - Trang cá nhân Nguyễn Thị Trinh.
 * Gợi ý tìm kiếm và ghi lượt xem qua POST có CSRF.
 */

document.addEventListener("DOMContentLoaded", () => {

    // Giữ chức năng tìm kiếm món ăn.
    const searchInput = document.getElementById("search");

    const searchForm = searchInput
        ? searchInput.closest("form")
        : null;

    const quickTags = document.querySelectorAll(".tag-mon-an");

    quickTags.forEach((tag) => {
        tag.addEventListener("click", () => {

            if (!searchInput) {
                return;
            }

            const tuKhoa = tag.textContent
                .replace("#", "")
                .trim();

            searchInput.value = tuKhoa;
            searchInput.focus();

            if (searchForm) {
                searchForm.requestSubmit();
            }
        });
    });

    // BT7: GET không ghi CSDL.
    // Gửi POST kèm mã CSRF từ trường ẩn của form.
    const formLuotXem = document.getElementById("form-ghi-luot-xem");

    if (formLuotXem) {
        formLuotXem.requestSubmit();
    }
});
