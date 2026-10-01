/*
 * trang-goi-y-mon-an.js
 * Xử lý chức năng Tủ lạnh của tôi - Hôm nay ăn gì?
 * Gợi ý món ăn và tạo danh sách đi chợ.
 */

const KHOA_DANH_SACH_DI_CHO = 'danhSachDiCho';

let danhSachMonAn = [];


/* =========================================================
   1. HỖ TRỢ
   ========================================================= */

const boDauTiengViet = (chuoi) => {
    return chuoi
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/đ/g, 'd')
        .replace(/Đ/g, 'D')
        .toLowerCase()
        .trim();
};


const laySo = (giaTri) => {
    if (typeof giaTri === 'number') {
        return giaTri;
    }

    if (typeof giaTri !== 'string') {
        return 0;
    }

    const chuoi = giaTri
        .replace(/[^\d]/g, '');

    return Number(chuoi) || 0;
};


const layDanhSachNguyenLieu = (monAn) => {
    if (!Array.isArray(monAn.nguyenLieu)) {
        return [];
    }

    return monAn.nguyenLieu
        .map((nguyenLieu) => {

            if (typeof nguyenLieu === 'string') {
                return nguyenLieu.trim();
            }

            if (
                nguyenLieu !== null &&
                typeof nguyenLieu === 'object'
            ) {
                return String(
                    nguyenLieu.ten ||
                    nguyenLieu.name ||
                    nguyenLieu.nguyenLieu ||
                    ''
                ).trim();
            }

            return '';
        })
        .filter((nguyenLieu) => nguyenLieu !== '');
};


const tachNguyenLieuNguoiDung = (chuoi) => {
    return chuoi
        .split(/[,;\n]/)
        .map((nguyenLieu) => boDauTiengViet(nguyenLieu))
        .filter((nguyenLieu) => nguyenLieu !== '');
};


const layAnhMonAn = (monAn) => {
    if (!monAn.hinhAnh) {
        return 'images/mon-an-nhanh.jpg';
    }

    if (
        monAn.hinhAnh.startsWith('http://') ||
        monAn.hinhAnh.startsWith('https://') ||
        monAn.hinhAnh.startsWith('/')
    ) {
        return monAn.hinhAnh;
    }

    if (monAn.hinhAnh.startsWith('images/')) {
        return monAn.hinhAnh;
    }

    return `images/${monAn.hinhAnh}`;
};


/* =========================================================
   2. LOCAL STORAGE
   ========================================================= */

const docDanhSachDiCho = () => {
    try {
        const duLieu = localStorage.getItem(
            KHOA_DANH_SACH_DI_CHO
        );

        if (duLieu === null) {
            return [];
        }

        const danhSach = JSON.parse(duLieu);

        return Array.isArray(danhSach)
            ? danhSach
            : [];
    } catch (error) {
        return [];
    }
};


const luuDanhSachDiCho = (danhSach) => {
    localStorage.setItem(
        KHOA_DANH_SACH_DI_CHO,
        JSON.stringify(danhSach)
    );
};


/* =========================================================
   3. TÌM NGUYÊN LIỆU CÒN THIẾU
   ========================================================= */

const layNguyenLieuConThieu = (
    monAn,
    nguyenLieuNguoiDung
) => {

    const danhSachNguyenLieu =
        layDanhSachNguyenLieu(monAn);

    return danhSachNguyenLieu.filter((nguyenLieu) => {

        const tenNguyenLieu =
            boDauTiengViet(nguyenLieu);

        return !nguyenLieuNguoiDung.some(
            (nguyenLieuDaCo) => {

                return (
                    tenNguyenLieu.includes(nguyenLieuDaCo) ||
                    nguyenLieuDaCo.includes(tenNguyenLieu)
                );
            }
        );
    });
};


/* =========================================================
   4. TÍNH ĐIỂM PHÙ HỢP
   ========================================================= */

