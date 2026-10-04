/*
 * trang-goi-y-mon-an.js
 * Xử lý chức năng Tủ lạnh của tôi - Hôm nay ăn gì?
 * Gợi ý món ăn và tạo danh sách đi chợ.
 */

const khoaDanhSachDiCho =
    'danhSachDiCho';

const duongDanDuLieuMonAn =
    'data/mon-an.json';

let danhSachMonAn = [];


/* =========================================================
   1. HỖ TRỢ
   ========================================================= */

/*
 * Bỏ dấu tiếng Việt để phục vụ tìm kiếm
 * và so sánh nguyên liệu.
 */
const boDauTiengViet = (
    chuoi
) => {

    if (
        chuoi === null
        || chuoi === undefined
    ) {
        return '';
    }

    return String(chuoi)
        .normalize('NFD')
        .replace(
            /[\u0300-\u036f]/g,
            ''
        )
        .replace(
            /đ/g,
            'd'
        )
        .replace(
            /Đ/g,
            'D'
        )
        .toLowerCase()
        .trim();
};


/*
 * Chuyển giá trị về số.
 */
const laySo = (
    giaTri
) => {

    if (
        typeof giaTri === 'number'
    ) {
        return Number.isFinite(
            giaTri
        )
            ? giaTri
            : 0;
    }

    if (
        typeof giaTri !== 'string'
    ) {
        return 0;
    }

    const chuoi =
        giaTri.replace(
            /[^\d]/g,
            ''
        );

    return Number(
        chuoi
    ) || 0;
};


/*
 * Lấy danh sách tên nguyên liệu của món ăn.
 */
const layDanhSachNguyenLieu = (
    monAn
) => {

    if (
        monAn === null
        || typeof monAn !== 'object'
        || Array.isArray(
            monAn.nguyenLieu
        ) === false
    ) {
        return [];
    }

    return monAn.nguyenLieu
        .map(
            (nguyenLieu) => {

                if (
                    typeof nguyenLieu === 'string'
                ) {
                    return nguyenLieu.trim();
                }

                if (
                    nguyenLieu !== null
                    &&
                    typeof nguyenLieu === 'object'
                ) {

                    return String(
                        nguyenLieu.ten
                        ||
                        nguyenLieu.name
                        ||
                        nguyenLieu.nguyenLieu
                        ||
                        ''
                    ).trim();
                }

                return '';
            }
        )
        .filter(
            (nguyenLieu) => {
                return nguyenLieu !== '';
            }
        );
};


/*
 * Tách nguyên liệu người dùng nhập.
 *
 * Ví dụ:
 * "tôm, trứng; hành lá"
 * =>
 * ["tom", "trung", "hanh la"]
 */
const tachNguyenLieuNguoiDung = (
    chuoi
) => {

    if (
        typeof chuoi !== 'string'
    ) {
        return [];
    }

    return chuoi
        .split(
            /[,;\n]/
        )
        .map(
            (nguyenLieu) => {
                return boDauTiengViet(
                    nguyenLieu
                );
            }
        )
        .filter(
            (nguyenLieu) => {
                return nguyenLieu !== '';
            }
        );
};


/*
 * Lấy đường dẫn ảnh món ăn.
 */
const layAnhMonAn = (
    monAn
) => {

    if (
        monAn === null
        || typeof monAn !== 'object'
        || !monAn.hinhAnh
    ) {
        return 'images/mon-an-nhanh.jpg';
    }

    const hinhAnh =
        String(
            monAn.hinhAnh
        ).trim();


    if (
        hinhAnh === ''
    ) {
        return 'images/mon-an-nhanh.jpg';
    }


    if (
        hinhAnh.startsWith(
            'http://'
        )
        ||
        hinhAnh.startsWith(
            'https://'
        )
        ||
        hinhAnh.startsWith(
            '/'
        )
    ) {
        return hinhAnh;
    }


    if (
        hinhAnh.startsWith(
            'images/'
        )
    ) {
        return hinhAnh;
    }


    return `images/${hinhAnh}`;
};


