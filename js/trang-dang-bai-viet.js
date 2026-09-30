/*
 * trang-dang-bai-viet.js
 * Xử lý trang đăng bài viết trực tiếp của người dùng.
 * Cho phép chọn hình ảnh, xem trước hình ảnh và kiểm tra dữ liệu bài viết.
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


/* ================================
   LẤY CÁC PHẦN TỬ HTML
   ================================ */

const formDangBai = document.querySelector(
    '.form-dang-bai-viet'
);

const oChonHinhAnh = document.querySelector(
    '#hinh-anh'
);

const khuVucXemTruoc = document.querySelector(
    '.xem-truoc-hinh-anh'
);

const moTaBaiViet = document.querySelector(
    '#mo-ta-bai-viet'
);

const tenMon = document.querySelector(
    '#ten-mon'
);

const danhMuc = document.querySelector(
    '#danh-muc'
);

const thoiGianNau = document.querySelector(
    '#thoi-gian-nau'
);

const soNguoiAn = document.querySelector(
    '#so-nguoi-an'
);

const nganSach = document.querySelector(
    '#ngan-sach'
);

const nguyenLieu = document.querySelector(
    '#nguyen-lieu'
);

const cachLam = document.querySelector(
    '#cach-lam'
);


/* ================================
   XÁC ĐỊNH CHẾ ĐỘ THÊM / SỬA
   ================================ */

const thamSo = new URLSearchParams(
    window.location.search
);

const idBaiViet = thamSo.get('id');

const cheDo = thamSo.get('cheDo');

const dangSua = cheDo === 'sua';


/* ================================
   DANH SÁCH HÌNH ẢNH
   ================================ */

let danhSachHinhAnh = [];


/* ================================
   HIỂN THỊ LỖI
   ================================ */

const hienThiLoi = (
    phanTu,
    noiDung
) => {

    if (phanTu === null) {
        return;
    }

    phanTu.classList.add(
        'truong-co-loi'
    );

    let thongBaoLoi =
        phanTu.parentElement.querySelector(
            '.thong-bao-loi-truong'
        );

    if (thongBaoLoi === null) {

        thongBaoLoi =
            document.createElement('p');

        thongBaoLoi.className =
            'thong-bao-loi-truong';

        phanTu.parentElement.appendChild(
            thongBaoLoi
        );
    }

    thongBaoLoi.textContent =
        noiDung;
};


/* ================================
   XÓA LỖI
   ================================ */

const xoaLoi = (phanTu) => {

    if (phanTu === null) {
        return;
    }

    phanTu.classList.remove(
        'truong-co-loi'
    );

    const thongBaoLoi =
        phanTu.parentElement.querySelector(
            '.thong-bao-loi-truong'
        );

    if (thongBaoLoi !== null) {
        thongBaoLoi.remove();
    }
};


/* ================================
   KIỂM TRA NGƯỜI DÙNG HIỆN TẠI
   ================================ */

const nguoiDungHienTai =
    docNguoiDungHienTai();

if (nguoiDungHienTai === null) {

    window.location.href =
        'dang-nhap.html';
}


/* ================================
   LẤY BÀI VIẾT CẦN SỬA
   ================================ */

const layBaiVietCanSua = () => {

    if (dangSua === false) {
        return null;
    }

    if (idBaiViet === null) {
        return null;
    }

    const danhSachBaiViet =
        docBaiViet();

    const baiViet =
        danhSachBaiViet.find(
            (item) => {
                return item.id === idBaiViet;
            }
        );

    if (baiViet === undefined) {
        return null;
    }

    return baiViet;
};


/* ================================
   THIẾT LẬP CHẾ ĐỘ SỬA
   ================================ */

const thietLapCheDoSua = () => {

    if (dangSua === false) {
        return;
    }

    const tieuDe =
        document.querySelector(
            '.nguoi-dang-bai strong'
        );

    if (tieuDe !== null) {

        tieuDe.textContent =
            'Chỉnh sửa bài viết';
    }

    const nutDangBai =
        document.querySelector(
            '.nut-dang-bai'
        );

    if (nutDangBai !== null) {

        nutDangBai.textContent =
            'Lưu thay đổi';
    }
};


/* ================================
   KIỂM TRA MÔ TẢ
   ================================ */

const kiemTraMoTa = () => {

    if (moTaBaiViet === null) {
        return false;
    }

    const noiDung =
        moTaBaiViet.value.trim();

    if (noiDung === '') {

        hienThiLoi(
            moTaBaiViet,
            'Vui lòng nhập nội dung chia sẻ.'
        );

        return false;
    }

    if (noiDung.length < 10) {

        hienThiLoi(
            moTaBaiViet,
            'Nội dung chia sẻ phải có ít nhất 10 ký tự.'
        );

        return false;
    }

    xoaLoi(moTaBaiViet);

    return true;
};


