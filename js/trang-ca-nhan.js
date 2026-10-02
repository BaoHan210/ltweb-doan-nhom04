/*
 * trang-ca-nhan.js
 * Hiển thị thông tin tài khoản, bài viết của người dùng
 * và danh sách món ăn đã lưu trên trang cá nhân.
 */

import {
    docNguoiDungHienTai
} from './tai-khoan.js';

import {
    docBaiViet,
    xoaBaiViet
} from './bai-viet.js';

import {
    docYeuThich
} from './yeu-thich.js';

import {
    taiJSON
} from './api.js';


/* =========================================================
   1. LẤY CÁC PHẦN TỬ HTML
   ========================================================= */

const tenNguoiDung =
    document.querySelector(
        '.ten-nguoi-dung'
    );

const emailNguoiDung =
    document.querySelector(
        '.email-nguoi-dung'
    );

const chuCaiDaiDien =
    document.querySelector(
        '.chu-cai-dai-dien'
    );

const danhSachBaiViet =
    document.querySelector(
        '.danh-sach-bai-viet-cua-toi'
    );

const khuVucCongThuc =
    document.querySelector(
        '.khu-vuc-cong-thuc-ca-nhan'
    );

const khuVucMonDaLuu =
    document.querySelector(
        '.khu-vuc-mon-da-luu'
    );

const cacTab =
    document.querySelectorAll(
        '.tab-ca-nhan'
    );


/* =========================================================
   2. HIỂN THỊ THÔNG TIN NGƯỜI DÙNG
   ========================================================= */

const hienThiThongTinNguoiDung = (
    nguoiDung
) => {

    if (
        nguoiDung === null
        ||
        typeof nguoiDung !== 'object'
    ) {
        return;
    }

    const hoTen =
        String(
            nguoiDung.hoTen || ''
        ).trim();

    if (
        tenNguoiDung !== null
    ) {
        tenNguoiDung.textContent =
            hoTen || 'Người dùng';
    }

    if (
        emailNguoiDung !== null
    ) {
        emailNguoiDung.textContent =
            String(
                nguoiDung.email || ''
            );
    }

    if (
        chuCaiDaiDien !== null
    ) {

        chuCaiDaiDien.textContent =
            hoTen === ''
                ? '?'
                : hoTen
                    .charAt(0)
                    .toUpperCase();
    }
};


/* =========================================================
   3. TẠO THẺ BÀI VIẾT
   ========================================================= */

