ltweb-doan-nhom04
Dự án Lập trình Web - Cook with me (Nhóm 04)

Website chia sẻ công thức nấu ăn, gợi ý món ngon, lưu trữ món ăn yêu thích và kết nối cộng đồng yêu ẩm thực.

1. Hướng dẫn cài đặt và khởi chạy dự án
Cách 1: Chạy bằng PHP Built-in Server (Khuyên dùng)
Mở Terminal / Git Bash tại thư mục gốc của dự án (ltweb-doan-nhom04).

Cập nhật trình tự động nạp Autoload của Composer (nếu chưa chạy):
composer dump-autoload

Khởi động server PHP tích hợp:
php -S localhost:8000

Truy cập website trên trình duyệt theo địa chỉ: http://localhost:8000

Cách 2: Chạy bằng XAMPP (Apache)
Sao chép thư mục dự án vào thư mục htdocs của XAMPP theo đường dẫn:

C:\xampp\htdocs\ltweb-doan-nhom04

Mở XAMPP Control Panel và nhấn Start dịch vụ Apache.

Truy cập website trên trình duyệt theo địa chỉ: http://localhost/ltweb-doan-nhom04

2. Tài khoản thử nghiệm Quản trị
Hệ thống hỗ trợ tài khoản quản trị viên cho cả 4 thành viên trong nhóm để phục vụ việc kiểm thử trang Quản trị (quan-tri.php).

Mật khẩu chung cho tất cả tài khoản: admin123

Phan Thị Bảo Hân (Trưởng nhóm): baohan@cookwithme.com

Nguyễn Thị Trinh (Thành viên): ngoctrinh@cookwithme.com

Nguyễn Thị Ngọc Bình (Thành viên): ngocbinh@cookwithme.com

Lê Thị A Na (Thành viên): ana@cookwithme.com

3. Danh sách các trang chính & URL chức năng
Trang chủ: index.php (Khám phá món ăn nổi bật, gợi ý từ API và danh sách xem gần đây)

Khám phá món ăn: danh-sach.php (Tìm kiếm từ khóa, lọc theo danh mục, sắp xếp món ăn)

Chi tiết món ăn: chi-tiet.php?id=1 (Xem nguyên liệu, các bước chế biến và lưu Cookie đã xem)

Danh sách yêu thích: yeu-thich.php (Quản lý các món ăn đã lưu)

Gợi ý món ăn: goi-y-mon-an.php (Tìm món ngon theo nguyên liệu có sẵn)

Đăng bài viết: dang-bai-viet.php (Chia sẻ công thức nấu ăn mới)

Liên hệ & Góp ý: lien-he.php (Gửi phản hồi, đính kèm hình ảnh)

Đăng nhập hệ thống: dang-nhap.php (Xác thực tài khoản người dùng / quản trị viên)

Trang quản trị liên hệ: quan-tri.php (Yêu cầu đăng nhập - Xem thư liên hệ đã nhận)

Đăng xuất: dang-xuat.php (Hủy phiên làm việc người dùng)

Trang giới thiệu dự án: gioi-thieu.php

Trang cá nhân thành viên: thanhvien/3120224045_baohan/gioithieu.php

4. Cấu trúc thư mục dự án
ltweb-doan-nhom04/
├── 404.php                     # Trang báo lỗi 404 Not Found
├── 500.php                     # Trang báo lỗi 500 Internal Server Error
├── index.php                   # Trang chủ
├── danh-sach.php               # Trang danh sách & lọc món ăn
├── chi-tiet.php                # Trang chi tiết món ăn
├── yeu-thich.php               # Trang danh sách món ăn yêu thích
├── goi-y-mon-an.php            # Trang gợi ý món ăn
├── dang-bai-viet.php           # Trang đăng bài viết mới
├── lien-he.php                 # Trang gửi biểu mẫu liên hệ
├── dang-nhap.php               # Trang đăng nhập
├── dang-xuat.php               # Trang đăng xuất
├── quan-tri.php                # Trang quản trị xem thư liên hệ
├── gioi-thieu.php              # Trang giới thiệu
├── ca-nhan.php                 # Trang cá nhân người dùng
├── cai-dat.php                 # Trang cài đặt tài khoản
├── nguoi-dung.php              # Trang danh sách người dùng
├── composer.json               # Cấu hình Composer Autoload (PSR-4)
├── .gitignore                  # Cấu hình bỏ qua thư mục/file khi commit
├── README.md                   # Tài liệu hướng dẫn dự án
├── inc/                        # Thành phần dùng chung
│   ├── config.php              # Cấu hình hệ thống, session, báo lỗi
│   ├── ham.php                 # Các hàm tiện ích dùng chung
│   ├── header.php              # Header và Menu điều hướng
│   ├── footer.php              # Footer dùng chung
│   ├── bao-ve.php              # Kiểm tra quyền truy cập bảo vệ trang quản trị
│   └── tai-khoan.php           # Danh sách tài khoản thử nghiệm băm mật khẩu
├── src/                        # Mã nguồn ứng dụng (App)
│   ├── Data/                   # Lớp truy xuất dữ liệu (KhoMonAn.php)
│   ├── Models/                 # Lớp đối tượng (MonAn.php)
│   └── Services/               # Lớp dịch vụ nghiệp vụ (LienHeService.php, YeuThichService.php)
├── data/                       # Chứa dữ liệu mẫu (mon-an.json)
├── storage/                    # Chứa dữ liệu ghi log phản hồi (lien-he.jsonl, .htaccess)
├── logs/                       # Chứa log truy cập lỗi hệ thống (access-error.log, .htaccess)
├── uploads/                    # Thư mục lưu ảnh người dùng tải lên (.gitkeep)
├── css/                        # Các tệp định dạng giao diện Modular CSS
├── js/                         # Các tệp xử lý JavaScript phía Client
├── images/                     # Hình ảnh tài nguyên của website
└── thanhvien/                  # Trang giới thiệu cá nhân các thành viên