/* ================================
   KIỂM TRA TÊN MÓN
   ================================ */

const kiemTraTenMon = () => {

    if (tenMon === null) {
        return false;
    }

    const giaTri =
        tenMon.value.trim();

    if (giaTri === '') {

        hienThiLoi(
            tenMon,
            'Vui lòng nhập tên món ăn.'
        );

        return false;
    }

    if (giaTri.length < 2) {

        hienThiLoi(
            tenMon,
            'Tên món ăn phải có ít nhất 2 ký tự.'
        );

        return false;
    }

    xoaLoi(tenMon);

    return true;
};


/* ================================
   KIỂM TRA DANH MỤC
   ================================ */

const kiemTraDanhMuc = () => {

    if (danhMuc === null) {
        return false;
    }

    if (danhMuc.value === '') {

        hienThiLoi(
            danhMuc,
            'Vui lòng chọn danh mục món ăn.'
        );

        return false;
    }

    xoaLoi(danhMuc);

    return true;
};


/* ================================
   KIỂM TRA THỜI GIAN NẤU
   ================================ */

const kiemTraThoiGianNau = () => {

    if (thoiGianNau === null) {
        return false;
    }

    const giaTri =
        Number(thoiGianNau.value);

    if (
        thoiGianNau.value === ''
        || Number.isNaN(giaTri)
        || giaTri < 1
        || giaTri > 300
    ) {

        hienThiLoi(
            thoiGianNau,
            'Thời gian nấu phải từ 1 đến 300 phút.'
        );

        return false;
    }

    xoaLoi(thoiGianNau);

    return true;
};


/* ================================
   KIỂM TRA KHẨU PHẦN
   ================================ */

const kiemTraSoNguoiAn = () => {

    if (soNguoiAn === null) {
        return false;
    }

    const giaTri =
        Number(soNguoiAn.value);

    if (
        soNguoiAn.value === ''
        || Number.isNaN(giaTri)
        || giaTri < 1
        || giaTri > 20
    ) {

        hienThiLoi(
            soNguoiAn,
            'Khẩu phần phải từ 1 đến 20 người.'
        );

        return false;
    }

    xoaLoi(soNguoiAn);

    return true;
};


/* ================================
   KIỂM TRA NGÂN SÁCH
   ================================ */

const kiemTraNganSach = () => {

    if (nganSach === null) {
        return false;
    }

    const giaTri =
        Number(nganSach.value);

    if (
        nganSach.value === ''
        || Number.isNaN(giaTri)
        || giaTri < 0
    ) {

        hienThiLoi(
            nganSach,
            'Vui lòng nhập ngân sách hợp lệ.'
        );

        return false;
    }

    xoaLoi(nganSach);

    return true;
};


/* ================================
   KIỂM TRA NGUYÊN LIỆU
   ================================ */

const kiemTraNguyenLieu = () => {

    if (nguyenLieu === null) {
        return false;
    }

    const noiDung =
        nguyenLieu.value.trim();

    if (noiDung === '') {

        hienThiLoi(
            nguyenLieu,
            'Vui lòng nhập danh sách nguyên liệu.'
        );

        return false;
    }

    if (noiDung.length < 10) {

        hienThiLoi(
            nguyenLieu,
            'Danh sách nguyên liệu quá ngắn.'
        );

        return false;
    }

    xoaLoi(nguyenLieu);

    return true;
};


/* ================================
   KIỂM TRA CÁCH LÀM
   ================================ */

const kiemTraCachLam = () => {

    if (cachLam === null) {
        return false;
    }

    const noiDung =
        cachLam.value.trim();

    if (noiDung === '') {

        hienThiLoi(
            cachLam,
            'Vui lòng nhập các bước chế biến.'
        );

        return false;
    }

    if (noiDung.length < 10) {

        hienThiLoi(
            cachLam,
            'Cách chế biến quá ngắn.'
        );

        return false;
    }

    xoaLoi(cachLam);

    return true;
};


/* ================================
   KIỂM TRA HÌNH ẢNH
   ================================ */