/* =========================================================
   2. LOCAL STORAGE
   ========================================================= */

/*
 * Đọc danh sách đi chợ.
 */
const docDanhSachDiCho = () => {

    try {

        const duLieu =
            localStorage.getItem(
                khoaDanhSachDiCho
            );


        if (
            duLieu === null
        ) {
            return [];
        }


        const danhSach =
            JSON.parse(
                duLieu
            );


        if (
            Array.isArray(
                danhSach
            ) === false
        ) {
            return [];
        }


        return danhSach.filter(
            (item) => {

                return (
                    item !== null
                    &&
                    typeof item === 'object'
                );
            }
        );

    } catch (error) {

        return [];
    }
};


/*
 * Lưu danh sách đi chợ.
 */
const luuDanhSachDiCho = (
    danhSach
) => {

    if (
        Array.isArray(
            danhSach
        ) === false
    ) {
        return;
    }

    try {

        localStorage.setItem(
            khoaDanhSachDiCho,
            JSON.stringify(
                danhSach
            )
        );

    } catch (error) {

        console.error(
            'Không thể lưu danh sách đi chợ:',
            error
        );
    }
};


/* =========================================================
   3. TÌM NGUYÊN LIỆU CÒN THIẾU
   ========================================================= */

/*
 * Xác định những nguyên liệu của món ăn
 * mà người dùng chưa có.
 */
const layNguyenLieuConThieu = (
    monAn,
    nguyenLieuNguoiDung
) => {

    const danhSachNguyenLieu =
        layDanhSachNguyenLieu(
            monAn
        );


    if (
        danhSachNguyenLieu.length === 0
    ) {
        return [];
    }


    return danhSachNguyenLieu.filter(
        (nguyenLieu) => {

            const tenNguyenLieu =
                boDauTiengViet(
                    nguyenLieu
                );


            return !nguyenLieuNguoiDung.some(
                (nguyenLieuDaCo) => {

                    return (
                        tenNguyenLieu.includes(
                            nguyenLieuDaCo
                        )
                        ||
                        nguyenLieuDaCo.includes(
                            tenNguyenLieu
                        )
                    );
                }
            );
        }
    );
};


/* =========================================================
   4. TÍNH ĐIỂM PHÙ HỢP
   ========================================================= */

/*
 * Tính số nguyên liệu của món ăn
 * mà người dùng đang có.
 */
const tinhDiemPhuHop = (
    monAn,
    nguyenLieuNguoiDung
) => {

    const danhSachNguyenLieu =
        layDanhSachNguyenLieu(
            monAn
        );


    let diem = 0;


    danhSachNguyenLieu.forEach(
        (nguyenLieu) => {

            const tenNguyenLieu =
                boDauTiengViet(
                    nguyenLieu
                );


            const coSan =
                nguyenLieuNguoiDung.some(
                    (nguyenLieuDaCo) => {

                        return (
                            tenNguyenLieu.includes(
                                nguyenLieuDaCo
                            )
                            ||
                            nguyenLieuDaCo.includes(
                                tenNguyenLieu
                            )
                        );
                    }
                );


            if (
                coSan
            ) {
                diem += 1;
            }
        }
    );


    return diem;
};


/* =========================================================
   5. LỌC MÓN ĂN
   ========================================================= */

/*
 * Tìm tối đa 3 món phù hợp.
 *
 * Thứ tự ưu tiên:
 * 1. Nguyên liệu
 * 2. Ngân sách
 * 3. Thời gian
 * 4. Khẩu phần
 */
