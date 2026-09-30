/*
 * yeu-thich.js
 * Quản lý danh sách món ăn yêu thích của người dùng.
 * Dữ liệu yêu thích được lưu và đọc từ localStorage.
 */

const TEN_KHOA_YEU_THICH = 'monAnYeuThich';

export const docYeuThich = () => {
  const duLieu = localStorage.getItem(TEN_KHOA_YEU_THICH);

  if (duLieu === null) {
    return [];
  }

  try {
    const danhSach = JSON.parse(duLieu);

    if (Array.isArray(danhSach) === false) {
      return [];
    }

    return danhSach;
  } catch (error) {
    return [];
  }
};

export const ghiYeuThich = (danhSach) => {
  localStorage.setItem(
    TEN_KHOA_YEU_THICH,
    JSON.stringify(danhSach)
  );

  window.dispatchEvent(
    new CustomEvent('yeuThichThayDoi')
  );
};

export const kiemTraYeuThich = (id) => {
  const danhSach = docYeuThich();

  return danhSach.includes(id);
};

export const doiTrangThaiYeuThich = (id) => {
  const danhSach = docYeuThich();

  if (danhSach.includes(id)) {
    const danhSachMoi = danhSach.filter((itemId) => {
      return itemId !== id;
    });

    ghiYeuThich(danhSachMoi);

    return false;
  }

  danhSach.push(id);
  ghiYeuThich(danhSach);

  return true;
};