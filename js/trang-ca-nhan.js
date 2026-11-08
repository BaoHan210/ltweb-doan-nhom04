/*
 * trang-ca-nhan.js
 */

import { docNguoiDungHienTai } from './tai-khoan.js';
import { docBaiViet } from './bai-viet.js';

/* 1. LẤY PHẦN TỬ HTML */
const tenNguoiDung = document.querySelector('.ten-nguoi-dung');
const emailNguoiDung = document.querySelector('.email-nguoi-dung');
const chuCaiDaiDien = document.querySelector('.chu-cai-dai-dien');
const danhSachBaiViet = document.querySelector('.danh-sach-bai-viet-cua-toi');
const khuVucCongThuc = document.querySelector('.khu-vuc-cong-thuc-ca-nhan');
const khuVucMonDaLuu = document.querySelector('.khu-vuc-mon-da-luu');
const cacTab = document.querySelectorAll('.tab-ca-nhan');

const ANH_MON_AN_MAC_DINH = 'images/cao-lau.jpg';

/* 2. HIỂN THỊ THÔNG TIN NGƯỜI DÙNG */
const hienThiThongTinNguoiDung = (nguoiDung) => {
    if (!nguoiDung || typeof nguoiDung !== 'object') {
        return;
    }

    const hoTen = String(nguoiDung.hoTen || '').trim();

    // Không ghi đè tên mặc định nếu localStorage không có tên.
    if (hoTen && tenNguoiDung) {
        tenNguoiDung.textContent = hoTen;
    }

    if (emailNguoiDung) {
        emailNguoiDung.textContent = String(nguoiDung.email || '');
    }

    if (chuCaiDaiDien && hoTen) {
        chuCaiDaiDien.textContent = hoTen.charAt(0).toUpperCase();
    }
};

/* 3. LẤY ĐƯỜNG DẪN ẢNH */
const layDuongDanHinhAnh = (baiViet) => {
    if (!baiViet || typeof baiViet !== 'object') {
        return ANH_MON_AN_MAC_DINH;
    }

    let hinhAnh = baiViet.hinhAnh;

    if (Array.isArray(hinhAnh)) {
        hinhAnh = hinhAnh.length > 0 ? hinhAnh[0] : '';
    }

    if (typeof hinhAnh !== 'string' || hinhAnh.trim() === '') {
        return ANH_MON_AN_MAC_DINH;
    }

    hinhAnh = hinhAnh.trim();

    // Chỉ chấp nhận đường dẫn tương đối hoặc URL HTTPS.
    if (
        hinhAnh.startsWith('https://')
        || hinhAnh.startsWith('images/')
        || hinhAnh.startsWith('uploads/')
    ) {
        return hinhAnh;
    }

    return ANH_MON_AN_MAC_DINH;
};

/* 4. TẠO THẺ BÀI VIẾT / MÓN ĂN */
const taoTheBaiVietNguoiDung = (baiViet) => {
    const article = document.createElement('article');
    article.className = 'the-mon-an-cn';

    const id = String(baiViet.id || '');
    const ten = String(baiViet.tenMon || baiViet.ten || 'Món ăn');

    const hinhAnh = document.createElement('img');
    hinhAnh.src = layDuongDanHinhAnh(baiViet);
    hinhAnh.alt = ten;

    // Ảnh lỗi sẽ được thay bằng ảnh mặc định.
    hinhAnh.addEventListener('error', () => {
        if (hinhAnh.src !== new URL(ANH_MON_AN_MAC_DINH, document.baseURI).href) {
            hinhAnh.src = ANH_MON_AN_MAC_DINH;
        }
    }, { once: true });

    const lienKetAnh = document.createElement('a');
    lienKetAnh.href = `chi-tiet.php?id=${encodeURIComponent(id)}`;
    lienKetAnh.appendChild(hinhAnh);

    const khungAnh = document.createElement('div');
    khungAnh.className = 'khung-anh-mon-cn';
    khungAnh.appendChild(lienKetAnh);

    const nutYeuThich = document.createElement('button');
    nutYeuThich.className = 'nut-yeu-thich-cn';
    nutYeuThich.type = 'button';
    nutYeuThich.setAttribute('aria-label', 'Yêu thích');

    nutYeuThich.innerHTML = `
        <svg
            width="15"
            height="15"
            viewBox="0 0 24 24"
            fill="currentColor"
            aria-hidden="true"
        >
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
        </svg>
    `;

    khungAnh.appendChild(nutYeuThich);

    const noiDung = document.createElement('div');
    noiDung.className = 'noi-dung-mon-cn';

    const tieuDe = document.createElement('h3');
    tieuDe.className = 'tieu-de-mon-cn';

    const lienKetTieuDe = document.createElement('a');
    lienKetTieuDe.href = `chi-tiet.php?id=${encodeURIComponent(id)}`;
    lienKetTieuDe.textContent = ten;

    tieuDe.appendChild(lienKetTieuDe);

    const thongTinMeta = document.createElement('div');
    thongTinMeta.className = 'thong-tin-meta-cn';

    const thoiGian = baiViet.thoiGianNau || baiViet.thoiGian || 30;
    const khauPhan = baiViet.soNguoiAn || baiViet.khauPhan || 2;

    const itemThoiGian = document.createElement('span');
    itemThoiGian.className = 'item-meta-cn';
    itemThoiGian.textContent = `${thoiGian} phút`;

    const itemKhauPhan = document.createElement('span');
    itemKhauPhan.className = 'item-meta-cn';
    itemKhauPhan.textContent = `${khauPhan} người`;

    thongTinMeta.append(itemThoiGian, itemKhauPhan);
    noiDung.append(tieuDe, thongTinMeta);

    article.append(khungAnh, noiDung);

    return article;
};