const taoTheBaiVietNguoiDung = (
    baiViet
) => {

    const baiVietItem =
        document.createElement(
            'article'
        );

    baiVietItem.className =
        'the-bai-viet-cua-toi';


    /* Hình ảnh */

    if (
        Array.isArray(
            baiViet.hinhAnh
        )
        &&
        baiViet.hinhAnh.length > 0
    ) {

        const khuVucHinhAnh =
            document.createElement(
                'div'
            );

        khuVucHinhAnh.className =
            'anh-bai-viet';


        const hinhAnh =
            document.createElement(
                'img'
            );

        hinhAnh.src =
            String(
                baiViet.hinhAnh[0]
            );

        hinhAnh.alt =
            String(
                baiViet.tenMon
                ||
                'Hình ảnh món ăn'
            );

        khuVucHinhAnh.appendChild(
            hinhAnh
        );

        baiVietItem.appendChild(
            khuVucHinhAnh
        );
    }


    /* Nội dung */

    const noiDung =
        document.createElement(
            'div'
        );

    noiDung.className =
        'noi-dung-the-bai-viet';


    const tieuDe =
        document.createElement(
            'h3'
        );

    tieuDe.textContent =
        String(
            baiViet.tenMon
            ||
            'Bài viết món ăn'
        );


    const moTa =
        document.createElement(
            'p'
        );

    moTa.className =
        'mo-ta-bai-viet';

    moTa.textContent =
        String(
            baiViet.moTa || ''
        );


    const thongTin =
        document.createElement(
            'p'
        );

    thongTin.className =
        'thong-tin-bai-viet';

    thongTin.textContent =
        `${baiViet.thoiGianNau || 0} phút · `
        +
        `${baiViet.soNguoiAn || 0} người`;


    /* Khu vực thao tác */

    const khuVucThaoTac =
        document.createElement(
            'div'
        );

    khuVucThaoTac.className =
        'khu-vuc-thao-tac-bai-viet';


    /* Nút xem */

    const nutXem =
        document.createElement(
            'a'
        );

    nutXem.href =
        `chi-tiet.html?id=${encodeURIComponent(
            baiViet.id
        )}`;

    nutXem.className =
        'nut-xem-bai-viet';

    nutXem.textContent =
        'Xem bài viết';


    /* Nút sửa */

    const nutSua =
        document.createElement(
            'a'
        );

    nutSua.href =
        `dang-bai-viet.html?id=${encodeURIComponent(
            baiViet.id
        )}&cheDo=sua`;

    nutSua.className =
        'nut-sua-bai-viet';

    nutSua.textContent =
        'Sửa';


    /* Nút xóa */

    const nutXoa =
        document.createElement(
            'button'
        );

    nutXoa.type =
        'button';

    nutXoa.className =
        'nut-xoa-bai-viet';

    nutXoa.textContent =
        'Xóa';

    nutXoa.setAttribute(
        'aria-label',
        `Xóa bài viết ${
            String(
                baiViet.tenMon || ''
            )
        }`
    );


    nutXoa.addEventListener(
        'click',
        () => {

            const xacNhan =
                window.confirm(
                    'Bạn có chắc muốn xóa bài viết này không?'
                );

            if (
                xacNhan === false
            ) {
                return;
            }


            const daXoa =
                xoaBaiViet(
                    baiViet.id
                );


            if (
                daXoa === false
            ) {

                window.alert(
                    'Không thể xóa bài viết.'
                );

                return;
            }


            hienThiBaiVietCuaToi(
                docNguoiDungHienTai()
            );
        }
    );


    khuVucThaoTac.appendChild(
        nutXem
    );

    khuVucThaoTac.appendChild(
        nutSua
    );

    khuVucThaoTac.appendChild(
        nutXoa
    );


    noiDung.appendChild(
        tieuDe
    );

    noiDung.appendChild(
        moTa
    );

    noiDung.appendChild(
        thongTin
    );

    noiDung.appendChild(
        khuVucThaoTac
    );


    baiVietItem.appendChild(
        noiDung
    );


    return baiVietItem;
};


/* =========================================================
   4. HIỂN THỊ BÀI VIẾT CỦA TÔI
   ========================================================= */

const hienThiBaiVietCuaToi = (
    nguoiDung
) => {

    if (
        danhSachBaiViet === null
        ||
        nguoiDung === null
    ) {
        return;
    }


    danhSachBaiViet.replaceChildren();


    const tatCaBaiViet =
        docBaiViet();


    const baiVietCuaToi =
        tatCaBaiViet.filter(
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
                        baiViet.userId
                    )
                    ===
                    String(
                        nguoiDung.id
                    )
                );
            }
        );


    const soBaiDang =
        document.querySelector(
            '.so-bai-dang'
        );


    if (
        soBaiDang !== null
    ) {

        soBaiDang.textContent =
            String(
                baiVietCuaToi.length
            );
    }


    if (
        baiVietCuaToi.length === 0
    ) {

        const thongBao =
            document.createElement(
                'p'
            );

        thongBao.className =
            'thong-bao-chua-co-bai-viet';

        thongBao.setAttribute(
            'aria-live',
            'polite'
        );

        thongBao.textContent =
            'Bạn chưa có bài viết nào.';


        danhSachBaiViet.appendChild(
            thongBao
        );

        return;
    }


    baiVietCuaToi.forEach(
        (baiViet) => {

            const baiVietItem =
                taoTheBaiVietNguoiDung(
                    baiViet
                );

            danhSachBaiViet.appendChild(
                baiVietItem
            );
        }
    );
};


