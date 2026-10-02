/*
 * yeu-thich.js
 * Quản lý danh sách món ăn yêu thích của người dùng.
 * Dữ liệu yêu thích được lưu và đọc từ localStorage.
 */

const tenKhoaYeuThich = 'monAnYeuThich';


/* =========================================================
 * ĐỌC DANH SÁCH YÊU THÍCH
 * ========================================================= */

export const docYeuThich = () => {
    try {
        const duLieu =
            localStorage.getItem(
                tenKhoaYeuThich
            );

        if (duLieu === null) {
            return [];
        }

        const danhSach =
            JSON.parse(duLieu);

        if (
            Array.isArray(danhSach) === false
        ) {
            return [];
        }

        /*
         * Chuẩn hóa tất cả ID thành chuỗi.
         * Điều này tránh trường hợp:
         * 1 !== "1"
         */
        return danhSach.map(
            (itemId) => String(itemId)
        );

    } catch (error) {
        console.error(
            'Không thể đọc danh sách yêu thích:',
            error
        );

        return [];
    }
};


/* =========================================================
 * GHI DANH SÁCH YÊU THÍCH
 * ========================================================= */

export const ghiYeuThich = (
    danhSach
) => {

    if (
        Array.isArray(danhSach) === false
    ) {
        return;
    }

    try {
        /*
         * Chuẩn hóa ID trước khi lưu.
         */
        const danhSachChuanHoa =
            danhSach.map(
                (itemId) => String(itemId)
            );

        /*
         * Loại bỏ ID trùng nhau.
         */
        const danhSachKhongTrung =
            [...new Set(danhSachChuanHoa)];

        localStorage.setItem(
            tenKhoaYeuThich,
            JSON.stringify(
                danhSachKhongTrung
            )
        );

        /*
         * Thông báo cho main.js cập nhật
         * số lượng yêu thích trên header.
         */
        window.dispatchEvent(
            new CustomEvent(
                'yeuThichThayDoi'
            )
        );

    } catch (error) {
        console.error(
            'Không thể lưu danh sách yêu thích:',
            error
        );
    }
};


/* =========================================================
 * KIỂM TRA MÓN ĂN ĐÃ ĐƯỢC YÊU THÍCH CHƯA
 * ========================================================= */

export const kiemTraYeuThich = (
    id
) => {

    const danhSach =
        docYeuThich();

    const idCanKiemTra =
        String(id);

    return danhSach.includes(
        idCanKiemTra
    );
};


/* =========================================================
 * THÊM / XÓA MÓN ĂN KHỎI YÊU THÍCH
 * ========================================================= */

export const doiTrangThaiYeuThich = (
    id
) => {

    const danhSach =
        docYeuThich();

    const idCanXuLy =
        String(id);

    const daTonTai =
        danhSach.includes(
            idCanXuLy
        );


    /*
     * Nếu đã yêu thích → xóa.
     */
    if (daTonTai === true) {

        const danhSachMoi =
            danhSach.filter(
                (itemId) => {
                    return itemId !==
                        idCanXuLy;
                }
            );

        ghiYeuThich(
            danhSachMoi
        );

        return false;
    }


    /*
     * Nếu chưa yêu thích → thêm.
     */
    danhSach.push(
        idCanXuLy
    );

    ghiYeuThich(
        danhSach
    );

    return true;
};