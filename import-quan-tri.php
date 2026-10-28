
<?php
/**
 * Nhập 4 tài khoản quản trị viên của nhóm 04 vào MySQL.
 *
 * Chỉ chạy bằng Terminal:
 * php import-quan-tri.php
 *
 * Sau khi nhập xong phải xóa file này.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Khong cho phep truy cap qua trinh duyet.');
}

use App\Data\KhoNguoiDung;

require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/src/Data/KhoNguoiDung.php';

// Danh sách tài khoản nhóm 04
$thanhVienNhom = [
    [
        'ho_ten' => 'Phan Thị Bảo Hân (Trưởng nhóm)',
        'email' => 'baohan@cookwithme.com',
        'mat_khau' => 'Han@2026Cook'
    ],
    [
        'ho_ten' => 'Nguyễn Thị Trinh',
        'email' => 'ngoctrinh@cookwithme.com',
        'mat_khau' => 'Trinh@2026Cook'
    ],
    [
        'ho_ten' => 'Nguyễn Thị Ngọc Bình',
        'email' => 'ngocbinh@cookwithme.com',
        'mat_khau' => 'Binh@2026Cook'
    ],
    [
        'ho_ten' => 'Lê Thị A Na',
        'email' => 'ana@cookwithme.com',
        'mat_khau' => 'Ana@2026Cook'
    ]
];

$khoNguoiDung = new KhoNguoiDung(db());

echo "BAT DAU NHAP TAI KHOAN NHOM 04\n";
echo "--------------------------------\n";

foreach ($thanhVienNhom as $thanhVien) {

    $hoTen = $thanhVien['ho_ten'];
    $email = $thanhVien['email'];
    $matKhau = $thanhVien['mat_khau'];

    // Kiểm tra tài khoản đã tồn tại chưa
    if ($khoNguoiDung->emailDaTonTai($email)) {

        echo "[BO QUA] {$email} da ton tai.\n";
        continue;
    }

    // Thêm tài khoản quản trị vào MySQL
    // Mật khẩu được băm trong phương thức themQuanTriNhom()
    $ketQua = $khoNguoiDung->themQuanTriNhom(
        $hoTen,
        $email,
        $matKhau
    );

    if ($ketQua) {

        echo "[THANH CONG] {$hoTen}\n";
        echo "Email: {$email}\n";
        echo "Vai tro: quan_tri\n";
        echo "--------------------------------\n";

    } else {

        echo "[THAT BAI] {$email}\n";
    }
}

echo "\nHOAN THANH NHAP TAI KHOAN.\n";