/* =========================================================
   5. TẠO THẺ MÓN ĂN ĐÃ LƯU
   ========================================================= */

const taoTheMonDaLuu = (
    monAn
) => {

    const monAnItem =
        document.createElement(
            'article'
        );

    monAnItem.className =
        'the-bai-viet-cua-toi';


    const hinhAnh =
        document.createElement(
            'img'
        );

    hinhAnh.className =
        'anh-bai-viet';

    hinhAnh.src =
        String(
            monAn.hinhAnh || ''
        );

    hinhAnh.alt =
        String(
            monAn.ten || 'Món ăn'
        );


    const noiDung =
        document.createElement(
            'div'
        );

    noiDung.className =
        'noi-dung-the-bai-viet';


    const tieuDe =
        document.createElement(
            'h3'
        );

    tieuDe.textContent =
        String(
            monAn.ten || 'Món ăn'
        );


    const thongTin =
        document.createElement(
            'p'
        );

    thongTin.className =
        'thong-tin-bai-viet';

    thongTin.textContent =
        `${monAn.thoiGian || 0} phút · `
        +
        `${monAn.khauPhan || 0} người`;


    const nutXem =
        document.createElement(
            'a'
        );

    nutXem.href =
        `chi-tiet.html?id=${encodeURIComponent(
            monAn.id
        )}`;

    nutXem.className =
        'nut-xem-bai-viet';

    nutXem.textContent =
        'Xem công thức';


    noiDung.appendChild(
        tieuDe
    );

    noiDung.appendChild(
        thongTin
    );

    noiDung.appendChild(
        nutXem
    );


    monAnItem.appendChild(
        hinhAnh
    );

    monAnItem.appendChild(
        noiDung
    );


    return monAnItem;
};


/* =========================================================
   6. TRẠNG THÁI MÓN ĐÃ LƯU
   ========================================================= */

const hienThiTrangThaiMonDaLuu = (
    noiDung,
    laLoi = false
) => {

    if (
        khuVucMonDaLuu === null
    ) {
        return;
    }


    const thongBao =
        document.createElement(
            'p'
        );

    thongBao.className =
        'thong-bao-mon-da-luu';

    thongBao.setAttribute(
        'aria-live',
        'polite'
    );

    thongBao.textContent =
        noiDung;


    khuVucMonDaLuu.appendChild(
        thongBao
    );


    if (
        laLoi
    ) {

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

                await hienThiMonDaLuu();
            }
        );


        khuVucMonDaLuu.appendChild(
            nutThuLai
        );
    }
};


/* =========================================================
   7. HIỂN THỊ MÓN ĐÃ LƯU
   ========================================================= */

