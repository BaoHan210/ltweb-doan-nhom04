/*
 * canhan.js
 * Xử lý tương tác trên trang cá nhân: đổi giao diện và sao chép email.
 * Cách thử: nhấn nút Chế độ tối và Sao chép email trên trang cá nhân.
 */

const nutChuyenGiaoDien =
    document.querySelector('.nut-chuyen-giao-dien');

const nutSaoChepEmail =
    document.querySelector('.nut-sao-chep-email');

const thongBaoSaoChep =
    document.querySelector('.thong-bao-sao-chep');

const TEN_KHOA_GIAO_DIEN = 'giaoDienCaNhan';

const capNhatNutGiaoDien = (laGiaoDienToi) => {
    if (nutChuyenGiaoDien === null) return;

    nutChuyenGiaoDien.setAttribute(
        'aria-pressed',
        laGiaoDienToi ? 'true' : 'false'
    );

    nutChuyenGiaoDien.textContent =
        laGiaoDienToi
            ? 'Chế độ sáng'
            : 'Chế độ tối';
};

const apDungGiaoDien = (laGiaoDienToi) => {
    document.body.classList.toggle(
        'giao-dien-toi',
        laGiaoDienToi
    );

    capNhatNutGiaoDien(laGiaoDienToi);
};

const khoiTaoGiaoDien = () => {
    const giaoDienDaLuu =
        localStorage.getItem(TEN_KHOA_GIAO_DIEN);

    const laGiaoDienToi =
        giaoDienDaLuu === 'toi';

    apDungGiaoDien(laGiaoDienToi);
};

const khoiTaoNutGiaoDien = () => {
    if (nutChuyenGiaoDien === null) return;

    nutChuyenGiaoDien.addEventListener('click', () => {
        const laGiaoDienToi =
            document.body.classList.contains('giao-dien-toi') === false;

        apDungGiaoDien(laGiaoDienToi);

        localStorage.setItem(
            TEN_KHOA_GIAO_DIEN,
            laGiaoDienToi ? 'toi' : 'sang'
        );
    });
};

const xuLySaoChepEmail = async () => {
    if (
        nutSaoChepEmail === null ||
        thongBaoSaoChep === null
    ) {
        return;
    }

    const phanTuEmail =
        document.querySelector('.dia-chi-email');

    if (phanTuEmail === null) {
        thongBaoSaoChep.textContent =
            'Không tìm thấy địa chỉ email.';
        return;
    }

    const email =
        phanTuEmail.textContent.trim();

    try {
        await navigator.clipboard.writeText(email);

        thongBaoSaoChep.textContent =
            'Đã sao chép email.';
    } catch (error) {
        console.error(
            'Không thể sao chép email:',
            error
        );

        thongBaoSaoChep.textContent =
            'Không thể sao chép email.';
    }
};

const khoiTaoSaoChepEmail = () => {
    if (nutSaoChepEmail === null) return;

    nutSaoChepEmail.addEventListener(
        'click',
        xuLySaoChepEmail
    );
};

const khoiTaoTrangCaNhan = () => {
    khoiTaoGiaoDien();
    khoiTaoNutGiaoDien();
    khoiTaoSaoChepEmail();
};

khoiTaoTrangCaNhan();