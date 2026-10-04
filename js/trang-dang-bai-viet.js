/*
 * trang-dang-bai-viet.js
 * Xử lý trang đăng bài viết trực tiếp của người dùng.
 *
 * Chức năng:
 * - Kiểm tra người dùng đã đăng nhập.
 * - Đăng bài viết mới.
 * - Chỉnh sửa bài viết của chính người dùng.
 * - Chọn nhiều hình ảnh.
 * - Xem trước hình ảnh.
 * - Hiển thị ảnh cũ khi chỉnh sửa.
 * - Kiểm tra dữ liệu trước khi lưu.
 * - Lưu dữ liệu thông qua bai-viet.js.
 */

import {
    themBaiViet,
    capNhatBaiViet,
    docBaiViet,
    chuyenHinhAnhThanhDataUrl
} from './bai-viet.js';

import {
    docNguoiDungHienTai
} from './tai-khoan.js';


/* =========================================================
   1. LẤY CÁC PHẦN TỬ HTML
   ========================================================= */

const formDangBai =
    document.querySelector(
        '.form-dang-bai-viet'
    );

const oChonHinhAnh =
    document.querySelector(
        '#hinh-anh'
    );

const khuVucXemTruoc =
    document.querySelector(
        '.xem-truoc-hinh-anh'
    );

const moTaBaiViet =
    document.querySelector(
        '#mo-ta-bai-viet'
    );

const tenMon =
    document.querySelector(
        '#ten-mon'
    );

const danhMuc =
    document.querySelector(
        '#danh-muc'
    );

const thoiGianNau =
    document.querySelector(
        '#thoi-gian-nau'
    );

const soNguoiAn =
    document.querySelector(
        '#so-nguoi-an'
    );

const nganSach =
    document.querySelector(
        '#ngan-sach'
    );

const nguyenLieu =
    document.querySelector(
        '#nguyen-lieu'
    );

const cachLam =
    document.querySelector(
        '#cach-lam'
    );

const nutDangBai =
    document.querySelector(
        '.nut-dang-bai'
    );


/* =========================================================
   2. XÁC ĐỊNH CHẾ ĐỘ THÊM / SỬA
   ========================================================= */

const thamSo =
    new URLSearchParams(
        window.location.search
    );

const idBaiViet =
    thamSo.get(
        'id'
    );

const cheDo =
    thamSo.get(
        'cheDo'
    );

const dangSua =
    cheDo === 'sua';


/* =========================================================
   3. NGƯỜI DÙNG HIỆN TẠI
   ========================================================= */

const nguoiDungHienTai =
    docNguoiDungHienTai();


/* =========================================================
   4. CHUYỂN VỀ TRANG ĐĂNG NHẬP NẾU CHƯA ĐĂNG NHẬP
   ========================================================= */

if (
    nguoiDungHienTai === null
) {

    window.alert(
        'Vui lòng đăng nhập để sử dụng chức năng này.'
    );

    window.location.href =
        'dang-nhap.php';
}


/* =========================================================
   5. DANH SÁCH HÌNH ẢNH
   ========================================================= */

/*
 * Ảnh người dùng vừa chọn từ thiết bị.
 */
let danhSachHinhAnh = [];


/*
 * Ảnh đã lưu trước đó trong bài viết.
 *
 * Có thể là Data URL hoặc chuỗi đường dẫn ảnh.
 */
let danhSachHinhAnhCu = [];


/* =========================================================
   6. HÀM HIỂN THỊ LỖI
   ========================================================= */

const hienThiLoi = (
    phanTu,
    noiDung
) => {

    if (
        phanTu === null
    ) {
        return;
    }

    phanTu.classList.add(
        'truong-co-loi'
    );

    let thongBaoLoi =
        phanTu.parentElement
            ?.querySelector(
                '.thong-bao-loi-truong'
            );

    if (
        thongBaoLoi === null
        ||
        thongBaoLoi === undefined
    ) {

        thongBaoLoi =
            document.createElement(
                'p'
            );

        thongBaoLoi.className =
            'thong-bao-loi-truong';

        thongBaoLoi.setAttribute(
            'role',
            'alert'
        );

        phanTu.parentElement?.appendChild(
            thongBaoLoi
        );
    }

    if (
        thongBaoLoi !== null
        &&
        thongBaoLoi !== undefined
    ) {

        thongBaoLoi.textContent =
            noiDung;
    }
};


