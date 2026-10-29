# ltweb-doan-nhom04

**Bài thực hành nhóm 6 – PHP và MySQL**

**Nhóm 04 – Đề tài: Cook with me**

Cook with me là website chia sẻ công thức nấu ăn, hỗ trợ tìm kiếm, xem chi tiết món ăn, quản lý yêu thích, danh sách đi chợ, quản lý tài khoản và quản trị nội dung. Website được xây dựng bằng PHP, MySQL, HTML, CSS và JavaScript.

## 1. Yêu cầu môi trường

- PHP 8.1 trở lên, có các extension `pdo_mysql`, `mbstring`.
- MySQL hoặc MariaDB.
- Composer.
- Git và trình duyệt web hiện đại.
- Có thể sử dụng XAMPP để chạy Apache và MySQL.

Kiểm tra môi trường:

```bash
php -v
composer --version
php -m
```

Cấu hình kết nối CSDL nằm tại `inc/db.php`.

Theo cấu hình hiện tại của nhóm:

- Host: `127.0.0.1`
- Port: `3306`
- Database: `ltweb_nhom04`
- Username: `root`
- Password: để trống

Khi sử dụng môi trường khác, cần điều chỉnh thông tin kết nối trong `inc/db.php`.

## 2. Hướng dẫn cài đặt và chạy website

### 2.1. Tải mã nguồn

Kho GitHub:

https://github.com/BaoHan210/ltweb-doan-nhom04

```bash
git clone https://github.com/BaoHan210/ltweb-doan-nhom04.git
cd ltweb-doan-nhom04
```

### 2.2. Cài đặt Composer

```bash
composer install
```

Nếu cần tạo lại autoload:

```bash
composer dump-autoload
```

Thư mục `vendor/` được tạo sau khi cài đặt và không cần đưa lên GitHub.

### 2.3. Khởi tạo cơ sở dữ liệu

Khởi động MySQL/MariaDB.

Hai tệp SQL chính:

- `database/schema.sql`: Tạo CSDL, các bảng và ràng buộc.
- `database/seed.sql`: Nhập dữ liệu mẫu.

**Cảnh báo:** `schema.sql` có lệnh `DROP DATABASE IF EXISTS ltweb_nhom04`. Chỉ chạy trên môi trường thử nghiệm sau khi đã sao lưu dữ liệu cần giữ.

Có thể import bằng phpMyAdmin hoặc dòng lệnh MySQL.

Ví dụ dùng dòng lệnh:

```bash
mysql -u root -p < database/schema.sql
mysql -u root -p ltweb_nhom04 < database/seed.sql
```

Nếu tài khoản MySQL không có mật khẩu, có thể dùng `mysql -u root` thay cho `mysql -u root -p`.

Sau khi import, kiểm tra trong phpMyAdmin xem các bảng và dữ liệu mẫu đã được tạo thành công.

### 2.4. Chạy website bằng PHP

Mở terminal tại thư mục gốc dự án:

```bash
php -S localhost:8000
```

Truy cập:

http://localhost:8000

Dừng máy chủ bằng `Ctrl + C`.

### 2.5. Chạy website bằng XAMPP

Sao chép thư mục dự án vào `htdocs` của XAMPP, khởi động Apache và MySQL.

Ví dụ nếu thư mục là `C:\xampp\htdocs\ltweb-doan-nhom04` thì truy cập:

http://localhost/ltweb-doan-nhom04/

Đường dẫn thực tế phụ thuộc vào tên thư mục được đặt trong `htdocs`.

## 3. Tài khoản kiểm thử

| Thành viên | Email | Mật khẩu |
|---|---|---|
| Phan Thị Bảo Hân | `baohan@cookwithme.com` | `Han@2026Cook` |
| Nguyễn Thị Trinh | `ngoctrinh@cookwithme.com` | `Trinh@2026Cook` |
| Nguyễn Thị Ngọc Bình | `ngocbinh@cookwithme.com` | `Binh@2026Cook` |
| Lê Thị A Na | `ana@cookwithme.com` | `Na@2026Cook` |

**Lưu ý:** Đây là thông tin kiểm thử đang được ghi trong README của nhóm. Cần xác nhận các tài khoản hoạt động sau khi import `seed.sql`, đồng thời bảo đảm không dùng mật khẩu thật của các thành viên.

## 4. Bảng chức năng – URL – Tệp PHP

