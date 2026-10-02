/*
 * Tệp canhan.js tạo chức năng đánh giá cho trang cá nhân.
 * Người dùng có thể chọn mức đánh giá từ 1 đến 5 sao.
 * JavaScript xử lý sự kiện và hiển thị kết quả đánh giá trực tiếp trên trang.
 * Cách thử: nhấn một trong năm mức đánh giá và quan sát thông báo kết quả.
 */

document.addEventListener("DOMContentLoaded", function () {
    const ratingSection = document.createElement("section");
    const ratingTitle = document.createElement("h2");
    const ratingText = document.createElement("p");
    const ratingList = document.createElement("div");

    ratingSection.classList.add("danh-gia-ca-nhan");
    ratingTitle.textContent = "Đánh giá trang cá nhân";
    ratingText.textContent = "Bạn đánh giá trang cá nhân này bao nhiêu sao?";
    ratingList.classList.add("rating-list");

    for (let i = 1; i <= 5; i++) {
        const ratingButton = document.createElement("button");

        ratingButton.type = "button";
        ratingButton.textContent = "⭐ " + i;
        ratingButton.setAttribute("aria-label", "Đánh giá " + i + " sao");
        ratingButton.classList.add("rating-button");

        ratingButton.addEventListener("click", function () {
            ratingText.textContent =
                "Bạn đã đánh giá " + i + " sao. Cảm ơn bạn đã đánh giá!";

            const buttons = ratingList.querySelectorAll(".rating-button");

            buttons.forEach(function (button) {
                button.classList.remove("rating-selected");
            });

            ratingButton.classList.add("rating-selected");
        });

        ratingList.appendChild(ratingButton);
    }

    ratingSection.appendChild(ratingTitle);
    ratingSection.appendChild(ratingText);
    ratingSection.appendChild(ratingList);

    document.querySelector(".ho-so-trang").appendChild(ratingSection);
});