/*
 * gio-hang-them.js
 * Thêm hoặc bỏ món khỏi giỏ bằng API, không tải lại trang.
 * Không có JavaScript: form POST vẫn chạy nhờ hidden input doi_yeu_thich.
 */
(() => {
  'use strict';
  const form = document.querySelector('.form-them-gio');
  if (!form) return;

  const nut = form.querySelector('button');
  const thongBao = document.querySelector('.thong-bao-gio');
  const idMon = form.dataset.idMon;
  const api = new URL('api/gio-hang.php', document.baseURI);
  let csrf = '';
  let dang = false;

  const hienThi = (noiDung) => { if (thongBao) thongBao.textContent = noiDung; };

  function capNhatHeader(soMon) {
    document.querySelectorAll('.so-luong-yeu-thich').forEach((el) => {
      el.textContent = String(soMon);
    });
  }

  function capNhatNut(daCo) {
    nut.textContent = daCo ? '♥ Đã có trong giỏ' : '♡ Thêm vào giỏ';
    nut.setAttribute('aria-pressed', daCo ? 'true' : 'false');
  }

  async function goi(payload) {
    const resp = await fetch(api, {
      method: payload ? 'POST' : 'GET',
      credentials: 'same-origin',
      headers: payload
        ? { 'Content-Type': 'application/json', Accept: 'application/json' }
        : { Accept: 'application/json' },
      body: payload ? JSON.stringify({ ...payload, csrf_token: csrf }) : undefined,
    });
    const body = await resp.json();
    if (!resp.ok || !body.success) throw new Error(body.loi || 'Có lỗi xảy ra.');
    csrf = body.csrf_token;
    return body.data;
  }

  // Khởi tạo: lấy csrf và trạng thái hiện tại của món
  goi(null)
    .then((data) => {
      capNhatNut(data.mon.some((m) => m.id === idMon));
      capNhatHeader(data.mon.length);
    })
    .catch(() => { /* Không lấy được API: form POST thường vẫn hoạt động */ });

  form.addEventListener('submit', async (event) => {
    if (!csrf) return;                      // chưa có API → để trình duyệt gửi form
    event.preventDefault();
    if (dang) return;
    dang = true;
    nut.disabled = true;
    try {
      const dangCo = nut.getAttribute('aria-pressed') === 'true';
      const data = await goi({ hanh_dong: dangCo ? 'xoa' : 'them', id_mon: idMon });
      const daCo = data.mon.some((m) => m.id === idMon);
      capNhatNut(daCo);
      capNhatHeader(data.mon.length);
      hienThi(daCo ? 'Đã thêm món vào giỏ.' : 'Đã bỏ món khỏi giỏ.');
    } catch (e) {
      hienThi(e.message);                   // textContent: không chèn HTML
    } finally {
      dang = false;
      nut.disabled = false;
    }
  });
})();