/* =========================================================
   7. XÓA LỖI
   ========================================================= */

const xoaLoi = (
    phanTu
) => {

    if (
        phanTu === null
    ) {
        return;
    }

    phanTu.classList.remove(
        'truong-co-loi'
    );

    const thongBaoLoi =
        phanTu.parentElement
            ?.querySelector(
                '.thong-bao-loi-truong'
            );

    if (
        thongBaoLoi !== null
        &&
        thongBaoLoi !== undefined
    ) {

        thongBaoLoi.remove();
    }
};


/* =========================================================
   8. LẤY BÀI VIẾT CẦN SỬA
   ========================================================= */

const layBaiVietCanSua = () => {

    if (
        dangSua === false
        ||
        idBaiViet === null
    ) {
        return null;
    }

    const danhSachBaiViet =
        docBaiViet();

    return (
        danhSachBaiViet.find(
            (baiViet) => {

                if (
                    baiViet === null
                    ||
                    typeof baiViet !== 'object'
                ) {
                    return false;
                }

                return (
                    String(
                        baiViet.id
                    )
                    ===
                    String(
                        idBaiViet
                    )
                );
            }
        )
        ||
        null
    );
};

const baiVietCanSua =
    layBaiVietCanSua();


/* =========================================================
   9. KIỂM TRA QUYỀN SỬA
   ========================================================= */

if (
    nguoiDungHienTai !== null
    &&
    dangSua
    &&
    (
        baiVietCanSua === null
        ||
        String(
            baiVietCanSua.userId
        )
        !==
        String(
            nguoiDungHienTai.id
        )
    )
) {

    window.alert(
        'Bạn không có quyền sửa bài viết này.'
    );

    window.location.href =
        'ca-nhan.php';
}


/* =========================================================
   10. CẬP NHẬT THÔNG TIN NGƯỜI ĐĂNG
   ========================================================= */

const capNhatThongTinNguoiDang = () => {

    if (
        nguoiDungHienTai === null
    ) {
        return;
    }

    const phanTuTen =
        document.querySelector(
            '.nguoi-dang-bai strong'
        );

    const phanTuAvatar =
        document.querySelector(
            '.anh-dai-dien span'
        );

    const tenNguoiDung =
        String(
            nguoiDungHienTai.hoTen
            ||
            nguoiDungHienTai.ten
            ||
            nguoiDungHienTai.email
            ||
            'Người dùng'
        ).trim();

    if (
        phanTuTen !== null
    ) {

        phanTuTen.textContent =
            tenNguoiDung;
    }

    if (
        phanTuAvatar !== null
    ) {

        phanTuAvatar.textContent =
            tenNguoiDung
                .charAt(0)
                .toUpperCase();
    }
};


/* =========================================================
   11. THIẾT LẬP CHẾ ĐỘ SỬA
   ========================================================= */

const thietLapCheDoSua = () => {

    if (
        dangSua === false
    ) {
        return;
    }

    const tieuDe =
        document.querySelector(
            '.nguoi-dang-bai strong'
        );

    /*
     * Không thay tên người dùng.
     * Tên người dùng vẫn được hiển thị ở phần thông tin.
     */

    const tieuDeTrang =
        document.querySelector(
            'main h1'
        );

    if (
        tieuDeTrang !== null
    ) {

        tieuDeTrang.textContent =
            'Chỉnh sửa bài viết';
    }

    document.title =
        'Chỉnh sửa bài viết | Cook with me';

    if (
        nutDangBai !== null
    ) {

        nutDangBai.textContent =
            'Lưu thay đổi';
    }

    /*
     * Dòng phụ bên dưới tên người dùng.
     */
    const moTaNguoiDang =
        document.querySelector(
            '.thong-tin-nguoi-dang span'
        );

    if (
        moTaNguoiDang !== null
    ) {

        moTaNguoiDang.textContent =
            'Đang chỉnh sửa công thức';
    }
};


