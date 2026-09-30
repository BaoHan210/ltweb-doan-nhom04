/*
 * trang-lien-he.js
 * Xử lý biểu mẫu liên hệ và gửi công thức.
 * Kiểm tra dữ liệu, hiển thị lỗi và gửi biểu mẫu bằng fetch.
 */


const formLienHe = document.querySelector(
    '.form-lien-he'
);

const tenNguoiGui = document.querySelector(
    '#full-name'
);

const email = document.querySelector(
    '#email'
);

const tenMon = document.querySelector(
    '#dish-name'
);

const soNguoiAn = document.querySelector(
    '#servings'
);

const danhMuc = document.querySelector(
    '#category'
);

const noiDungCongThuc = document.querySelector(
    '#recipe-content'
);
const chuDe = document.querySelector(
    '#subject'
);

const khuVucCongThuc = document.querySelector(
    '.khu-vuc-cong-thuc'
);

const noiDung = document.querySelector(
    '#message'
);

const thoiGianNau = document.querySelector(
    '#cooking-time'
);

const layCheDoTrang = () => {
    const thamSo = new URLSearchParams(
        window.location.search
    );

    return thamSo.get('loai');
};

const thietLapCheDoDangCongThuc = () => {
    const cheDoTrang = layCheDoTrang();

    if (cheDoTrang !== 'cong-thuc') {
        return;
    }

    const tieuDe = document.querySelector(
        '.tieu-de-lien-he'
    );

    const tieuDePhu = document.querySelector(
        '.tieu-de-phu-lien-he'
    );

    const moTa = document.querySelector(
        '.mo-ta-lien-he'
    );

    const chuDe = document.querySelector(
        '#subject'
    );

    const khuVucCongThuc = document.querySelector(
    '.khu-vuc-cong-thuc'
);

    if (tieuDe !== null) {
        tieuDe.textContent = 'Đăng công thức';
    }

    if (tieuDePhu !== null) {
        tieuDePhu.textContent =
            'Chia sẻ công thức cùng Cook with me';
    }

    if (moTa !== null) {
        moTa.textContent =
            'Đăng công thức nấu ăn để chia sẻ món ăn và kinh nghiệm của bạn với cộng đồng Cook with me.';
    }

    if (chuDe !== null) {
        chuDe.value = 'gui-cong-thuc';
    }

    if (khuVucCongThuc !== null) {
        khuVucCongThuc.hidden = false;
    }
};

/*
 * Kiểm tra họ và tên.
 */

const kiemTraHoTen = () => {
    if (tenNguoiGui === null) {
        return true;
    }

    const giaTri = tenNguoiGui.value.trim();

    if (giaTri === '') {
        hienThiLoiTruong(
            tenNguoiGui,
            'Vui lòng nhập họ và tên.'
        );

        return false;
    }

    if (/^[A-Za-zÀ-ỹĐđ\s]{2,50}$/.test(giaTri) === false) {
        hienThiLoiTruong(
            tenNguoiGui,
            'Họ tên chỉ được chứa chữ cái và khoảng trắng.'
        );

        return false;
    }

    xoaLoiTruong(tenNguoiGui);

    return true;
};

/*
 * Kiểm tra email.
 */

const kiemTraEmail = () => {
    if (email === null) {
        return true;
    }

    const giaTri = email.value.trim();

    if (giaTri === '') {
        hienThiLoiTruong(
            email,
            'Vui lòng nhập email.'
        );

        return false;
    }

    if (email.validity.typeMismatch === true) {
        hienThiLoiTruong(
            email,
            'Email không đúng định dạng.'
        );

        return false;
    }

    xoaLoiTruong(email);

    return true;
};

/*
 * Kiểm tra chủ đề.
 */

const kiemTraChuDe = () => {
    if (chuDe === null) {
        return true;
    }

    if (chuDe.value === '') {
        hienThiLoiTruong(
            chuDe,
            'Vui lòng chọn chủ đề.'
        );

        return false;
    }

    xoaLoiTruong(chuDe);

    return true;
};

/*
 * Kiểm tra số người ăn.
 */

const kiemTraSoNguoiAn = () => {
    if (soNguoiAn === null) {
        return true;
    }

    const giaTri = Number(soNguoiAn.value);

    if (
        soNguoiAn.value === ''
        || giaTri < 1
        || giaTri > 20
    ) {
        hienThiLoiTruong(
            soNguoiAn,
            'Số người ăn phải từ 1 đến 20.'
        );

        return false;
    }

    xoaLoiTruong(soNguoiAn);

    return true;
};

/*
 * Kiểm tra thời gian nấu.
 */

const kiemTraThoiGianNau = () => {
    if (thoiGianNau === null) {
        return true;
    }

    const giaTri = Number(
        thoiGianNau.value
    );

    if (
        thoiGianNau.value === ''
        || giaTri < 1
        || giaTri > 300
    ) {
        hienThiLoiTruong(
            thoiGianNau,
            'Thời gian nấu phải từ 1 đến 300 phút.'
        );

        return false;
    }

    xoaLoiTruong(thoiGianNau);

    return true;
};