const kiemTraHinhAnh = () => {

    /*
     * Khi sửa bài viết, bài cũ có thể đã có hình ảnh.
     * Không bắt buộc người dùng phải chọn lại hình ảnh.
     */

    if (dangSua === true) {

        if (danhSachHinhAnh.length === 0) {
            return true;
        }
    }

    if (danhSachHinhAnh.length === 0) {

        if (khuVucXemTruoc !== null) {

            khuVucXemTruoc.classList.add(
                'khu-vuc-co-loi'
            );

            khuVucXemTruoc.textContent =
                'Vui lòng thêm ít nhất một hình ảnh món ăn.';
        }

        return false;
    }

    if (khuVucXemTruoc !== null) {

        khuVucXemTruoc.classList.remove(
            'khu-vuc-co-loi'
        );
    }

    return true;
};


/* ================================
   HIỂN THỊ HÌNH ẢNH
   ================================ */

const hienThiHinhAnh = () => {

    if (khuVucXemTruoc === null) {
        return;
    }

    khuVucXemTruoc.innerHTML = '';

    danhSachHinhAnh.forEach(
        (tepHinhAnh, chiSo) => {

            const khungHinhAnh =
                document.createElement('div');

            khungHinhAnh.className =
                'khung-hinh-anh-xem-truoc';


            const hinhAnh =
                document.createElement('img');

            hinhAnh.alt =
                `Hình ảnh món ăn ${chiSo + 1}`;


            const nutXoa =
                document.createElement('button');

            nutXoa.type = 'button';

            nutXoa.className =
                'nut-xoa-hinh-anh';

            nutXoa.textContent = '×';

            nutXoa.setAttribute(
                'aria-label',
                `Xóa hình ảnh ${chiSo + 1}`
            );


            nutXoa.addEventListener(
                'click',
                () => {

                    danhSachHinhAnh =
                        danhSachHinhAnh.filter(
                            (tep, viTri) => {
                                return viTri !== chiSo;
                            }
                        );

                    hienThiHinhAnh();
                }
            );


            const boDocFile =
                new FileReader();


            boDocFile.addEventListener(
                'load',
                () => {

                    hinhAnh.src =
                        boDocFile.result;

                    khungHinhAnh.appendChild(
                        hinhAnh
                    );

                    khungHinhAnh.appendChild(
                        nutXoa
                    );

                    khuVucXemTruoc.appendChild(
                        khungHinhAnh
                    );
                }
            );


            boDocFile.readAsDataURL(
                tepHinhAnh
            );
        }
    );
};


/* ================================
   XỬ LÝ CHỌN HÌNH ẢNH
   ================================ */

const xuLyChonHinhAnh = () => {

    if (oChonHinhAnh === null) {
        return;
    }

    const danhSachTepMoi =
        Array.from(oChonHinhAnh.files);


    danhSachTepMoi.forEach(
        (tepHinhAnh) => {

            if (
                tepHinhAnh.type.startsWith(
                    'image/'
                ) === false
            ) {
                return;
            }

            const daTonTai =
                danhSachHinhAnh.some(
                    (tepDaChon) => {
                        return (
                            tepDaChon.name ===
                            tepHinhAnh.name
                            &&
                            tepDaChon.size ===
                            tepHinhAnh.size
                        );
                    }
                );


            if (
                daTonTai === false
                &&
                danhSachHinhAnh.length < 10
            ) {
                danhSachHinhAnh.push(
                    tepHinhAnh
                );
            }
        }
    );


    hienThiHinhAnh();

    oChonHinhAnh.value = '';
};


/* ================================
   KIỂM TRA TOÀN BỘ FORM
   ================================ */

const kiemTraBieuMau = () => {

    const ketQuaMoTa =
        kiemTraMoTa();

    const ketQuaHinhAnh =
        kiemTraHinhAnh();

    const ketQuaTenMon =
        kiemTraTenMon();

    const ketQuaDanhMuc =
        kiemTraDanhMuc();

    const ketQuaThoiGian =
        kiemTraThoiGianNau();

    const ketQuaSoNguoi =
        kiemTraSoNguoiAn();

    const ketQuaNganSach =
        kiemTraNganSach();

    const ketQuaNguyenLieu =
        kiemTraNguyenLieu();

    const ketQuaCachLam =
        kiemTraCachLam();


    return (
        ketQuaMoTa === true
        && ketQuaHinhAnh === true
        && ketQuaTenMon === true
        && ketQuaDanhMuc === true
        && ketQuaThoiGian === true
        && ketQuaSoNguoi === true
        && ketQuaNganSach === true
        && ketQuaNguyenLieu === true
        && ketQuaCachLam === true
    );
};


/* ================================
   ĐIỀN DỮ LIỆU KHI SỬA
   ================================ */