/* =========================================================
   12. KIỂM TRA MÔ TẢ
   ========================================================= */

const kiemTraMoTa = () => {

    if (
        moTaBaiViet === null
    ) {
        return false;
    }

    const noiDung =
        moTaBaiViet.value.trim();

    if (
        noiDung === ''
    ) {

        hienThiLoi(
            moTaBaiViet,
            'Vui lòng nhập nội dung chia sẻ.'
        );

        return false;
    }

    if (
        noiDung.length < 10
    ) {

        hienThiLoi(
            moTaBaiViet,
            'Nội dung chia sẻ phải có ít nhất 10 ký tự.'
        );

        return false;
    }

    xoaLoi(
        moTaBaiViet
    );

    return true;
};


/* =========================================================
   13. KIỂM TRA TÊN MÓN
   ========================================================= */

const kiemTraTenMon = () => {

    if (
        tenMon === null
    ) {
        return false;
    }

    const giaTri =
        tenMon.value.trim();

    if (
        giaTri === ''
    ) {

        hienThiLoi(
            tenMon,
            'Vui lòng nhập tên món ăn.'
        );

        return false;
    }

    if (
        giaTri.length < 2
    ) {

        hienThiLoi(
            tenMon,
            'Tên món ăn phải có ít nhất 2 ký tự.'
        );

        return false;
    }

    xoaLoi(
        tenMon
    );

    return true;
};


/* =========================================================
   14. KIỂM TRA DANH MỤC
   ========================================================= */

const kiemTraDanhMuc = () => {

    if (
        danhMuc === null
    ) {
        return false;
    }

    if (
        danhMuc.value === ''
    ) {

        hienThiLoi(
            danhMuc,
            'Vui lòng chọn danh mục món ăn.'
        );

        return false;
    }

    xoaLoi(
        danhMuc
    );

    return true;
};


/* =========================================================
   15. KIỂM TRA THỜI GIAN NẤU
   ========================================================= */

const kiemTraThoiGianNau = () => {

    if (
        thoiGianNau === null
    ) {
        return false;
    }

    const giaTri =
        Number(
            thoiGianNau.value
        );

    if (
        thoiGianNau.value === ''
        ||
        Number.isNaN(giaTri)
        ||
        giaTri < 1
        ||
        giaTri > 300
    ) {

        hienThiLoi(
            thoiGianNau,
            'Thời gian nấu phải từ 1 đến 300 phút.'
        );

        return false;
    }

    xoaLoi(
        thoiGianNau
    );

    return true;
};


/* =========================================================
   16. KIỂM TRA KHẨU PHẦN
   ========================================================= */

const kiemTraSoNguoiAn = () => {

    if (
        soNguoiAn === null
    ) {
        return false;
    }

    const giaTri =
        Number(
            soNguoiAn.value
        );

    if (
        soNguoiAn.value === ''
        ||
        Number.isNaN(giaTri)
        ||
        giaTri < 1
        ||
        giaTri > 20
    ) {

        hienThiLoi(
            soNguoiAn,
            'Khẩu phần phải từ 1 đến 20 người.'
        );

        return false;
    }

    xoaLoi(
        soNguoiAn
    );

    return true;
};


/* =========================================================
   17. KIỂM TRA NGÂN SÁCH
   ========================================================= */

const kiemTraNganSach = () => {

    if (
        nganSach === null
    ) {
        return false;
    }

    const giaTri =
        Number(
            nganSach.value
        );

    if (
        nganSach.value === ''
        ||
        Number.isNaN(giaTri)
        ||
        giaTri < 0
    ) {

        hienThiLoi(
            nganSach,
            'Vui lòng nhập ngân sách hợp lệ.'
        );

        return false;
    }

    xoaLoi(
        nganSach
    );

    return true;
};


/* =========================================================
   18. KIỂM TRA NGUYÊN LIỆU
   ========================================================= */

