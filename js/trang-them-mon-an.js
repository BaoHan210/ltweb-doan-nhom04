const danhSach = document.getElementById('danh-sach-nguyen-lieu');
const nutThem = document.getElementById('nut-them-nguyen-lieu');

if (danhSach && nutThem) {
    nutThem.addEventListener('click', () => {
    const cacDong = danhSach.querySelectorAll('.dong-nguyen-lieu');

    if (cacDong.length >= 50) {
        alert('Chỉ được phép thêm tối đa 50 nguyên liệu.');
        return;
    }

    const dong = document.createElement('div');
        dong.className = 'dong-nguyen-lieu';

        const oTen = document.createElement('div');
        const nhanTen = document.createElement('label');
        nhanTen.textContent = 'Tên nguyên liệu';

        const inputTen = document.createElement('input');
        inputTen.type = 'text';
        inputTen.name = 'nguyen_lieu_ten[]';
        inputTen.maxLength = 150;
        inputTen.className = 'o-nhap-mon-an';
        inputTen.placeholder = 'Ví dụ: Thịt bò';

        oTen.append(nhanTen, inputTen);

        const oSoLuong = document.createElement('div');
        const nhanSoLuong = document.createElement('label');
        nhanSoLuong.textContent = 'Số lượng';

        const inputSoLuong = document.createElement('input');
        inputSoLuong.type = 'text';
        inputSoLuong.name = 'nguyen_lieu_so_luong[]';
        inputSoLuong.maxLength = 100;
        inputSoLuong.className = 'o-nhap-mon-an';
        inputSoLuong.placeholder = 'Ví dụ: 200 g';

        oSoLuong.append(nhanSoLuong, inputSoLuong);

        const nutXoa = document.createElement('button');
        nutXoa.type = 'button';
        nutXoa.className = 'nut nut-xoa-nguyen-lieu';
        nutXoa.dataset.hanhDong = 'xoa-nguyen-lieu';
        nutXoa.textContent = 'Xóa';

        dong.append(oTen, oSoLuong, nutXoa);
        danhSach.appendChild(dong);
    });

    danhSach.addEventListener('click', (event) => {
        const nutXoa = event.target.closest(
            '[data-hanh-dong="xoa-nguyen-lieu"]'
        );

        if (!nutXoa) {
            return;
        }

        const cacDong = danhSach.querySelectorAll('.dong-nguyen-lieu');

        if (cacDong.length === 1) {
            cacDong[0].querySelectorAll('input').forEach((input) => {
                input.value = '';
            });
        } else {
            nutXoa.closest('.dong-nguyen-lieu').remove();
        }
    });
}