/* 5. HIỂN THỊ BÀI VIẾT CỦA TÔI */
const hienThiBaiVietCuaToi = (nguoiDung) => {
    if (!danhSachBaiViet) {
        return;
    }

    danhSachBaiViet.replaceChildren();

    const tatCaBaiViet = docBaiViet();

    const baiVietCuaToi = Array.isArray(tatCaBaiViet)
        ? tatCaBaiViet.filter((baiViet) => {
            if (!baiViet || typeof baiViet !== 'object') {
                return false;
            }

            return String(baiViet.userId) === String(nguoiDung?.id);
        })
        : [];

    const soBaiDang = document.querySelector('.so-bai-dang');

    if (soBaiDang) {
        soBaiDang.textContent = String(baiVietCuaToi.length);
    }

    if (baiVietCuaToi.length === 0) {
        const thongBao = document.createElement('p');
        thongBao.className = 'thong-bao-chua-co-bai-viet';
        thongBao.textContent = 'Bạn chưa có bài viết nào.';

        danhSachBaiViet.appendChild(thongBao);
        return;
    }

    baiVietCuaToi.forEach((baiViet) => {
        danhSachBaiViet.appendChild(
            taoTheBaiVietNguoiDung(baiViet)
        );
    });
};

/* 6. CHUYỂN TAB */
const chuyenTab = (tabDuocChon) => {
    cacTab.forEach((tab) => {
        const dangChon = tab === tabDuocChon;

        tab.classList.toggle('dang-chon', dangChon);
        tab.setAttribute('aria-selected', String(dangChon));
    });

    const viTriTab = Array.from(cacTab).indexOf(tabDuocChon);

    if (viTriTab === 0) {
        if (khuVucCongThuc) {
            khuVucCongThuc.hidden = false;
        }

        if (khuVucMonDaLuu) {
            khuVucMonDaLuu.hidden = true;
        }
    } else if (viTriTab === 1) {
        if (khuVucCongThuc) {
            khuVucCongThuc.hidden = true;
        }

        if (khuVucMonDaLuu) {
            khuVucMonDaLuu.hidden = false;
        }
    }
};

/* 7. KHỞI TẠO TAB */
const khoiTaoTab = () => {
    cacTab.forEach((tab) => {
        tab.addEventListener('click', () => {
            chuyenTab(tab);
        });
    });

    if (cacTab.length > 0) {
        chuyenTab(cacTab[0]);
    }
};

/* 8. KHỞI TẠO TRANG */
const khoiTaoTrangCaNhan = () => {
    const nguoiDung = docNguoiDungHienTai();

    hienThiThongTinNguoiDung(nguoiDung);
    hienThiBaiVietCuaToi(nguoiDung);
    khoiTaoTab();
};

document.addEventListener('DOMContentLoaded', khoiTaoTrangCaNhan);