const kiemTraNguyenLieu = () => {

    if (
        nguyenLieu === null
    ) {
        return false;
    }

    const noiDung =
        nguyenLieu.value.trim();

    if (
        noiDung === ''
    ) {

        hienThiLoi(
            nguyenLieu,
            'Vui lòng nhập danh sách nguyên liệu.'
        );

        return false;
    }

    if (
        noiDung.length < 10
    ) {

        hienThiLoi(
            nguyenLieu,
            'Danh sách nguyên liệu quá ngắn.'
        );

        return false;
    }

    xoaLoi(
        nguyenLieu
    );

    return true;
};


/* =========================================================
   19. KIỂM TRA CÁCH LÀM
   ========================================================= */

const kiemTraCachLam = () => {

    if (
        cachLam === null
    ) {
        return false;
    }

    const noiDung =
        cachLam.value.trim();

    if (
        noiDung === ''
    ) {

        hienThiLoi(
            cachLam,
            'Vui lòng nhập các bước chế biến.'
        );

        return false;
    }

    if (
        noiDung.length < 10
    ) {

        hienThiLoi(
            cachLam,
            'Cách chế biến quá ngắn.'
        );

        return false;
    }

    xoaLoi(
        cachLam
    );

    return true;
};


/* =========================================================
   20. KIỂM TRA HÌNH ẢNH
   ========================================================= */

const kiemTraHinhAnh = () => {

    /*
     * Khi đăng bài mới:
     * phải có ít nhất một ảnh.
     *
     * Khi sửa:
     * - không chọn ảnh mới -> giữ ảnh cũ;
     * - chọn ảnh mới -> dùng ảnh mới.
     */

    if (
        dangSua
        &&
        danhSachHinhAnh.length === 0
        &&
        danhSachHinhAnhCu.length > 0
    ) {

        if (
            khuVucXemTruoc !== null
        ) {

            khuVucXemTruoc.classList.remove(
                'khu-vuc-co-loi'
            );
        }

        return true;
    }

    if (
        danhSachHinhAnh.length === 0
    ) {

        if (
            khuVucXemTruoc !== null
        ) {

            khuVucXemTruoc.classList.add(
                'khu-vuc-co-loi'
            );

            hienThiLoiHinhAnh();
        }

        return false;
    }

    if (
        khuVucXemTruoc !== null
    ) {

        khuVucXemTruoc.classList.remove(
            'khu-vuc-co-loi'
        );
    }

    return true;
};


/* =========================================================
   21. HIỂN THỊ LỖI HÌNH ẢNH
   ========================================================= */

const hienThiLoiHinhAnh = () => {

    if (
        khuVucXemTruoc === null
    ) {
        return;
    }

    khuVucXemTruoc.replaceChildren();

    const thongBao =
        document.createElement(
            'p'
        );

    thongBao.className =
        'thong-bao-loi-truong';

    thongBao.setAttribute(
        'role',
        'alert'
    );

    thongBao.textContent =
        'Vui lòng thêm ít nhất một hình ảnh món ăn.';

    khuVucXemTruoc.appendChild(
        thongBao
    );
};


/* =========================================================
   22. TẠO KHUNG XEM TRƯỚC ẢNH
   ========================================================= */

const taoKhungHinhAnh = (
    src,
    chiSo,
    laAnhCu = false
) => {

    if (
        khuVucXemTruoc === null
    ) {
        return;
    }

    const khungHinhAnh =
        document.createElement(
            'div'
        );

    khungHinhAnh.className =
        'khung-hinh-anh-xem-truoc';


    const hinhAnh =
        document.createElement(
            'img'
        );

    hinhAnh.src =
        String(
            src
        );

    hinhAnh.alt =
        laAnhCu
            ? `Hình ảnh món ăn hiện tại ${chiSo + 1}`
            : `Hình ảnh món ăn mới ${chiSo + 1}`;


    khungHinhAnh.appendChild(
        hinhAnh
    );


    if (
        laAnhCu === false
    ) {

        const nutXoa =
            document.createElement(
                'button'
            );

        nutXoa.type =
            'button';

        nutXoa.className =
            'nut-xoa-hinh-anh';

        nutXoa.textContent =
            '×';

        nutXoa.setAttribute(
            'aria-label',
            `Xóa hình ảnh ${chiSo + 1}`
        );

        nutXoa.addEventListener(
            'click',
            () => {

                danhSachHinhAnh =
                    danhSachHinhAnh.filter(
                        (
                            tepHinhAnh,
                            viTri
                        ) => {

                            return (
                                viTri !==
                                chiSo
                            );
                        }
                    );

                hienThiHinhAnhMoi();
            }
        );

        khungHinhAnh.appendChild(
            nutXoa
        );
    }

    khuVucXemTruoc.appendChild(
        khungHinhAnh
    );
};


