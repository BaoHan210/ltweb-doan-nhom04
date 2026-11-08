/**
 * Tệp kịch bản: canhan.js - Nguyễn Thị Trinh
 * Chức năng: Gợi ý từ khóa tìm kiếm món ăn.
 */

document.addEventListener("DOMContentLoaded", () => {
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

            const tuKhoa = tag.textContent.replace("#", "").trim();
            searchInput.value = tuKhoa;
            searchInput.focus();

            if (searchForm) {
                searchForm.requestSubmit();
            }
        });
    });
});