const timMonPhuHop = (
    nguyenLieu,
    nganSach,
    thoiGian,
    soNguoi
) => {

    const nguyenLieuNguoiDung =
        tachNguyenLieuNguoiDung(
            nguyenLieu
        );


    const monPhuHop =
        danhSachMonAn
            .map(
                (monAn) => {

                    const gia =
                        laySo(
                            monAn.nganSach
                        );

                    const thoiGianMon =
                        laySo(
                            monAn.thoiGian
                        );

                    const khauPhan =
                        laySo(
                            monAn.khauPhan
                        );


                    /*
                     * Điểm nguyên liệu.
                     */
                    const diemNguyenLieu =
                        tinhDiemPhuHop(
                            monAn,
                            nguyenLieuNguoiDung
                        );


                    /*
                     * Nếu người dùng đã nhập nguyên liệu
                     * nhưng món không có nguyên liệu nào
                     * liên quan thì loại món đó.
                     */
                    if (
                        nguyenLieuNguoiDung.length > 0
                        &&
                        diemNguyenLieu === 0
                    ) {
                        return null;
                    }


                    let diem = 0;


                    /*
                     * Mỗi nguyên liệu phù hợp:
                     * +50 điểm.
                     */
                    diem +=
                        diemNguyenLieu * 50;


                    /*
                     * Ngân sách.
                     */
                    if (
                        nganSach > 0
                        &&
                        gia > 0
                    ) {

                        if (
                            gia <= nganSach
                        ) {

                            diem += 25;

                        } else {

                            const phanTramVuot =
                                (
                                    gia
                                    -
                                    nganSach
                                )
                                /
                                nganSach;


                            if (
                                phanTramVuot <= 0.10
                            ) {

                                diem += 20;

                            } else if (
                                phanTramVuot <= 0.25
                            ) {

                                diem += 15;

                            } else if (
                                phanTramVuot <= 0.50
                            ) {

                                diem += 8;

                            } else {

                                diem += 2;
                            }
                        }
                    }


                    /*
                     * Thời gian nấu.
                     */
                    if (
                        thoiGian > 0
                        &&
                        thoiGianMon > 0
                    ) {

                        if (
                            thoiGianMon <= thoiGian
                        ) {

                            diem += 15;

                        } else {

                            const phanTramVuot =
                                (
                                    thoiGianMon
                                    -
                                    thoiGian
                                )
                                /
                                thoiGian;


                            if (
                                phanTramVuot <= 0.20
                            ) {

                                diem += 10;

                            } else if (
                                phanTramVuot <= 0.50
                            ) {

                                diem += 5;

                            } else {

                                diem += 1;
                            }
                        }
                    }


                    /*
                     * Khẩu phần.
                     */
                    if (
                        soNguoi > 0
                        &&
                        khauPhan > 0
                    ) {

                        if (
                            khauPhan >= soNguoi
                        ) {

                            diem += 10;

                        } else {

                            const tiLe =
                                khauPhan
                                /
                                soNguoi;


                            if (
                                tiLe >= 0.75
                            ) {

                                diem += 7;

                            } else if (
                                tiLe >= 0.50
                            ) {

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
                }
            )
            .filter(
                (item) => {
                    return item !== null;
                }
            )
            .sort(
                (a, b) => {

                    /*
                     * Ưu tiên tổng điểm.
                     */
                    if (
                        b.diem !== a.diem
                    ) {
                        return (
                            b.diem
                            -
                            a.diem
                        );
                    }


                    /*
                     * Nếu bằng điểm,
                     * ưu tiên món có nhiều nguyên liệu
                     * người dùng đang có.
                     */
                    if (
                        b.diemNguyenLieu
                        !==
                        a.diemNguyenLieu
                    ) {

                        return (
                            b.diemNguyenLieu
                            -
                            a.diemNguyenLieu
                        );
                    }


                    /*
                     * Nếu vẫn bằng điểm,
                     * ưu tiên món nấu nhanh hơn.
                     */
                    return (
                        a.thoiGianMon
                        -
                        b.thoiGianMon
                    );
                }
            )
            .slice(
                0,
                3
            )
            .map(
                (item) => {
                    return item.monAn;
                }
            );


    return monPhuHop;
};


/* =========================================================
   6. HIỂN THỊ CARD
   ========================================================= */

/*
 * Tạo card món ăn bằng DOM API.
 *
 * Không đưa dữ liệu món ăn vào innerHTML.
 */
const taoTheMonAn = (
    monAn,
    nguyenLieuNguoiDung
) => {

    const article =
        document.createElement(
            'article'
        );

    article.className =
        'the-goi-y';


    const hinhAnh =
        document.createElement(
            'img'
        );

    hinhAnh.src =
        layAnhMonAn(
            monAn
        );

    hinhAnh.alt =
        `Hình ảnh món ${
            monAn.ten || 'ăn'
        }`;

    hinhAnh.loading =
        'lazy';


    const tieuDe =
        document.createElement(
            'h3'
        );

    tieuDe.textContent =
        monAn.ten
        ||
        'Món ăn';


    const moTa =
        document.createElement(
            'p'
        );

    moTa.textContent =
        monAn.moTa
        ||
        'Món ăn phù hợp với nhu cầu của bạn.';


    const thongTin =
        document.createElement(
            'p'
        );

    thongTin.className =
        'thong-tin-ngan';


    const thoiGian =
        laySo(
            monAn.thoiGian
        );

    const nganSach =
        laySo(
            monAn.nganSach
        );

    const khauPhan =
        laySo(
            monAn.khauPhan
        );


    thongTin.textContent =
        `${thoiGian} phút · `
        +
        `${nganSach.toLocaleString('vi-VN')} VNĐ · `
        +
        `${khauPhan} người`;


    const hanhDong =
        document.createElement(
            'div'
        );

    hanhDong.className =
        'hanh-dong-the-goi-y';


    /*
     * Link chi tiết.
     */
    const linkChiTiet =
        document.createElement(
            'a'
        );

    linkChiTiet.href =
        `chi-tiet.html?id=${
            encodeURIComponent(
                String(
                    monAn.id
                )
            )
        }`;

    linkChiTiet.textContent =
        'Xem chi tiết';


    /*
     * Nút thêm vào danh sách đi chợ.
     */
    const nutDanhSach =
        document.createElement(
            'button'
        );

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


    hanhDong.appendChild(
        linkChiTiet
    );

    hanhDong.appendChild(
        nutDanhSach
    );


    article.appendChild(
        hinhAnh
    );

    article.appendChild(
        tieuDe
    );

    article.appendChild(
        moTa
    );

    article.appendChild(
        thongTin
    );

    article.appendChild(
        hanhDong
    );


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
        khuVuc === null
        ||
        thongBao === null
    ) {
        return;
    }


    /*
     * Chỉ xóa các phần tử con.
     * Không đưa dữ liệu bên ngoài vào innerHTML.
     */
    khuVuc.replaceChildren();


    if (
        danhSach.length === 0
    ) {

        thongBao.textContent =
            'Chưa tìm thấy món phù hợp với nguyên liệu bạn đã nhập. '
            +
            'Bạn hãy thử nhập nguyên liệu khác hoặc điều chỉnh ngân sách, thời gian nấu.';

        return;
    }


    thongBao.textContent =
        `Tìm thấy ${danhSach.length} món ăn phù hợp với thông tin bạn đã nhập.`;


    danhSach.forEach(
        (monAn) => {

            const theMonAn =
                taoTheMonAn(
                    monAn,
                    nguyenLieu
                );

            khuVuc.appendChild(
                theMonAn
            );
        }
    );
};


/* =========================================================
   8. DANH SÁCH ĐI CHỢ
   ========================================================= */

/*
 * Hiển thị danh sách đi chợ.
 */
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
        khuVuc === null
        ||
        tenMon === null
        ||
        danhSachNguyenLieu === null
    ) {
        return;
    }


    const danhSach =
        docDanhSachDiCho();


    danhSachNguyenLieu.replaceChildren();


    if (
        danhSach.length === 0
    ) {

        khuVuc.hidden =
            true;

        return;
    }


    khuVuc.hidden =
        false;


    const monAnCuoi =
        danhSach[
            danhSach.length - 1
        ];


    tenMon.textContent =
        `Nguyên liệu cần mua cho ${
            monAnCuoi.ten || 'món ăn'
        }`;


    const tapNguyenLieu =
        new Set();


    danhSach.forEach(
        (monAn) => {

            if (
                Array.isArray(
                    monAn.nguyenLieuConThieu
                ) === false
            ) {
                return;
            }


            monAn.nguyenLieuConThieu.forEach(
                (nguyenLieu) => {

                    const giaTri =
                        String(
                            nguyenLieu || ''
                        ).trim();


                    if (
                        giaTri !== ''
                    ) {
                        tapNguyenLieu.add(
                            giaTri
                        );
                    }
                }
            );
        }
    );


    tapNguyenLieu.forEach(
        (nguyenLieu) => {

            const li =
                document.createElement(
                    'li'
                );

            li.textContent =
                nguyenLieu;

            danhSachNguyenLieu.appendChild(
                li
            );
        }
    );
};


