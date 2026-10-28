/** Cook with me - BTN6: tim kiem goi y qua Fetch API, debounce 350ms.
 * Form GET cu va phan trang PHP luon la phuong an du phong.
 */
(() => {
  'use strict';
  const form = document.getElementById('o-tim-mon-an');
  const input = document.getElementById('tim-mon-an');
  if (!form || !input) return;

  const goiY = document.createElement('div');
  goiY.id = 'goi-y-mon-an-api';
  goiY.setAttribute('role', 'status');
  goiY.setAttribute('aria-live', 'polite');
  goiY.style.cssText = 'padding:8px 0;max-width:550px;';
  form.insertAdjacentElement('afterend', goiY);

  let timer;
  let request;
  const endpoint = new URL('api/mon-an.php', document.baseURI);
  const donGia = n => Number(n).toLocaleString('vi-VN') + 'đ';

  function taoKetQua(mon) {
    const link = document.createElement('a');
    link.href = new URL('chi-tiet.php?id=' + encodeURIComponent(mon.id), document.baseURI).href;
    link.style.cssText = 'display:block;padding:8px 10px;border-bottom:1px solid #eee;';
    // textContent: khong bien du lieu tu API thanh HTML.
    link.textContent = `${mon.ten} · ${mon.thoi_gian} phút · ${donGia(mon.ngan_sach)}`;
    return link;
  }

  async function timKiem() {
    const q = input.value.trim();
    if (request) request.abort();
    goiY.replaceChildren();
    if (q.length < 2) return;
    request = new AbortController();
    const signal = request.signal;
    const url = new URL(endpoint);
    url.searchParams.set('q', q);
    const dm = form.querySelector('input[name="dm"]')?.value;
    if (dm) url.searchParams.set('dm', dm);
    try {
      const response = await fetch(url, { signal, headers: { Accept: 'application/json' } });
      if (!response.ok) throw new Error('HTTP ' + response.status);
      const body = await response.json();
      if (!body.success || !Array.isArray(body.data)) throw new Error('API tra du lieu khong hop le');
      // Bo qua phan hoi cu neu nguoi dung da go tiep.
      if (input.value.trim() !== q) return;
      const title = document.createElement('p');
      title.textContent = `Gợi ý: ${body.data.length} món (tối đa 50)`;
      goiY.append(title);
      if (!body.data.length) {
        const msg = document.createElement('p');
        msg.textContent = 'Không có món phù hợp. Nhấn Tìm kiếm để xem kết quả đầy đủ.';
        goiY.append(msg);
      }
      for (const mon of body.data.slice(0, 8)) goiY.append(taoKetQua(mon));
      const full = document.createElement('button');
      full.type = 'submit';
      full.className = 'nut';
      full.textContent = 'Xem tất cả kết quả và bộ lọc';
      goiY.append(full);
    } catch (e) {
      if (e.name === 'AbortError') return;
      const msg = document.createElement('p');
      msg.textContent = 'Không tải được gợi ý. Bạn vẫn có thể nhấn nút Tìm kiếm.';
      goiY.replaceChildren(msg);
    }
  }

  input.addEventListener('input', () => {
    clearTimeout(timer);
    timer = setTimeout(timKiem, 350);
  });
})();