/*
 * Kiểm tra danh mục.
 */

const kiemTraDanhMuc = () => {
    if (danhMuc === null) {
        return true;
    }

    if (danhMuc.value === '') {
        hienThiLoiTruong(
            danhMuc,
            'Vui lòng chọn danh mục món ăn.'
        );

        return false;
    }

    xoaLoiTruong(danhMuc);

    return true;
};

/*
 * Kiểm tra nội dung công thức.
 */

const kiemTraNoiDungCongThuc = () => {
    if (noiDungCongThuc === null) {
        return true;
    }

    if (noiDungCongThuc.value.trim() === '') {
        hienThiLoiTruong(
            noiDungCongThuc,
            'Vui lòng nhập nội dung công thức.'
        );

        return false;
    }

    xoaLoiTruong(noiDungCongThuc);

    return true;
};

/*
 * Kiểm tra toàn bộ biểu mẫu.
 */

const kiemTraBieuMau = () => {
    const ketQuaHoTen = kiemTraHoTen();
    const ketQuaEmail = kiemTraEmail();
    const ketQuaChuDe = kiemTraChuDe();
    const ketQuaNoiDung = kiemTraNoiDung();

    if (
        ketQuaHoTen === false
        || ketQuaEmail === false
        || ketQuaChuDe === false
        || ketQuaNoiDung === false
    ) {
        return false;
    }

    if (
        chuDe !== null
        && chuDe.value === 'gui-cong-thuc'
    ) {
        const ketQuaTenMon = kiemTraTenMon();
        const ketQuaSoNguoiAn = kiemTraSoNguoiAn();
        const ketQuaDanhMuc = kiemTraDanhMuc();
        const ketQuaNoiDungCongThuc =
            kiemTraNoiDungCongThuc();
        const ketQuaThoiGianNau =
            kiemTraThoiGianNau();

        return (
            ketQuaTenMon === true
            && ketQuaSoNguoiAn === true
            && ketQuaDanhMuc === true
            && ketQuaNoiDungCongThuc === true
            && ketQuaThoiGianNau === true
        );
    }

    return true;
};

/*
 * Kiểm tra tên món ăn.
 */

const kiemTraTenMon = () => {
    if (tenMon === null) {
        return true;
    }

    const giaTri = tenMon.value.trim();

    if (giaTri === '') {
        hienThiLoiTruong(
            tenMon,
            'Vui lòng nhập tên món ăn.'
        );

        return false;
    }

    if (
        /^[A-Za-zÀ-ỹĐđ\s]{2,50}$/.test(giaTri) === false
    ) {
        hienThiLoiTruong(
            tenMon,
            'Tên món ăn chỉ được chứa chữ cái và có từ 2 đến 50 ký tự.'
        );

        return false;
    }

    xoaLoiTruong(tenMon);

    return true;
};

/*
 * Hiển thị lỗi cho từng trường.
 */

const hienThiLoiTruong = (truong, noiDung) => {
    if (truong === null) {
        return;
    }

    truong.setCustomValidity(noiDung);

    truong.classList.add('co-loi');

    let thongBao = truong.parentElement.querySelector(
        '.thong-bao-loi-truong'
    );

    if (thongBao === null) {
        thongBao = document.createElement('p');
        thongBao.className = 'thong-bao-loi-truong';

        truong.parentElement.appendChild(thongBao);
    }

    thongBao.textContent = noiDung;
};

const xoaLoiTruong = (truong) => {
    if (truong === null) {
        return;
    }

    truong.setCustomValidity('');

    truong.classList.remove('co-loi');

    const thongBao = truong.parentElement.querySelector(
        '.thong-bao-loi-truong'
    );

    if (thongBao !== null) {
        thongBao.remove();
    }
};

/*
 * Kiểm tra nội dung liên hệ.
 */

const kiemTraNoiDung = () => {
    if (noiDung === null) {
        return true;
    }

    if (noiDung.value.trim() === '') {
        hienThiLoiTruong(
            noiDung,
            'Vui lòng nhập nội dung.'
        );

        return false;
    }

    xoaLoiTruong(noiDung);

    return true;
};

/*
 * Tạo dữ liệu gửi đi.
 */

const taoDuLieuGuiDi = () => {
    const duLieuForm = new FormData(
        formLienHe
    );

    const dangCongThuc =
        layCheDoTrang() === 'cong-thuc';

    if (dangCongThuc === true) {
        return {
            loai: 'cong-thuc',
            hoTen: duLieuForm.get('full_name'),
            email: duLieuForm.get('email'),
            tenMon: duLieuForm.get('dish_name'),
            soNguoiAn: duLieuForm.get('servings'),
            danhMuc: duLieuForm.get('category'),
            noiDungCongThuc:
                duLieuForm.get('recipe_content'),
            thoiGianNau:
                duLieuForm.get('cooking_time')
        };
    }

    return {
        loai: 'lien-he',
        hoTen: duLieuForm.get('full_name'),
        email: duLieuForm.get('email'),
        chuDe: duLieuForm.get('subject'),
        noiDung: duLieuForm.get('message')
    };
};


