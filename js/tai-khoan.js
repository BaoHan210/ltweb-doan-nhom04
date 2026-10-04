/*
 * tai-khoan.js
 * Quản lý thông tin tài khoản người dùng.
 * Dữ liệu tài khoản được lưu trong localStorage.
 */

const tenKhoaTaiKhoan =
    'taiKhoanNguoiDung';

const tenKhoaNguoiDungHienTai =
    'nguoiDungHienTai';

const tenKhoaCaiDat =
    'caiDatNguoiDung';


/* =========================================================
   1. ĐỌC DANH SÁCH TÀI KHOẢN
   ========================================================= */

export const docDanhSachTaiKhoan = () => {

    try {

        const duLieu =
            localStorage.getItem(
                tenKhoaTaiKhoan
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


        return danhSach;

    } catch (error) {

        console.error(
            'Không thể đọc danh sách tài khoản:',
            error
        );

        return [];
    }
};


/* =========================================================
   2. GHI DANH SÁCH TÀI KHOẢN
   ========================================================= */

export const ghiDanhSachTaiKhoan = (
    danhSachTaiKhoan
) => {

    if (
        Array.isArray(
            danhSachTaiKhoan
        ) === false
    ) {
        return false;
    }


    try {

        localStorage.setItem(
            tenKhoaTaiKhoan,
            JSON.stringify(
                danhSachTaiKhoan
            )
        );

        return true;

    } catch (error) {

        console.error(
            'Không thể lưu danh sách tài khoản:',
            error
        );

        return false;
    }
};


/* =========================================================
   3. TÌM TÀI KHOẢN THEO EMAIL
   ========================================================= */

export const timTaiKhoanTheoEmail = (
    email
) => {

    const danhSach =
        docDanhSachTaiKhoan();


    const emailCanTim =
        String(
            email || ''
        )
            .trim()
            .toLowerCase();


    return danhSach.find(
        (taiKhoan) => {

            if (
                taiKhoan === null
                ||
                typeof taiKhoan !== 'object'
            ) {
                return false;
            }


            return (
                String(
                    taiKhoan.email || ''
                )
                    .trim()
                    .toLowerCase()
                ===
                emailCanTim
            );
        }
    );
};


/* =========================================================
   4. TẠO TÀI KHOẢN MỚI
   ========================================================= */

export const taoTaiKhoan = (
    thongTinTaiKhoan
) => {

    if (
        thongTinTaiKhoan === null
        ||
        typeof thongTinTaiKhoan !== 'object'
        ||
        Array.isArray(
            thongTinTaiKhoan
        )
    ) {
        return null;
    }


    const danhSach =
        docDanhSachTaiKhoan();


    /*
     * Không tạo tài khoản trùng email.
     *
     * Hàm này vẫn kiểm tra lại ở tầng
     * quản lý dữ liệu để tránh trường hợp
     * module gọi trực tiếp mà bỏ qua form.
     */
    const taiKhoanDaTonTai =
        timTaiKhoanTheoEmail(
            thongTinTaiKhoan.email
        );


    if (
        taiKhoanDaTonTai !== undefined
    ) {
        return null;
    }


    danhSach.push(
        thongTinTaiKhoan
    );


    const luuThanhCong =
        ghiDanhSachTaiKhoan(
            danhSach
        );


    if (
        luuThanhCong === false
    ) {
        return null;
    }


    return thongTinTaiKhoan;
};


/* =========================================================
   5. ĐĂNG NHẬP
   ========================================================= */

export const dangNhap = (
    email,
    matKhau
) => {

    const danhSachTaiKhoan =
        docDanhSachTaiKhoan();


    const emailCanTim =
        String(
            email || ''
        )
            .trim()
            .toLowerCase();


    const taiKhoan =
        danhSachTaiKhoan.find(
            (item) => {

                if (
                    item === null
                    ||
                    typeof item !== 'object'
                ) {
                    return false;
                }


                return (
                    String(
                        item.email || ''
                    )
                        .trim()
                        .toLowerCase()
                    ===
                    emailCanTim
                    &&
                    item.matKhau === matKhau
                );
            }
        );


    if (
        taiKhoan === undefined
    ) {
        return false;
    }


    try {

        localStorage.setItem(
            tenKhoaNguoiDungHienTai,
            JSON.stringify({

                id:
                    taiKhoan.id,

                hoTen:
                    taiKhoan.hoTen,

                email:
                    taiKhoan.email
            })
        );

        return true;

    } catch (error) {

        console.error(
            'Không thể lưu phiên đăng nhập:',
            error
        );

        return false;
    }
};


/* =========================================================
   6. ĐỌC NGƯỜI DÙNG HIỆN TẠI
   ========================================================= */

export const docNguoiDungHienTai = () => {

    try {

        const duLieu =
            localStorage.getItem(
                tenKhoaNguoiDungHienTai
            );


        if (
            duLieu === null
        ) {
            return null;
        }


        const nguoiDung =
            JSON.parse(
                duLieu
            );


        if (
            nguoiDung === null
            ||
            typeof nguoiDung !== 'object'
            ||
            Array.isArray(
                nguoiDung
            )
        ) {
            return null;
        }


        return nguoiDung;

    } catch (error) {

        console.error(
            'Không thể đọc người dùng hiện tại:',
            error
        );

        return null;
    }
};


/* =========================================================
   7. ĐĂNG XUẤT
   ========================================================= */

export const dangXuat = () => {

    try {

        localStorage.removeItem(
            tenKhoaNguoiDungHienTai
        );

        return true;

    } catch (error) {

        console.error(
            'Không thể đăng xuất:',
            error
        );

        return false;
    }
};


/* =========================================================
   8. KIỂM TRA TRẠNG THÁI ĐĂNG NHẬP
   ========================================================= */

export const daDangNhap = () => {

    return (
        docNguoiDungHienTai()
        !==
        null
    );
};


/* =========================================================
   9. ĐỔI MẬT KHẨU
   ========================================================= */

/*
 * Trả về:
 * - true: đổi mật khẩu thành công.
 * - false: không tìm thấy tài khoản
 *          hoặc mật khẩu cũ không đúng.
 */

export const doiMatKhau = (
    idTaiKhoan,
    matKhauCu,
    matKhauMoi
) => {

    const danhSachTaiKhoan =
        docDanhSachTaiKhoan();


    const viTriTaiKhoan =
        danhSachTaiKhoan.findIndex(
            (taiKhoan) => {

                if (
                    taiKhoan === null
                    ||
                    typeof taiKhoan !== 'object'
                ) {
                    return false;
                }


                return (
                    String(
                        taiKhoan.id
                    )
                    ===
                    String(
                        idTaiKhoan
                    )
                );
            }
        );


    if (
        viTriTaiKhoan === -1
    ) {
        return false;
    }


    const taiKhoan =
        danhSachTaiKhoan[
            viTriTaiKhoan
        ];


    if (
        taiKhoan.matKhau
        !==
        matKhauCu
    ) {
        return false;
    }


    taiKhoan.matKhau =
        matKhauMoi;


    danhSachTaiKhoan[
        viTriTaiKhoan
    ] =
        taiKhoan;


    return ghiDanhSachTaiKhoan(
        danhSachTaiKhoan
    );
};


/* =========================================================
   10. XÓA CÀI ĐẶT TÀI KHOẢN
   ========================================================= */

/*
 * Mỗi tài khoản có một vùng dữ liệu riêng
 * trong localStorage theo ID.
 */

const xoaCaiDatTaiKhoan = (
    idTaiKhoan
) => {

    try {

        const duLieu =
            localStorage.getItem(
                tenKhoaCaiDat
            );


        if (
            duLieu === null
        ) {
            return;
        }


        const danhSachCaiDat =
            JSON.parse(
                duLieu
            );


        if (
            danhSachCaiDat === null
            ||
            typeof danhSachCaiDat !== 'object'
            ||
            Array.isArray(
                danhSachCaiDat
            )
        ) {
            return;
        }


        delete danhSachCaiDat[
            String(
                idTaiKhoan
            )
        ];


        localStorage.setItem(
            tenKhoaCaiDat,
            JSON.stringify(
                danhSachCaiDat
            )
        );

    } catch (error) {

        console.error(
            'Không thể xóa cài đặt tài khoản:',
            error
        );
    }
};


/* =========================================================
   11. XÓA TÀI KHOẢN
   ========================================================= */

/*
 * Trả về:
 * - true: xóa tài khoản thành công.
 * - false: không tìm thấy tài khoản
 *          hoặc không thể xử lý.
 *
 * Khi xóa tài khoản:
 * - Xóa tài khoản khỏi danh sách.
 * - Xóa cài đặt riêng của tài khoản.
 * - Xóa phiên đăng nhập nếu đó là tài khoản hiện tại.
 */

export const xoaTaiKhoan = (
    idTaiKhoan
) => {

    const danhSachTaiKhoan =
        docDanhSachTaiKhoan();


    const danhSachMoi =
        danhSachTaiKhoan.filter(
            (taiKhoan) => {

                if (
                    taiKhoan === null
                    ||
                    typeof taiKhoan !== 'object'
                ) {
                    return false;
                }


                return (
                    String(
                        taiKhoan.id
                    )
                    !==
                    String(
                        idTaiKhoan
                    )
                );
            }
        );


    /*
     * Không tìm thấy tài khoản.
     */
    if (
        danhSachMoi.length
        ===
        danhSachTaiKhoan.length
    ) {
        return false;
    }


    const luuThanhCong =
        ghiDanhSachTaiKhoan(
            danhSachMoi
        );


    if (
        luuThanhCong === false
    ) {
        return false;
    }


    /*
     * Xóa cài đặt riêng.
     */
    xoaCaiDatTaiKhoan(
        idTaiKhoan
    );


    /*
     * Nếu là tài khoản hiện tại
     * thì xóa phiên đăng nhập.
     */
    const nguoiDungHienTai =
        docNguoiDungHienTai();


    if (
        nguoiDungHienTai !== null
        &&
        String(
            nguoiDungHienTai.id
        )
        ===
        String(
            idTaiKhoan
        )
    ) {

        dangXuat();
    }


    return true;
};