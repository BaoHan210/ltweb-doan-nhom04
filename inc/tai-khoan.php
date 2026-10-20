<?php
// inc/tai-khoan.php - Danh sách tài khoản Quản trị viên của nhóm (Mật khẩu chung: admin123)
return [
    'baohan@cookwithme.com' => [
        'id'       => 1,
        'ho_ten'   => 'Phan Thị Bảo Hân (Trưởng nhóm)',
        'email'    => 'baohan@cookwithme.com',
        'mat_khau' => password_hash('admin123', PASSWORD_DEFAULT)
    ],
    'ngoctrinh@cookwithme.com' => [
        'id'       => 2,
        'ho_ten'   => 'Nguyễn Thị Trinh',
        'email'    => 'ngoctrinh@cookwithme.com',
        'mat_khau' => password_hash('admin123', PASSWORD_DEFAULT)
    ],
    'ngocbinh@cookwithme.com' => [
        'id'       => 3,
        'ho_ten'   => 'Nguyễn Thị Ngọc Bình',
        'email'    => 'ngocbinh@cookwithme.com',
        'mat_khau' => password_hash('admin123', PASSWORD_DEFAULT)
    ],
    'ana@cookwithme.com' => [
        'id'       => 4,
        'ho_ten'   => 'Lê Thị A Na',
        'email'    => 'ana@cookwithme.com',
        'mat_khau' => password_hash('admin123', PASSWORD_DEFAULT)
    ]
];