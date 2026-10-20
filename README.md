# ltweb-doan-nhom04

**Dự án Lập trình Web - Cook with me (Nhóm 04)**

Cook with me là website chia sẻ công thức nấu ăn, hỗ trợ người dùng khám phá món ăn, xem hướng dẫn chế biến, lưu món ăn yêu thích và tìm kiếm gợi ý món ăn phù hợp. Dự án được xây dựng bằng PHP, HTML, CSS và JavaScript.

## 1. Yêu cầu môi trường

Để cài đặt và chạy dự án, cần chuẩn bị các công cụ sau:

- PHP phiên bản 8.1 trở lên.
- Composer.
- Trình duyệt web hiện đại.
- Git để quản lý và cập nhật mã nguồn.

Kiểm tra phiên bản PHP:

php -v

Kiểm tra Composer:

composer --version

## 2. Cài đặt và chạy dự án

### 2.1. Tải mã nguồn

Kho mã nguồn GitHub:

https://github.com/BaoHan210/ltweb-doan-nhom04.git

Nếu chưa có mã nguồn trên máy, sử dụng lệnh:

git clone https://github.com/BaoHan210/ltweb-doan-nhom04.git

Di chuyển vào thư mục dự án vừa tải:

cd ltweb-doan-nhom04

Nếu đã có thư mục `ltweb-doan-nhom04-main` trên máy, mở terminal tại thư mục đó và thực hiện các bước tiếp theo.

### 2.2. Cài đặt thư viện

Tại thư mục gốc dự án, chạy:

composer install

Nếu cần tạo lại bản đồ tự động nạp lớp của Composer, chạy:

composer dump-autoload

### 2.3. Chạy bằng PHP tích hợp sẵn

Mở terminal tại thư mục gốc dự án và chạy:

php -S localhost:8000

Sau khi máy chủ khởi động, mở trình duyệt và truy cập:

http://localhost:8000

Giữ cửa sổ terminal đang chạy máy chủ trong suốt quá trình sử dụng website. Nhấn `Ctrl + C` để dừng máy chủ.

### 2.4. Chạy bằng XAMPP

Nếu sử dụng XAMPP, đặt thư mục dự án tại đường dẫn:

C:\xampp\htdocs\ltweb-doan-nhom04-main

Khởi động Apache trong XAMPP Control Panel, sau đó truy cập:

http://localhost/ltweb-doan-nhom04-main/

Nếu thư mục dự án được đặt tại vị trí khác, cần điều chỉnh đường dẫn truy cập cho phù hợp.

**Lưu ý:** Chạy bằng XAMPP và chạy bằng lệnh `php -S localhost:8000` là hai cách khởi động khác nhau. Khi kiểm tra bài tập, cần bảo đảm dự án hoạt động theo lệnh chạy PHP tích hợp sẵn được yêu cầu.

## 3. Tài khoản kiểm thử

Các tài khoản dưới đây được cung cấp để phục vụ việc kiểm thử chức năng đăng nhập và quản trị.

| STT | Họ và tên | Tài khoản | Mật khẩu |
|---|---|---|---|
| 1 | Phan Thị Bảo Hân | `baohan@cookwithme.com` | `admin123` |
| 2 | Nguyễn Thị Trinh | `ngoctrinh@cookwithme.com` | `admin123` |
| 3 | Nguyễn Thị Ngọc Bình | `ngocbinh@cookwithme.com` | `admin123` |
| 4 | Lê Thị A Na | `ana@cookwithme.com` | `admin123` |

Lưu ý: Đây là thông tin tài khoản kiểm thử được cung cấp trong tài liệu dự án. Cần xác nhận các tài khoản và mật khẩu còn hoạt động trong mã nguồn hiện tại trước khi nộp bài.

## 4. Danh sách chức năng

| Chức năng | URL | Tệp PHP |
|---|---|---|
| Trang chủ | `/` | `index.php` |
| Khám phá món ăn | `/danh-sach.php` | `danh-sach.php` |
| Chi tiết món ăn | `/chi-tiet.php?id=1` | `chi-tiet.php` |
| Danh sách yêu thích | `/yeu-thich.php` | `yeu-thich.php` |
| Gợi ý món ăn | `/goi-y-mon-an.php` | `goi-y-mon-an.php` |
| Đăng bài viết | `/dang-bai-viet.php` | `dang-bai-viet.php` |
| Liên hệ và góp ý | `/lien-he.php` | `lien-he.php` |
| Đăng nhập | `/dang-nhap.php` | `dang-nhap.php` |
| Trang quản trị liên hệ | `/quan-tri.php` | `quan-tri.php` |
| Đăng xuất | `/dang-xuat.php` | `dang-xuat.php` |
| Giới thiệu | `/gioi-thieu.php` | `gioi-thieu.php` |
| Trang giới thiệu cá nhân | `/thanhvien/3120224045_baohan/gioithieu.php` | `thanhvien/3120224045_baohan/gioithieu.php` |

Các URL trong bảng được trình bày theo đường dẫn tương đối từ thư mục gốc dự án. Một số chức năng có thể yêu cầu người dùng đăng nhập hoặc có quyền truy cập phù hợp.

## 5. Cấu trúc thư mục

ltweb-doan-nhom04-main/
├── 404.php
├── 500.php
├── index.php
├── danh-sach.php
├── chi-tiet.php
├── yeu-thich.php
├── goi-y-mon-an.php
├── dang-bai-viet.php
├── lien-he.php
├── dang-nhap.php
├── dang-xuat.php
├── quan-tri.php
├── gioi-thieu.php
├── ca-nhan.php
├── cai-dat.php
├── nguoi-dung.php
├── composer.json
├── .gitignore
├── README.md
├── inc/
│   ├── config.php
│   ├── ham.php
│   ├── header.php
│   ├── footer.php
│   ├── bao-ve.php
│   └── tai-khoan.php
├── src/
│   ├── Data/
│   │   └── KhoMonAn.php
│   ├── Models/
│   │   └── MonAn.php
│   └── Services/
│       ├── LienHeService.php
│       └── YeuThichService.php
├── data/
│   └── mon-an.json
├── storage/
│   ├── lien-he.jsonl
│   └── .htaccess
├── logs/
│   ├── access-error.log
│   └── .htaccess
├── uploads/
│   └── .gitkeep
├── css/
├── js/
├── images/
└── thanhvien/

Cấu trúc trên thể hiện các thư mục và tệp chính của dự án. Các thư mục `css/`, `js/`, `images/` và `thanhvien/` có thể chứa thêm các tệp con phục vụ giao diện và chức năng website.
