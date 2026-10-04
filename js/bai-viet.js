/*
 * bai-viet.js
 * Quản lý danh sách bài viết do người dùng tạo.
 * Dữ liệu bài viết được lưu và đọc từ localStorage.
 */

const tenKhoaBaiViet =
    'baiVietNguoiDung';


/* =========================================================
   1. ĐỌC DANH SÁCH BÀI VIẾT
   ========================================================= */

export const docBaiViet = () => {

    try {

        const duLieu =
            localStorage.getItem(
                tenKhoaBaiViet
            );

        if (duLieu === null) {
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
            'Không thể đọc danh sách bài viết:',
            error
        );

        return [];
    }
};


/* =========================================================
   2. GHI DANH SÁCH BÀI VIẾT
   ========================================================= */

export const ghiBaiViet = (
    danhSachBaiViet
) => {

    if (
        Array.isArray(
            danhSachBaiViet
        ) === false
    ) {
        return false;
    }

    try {

        localStorage.setItem(
            tenKhoaBaiViet,
            JSON.stringify(
                danhSachBaiViet
            )
        );

        return true;

    } catch (error) {

        console.error(
            'Không thể lưu danh sách bài viết:',
            error
        );

        return false;
    }
};


/* =========================================================
   3. CHUYỂN HÌNH ẢNH THÀNH DATA URL
   ========================================================= */

const docHinhAnhThanhDataUrl = (
    tepHinhAnh
) => {

    return new Promise(
        (resolve, reject) => {

            if (
                tepHinhAnh instanceof File
                === false
            ) {
                reject(
                    new Error(
                        'Tệp hình ảnh không hợp lệ.'
                    )
                );

                return;
            }

            const boDocFile =
                new FileReader();

            boDocFile.addEventListener(
                'load',
                () => {

                    resolve(
                        boDocFile.result
                    );
                }
            );

            boDocFile.addEventListener(
                'error',
                () => {

                    reject(
                        new Error(
                            'Không thể đọc hình ảnh.'
                        )
                    );
                }
            );

            boDocFile.readAsDataURL(
                tepHinhAnh
            );
        }
    );
};


export const chuyenHinhAnhThanhDataUrl = async (
    danhSachHinhAnh
) => {

    if (
        Array.isArray(
            danhSachHinhAnh
        ) === false
    ) {
        return [];
    }

    const danhSachDataUrl = [];

    for (
        const tepHinhAnh of danhSachHinhAnh
    ) {

        const dataUrl =
            await docHinhAnhThanhDataUrl(
                tepHinhAnh
            );

        danhSachDataUrl.push(
            dataUrl
        );
    }

    return danhSachDataUrl;
};


/* =========================================================
   4. THÊM BÀI VIẾT
   ========================================================= */

export const themBaiViet = (
    baiViet
) => {

    if (
        baiViet === null
        ||
        typeof baiViet !== 'object'
        ||
        Array.isArray(baiViet)
    ) {
        return null;
    }

    const danhSach =
        docBaiViet();

    danhSach.unshift(
        baiViet
    );

    const luuThanhCong =
        ghiBaiViet(
            danhSach
        );

    if (
        luuThanhCong === false
    ) {
        return null;
    }

    return baiViet;
};


/* =========================================================
   5. XÓA BÀI VIẾT
   ========================================================= */

export const xoaBaiViet = (
    idBaiViet
) => {

    const danhSach =
        docBaiViet();

    const danhSachMoi =
        danhSach.filter(
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
                    !==
                    String(
                        idBaiViet
                    )
                );
            }
        );

    if (
        danhSachMoi.length
        ===
        danhSach.length
    ) {
        return false;
    }

    return ghiBaiViet(
        danhSachMoi
    );
};


/* =========================================================
   6. CẬP NHẬT BÀI VIẾT
   ========================================================= */

export const capNhatBaiViet = (
    idBaiViet,
    userId,
    duLieuMoi
) => {

    if (
        duLieuMoi === null
        ||
        typeof duLieuMoi !== 'object'
        ||
        Array.isArray(duLieuMoi)
    ) {
        return false;
    }

    const danhSach =
        docBaiViet();

    const viTri =
        danhSach.findIndex(
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
                    &&
                    String(
                        baiViet.userId
                    )
                    ===
                    String(
                        userId
                    )
                );
            }
        );

    if (
        viTri === -1
    ) {
        return false;
    }

    danhSach[viTri] = {
        ...danhSach[viTri],
        ...duLieuMoi,
        id:
            danhSach[viTri].id,
        userId:
            danhSach[viTri].userId
    };

    return ghiBaiViet(
        danhSach
    );
};