const tinhDiemPhuHop = (
    monAn,
    nguyenLieuNguoiDung
) => {

    const danhSachNguyenLieu =
        layDanhSachNguyenLieu(monAn);

    let diem = 0;

    danhSachNguyenLieu.forEach((nguyenLieu) => {

        const tenNguyenLieu =
            boDauTiengViet(nguyenLieu);

        const coSan = nguyenLieuNguoiDung.some(
            (nguyenLieuDaCo) => {

                return (
                    tenNguyenLieu.includes(nguyenLieuDaCo) ||
                    nguyenLieuDaCo.includes(tenNguyenLieu)
                );
            }
        );

        if (coSan) {
            diem += 1;
        }
    });

    return diem;
};


/* =========================================================
   5. LỌC MÓN ĂN
   ========================================================= */

const timMonPhuHop = (
    nguyenLieu,
    nganSach,
    thoiGian,
    soNguoi
) => {

    const nguyenLieuNguoiDung =
        tachNguyenLieuNguoiDung(nguyenLieu);


    const monPhuHop =
        danhSachMonAn
            .map((monAn) => {

                const gia =
                    laySo(monAn.nganSach);

                const thoiGianMon =
                    laySo(monAn.thoiGian);

                const khauPhan =
                    laySo(monAn.khauPhan);


                /*
                 * 1. ĐIỂM NGUYÊN LIỆU
                 *
                 * Đây là tiêu chí quan trọng nhất.
                 * Nếu người dùng nhập "tôm", món phải có
                 * ít nhất một nguyên liệu liên quan đến "tôm".
                 */

                const diemNguyenLieu =
                    tinhDiemPhuHop(
                        monAn,
                        nguyenLieuNguoiDung
                    );


                /*
                 * Nếu người dùng đã nhập nguyên liệu
                 * nhưng món không có bất kỳ nguyên liệu
                 * nào trùng thì không đưa món đó vào.
                 *
                 * Đây là lý do "nước ép xoài" sẽ không
                 * xuất hiện khi người dùng chỉ nhập "tôm".
                 */

                if (
                    nguyenLieuNguoiDung.length > 0 &&
                    diemNguyenLieu === 0
                ) {
                    return null;
                }


                let diem = 0;


                /*
                 * 2. NGUYÊN LIỆU
                 *
                 * Mỗi nguyên liệu người dùng có sẽ
                 * giúp món tăng điểm.
                 *
                 * Ví dụ:
                 * - Có tôm -> món có tôm được điểm
                 * - Có tôm + trứng -> món có cả hai
                 *   được điểm cao hơn món chỉ có tôm.
                 */

                diem += diemNguyenLieu * 50;


                /*
                 * 3. NGÂN SÁCH
                 *
                 * Không loại món chỉ vì vượt ngân sách.
                 *
                 * Trong ngân sách:
                 *     điểm cao
                 *
                 * Vượt một chút:
                 *     vẫn có điểm
                 *
                 * Vượt nhiều:
                 *     điểm thấp hơn
                 */

                if (nganSach > 0 && gia > 0) {

                    if (gia <= nganSach) {

                        diem += 25;

                    } else {

                        const phanTramVuot =
                            (gia - nganSach) / nganSach;

                        if (phanTramVuot <= 0.10) {

                            diem += 20;

                        } else if (phanTramVuot <= 0.25) {

                            diem += 15;

                        } else if (phanTramVuot <= 0.50) {

                            diem += 8;

                        } else {

                            diem += 2;
                        }
                    }
                }


                /*
                 * 4. THỜI GIAN
                 *
                 * Không bắt buộc phải nhỏ hơn thời gian
                 * người dùng nhập.
                 *
                 * Món nhanh hơn được ưu tiên.
                 * Món lâu hơn một chút vẫn có thể xuất hiện.
                 */

                if (thoiGian > 0 && thoiGianMon > 0) {

                    if (thoiGianMon <= thoiGian) {

                        diem += 15;

                    } else {

                        const phanTramVuot =
                            (thoiGianMon - thoiGian) / thoiGian;

                        if (phanTramVuot <= 0.20) {

                            diem += 10;

                        } else if (phanTramVuot <= 0.50) {

                            diem += 5;

                        } else {

                            diem += 1;
                        }
                    }
                }


                /*
                 * 5. KHẨU PHẦN
                 *
                 * Nếu món đủ cho số người cần ăn:
                 *     ưu tiên cao.
                 *
                 * Nếu ít hơn:
                 *     vẫn không loại ngay.
                 */

                if (soNguoi > 0 && khauPhan > 0) {

                    if (khauPhan >= soNguoi) {

                        diem += 10;

                    } else {

                        const tiLe =
                            khauPhan / soNguoi;

                        if (tiLe >= 0.75) {

                            diem += 7;

                        } else if (tiLe >= 0.50) {

                            diem += 4;

                        } else {

                            diem += 1;
                        }
                    }
                }


                return {
                    monAn,
                    diem,
                    diemNguyenLieu,
                    gia,
                    thoiGianMon
                };
            })
            .filter((item) => item !== null)
            .sort((a, b) => {

                /*
                 * Ưu tiên tổng điểm.
                 */

                if (b.diem !== a.diem) {
                    return b.diem - a.diem;
                }


                /*
                 * Nếu bằng điểm thì ưu tiên món
                 * có nhiều nguyên liệu người dùng có hơn.
                 */

                if (
                    b.diemNguyenLieu !==
                    a.diemNguyenLieu
                ) {
                    return (
                        b.diemNguyenLieu -
                        a.diemNguyenLieu
                    );
                }


                /*
                 * Nếu vẫn bằng điểm thì ưu tiên
                 * món có thời gian nấu ngắn hơn.
                 */

                return (
                    a.thoiGianMon -
                    b.thoiGianMon
                );
            })
            .slice(0, 3)
            .map((item) => item.monAn);


    return monPhuHop;
};


