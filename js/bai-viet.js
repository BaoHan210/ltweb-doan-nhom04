/*
 * bai-viet.js
 * Quản lý danh sách bài viết do người dùng tạo.
 * Dữ liệu bài viết được lưu và đọc từ localStorage.
 */

const tenKhoaBaiViet = 'baiVietNguoiDung';


export const docBaiViet = () => {

    const duLieu =
        localStorage.getItem(
            tenKhoaBaiViet
        );

    if (duLieu === null) {
        return [];
    }

    try {

        const danhSach =
            JSON.parse(duLieu);

        if (Array.isArray(danhSach) === false) {
            return [];
        }

        return danhSach;

    } catch (error) {

        return [];
    }
};


export const ghiBaiViet = (
    danhSachBaiViet
) => {

    localStorage.setItem(
        tenKhoaBaiViet,
        JSON.stringify(
            danhSachBaiViet
        )
    );
};

const docHinhAnhThanhDataUrl = (tepHinhAnh) => {
    return new Promise((resolve, reject) => {

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
    });
};

export const chuyenHinhAnhThanhDataUrl = async (
    danhSachHinhAnh
) => {

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

export const themBaiViet = (
    baiViet
) => {

    const danhSach =
        docBaiViet();

    danhSach.unshift(
        baiViet
    );

    ghiBaiViet(
        danhSach
    );

    return baiViet;
};


export const xoaBaiViet = (
    idBaiViet
) => {

    const danhSach =
        docBaiViet();

    const danhSachMoi =
        danhSach.filter(
            (baiViet) => {
                return baiViet.id !== idBaiViet;
            }
        );

    ghiBaiViet(
        danhSachMoi
    );
};

export const capNhatBaiViet = (
    idBaiViet,
    userId,
    duLieuMoi
) => {

    const danhSach =
        docBaiViet();

    const viTri =
        danhSach.findIndex(
            (baiViet) => {
                return (
                    baiViet.id === idBaiViet
                    && baiViet.userId === userId
                );
            }
        );

    if (viTri === -1) {
        return false;
    }

    danhSach[viTri] = {
        ...danhSach[viTri],
        ...duLieuMoi
    };

    ghiBaiViet(danhSach);

    return true;
};