const dienDuLieuBaiViet = (
    baiViet
) => {

    if (baiViet === null) {
        return;
    }

    moTaBaiViet.value =
        baiViet.moTa;

    tenMon.value =
        baiViet.tenMon;

    danhMuc.value =
        baiViet.danhMuc;

    thoiGianNau.value =
        baiViet.thoiGianNau;

    soNguoiAn.value =
        baiViet.soNguoiAn;

    nganSach.value =
        baiViet.nganSach;

    nguyenLieu.value =
        baiViet.nguyenLieu;

    cachLam.value =
        baiViet.cachLam;
};


/* ================================
   SỰ KIỆN CHỌN HÌNH ẢNH
   ================================ */

if (oChonHinhAnh !== null) {

    oChonHinhAnh.addEventListener(
        'change',
        xuLyChonHinhAnh
    );
}


/* ================================
   TẠO DỮ LIỆU BÀI VIẾT
   ================================ */

const taoDuLieuBaiViet = () => {

    return {
        moTa:
            moTaBaiViet.value.trim(),

        tenMon:
            tenMon.value.trim(),

        danhMuc:
            danhMuc.value,

        thoiGianNau:
            Number(thoiGianNau.value),

        soNguoiAn:
            Number(soNguoiAn.value),

        nganSach:
            Number(nganSach.value),

        nguyenLieu:
            nguyenLieu.value.trim(),

        cachLam:
            cachLam.value.trim()
    };
};


/* ================================
   HIỂN THỊ THÔNG BÁO
   ================================ */

const hienThiThongBao = (
    noiDung,
    laLoi = false
) => {

    let thongBao =
        document.querySelector(
            '.thong-bao-dang-bai'
        );

    if (thongBao === null) {

        thongBao =
            document.createElement('p');

        thongBao.className =
            'thong-bao-dang-bai';

        formDangBai.appendChild(
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


/* ================================
   SỰ KIỆN GỬI FORM
   ================================ */

if (formDangBai !== null) {

    formDangBai.addEventListener(
        'submit',
        async (event) => {

            event.preventDefault();

            const hopLe =
                kiemTraBieuMau();

            if (hopLe === false) {
                return;
            }

            const nutDangBai =
                formDangBai.querySelector(
                    '.nut-dang-bai'
                );

            if (nutDangBai !== null) {

                nutDangBai.disabled = true;

                if (dangSua === true) {

                    nutDangBai.textContent =
                        'Đang lưu...';

                } else {

                    nutDangBai.textContent =
                        'Đang đăng...';
                }
            }


            try {

                const duLieuBaiViet =
                    taoDuLieuBaiViet();


                /* ================================
                   CHẾ ĐỘ SỬA
                   ================================ */

                if (dangSua === true) {

                    const thanhCong =
                        capNhatBaiViet(
                            idBaiViet,
                            nguoiDungHienTai.id,
                            duLieuBaiViet
                        );

                    if (thanhCong === false) {

                        hienThiThongBao(
                            'Không thể cập nhật bài viết.',
                            true
                        );

                        return;
                    }

                    window.alert(
                        'Đã cập nhật bài viết.'
                    );

                    window.location.href =
                        'ca-nhan.html';

                    return;
                }


                /* ================================
                   CHẾ ĐỘ ĐĂNG BÀI MỚI
                   ================================ */

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


                themBaiViet(
                    baiVietMoi
                );


                window.alert(
                    'Đăng bài viết thành công.'
                );

                window.location.href =
                    'ca-nhan.html';

            } catch (error) {

                console.error(
                    'Lỗi đăng bài:',
                    error
                );

                hienThiThongBao(
                    'Không thể đăng bài viết. Vui lòng thử lại.',
                    true
                );

            } finally {

                if (nutDangBai !== null) {

                    nutDangBai.disabled =
                        false;

                    if (dangSua === true) {

                        nutDangBai.textContent =
                            'Lưu thay đổi';

                    } else {

                        nutDangBai.textContent =
                            'Đăng bài viết';
                    }
                }
            }
        }
    );
}


/* ================================
   KHỞI TẠO CHẾ ĐỘ TRANG
   ================================ */

const baiVietCanSua =
    layBaiVietCanSua();


/* ================================
   KIỂM TRA QUYỀN SỬA
   ================================ */

if (
    dangSua === true
    && (
        baiVietCanSua === null
        || baiVietCanSua.userId !== nguoiDungHienTai.id
    )
) {

    window.alert(
        'Bạn không có quyền sửa bài viết này.'
    );

    window.location.href =
        'ca-nhan.html';
}


/* ================================
   HIỂN THỊ CHẾ ĐỘ SỬA
   ================================ */

thietLapCheDoSua();

dienDuLieuBaiViet(
    baiVietCanSua
);