/*
 * Hiển thị thông báo.
 */

const hienThiThongBao = (
    noiDungThongBao,
    laLoi = false
) => {

    const thongBaoCu =
        document.querySelector(
            '.thong-bao-lien-he'
        );

    if (thongBaoCu !== null) {
        thongBaoCu.remove();
    }

    const thongBao =
        document.createElement('p');

    thongBao.className =
        'thong-bao-lien-he';

    if (laLoi === true) {
        thongBao.classList.add(
            'thong-bao-loi'
        );
    }

    thongBao.textContent =
        noiDungThongBao;

    formLienHe.prepend(thongBao);
};


/*
 * Gửi dữ liệu bằng fetch.
 */

const guiBieuMau = async (duLieu) => {

    const res = await fetch(
        'https://jsonplaceholder.typicode.com/posts',
        {
            method: 'POST',

            headers: {
                'Content-Type':
                    'application/json'
            },

            body: JSON.stringify(duLieu)
        }
    );

    if (res.ok === false) {

        throw new Error(
            `Gửi biểu mẫu thất bại: ${res.status}`
        );
    }

    return res.json();
};


/*
 * Xử lý gửi biểu mẫu.
 */

const xuLyGuiBieuMau = async (event) => {

    event.preventDefault();

    if (formLienHe === null) {
        return;
    }


    const hopLe =
        kiemTraBieuMau();


    if (hopLe === false) {
    return;
    }


    const nutGui =
        formLienHe.querySelector(
            'button[type="submit"]'
        );


    if (nutGui !== null) {

        nutGui.disabled = true;
        nutGui.textContent = 'Đang gửi...';
    }


    try {
    const duLieu = taoDuLieuGuiDi();

    await guiBieuMau(
        duLieu
    );

    const dangCongThuc =
        layCheDoTrang() === 'cong-thuc';

    if (dangCongThuc === true) {
        hienThiThongBao(
            'Đăng công thức thành công. Cảm ơn bạn đã chia sẻ với Cook with me.'
        );
    } else {
        hienThiThongBao(
            'Gửi thông tin thành công. Cảm ơn bạn đã liên hệ với Cook with me.'
        );
    }

    formLienHe.reset();

    if (dangCongThuc === true) {
        chuDe.value = 'gui-cong-thuc';
        capNhatKhuVucCongThuc();
    }


    } catch (error) {

        console.error(
            'Lỗi gửi biểu mẫu:',
            error
        );

        hienThiThongBao(
            'Không thể gửi thông tin lúc này. Vui lòng thử lại sau.',
            true
        );


    } finally {

        if (nutGui !== null) {
    nutGui.disabled = false;

    if (
        layCheDoTrang() === 'cong-thuc'
    ) {
        nutGui.textContent =
            'Đăng công thức';
    } else {
        nutGui.textContent =
            'Gửi liên hệ';
    }
}
    }
};

/*
 * Hiển thị hoặc ẩn khu vực thông tin công thức.
 */

const capNhatKhuVucCongThuc = () => {

    if (
        chuDe === null ||
        khuVucCongThuc === null
    ) {
        return;
    }


    if (chuDe.value === 'gui-cong-thuc') {

        khuVucCongThuc.hidden = false;

    } else {

        khuVucCongThuc.hidden = true;
    }
};

/*
 * Kiểm tra ngay khi người dùng nhập.
 */

const khoiTaoKiemTra = () => {

    if (tenNguoiGui !== null) {
        tenNguoiGui.addEventListener(
            'input',
            kiemTraHoTen
        );
    }

    if (tenMon !== null) {
        tenMon.addEventListener(
            'input',
            kiemTraTenMon
        );
    }

    if (soNguoiAn !== null) {
        soNguoiAn.addEventListener(
            'input',
            kiemTraSoNguoiAn
        );
    }

    if (danhMuc !== null) {
        danhMuc.addEventListener(
            'change',
            kiemTraDanhMuc
        );
    }

    if (noiDungCongThuc !== null) {
        noiDungCongThuc.addEventListener(
            'input',
            kiemTraNoiDungCongThuc
        );
    }

    if (email !== null) {
    email.addEventListener(
        'input',
        kiemTraEmail
    );
}

if (chuDe !== null) {
    chuDe.addEventListener(
        'change',
        kiemTraChuDe
    );
}

if (noiDung !== null) {
    noiDung.addEventListener(
        'input',
        kiemTraNoiDung
    );
}

};


/*
 * Khởi tạo trang.
 */

const khoiTaoTrang = () => {

    if (formLienHe === null) {
        return;
    }


    if (chuDe !== null) {

        chuDe.addEventListener(
            'change',
            capNhatKhuVucCongThuc
        );
    }


    khoiTaoKiemTra();


    formLienHe.addEventListener(
        'submit',
        xuLyGuiBieuMau
    );


    capNhatKhuVucCongThuc();
};

thietLapCheDoDangCongThuc();
khoiTaoTrang();