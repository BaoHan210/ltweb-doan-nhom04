/*
 * Tệp canhan.js tạo hai tương tác cho trang cá nhân của thành viên.
 * Chức năng 1: đánh giá trang cá nhân từ 1 đến 5 sao.
 * Chức năng 2: sao chép liên kết trang cá nhân và hiển thị thông báo.
 * Cách thử: chọn mức đánh giá hoặc nhấn nút sao chép liên kết.
 */

document.addEventListener("DOMContentLoaded", function () {
    // ==============================
    // TƯƠNG TÁC 1: ĐÁNH GIÁ 1–5 SAO
    // ==============================

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
            const buttons = ratingList.querySelectorAll(".rating-button");

            buttons.forEach(function (button) {
                button.classList.remove("rating-selected");
            });

            ratingButton.classList.add("rating-selected");
            ratingText.textContent =
                "Bạn đã đánh giá " + i + " sao. Cảm ơn bạn đã đánh giá!";
        });

        ratingList.appendChild(ratingButton);
    }

    ratingSection.appendChild(ratingTitle);
    ratingSection.appendChild(ratingText);
    ratingSection.appendChild(ratingList);

    // ==============================
    // TƯƠNG TÁC 2: SAO CHÉP LIÊN KẾT
    // ==============================

    const linkSection = document.createElement("section");
    const linkTitle = document.createElement("h2");
    const copyButton = document.createElement("button");
    const copyMessage = document.createElement("p");

    linkSection.classList.add("sao-chep-lien-ket");
    linkTitle.textContent = "Chia sẻ trang cá nhân";

    copyButton.type = "button";
    copyButton.textContent = "🔗 Sao chép liên kết";

    copyMessage.textContent = "";

    copyButton.addEventListener("click", function () {
        const pageUrl = window.location.href;

        navigator.clipboard.writeText(pageUrl)
            .then(function () {
                copyMessage.textContent =
                    "Đã sao chép liên kết trang cá nhân.";
            })
            .catch(function () {
                copyMessage.textContent =
                    "Không thể sao chép liên kết. Vui lòng thử lại.";
            });
    });

    linkSection.appendChild(linkTitle);
    linkSection.appendChild(copyButton);
    linkSection.appendChild(copyMessage);

    document.querySelector(".ho-so-trang").appendChild(ratingSection);
    document.querySelector(".ho-so-trang").appendChild(linkSection);
});