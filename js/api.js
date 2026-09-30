/*
 * api.js
 * Cung cấp hàm tải dữ liệu JSON cho website Cook with me.
 * Kiểm tra trạng thái phản hồi trước khi trả về dữ liệu.
 */

export const taiJSON = async (url) => {
  const res = await fetch(url);

  if (!res.ok) {
    throw new Error(`Không thể tải dữ liệu: ${res.status}`);
  }

  return res.json();
};