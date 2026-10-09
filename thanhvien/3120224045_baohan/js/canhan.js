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

const tenKhoaGiaoDien = 'giaoDienCaNhan';

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
        localStorage.getItem(tenKhoaGiaoDien);

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
            tenKhoaGiaoDien,
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



const nutChinhSua = document.querySelector('.nut-chinh-sua');
const nutLuuThayDoi = document.querySelector('.nut-luu-thay-doi');
const nutHuyChinhSua = document.querySelector('.nut-huy-chinh-sua');
const cacTruongChinhSua = document.querySelectorAll('[data-editable]');

let noiDungBanDau = [];

console.log('Đã tải chức năng chỉnh sửa:', {
    nutChinhSua: Boolean(nutChinhSua),
    nutLuuThayDoi: Boolean(nutLuuThayDoi),
    nutHuyChinhSua: Boolean(nutHuyChinhSua),
    soTruong: cacTruongChinhSua.length
});

if (nutChinhSua && nutLuuThayDoi && nutHuyChinhSua) {
    nutChinhSua.addEventListener('click', () => {
    console.log('Đã nhấn nút Chỉnh sửa');

    noiDungBanDau = Array.from(cacTruongChinhSua).map((truong) => ({
        phanTu: truong,
        noiDung: truong.textContent
    }));

        cacTruongChinhSua.forEach((truong) => {
            truong.contentEditable = 'true';
            truong.classList.add('dang-chinh-sua');
        });

        nutChinhSua.hidden = true;
        nutLuuThayDoi.hidden = false;
        nutHuyChinhSua.hidden = false;

        console.log('Đã bật chế độ chỉnh sửa');
    });

    nutLuuThayDoi.addEventListener('click', () => {
    const cacTruong = Array.from(cacTruongChinhSua);

    const form = document.querySelector('#form-luu-ho-so');

    const cacTruongGuiDi = [
        document.querySelector('#du-lieu-email'),
        document.querySelector('#du-lieu-ho-ten'),
        document.querySelector('#du-lieu-vai-tro'),
        document.querySelector('#du-lieu-nhiem-vu')
    ];

    if (
        form === null
        || cacTruong.length !== 4
        || cacTruongGuiDi.some((truong) => truong === null)
    ) {
        console.error('Không tìm thấy đủ trường dữ liệu để lưu.');
        return;
    }

    cacTruong.forEach((truong, viTri) => {
        cacTruongGuiDi[viTri].value = truong.textContent.trim();
    });

    form.requestSubmit();
});

    nutHuyChinhSua.addEventListener('click', () => {
        noiDungBanDau.forEach((banGhi) => {
            banGhi.phanTu.textContent = banGhi.noiDung;
        });

        cacTruongChinhSua.forEach((truong) => {
            truong.contentEditable = 'false';
            truong.classList.remove('dang-chinh-sua');
        });

        nutChinhSua.hidden = false;
        nutLuuThayDoi.hidden = true;
        nutHuyChinhSua.hidden = true;
    });
} else {
    console.error('Không tìm thấy đủ ba nút chỉnh sửa, lưu và hủy.');
}