/* =========================================================
   23. HIỂN THỊ ẢNH CŨ
   ========================================================= */

const hienThiHinhAnhCu = () => {

    if (
        khuVucXemTruoc === null
    ) {
        return;
    }

    danhSachHinhAnhCu.forEach(
        (
            src,
            chiSo
        ) => {

            if (
                typeof src !== 'string'
                ||
                src.trim() === ''
            ) {
                return;
            }

            taoKhungHinhAnh(
                src,
                chiSo,
                true
            );
        }
    );
};


/* =========================================================
   24. HIỂN THỊ ẢNH MỚI
   ========================================================= */

const hienThiHinhAnhMoi = () => {

    if (
        khuVucXemTruoc === null
    ) {
        return;
    }

    /*
     * Khi đang sửa và có ảnh mới,
     * ảnh cũ không được hiển thị nữa
     * vì ảnh mới sẽ thay thế ảnh cũ.
     */
    khuVucXemTruoc.replaceChildren();

    if (
        danhSachHinhAnh.length === 0
    ) {

        if (
            dangSua
            &&
            danhSachHinhAnhCu.length > 0
        ) {

            hienThiHinhAnhCu();
        }

        return;
    }

    danhSachHinhAnh.forEach(
        (
            tepHinhAnh,
            chiSo
        ) => {

            const boDocFile =
                new FileReader();

            boDocFile.addEventListener(
                'load',
                () => {

                    if (
                        typeof boDocFile.result
                        !==
                        'string'
                    ) {
                        return;
                    }

                    taoKhungHinhAnh(
                        boDocFile.result,
                        chiSo,
                        false
                    );
                }
            );

            boDocFile.readAsDataURL(
                tepHinhAnh
            );
        }
    );
};


/* =========================================================
   25. XỬ LÝ CHỌN HÌNH ẢNH
   ========================================================= */

const xuLyChonHinhAnh = () => {

    if (
        oChonHinhAnh === null
    ) {
        return;
    }

    const danhSachTepMoi =
        Array.from(
            oChonHinhAnh.files
        );

    let soTepBiTuChoi = 0;

    danhSachTepMoi.forEach(
        (
            tepHinhAnh
        ) => {

            if (
                tepHinhAnh.type.startsWith(
                    'image/'
                ) === false
            ) {

                soTepBiTuChoi += 1;

                return;
            }

            /*
             * Giới hạn kích thước mỗi ảnh 5 MB.
             */
            if (
                tepHinhAnh.size
                >
                5 * 1024 * 1024
            ) {

                soTepBiTuChoi += 1;

                return;
            }

            const daTonTai =
                danhSachHinhAnh.some(
                    (
                        tepDaChon
                    ) => {

                        return (
                            tepDaChon.name
                            ===
                            tepHinhAnh.name
                            &&
                            tepDaChon.size
                            ===
                            tepHinhAnh.size
                        );
                    }
                );

            if (
                daTonTai
            ) {

                soTepBiTuChoi += 1;

                return;
            }

            if (
                danhSachHinhAnh.length
                >=
                10
            ) {

                soTepBiTuChoi += 1;

                return;
            }

            danhSachHinhAnh.push(
                tepHinhAnh
            );
        }
    );

    hienThiHinhAnhMoi();

    oChonHinhAnh.value = '';

    if (
        soTepBiTuChoi > 0
    ) {

        hienThiThongBao(
            `Có ${soTepBiTuChoi} hình ảnh không được thêm. ` +
            'Chỉ chấp nhận ảnh hợp lệ, tối đa 10 ảnh và 5 MB mỗi ảnh.',
            true
        );
    }
};


