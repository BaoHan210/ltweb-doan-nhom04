/** Cook with me - BTN6: progressive enhancement cho trang yeu-thich.
 * Neu API loi thi bieu mau POST PHP goc van su dung duoc.
 */
(() => {
  'use strict';
  const main = document.querySelector('.trang-yeu-thich');
  const table = main?.querySelector('.bang-gio-hang');
  if (!table) return;
  const endpoint = new URL('api/gio-hang.php', document.baseURI);
  let csrf = '';
  let sanSang = false;
  let busy = false;
  const fmt = n => Number(n).toLocaleString('vi-VN') + 'đ';
  const alert = document.createElement('p');
  alert.setAttribute('role', 'status');
  alert.setAttribute('aria-live', 'polite');
  table.insertAdjacentElement('beforebegin', alert);

  function rowFor(slug) {
    return [...table.tBodies[0].rows].find(row => row.querySelector('input[name="id_mon"]')?.value === slug);
  }

  function sync(data) {
    if (!data || !Array.isArray(data.mon)) return;
    const map = new Map(data.mon.map(m => [m.id, m]));
    for (const row of [...table.tBodies[0].rows]) {
      const slug = row.querySelector('input[name="id_mon"]')?.value;
      if (!map.has(slug)) {
        row.remove();
        continue;
      }
      const mon = map.get(slug);
      const quantity = row.querySelector('input[name="so_luong"]');
      if (quantity) quantity.value = String(mon.so_luong);
      // 0: mon, 1: don gia, 2: so luong, 3: thanh tien, 4: thao tac
      if (row.cells[1]) row.cells[1].textContent = fmt(mon.don_gia);
      if (row.cells[3]) row.cells[3].textContent = fmt(mon.thanh_tien);
    }
    const label = table.tFoot?.rows[0]?.cells[0];
    const total = table.tFoot?.rows[0]?.cells[1];
    if (label) label.textContent = `Tổng tiền (${data.tong_so_phan} phần)`;
    if (total) {
      const strong = total.querySelector('strong');
      if (strong) strong.textContent = fmt(data.tong_tien);
      else total.textContent = fmt(data.tong_tien);
    }
    if (data.mon.length === 0) {
      const p = document.createElement('p');
      p.textContent = 'Danh sách đã trống. Tải lại trang để xem giao diện trống.';
      table.insertAdjacentElement('afterend', p);
      table.hidden = true;
    }
  }

  async function callApi(payload) {
    const resp = await fetch(endpoint, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
      credentials: 'same-origin',
      body: JSON.stringify({ ...payload, csrf_token: csrf }),
    });
    const body = await resp.json();
    if (!resp.ok || !body.success) throw new Error(body.error || `HTTP ${resp.status}`);
    csrf = body.csrf_token;
    sync(body.data);
  }

  async function init() {
    try {
      const resp = await fetch(endpoint, { credentials: 'same-origin', headers: { Accept: 'application/json' } });
      if (!resp.ok) return; // de nguyen form PHP
      const data = await resp.json();
      if (!data.success || typeof data.csrf_token !== 'string') return;
      csrf = data.csrf_token;
      sanSang = true;
    } catch (_) { /* Form PHP van duoc dung */ }
  }
  init();

  main.addEventListener('submit', async event => {
    const form = event.target;
    if (!(form instanceof HTMLFormElement) || !sanSang || busy || form.action !== new URL('yeu-thich.php', document.baseURI).href) return;
    const button = event.submitter;
    const action = button?.value;
    if (!['cap_nhat', 'xoa', 'xoa_het'].includes(action)) return;
    // Neu quantity khong hop le, browser xu ly theo form PHP.
    const slug = form.querySelector('input[name="id_mon"]')?.value;
    const qty = Number(form.querySelector('input[name="so_luong"]')?.value);
    if (action === 'cap_nhat' && (!Number.isInteger(qty) || qty < 1 || qty > 10)) return;
    event.preventDefault();
    busy = true;
    alert.textContent = 'Đang cập nhật...';
    try {
      await callApi({ hanh_dong: action, id_mon: slug, ...(action === 'cap_nhat' ? { so_luong: qty } : {}) });
      alert.textContent = 'Đã cập nhật thành công (không tải lại trang).';
    } catch (e) {
      // Khong gui lai tu dong: thao tac co the da thanh cong nhung mat ket noi.
      alert.textContent = (e.message || 'Lỗi API') + '. Có thể dùng form PHP sau khi tải lại trang.';
    } finally {
      busy = false;
    }
  });
})();