/* =========================================================
   6. HIỂN THỊ CARD
   ========================================================= */

const taoTheMonAn = (
    monAn,
    nguyenLieuNguoiDung
) => {

    const article =
        document.createElement('article');

    article.className = 'the-goi-y';


    const hinhAnh =
        document.createElement('img');

    hinhAnh.src =
        layAnhMonAn(monAn);

    hinhAnh.alt =
        `Hình ảnh món ${monAn.ten || 'ăn'}`;

    hinhAnh.loading = 'lazy';


    const tieuDe =
        document.createElement('h3');

    tieuDe.textContent =
        monAn.ten || 'Món ăn';


    const moTa =
        document.createElement('p');

    moTa.textContent =
        monAn.moTa ||
        'Món ăn phù hợp với nhu cầu của bạn.';


    const thongTin =
        document.createElement('p');

    thongTin.className =
        'thong-tin-ngan';

    const thoiGian =
        laySo(monAn.thoiGian);

    const nganSach =
        laySo(monAn.nganSach);

    const khauPhan =
        laySo(monAn.khauPhan);


    thongTin.textContent =
        `${thoiGian} phút · ` +
        `${nganSach.toLocaleString('vi-VN')} VNĐ · ` +
        `${khauPhan} người`;


    const hanhDong =
        document.createElement('div');

    hanhDong.className =
        'hanh-dong-the-goi-y';


    const linkChiTiet =
        document.createElement('a');

    linkChiTiet.href =
        `chi-tiet.html?id=${encodeURIComponent(monAn.id)}`;

    linkChiTiet.textContent =
        'Xem chi tiết';


    const nutDanhSach =
        document.createElement('button');

    nutDanhSach.type =
        'button';

    nutDanhSach.className =
        'nut';

    nutDanhSach.textContent =
        'Thêm vào danh sách đi chợ';


    nutDanhSach.addEventListener(
        'click',
        () => {

            themVaoDanhSachDiCho(
                monAn,
                nguyenLieuNguoiDung
            );
        }
    );


    hanhDong.appendChild(linkChiTiet);
    hanhDong.appendChild(nutDanhSach);


    article.appendChild(hinhAnh);
    article.appendChild(tieuDe);
    article.appendChild(moTa);
    article.appendChild(thongTin);
    article.appendChild(hanhDong);


    return article;
};