/* =========================================================
   26. KIỂM TRA TOÀN BỘ FORM
   ========================================================= */

const kiemTraBieuMau = () => {

    const ketQua = [
        kiemTraMoTa(),
        kiemTraHinhAnh(),
        kiemTraTenMon(),
        kiemTraDanhMuc(),
        kiemTraThoiGianNau(),
        kiemTraSoNguoiAn(),
        kiemTraNganSach(),
        kiemTraNguyenLieu(),
        kiemTraCachLam()
    ];

    return ketQua.every(
        (hopLe) => hopLe
    );
};


/* =========================================================
   27. ĐIỀN DỮ LIỆU KHI SỬA
   ========================================================= */

const dienDuLieuBaiViet = (
    baiViet
) => {

    if (
        baiViet === null
    ) {
        return;
    }

    if (
        moTaBaiViet !== null
    ) {

        moTaBaiViet.value =
            baiViet.moTa || '';
    }

    if (
        tenMon !== null
    ) {

        tenMon.value =
            baiViet.tenMon || '';
    }

    if (
        danhMuc !== null
    ) {

        danhMuc.value =
            baiViet.danhMuc || '';
    }

    if (
        thoiGianNau !== null
    ) {

        thoiGianNau.value =
            baiViet.thoiGianNau ?? '';
    }

    if (
        soNguoiAn !== null
    ) {

        soNguoiAn.value =
            baiViet.soNguoiAn ?? '';
    }

    if (
        nganSach !== null
    ) {

        nganSach.value =
            baiViet.nganSach ?? '';
    }

    if (
        nguyenLieu !== null
    ) {

        nguyenLieu.value =
            baiViet.nguyenLieu || '';
    }

    if (
        cachLam !== null
    ) {

        cachLam.value =
            baiViet.cachLam || '';
    }

    /*
     * Lưu ảnh cũ.
     */
    if (
        Array.isArray(
            baiViet.hinhAnh
        )
    ) {

        danhSachHinhAnhCu =
            baiViet.hinhAnh.filter(
                (src) => {

                    return (
                        typeof src === 'string'
                        &&
                        src.trim() !== ''
                    );
                }
            );
    }

    /*
     * Hiển thị ảnh cũ ngay khi mở trang sửa.
     */
    if (
        dangSua
        &&
        danhSachHinhAnhCu.length > 0
    ) {

        hienThiHinhAnhCu();
    }
};


/* =========================================================
   28. TẠO DỮ LIỆU BÀI VIẾT
   ========================================================= */

const taoDuLieuBaiViet = () => {

    return {

        moTa:
            moTaBaiViet?.value.trim() || '',

        tenMon:
            tenMon?.value.trim() || '',

        danhMuc:
            danhMuc?.value || '',

        thoiGianNau:
            Number(
                thoiGianNau?.value
            ),

        soNguoiAn:
            Number(
                soNguoiAn?.value
            ),

        nganSach:
            Number(
                nganSach?.value
            ),

        nguyenLieu:
            nguyenLieu?.value.trim() || '',

        cachLam:
            cachLam?.value.trim() || ''
    };
};


/* =========================================================
   29. HIỂN THỊ THÔNG BÁO
   ========================================================= */

const hienThiThongBao = (
    noiDung,
    laLoi = false
) => {

    if (
        formDangBai === null
    ) {
        return;
    }

    let thongBao =
        formDangBai.querySelector(
            '.thong-bao-dang-bai'
        );

    if (
        thongBao === null
    ) {

        thongBao =
            document.createElement(
                'p'
            );

        thongBao.className =
            'thong-bao-dang-bai';

        thongBao.setAttribute(
            'aria-live',
            'polite'
        );

        formDangBai.prepend(
            thongBao
        );
    }

    thongBao.textContent =
        noiDung;

    thongBao.classList.toggle(
        'thong-bao-dang-bai-loi',
        laLoi
    );
};


/* =========================================================
   30. XỬ LÝ GỬI FORM
   ========================================================= */