const hienThiMonDaLuu = async () => {

    if (
        khuVucMonDaLuu === null
    ) {
        return;
    }


    khuVucMonDaLuu.replaceChildren();


    hienThiTrangThaiMonDaLuu(
        'Đang tải danh sách món đã lưu...'
    );


    const danhSachYeuThich =
        docYeuThich();


    if (
        danhSachYeuThich.length === 0
    ) {

        khuVucMonDaLuu.replaceChildren();


        const tieuDe =
            document.createElement(
                'h2'
            );

        tieuDe.textContent =
            'Món đã lưu';


        khuVucMonDaLuu.appendChild(
            tieuDe
        );


        hienThiTrangThaiMonDaLuu(
            'Bạn chưa lưu món ăn nào.'
        );

        return;
    }


    try {

        const danhSachMonAn =
            await taiJSON(
                'data/mon-an.json'
            );


        if (
            Array.isArray(
                danhSachMonAn
            ) === false
        ) {

            throw new Error(
                'Dữ liệu món ăn không hợp lệ.'
            );
        }


        const monAnDaLuu =
            danhSachMonAn.filter(
                (monAn) => {

                    return danhSachYeuThich.some(
                        (idMonAn) => {

                            return (
                                String(
                                    idMonAn
                                )
                                ===
                                String(
                                    monAn.id
                                )
                            );
                        }
                    );
                }
            );


        khuVucMonDaLuu.replaceChildren();


        const tieuDe =
            document.createElement(
                'h2'
            );

        tieuDe.textContent =
            'Món đã lưu';


        khuVucMonDaLuu.appendChild(
            tieuDe
        );


        if (
            monAnDaLuu.length === 0
        ) {

            hienThiTrangThaiMonDaLuu(
                'Không tìm thấy món ăn đã lưu.'
            );

            return;
        }


        const danhSach =
            document.createElement(
                'div'
            );

        danhSach.className =
            'danh-sach-bai-viet-cua-toi';


        monAnDaLuu.forEach(
            (monAn) => {

                const monAnItem =
                    taoTheMonDaLuu(
                        monAn
                    );

                danhSach.appendChild(
                    monAnItem
                );
            }
        );


        khuVucMonDaLuu.appendChild(
            danhSach
        );

    } catch (error) {

        console.error(
            'Lỗi tải món ăn đã lưu:',
            error
        );


        khuVucMonDaLuu.replaceChildren();


        const tieuDe =
            document.createElement(
                'h2'
            );

        tieuDe.textContent =
            'Món đã lưu';

        khuVucMonDaLuu.appendChild(
            tieuDe
        );


        hienThiTrangThaiMonDaLuu(
            'Không thể tải danh sách món đã lưu.',
            true
        );
    }
};


/* =========================================================
   8. CHUYỂN TAB
   ========================================================= */

const chuyenTab = (
    tabDuocChon
) => {

    cacTab.forEach(
        (tab) => {

            const dangChon =
                tab === tabDuocChon;


            tab.classList.toggle(
                'dang-chon',
                dangChon
            );


            tab.setAttribute(
                'aria-selected',
                String(
                    dangChon
                )
            );
        }
    );


    /*
     * Dùng vị trí của tab thay vì phụ thuộc
     * vào nội dung text của nút.
     */

    const viTriTab =
        Array.from(
            cacTab
        ).indexOf(
            tabDuocChon
        );


    if (
        viTriTab === 0
    ) {

        if (
            khuVucCongThuc !== null
        ) {

            khuVucCongThuc.hidden =
                false;
        }


        if (
            khuVucMonDaLuu !== null
        ) {

            khuVucMonDaLuu.hidden =
                true;
        }

        return;
    }


    if (
        viTriTab === 1
    ) {

        if (
            khuVucCongThuc !== null
        ) {

            khuVucCongThuc.hidden =
                true;
        }


        if (
            khuVucMonDaLuu !== null
        ) {

            khuVucMonDaLuu.hidden =
                false;
        }
    }
};


/* =========================================================
   9. KHỞI TẠO TAB
   ========================================================= */

const khoiTaoTab = () => {

    cacTab.forEach(
        (tab) => {

            tab.setAttribute(
                'aria-selected',
                'false'
            );


            tab.addEventListener(
                'click',
                () => {

                    chuyenTab(
                        tab
                    );
                }
            );
        }
    );


    if (
        cacTab.length > 0
    ) {

        chuyenTab(
            cacTab[0]
        );
    }
};


/* =========================================================
   10. KHỞI TẠO TRANG CÁ NHÂN
   ========================================================= */

const khoiTaoTrangCaNhan =
    async () => {

        const nguoiDung =
            docNguoiDungHienTai();


        if (
            nguoiDung === null
        ) {

            window.location.href =
                'dang-nhap.html';

            return;
        }


        hienThiThongTinNguoiDung(
            nguoiDung
        );


        hienThiBaiVietCuaToi(
            nguoiDung
        );


        khoiTaoTab();


        /*
         * Chỉ cần tải dữ liệu món đã lưu
         * khi khu vực này tồn tại.
         */

        if (
            khuVucMonDaLuu !== null
        ) {

            await hienThiMonDaLuu();
        }
    };


khoiTaoTrangCaNhan();