/* =========================================================
   7. HIỂN THỊ KẾT QUẢ
   ========================================================= */

const hienThiKetQua = (
    danhSach,
    nguyenLieu
) => {

    const khuVuc =
        document.querySelector(
            '#danh-sach-mon-goi-y'
        );

    const thongBao =
        document.querySelector(
            '#thong-bao-goi-y'
        );


    if (
        khuVuc === null ||
        thongBao === null
    ) {
        return;
    }


    khuVuc.innerHTML = '';


    if (danhSach.length === 0) {

    thongBao.textContent =
        'Chưa tìm thấy món phù hợp với nguyên liệu bạn đã nhập. ' +
        'Bạn hãy thử nhập nguyên liệu khác hoặc điều chỉnh ngân sách, thời gian nấu.';

    return;
}


    thongBao.textContent =
        `Tìm thấy ${danhSach.length} món ăn phù hợp với thông tin bạn đã nhập.`;


    danhSach.forEach((monAn) => {

        const theMonAn =
            taoTheMonAn(
                monAn,
                nguyenLieu
            );

        khuVuc.appendChild(theMonAn);
    });
};


/* =========================================================
   8. DANH SÁCH ĐI CHỢ
   ========================================================= */

const hienThiDanhSachDiCho = () => {

    const khuVuc =
        document.querySelector(
            '#khu-vuc-danh-sach-di-cho'
        );

    const tenMon =
        document.querySelector(
            '#ten-mon-danh-sach-di-cho'
        );

    const danhSachNguyenLieu =
        document.querySelector(
            '#danh-sach-nguyen-lieu-can-mua'
        );


    if (
        khuVuc === null ||
        tenMon === null ||
        danhSachNguyenLieu === null
    ) {
        return;
    }


    const danhSach =
        docDanhSachDiCho();


    danhSachNguyenLieu.innerHTML = '';


    if (danhSach.length === 0) {

        khuVuc.hidden = true;

        return;
    }


    khuVuc.hidden = false;


    const monAnCuoi =
        danhSach[danhSach.length - 1];


    tenMon.textContent =
        `Nguyên liệu cần mua cho ${monAnCuoi.ten}`;


    const tapNguyenLieu =
        new Set();


    danhSach.forEach((monAn) => {

        monAn.nguyenLieuConThieu.forEach(
            (nguyenLieu) => {

                tapNguyenLieu.add(
                    nguyenLieu
                );
            }
        );
    });


    tapNguyenLieu.forEach(
        (nguyenLieu) => {

            const li =
                document.createElement('li');

            li.textContent =
                nguyenLieu;

            danhSachNguyenLieu.appendChild(li);
        }
    );
};


const themVaoDanhSachDiCho = (
    monAn,
    nguyenLieuNguoiDung
) => {

    const nguyenLieuConThieu =
        layNguyenLieuConThieu(
            monAn,
            nguyenLieuNguoiDung
        );


    const danhSach =
        docDanhSachDiCho();


    const daCo =
        danhSach.some(
            (item) => item.id === monAn.id
        );


    if (!daCo) {

        danhSach.push({

            id: monAn.id,

            ten: monAn.ten,

            nguyenLieuConThieu
        });


        luuDanhSachDiCho(
            danhSach
        );
    }


    hienThiDanhSachDiCho();
};


/* =========================================================
   9. XÓA DANH SÁCH
   ========================================================= */

const xoaDanhSachDiCho = () => {

    localStorage.removeItem(
        KHOA_DANH_SACH_DI_CHO
    );

    hienThiDanhSachDiCho();
};


/* =========================================================
   10. LOAD JSON
   ========================================================= */

const hienThiDangTaiDuLieu = () => {
    const thongBao = document.querySelector('#thong-bao-goi-y');

    if (thongBao === null) {
        return;
    }

    thongBao.textContent = 'Đang tải dữ liệu món ăn...';
};