if (
    formDangBai !== null
    &&
    nguoiDungHienTai !== null
) {

    formDangBai.addEventListener(
        'submit',
        async (event) => {

            event.preventDefault();

            const hopLe =
                kiemTraBieuMau();

            if (
                hopLe === false
            ) {

                hienThiThongBao(
                    'Vui lòng kiểm tra lại các trường thông tin.',
                    true
                );

                return;
            }

            if (
                nutDangBai !== null
            ) {

                nutDangBai.disabled =
                    true;

                nutDangBai.textContent =
                    dangSua
                        ? 'Đang lưu...'
                        : 'Đang đăng...';
            }

            try {

                const duLieuBaiViet =
                    taoDuLieuBaiViet();


                /* =========================================
                   CHẾ ĐỘ SỬA
                   ========================================= */

                if (
                    dangSua
                ) {

                    let hinhAnhCapNhat =
                        danhSachHinhAnhCu;

                    /*
                     * Nếu người dùng chọn ảnh mới,
                     * ảnh mới thay thế ảnh cũ.
                     */
                    if (
                        danhSachHinhAnh.length > 0
                    ) {

                        hinhAnhCapNhat =
                            await chuyenHinhAnhThanhDataUrl(
                                danhSachHinhAnh
                            );
                    }

                    const duLieuCapNhat = {

                        ...duLieuBaiViet,

                        hinhAnh:
                            hinhAnhCapNhat,

                        soLuongHinhAnh:
                            hinhAnhCapNhat.length,

                        ngayCapNhat:
                            new Date().toISOString()
                    };

                    const thanhCong =
                        capNhatBaiViet(
                            idBaiViet,
                            nguoiDungHienTai.id,
                            duLieuCapNhat
                        );

                    if (
                        thanhCong === false
                    ) {

                        throw new Error(
                            'Không thể cập nhật bài viết.'
                        );
                    }

                    window.alert(
                        'Đã cập nhật bài viết.'
                    );

                    window.location.href =
                        'ca-nhan.php';

                    return;
                }


                /* =========================================
                   CHẾ ĐỘ ĐĂNG BÀI MỚI
                   ========================================= */

                const danhSachDataUrl =
                    await chuyenHinhAnhThanhDataUrl(
                        danhSachHinhAnh
                    );

                const baiVietMoi = {

                    id:
                        `bai-viet-${Date.now()}`,

                    userId:
                        nguoiDungHienTai.id,

                    ...duLieuBaiViet,

                    hinhAnh:
                        danhSachDataUrl,

                    soLuongHinhAnh:
                        danhSachDataUrl.length,

                    ngayDang:
                        new Date().toISOString()
                };

                const baiVietDaThem =
                    themBaiViet(
                        baiVietMoi
                    );

                if (
                    baiVietDaThem === null
                ) {

                    throw new Error(
                        'Không thể lưu bài viết.'
                    );
                }

                window.alert(
                    'Đăng bài viết thành công.'
                );

                window.location.href =
                    'ca-nhan.php';

            } catch (error) {

                console.error(
                    'Lỗi xử lý bài viết:',
                    error
                );

                hienThiThongBao(
                    dangSua
                        ? 'Không thể cập nhật bài viết. Vui lòng thử lại.'
                        : 'Không thể đăng bài viết. Vui lòng thử lại.',
                    true
                );

            } finally {

                if (
                    nutDangBai !== null
                ) {

                    nutDangBai.disabled =
                        false;

                    nutDangBai.textContent =
                        dangSua
                            ? 'Lưu thay đổi'
                            : 'Đăng bài viết';
                }
            }
        }
    );
}


/* =========================================================
   31. KHỞI TẠO TRANG
   ========================================================= */

if (
    nguoiDungHienTai !== null
) {

    capNhatThongTinNguoiDang();

    if (
        dangSua
        &&
        baiVietCanSua !== null
    ) {

        thietLapCheDoSua();

        dienDuLieuBaiViet(
            baiVietCanSua
        );

    } else {

        document.title =
            'Đăng bài viết | Cook with me';
    }
}