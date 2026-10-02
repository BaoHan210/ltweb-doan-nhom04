/*
 * Tệp canhan.js tạo các tương tác cho trang cá nhân của thành viên.
 * Chức năng 1: chuyển đổi giao diện sáng và tối, ghi nhớ bằng localStorage.
 * Chức năng 2: thu gọn và mở rộng nội dung của từng mục bằng accordion.
 * Cách thử: nhấn nút đổi giao diện hoặc nhấn vào tiêu đề các mục.
 */

document.addEventListener("DOMContentLoaded", function () {
    // ==============================
    // TƯƠNG TÁC 1: CHUYỂN SÁNG / TỐI
    // ==============================

    const themeButton = document.createElement("button");

    themeButton.type = "button";
    themeButton.textContent = "🌙 Chế độ tối";

    document.body.prepend(themeButton);

    const savedTheme = localStorage.getItem("theme");

    if (savedTheme === "dark") {
        document.body.classList.add("dark-mode");
        themeButton.textContent = "☀️ Chế độ sáng";
    }

    themeButton.addEventListener("click", function () {
        document.body.classList.toggle("dark-mode");

        if (document.body.classList.contains("dark-mode")) {
            themeButton.textContent = "☀️ Chế độ sáng";
            localStorage.setItem("theme", "dark");
        } else {
            themeButton.textContent = "🌙 Chế độ tối";
            localStorage.setItem("theme", "light");
        }
    });


    // ==============================
    // TƯƠNG TÁC 2: THU GỌN / MỞ RỘNG
    // ==============================

    const sections = document.querySelectorAll("main > section, main > article");

    sections.forEach(function (section) {
        const title = section.querySelector("h2");

        if (!title) {
            return;
        }

        title.setAttribute("tabindex", "0");
        title.setAttribute("role", "button");
        title.setAttribute("aria-expanded", "true");

        const arrow = document.createElement("span");
        arrow.textContent = " ▼";
        arrow.setAttribute("aria-hidden", "true");
        title.appendChild(arrow);

        title.addEventListener("click", function () {
            const isOpen = title.getAttribute("aria-expanded") === "true";

            title.setAttribute("aria-expanded", String(!isOpen));

            arrow.textContent = isOpen ? " ▶" : " ▼";

            Array.from(section.children).forEach(function (element) {
                if (element !== title) {
                    element.hidden = isOpen;
                }
            });
        });

        title.addEventListener("keydown", function (event) {
            if (event.key === "Enter" || event.key === " ") {
                event.preventDefault();
                title.click();
            }
        });
    });
});