const hienThiLoiTaiDuLieu = () => {
    const thongBao = document.querySelector('#thong-bao-goi-y');

    if (thongBao === null) {
        return;
    }

    thongBao.textContent = '';

    const noiDungLoi = document.createElement('span');
    noiDungLoi.textContent =
        'Không thể tải dữ liệu món ăn. Vui lòng thử lại.';

    const nutThuLai = document.createElement('button');
    nutThuLai.type = 'button';
    nutThuLai.className = 'nut nut-phu';
    nutThuLai.textContent = 'Thử lại';

    nutThuLai.addEventListener('click', async () => {
        await taiDanhSachMonAn();
    });

    thongBao.appendChild(noiDungLoi);
    thongBao.appendChild(document.createTextNode(' '));
    thongBao.appendChild(nutThuLai);
};

const taiDanhSachMonAn = async () => {
    hienThiDangTaiDuLieu();

    try {
        const response = await fetch(
            'data/mon-an.json'
        );

        if (!response.ok) {
            throw new Error(
                `Không thể tải dữ liệu món ăn: ${response.status}`
            );
        }

        const duLieu = await response.json();

        if (Array.isArray(duLieu) === false) {
            throw new Error(
                'Dữ liệu món ăn không đúng định dạng.'
            );
        }

        danhSachMonAn = duLieu;

    } catch (error) {
        console.error(
            'Lỗi tải dữ liệu món ăn:',
            error
        );

        danhSachMonAn = [];

        hienThiLoiTaiDuLieu();
    }
};


/* =========================================================
   11. XỬ LÝ FORM
   ========================================================= */

const xuLyFormGoiY = (event) => {

    event.preventDefault();


    const oNguyenLieu =
        document.querySelector(
            '#ingredients'
        );

    const oNganSach =
        document.querySelector(
            '#budget'
        );

    const oThoiGian =
        document.querySelector(
            '#cooking-time'
        );

    const oSoNguoi =
        document.querySelector(
            '#servings'
        );


    if (
        oNguyenLieu === null ||
        oNganSach === null ||
        oThoiGian === null ||
        oSoNguoi === null
    ) {
        return;
    }


    const nguyenLieu =
        oNguyenLieu.value.trim();

    const nganSach =
        Number(oNganSach.value);

    const thoiGian =
        Number(oThoiGian.value);

    const soNguoi =
        Number(oSoNguoi.value);


    if (
        nguyenLieu === '' ||
        nganSach <= 0 ||
        thoiGian <= 0 ||
        soNguoi <= 0
    ) {
        return;
    }


    const danhSach =
        timMonPhuHop(
            nguyenLieu,
            nganSach,
            thoiGian,
            soNguoi
        );


    hienThiKetQua(
        danhSach,
        tachNguyenLieuNguoiDung(
            nguyenLieu
        )
    );
};


/* =========================================================
   12. RESET
   ========================================================= */

const xuLyNhapLai = () => {

    const khuVuc =
        document.querySelector(
            '#danh-sach-mon-goi-y'
        );

    const thongBao =
        document.querySelector(
            '#thong-bao-goi-y'
        );


    if (khuVuc !== null) {
        khuVuc.innerHTML = '';
    }


    if (thongBao !== null) {

        thongBao.textContent =
            'Nhập thông tin ở trên để nhận gợi ý món ăn phù hợp.';
    }
};


/* =========================================================
   13. KHỞI TẠO
   ========================================================= */

const khoiTaoTrangGoiY = async () => {

    const form =
        document.querySelector(
            '#form-goi-y'
        );

    const nutXoa =
        document.querySelector(
            '#nut-xoa-danh-sach'
        );

    const nutNhapLai =
        document.querySelector(
            '#nut-nhap-lai'
        );


    if (form !== null) {

        form.addEventListener(
            'submit',
            xuLyFormGoiY
        );
    }


    if (nutNhapLai !== null) {

        nutNhapLai.addEventListener(
            'click',
            xuLyNhapLai
        );
    }


    if (nutXoa !== null) {

        nutXoa.addEventListener(
            'click',
            xoaDanhSachDiCho
        );
    }


    await taiDanhSachMonAn();

    hienThiDanhSachDiCho();
};


khoiTaoTrangGoiY();