| Chức năng | URL | Tệp PHP |
|---|---|---|
| Trang chủ | `/` | `index.php` |
| Danh sách, tìm kiếm món ăn | `/danh-sach.php` | `danh-sach.php` |
| Chi tiết món ăn | `/chi-tiet.php?id=...` | `chi-tiet.php` |
| Danh sách yêu thích | `/yeu-thich.php` | `yeu-thich.php` |
| Danh sách đi chợ | `/goi-y-mon-an.php` | `goi-y-mon-an.php` |
| Liên hệ | `/lien-he.php` | `lien-he.php` |
| Đăng ký | `/dang-ky.php` | `dang-ky.php` |
| Đăng nhập | `/dang-nhap.php` | `dang-nhap.php` |
| Đăng xuất | `/dang-xuat.php` | `dang-xuat.php` |
| Quản trị | `/quan-tri.php` | `quan-tri.php` |
| Thêm món ăn | `/them-mon-an.php` | `them-mon-an.php` |
| Sửa món ăn | `/sua-mon-an.php?id=...` | `sua-mon-an.php` |
| Xóa món ăn | `/xoa-mon-an.php` | `xoa-mon-an.php` |
| Trang cá nhân Bình | `/thanhvien/3120224013_binh/gioithieu.php` | `thanhvien/3120224013_binh/gioithieu.php` |
| Trang cá nhân Hân | `/thanhvien/3120224045_baohan/gioithieu.php` | `thanhvien/3120224045_baohan/gioithieu.php` |
| Trang cá nhân Na | `/thanhvien/3120224096_lena/gioithieu.php` | `thanhvien/3120224096_lena/gioithieu.php` |
| Trang cá nhân Trinh | `/thanhvien/3120224155_trinh/gioithieu.php` | `thanhvien/3120224155_trinh/gioithieu.php` |

Các URL được tính từ thư mục gốc website. Những trang quản trị hoặc thao tác cập nhật dữ liệu có thể yêu cầu đăng nhập và quyền tương ứng.

## 5. API endpoints

| Phương thức | Endpoint | Chức năng |
|---|---|---|
| GET | `/api/mon-an.php?q=pho` | Tìm kiếm món ăn theo từ khóa |
| GET | `/api/mon-an.php?dm=...` | Lọc món theo danh mục |
| GET | `/api/mon-an.php?id=pho-bo` | Xem chi tiết món ăn theo slug |
| GET | `/api/gio-hang.php` | Đọc dữ liệu yêu thích/giỏ hàng của tài khoản |
| POST | `/api/gio-hang.php` | Thêm, cập nhật hoặc xóa dữ liệu yêu thích/giỏ hàng |

API món ăn trả dữ liệu JSON và chỉ hỗ trợ GET.

API giỏ hàng sử dụng phiên đăng nhập. Yêu cầu POST phải có `Content-Type: application/json` và CSRF token hợp lệ.

Ví dụ nội dung JSON cho API giỏ hàng:

```json
{
  "hanh_dong": "them",
  "id_mon": "pho-bo",
  "so_luong": 2,
  "csrf_token": "TOKEN_HOP_LE"
}
```

Các hành động hỗ trợ gồm `them`, `cap_nhat`, `xoa`, `xoa_het`.

Các mã phản hồi được dùng tùy tình huống, chẳng hạn `200`, `400`, `401`, `403`, `404`, `405` và `422`.

## 6. Cấu trúc thư mục chính

```text
ltweb-doan-nhom04/
├── api/
│   ├── mon-an.php
│   └── gio-hang.php
├── database/
│   ├── schema.sql
│   ├── seed.sql
│   └── erd.png
├── inc/
│   ├── config.php
│   ├── db.php
│   ├── ham.php
│   └── xac-thuc.php
├── src/
│   ├── Data/
│   ├── Models/
│   └── Services/
├── thanhvien/
│   ├── 3120224013_binh/
│   ├── 3120224045_baohan/
│   ├── 3120224096_lena/
│   └── 3120224155_trinh/
├── api.http
├── css/
├── js/
├── images/
├── kiemtra/
├── storage/
├── uploads/
├── index.php
├── danh-sach.php
├── chi-tiet.php
├── yeu-thich.php
├── goi-y-mon-an.php
├── lien-he.php
├── quan-tri.php
├── composer.json
├── composer.lock
├── .gitignore
└── README.md
```

Đây là cấu trúc tóm tắt các thư mục và tệp chính, không phải danh sách toàn bộ tệp.

## 7. Quản lý mã nguồn và đóng góp cá nhân

Nhóm sử dụng Git và GitHub để quản lý phiên bản, lưu lịch sử thay đổi và minh chứng đóng góp của từng thành viên.

Kho mã nguồn:

https://github.com/BaoHan210/ltweb-doan-nhom04

Lịch sử commit:

https://github.com/BaoHan210/ltweb-doan-nhom04/commits/main/

Mỗi thành viên thực hiện commit các tệp và chức năng được phân công. Lịch sử commit trên GitHub là căn cứ xác định đóng góp cá nhân.

Mã commit cuối cùng được ghi trong báo cáo bàn giao khi nhóm hoàn tất việc nộp bài.

## 8. Lưu ý khi kiểm thử

- Kiểm tra kết nối MySQL trước khi truy cập các chức năng sử dụng CSDL.
- Kiểm thử các biểu mẫu khi bật và tắt JavaScript.
- Kiểm tra phân quyền của tài khoản thường và tài khoản quản trị.
- Kiểm tra dữ liệu đầu vào không hợp lệ và các phản hồi HTTP.
- Kiểm tra PHP Warning/Notice và mã HTML bằng W3C Validator.
- Không đưa dữ liệu cá nhân thật, thông tin đăng nhập thật hoặc các tệp cấu hình chứa bí mật lên GitHub.

Các minh chứng kiểm thử được lưu trong thư mục `kiemtra/`.