/*
 * Thêm món vào danh sách đi chợ.
 */
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
            (item) => {

                return (
                    String(
                        item.id
                    )
                    ===
                    String(
                        monAn.id
                    )
                );
            }
        );


    if (
        !daCo
    ) {

        danhSach.push({

            id:
                monAn.id,

            ten:
                monAn.ten,

            nguyenLieuConThieu:
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
        khoaDanhSachDiCho
    );

    hienThiDanhSachDiCho();
};


/* =========================================================
   10. LOAD JSON
   ========================================================= */

/*
 * Trạng thái đang tải.
 */
const hienThiDangTaiDuLieu = () => {

    const thongBao =
        document.querySelector(
            '#thong-bao-goi-y'
        );


    if (
        thongBao === null
    ) {
        return;
    }


    thongBao.textContent =
        'Đang tải dữ liệu món ăn...';
};


/*
 * Trạng thái lỗi.
 */
const hienThiLoiTaiDuLieu = () => {

    const thongBao =
        document.querySelector(
            '#thong-bao-goi-y'
        );


    if (
        thongBao === null
    ) {
        return;
    }


    thongBao.replaceChildren();


    const noiDungLoi =
        document.createElement(
            'span'
        );

    noiDungLoi.textContent =
        'Không thể tải dữ liệu món ăn. Vui lòng thử lại.';


    const nutThuLai =
        document.createElement(
            'button'
        );

    nutThuLai.type =
        'button';

    nutThuLai.className =
        'nut nut-phu';

    nutThuLai.textContent =
        'Thử lại';


    nutThuLai.addEventListener(
        'click',
        async () => {

            await taiDanhSachMonAn();
        }
    );


    thongBao.appendChild(
        noiDungLoi
    );

    thongBao.appendChild(
        document.createTextNode(
            ' '
        )
    );

    thongBao.appendChild(
        nutThuLai
    );
};


/*
 * Tải danh sách món ăn từ JSON.
 */
const taiDanhSachMonAn = async () => {

    hienThiDangTaiDuLieu();


    try {

        const response =
            await fetch(
                duongDanDuLieuMonAn
            );


        if (
            response.ok === false
        ) {

            throw new Error(
                `Không thể tải dữ liệu món ăn: ${response.status}`
            );
        }


        const duLieu =
            await response.json();


        if (
            Array.isArray(
                duLieu
            ) === false
        ) {

            throw new Error(
                'Dữ liệu món ăn không đúng định dạng.'
            );
        }


        danhSachMonAn =
            duLieu;


        /*
         * Không có dữ liệu.
         */
        if (
            danhSachMonAn.length === 0
        ) {

            const thongBao =
                document.querySelector(
                    '#thong-bao-goi-y'
                );


            if (
                thongBao !== null
            ) {

                thongBao.textContent =
                    'Hiện chưa có dữ liệu món ăn để gợi ý.';
            }

            return false;
        }


        return true;

    } catch (error) {

        console.error(
            'Lỗi tải dữ liệu món ăn:',
            error
        );


        danhSachMonAn =
            [];


        hienThiLoiTaiDuLieu();


        return false;
    }
};


/* =========================================================
   11. XỬ LÝ FORM
   ========================================================= */

const xuLyFormGoiY = (
    event
) => {

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

    const thongBao =
        document.querySelector(
            '#thong-bao-goi-y'
        );


    if (
        oNguyenLieu === null
        ||
        oNganSach === null
        ||
        oThoiGian === null
        ||
        oSoNguoi === null
    ) {
        return;
    }


    const nguyenLieu =
        oNguyenLieu.value.trim();

    const nganSach =
        Number(
            oNganSach.value
        );

    const thoiGian =
        Number(
            oThoiGian.value
        );

    const soNguoi =
        Number(
            oSoNguoi.value
        );


    /*
     * Kiểm tra dữ liệu nhập.
     */
    if (
        nguyenLieu === ''
    ) {

        if (
            thongBao !== null
        ) {

            thongBao.textContent =
                'Vui lòng nhập ít nhất một nguyên liệu.';
        }

        oNguyenLieu.focus();

        return;
    }


    if (
        !Number.isFinite(
            nganSach
        )
        ||
        nganSach <= 0
    ) {

        if (
            thongBao !== null
        ) {

            thongBao.textContent =
                'Vui lòng nhập ngân sách lớn hơn 0.';
        }

        oNganSach.focus();

        return;
    }


    if (
        !Number.isFinite(
            thoiGian
        )
        ||
        thoiGian <= 0
    ) {

        if (
            thongBao !== null
        ) {

            thongBao.textContent =
                'Vui lòng nhập thời gian nấu lớn hơn 0.';
        }

        oThoiGian.focus();

        return;
    }


    if (
        !Number.isFinite(
            soNguoi
        )
        ||
        soNguoi <= 0
    ) {

        if (
            thongBao !== null
        ) {

            thongBao.textContent =
                'Vui lòng nhập số người lớn hơn 0.';
        }

        oSoNguoi.focus();

        return;
    }


    if (
        danhSachMonAn.length === 0
    ) {

        if (
            thongBao !== null
        ) {

            thongBao.textContent =
                'Chưa có dữ liệu món ăn để gợi ý.';
        }

        return;
    }


    const nguyenLieuNguoiDung =
        tachNguyenLieuNguoiDung(
            nguyenLieu
        );


    const danhSach =
        timMonPhuHop(
            nguyenLieu,
            nganSach,
            thoiGian,
            soNguoi
        );


    hienThiKetQua(
        danhSach,
        nguyenLieuNguoiDung
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


    if (
        khuVuc !== null
    ) {
        khuVuc.replaceChildren();
    }


    if (
        thongBao !== null
    ) {

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


    /*
     * Form gợi ý.
     */
    if (
        form !== null
    ) {

        form.addEventListener(
            'submit',
            xuLyFormGoiY
        );
    }


    /*
     * Nút nhập lại.
     */
    if (
        nutNhapLai !== null
    ) {

        nutNhapLai.addEventListener(
            'click',
            xuLyNhapLai
        );
    }


    /*
     * Nút xóa danh sách đi chợ.
     */
    if (
        nutXoa !== null
    ) {

        nutXoa.addEventListener(
            'click',
            xoaDanhSachDiCho
        );
    }


    /*
     * Tải dữ liệu món ăn.
     */
    await taiDanhSachMonAn();


    /*
     * Khôi phục danh sách đi chợ
     * sau khi tải trang.
     */
    hienThiDanhSachDiCho();
};


khoiTaoTrangGoiY();