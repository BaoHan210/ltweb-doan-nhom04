ltweb-doan-nhom04
Bài thực hành nhóm 6 – PHP và MySQL

Nhóm 04 – Đề tài: Cook with me

Cook with me là website chia sẻ công thức nấu ăn, hỗ trợ tìm kiếm, xem chi tiết món ăn, quản lý yêu thích, danh sách đi chợ, quản lý tài khoản và quản trị nội dung. Website được xây dựng bằng PHP, MySQL, HTML, CSS và JavaScript.
1. Yêu cầu môi trường
- PHP 8.1 trở lên, có các extension pdo_mysql, mbstring.
- MySQL hoặc MariaDB.
- Composer.
- Git và trình duyệt web hiện đại.
- Có thể sử dụng XAMPP để chạy Apache và MySQL.
Kiểm tra môi trường:
php -v
composer --version
php -m
Cấu hình kết nối cơ sở dữ liệu được quản lý bằng tệp .env tại thư mục gốc dự án. Tệp inc/db.php sử dụng các biến môi trường để kết nối CSDL.

Các thông số kết nối mẫu:
- Host: 127.0.0.1
- Port: 3306
- Database: ltweb_nhom04
- Username: nhom04_app
- Password: được cấu hình riêng trong .env
Website không sử dụng tài khoản root để kết nối CSDL. Tài khoản ứng dụng nhom04_app chỉ được cấp các quyền SELECT, INSERT, UPDATE, DELETE trên CSDL ltweb_nhom04.
2. Hướng dẫn cài đặt và chạy website
2.1. Tải mã nguồn
Kho GitHub:

https://github.com/BaoHan210/ltweb-doan-nhom04
git clone https://github.com/BaoHan210/ltweb-doan-nhom04.git
cd ltweb-doan-nhom04
2.2. Cài đặt Composer
Tại thư mục gốc dự án, chạy:
composer install
Nếu cần tạo lại autoload:
composer dump-autoload
Thư mục vendor/ được tạo sau khi cài đặt và không cần đưa lên GitHub.
2.3. Khởi tạo cơ sở dữ liệu
Khởi động MySQL/MariaDB.

Hai tệp SQL chính:
- database/schema.sql: Tạo CSDL, các bảng và ràng buộc.
- database/seed.sql: Nhập dữ liệu mẫu.
Cảnh báo: database/schema.sql có lệnh DROP DATABASE IF EXISTS ltweb_nhom04. Chỉ chạy trên môi trường thử nghiệm sau khi đã sao lưu dữ liệu cần giữ.

Có thể import bằng phpMyAdmin hoặc dòng lệnh MySQL.

Ví dụ dùng dòng lệnh:
mysql -u root -p < database/schema.sql
mysql -u root -p ltweb_nhom04 < database/seed.sql
Nếu tài khoản MySQL không có mật khẩu, có thể dùng mysql -u root thay cho mysql -u root -p.

Sau khi import, kiểm tra trong phpMyAdmin để xác nhận CSDL, các bảng và dữ liệu mẫu đã được tạo thành công.
2.4. Tạo tài khoản MySQL cho ứng dụng
Sau khi khởi tạo CSDL, tạo tài khoản riêng cho website thay vì sử dụng root khi chạy ứng dụng.

Tệp database/tai-khoan.sql chứa các câu lệnh tạo tài khoản nhom04_app và cấp các quyền tối thiểu:
- SELECT: đọc dữ liệu.
- INSERT: thêm dữ liệu.
- UPDATE: cập nhật dữ liệu.
- DELETE: xóa dữ liệu.
Trước khi thực thi trên một môi trường mới, mở database/tai-khoan.sql và thay mật khẩu mẫu THAY_BANG_MAT_KHAU_RIENG bằng một mật khẩu mạnh do người triển khai tự đặt.

Chạy tệp SQL bằng tài khoản quản trị MySQL thông qua phpMyAdmin hoặc dòng lệnh:
mysql -u root -p < database/tai-khoan.sql
Lệnh trên cần được thực hiện sau khi CSDL ltweb_nhom04 đã được tạo. Tài khoản quản trị chỉ được dùng để khởi tạo CSDL và cấp quyền; website sử dụng tài khoản nhom04_app để kết nối.

Lưu ý: Nếu tài khoản nhom04_app đã tồn tại, CREATE USER IF NOT EXISTS không tạo lại tài khoản và cũng không thay đổi mật khẩu hiện tại. Khi đổi mật khẩu, cần cập nhật đồng thời mật khẩu tài khoản MySQL và biến DB_PASSWORD trong .env.
2.5. Cấu hình biến môi trường
Sao chép tệp cấu hình mẫu tại thư mục gốc dự án:
cp .env.example .env
Mở tệp .env và cấu hình các biến phù hợp với môi trường đang sử dụng:
APP_DEBUG=false

DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ltweb_nhom04
DB_USERNAME=nhom04_app
DB_PASSWORD=MAT_KHAU_DA_TAO
Ý nghĩa các biến:
- APP_DEBUG: Bật hoặc tắt chế độ hiển thị lỗi chi tiết. Đặt false khi triển khai.
- DB_HOST: Địa chỉ máy chủ CSDL.
- DB_PORT: Cổng kết nối MySQL/MariaDB.
- DB_DATABASE: Tên CSDL của dự án.
- DB_USERNAME: Tài khoản ứng dụng, mặc định là nhom04_app.
- DB_PASSWORD: Mật khẩu đã đặt cho tài khoản nhom04_app.
Giá trị MAT_KHAU_DA_TAO trong ví dụ chỉ là nội dung minh họa. Cần thay bằng mật khẩu thực tế đã sử dụng khi tạo tài khoản MySQL. Không gửi mật khẩu thật lên GitHub hoặc đưa vào tài liệu công khai.

Tệp .env đã được cấu hình trong .gitignore, không được đưa lên GitHub. Chỉ chia sẻ .env.example với các giá trị mẫu.
2.6. Chạy website bằng PHP
Mở terminal tại thư mục gốc dự án:
php -S localhost:8000
Truy cập:

http://localhost:8000

Dừng máy chủ bằng Ctrl + C.
2.7. Chạy website bằng XAMPP
Sao chép thư mục dự án vào htdocs của XAMPP, sau đó khởi động Apache và MySQL.

Ví dụ nếu thư mục dự án là C:\xampp\htdocs\ltweb-doan-nhom04 thì truy cập:

http://localhost/ltweb-doan-nhom04/

Đường dẫn thực tế phụ thuộc vào tên thư mục được đặt trong htdocs.

Khi chạy bằng XAMPP, tệp .htaccess của dự án được Apache sử dụng để áp dụng các quy tắc bảo vệ thư mục và tệp. Khi chạy bằng máy chủ tích hợp php -S, các quy tắc .htaccess không được áp dụng.
3. Tài khoản kiểm thử
Thành viên	Email	Mật khẩu
Phan Thị Bảo Hân	baohan@cookwithme.com	Han@2026Cook
Nguyễn Thị Trinh	ngoctrinh@cookwithme.com	Trinh@2026Cook
Nguyễn Thị Ngọc Bình	ngocbinh@cookwithme.com	Binh@2026Cook
Lê Thị A Na	ana@cookwithme.com	Na@2026Cook


Lưu ý: Đây là thông tin tài khoản kiểm thử được ghi trong README của nhóm. Cần xác nhận các tài khoản hoạt động sau khi import seed.sql. Không sử dụng mật khẩu thật hoặc mật khẩu cá nhân của thành viên làm mật khẩu kiểm thử. Nếu tài khoản kiểm thử được công khai trên GitHub, chỉ sử dụng chúng trong môi trường demo và không tái sử dụng mật khẩu ở dịch vụ khác.
4. Bảng chức năng – URL – Tệp PHP
Chức năng	URL	Tệp PHP
Trang chủ	/	index.php
Danh sách, tìm kiếm món ăn	/danh-sach.php	danh-sach.php
Chi tiết món ăn	/chi-tiet.php?id=...	chi-tiet.php
Danh sách yêu thích	/yeu-thich.php	yeu-thich.php
Danh sách đi chợ	/goi-y-mon-an.php	goi-y-mon-an.php
Liên hệ	/lien-he.php	lien-he.php
Đăng ký	/dang-ky.php	dang-ky.php
Đăng nhập	/dang-nhap.php	dang-nhap.php
Đăng xuất	/dang-xuat.php	dang-xuat.php
Quản trị	/quan-tri.php	quan-tri.php
Thêm món ăn	/them-mon-an.php	them-mon-an.php
Sửa món ăn	/sua-mon-an.php?id=...	sua-mon-an.php
Xóa món ăn	/xoa-mon-an.php	xoa-mon-an.php
Trang cá nhân Bình	/thanhvien/3120224013_binh/gioithieu.php	thanhvien/3120224013_binh/gioithieu.php
Trang cá nhân Hân	/thanhvien/3120224045_baohan/gioithieu.php	thanhvien/3120224045_baohan/gioithieu.php
Trang cá nhân Na	/thanhvien/3120224096_lena/gioithieu.php	thanhvien/3120224096_lena/gioithieu.php
Trang cá nhân Trinh	/thanhvien/3120224155_trinh/gioithieu.php	thanhvien/3120224155_trinh/gioithieu.php


Các URL được tính từ thư mục gốc website. Những trang quản trị hoặc thao tác cập nhật dữ liệu có thể yêu cầu đăng nhập và quyền tương ứng.
5. API endpoints
Phương thức	Endpoint	Chức năng
GET	/api/mon-an.php?q=pho	Tìm kiếm món ăn theo từ khóa
GET	/api/mon-an.php?dm=...	Lọc món theo danh mục
GET	/api/mon-an.php?id=pho-bo	Xem chi tiết món ăn theo slug
GET	/api/gio-hang.php	Đọc dữ liệu yêu thích/giỏ hàng của tài khoản
POST	/api/gio-hang.php	Thêm, cập nhật hoặc xóa dữ liệu yêu thích/giỏ hàng


API món ăn trả dữ liệu JSON và chỉ hỗ trợ GET.

API giỏ hàng sử dụng phiên đăng nhập. Yêu cầu POST phải có Content-Type: application/json và CSRF token hợp lệ.

Ví dụ nội dung JSON cho API giỏ hàng:
{
  "hanh_dong": "them",
  "id_mon": "pho-bo",
  "so_luong": 2,
  "csrf_token": "TOKEN_HOP_LE"
}
Các hành động hỗ trợ gồm them, cap_nhat, xoa, xoa_het.

Các mã phản hồi được dùng tùy tình huống, chẳng hạn 200, 400, 401, 403, 404, 405 và 422.
6. Cấu trúc thư mục chính
ltweb-doan-nhom04/
├── api/
│   ├── mon-an.php
│   └── gio-hang.php
├── database/
│   ├── schema.sql
│   ├── seed.sql
│   ├── tai-khoan.sql
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
├── .env.example
├── .gitignore
└── README.md
Đây là cấu trúc tóm tắt các thư mục và tệp chính, không phải danh sách toàn bộ tệp. Tệp .env và thư mục vendor/ được tạo riêng trên máy triển khai nên không xuất hiện trong kho mã nguồn.
7. Quản lý mã nguồn và đóng góp cá nhân
Nhóm sử dụng Git và GitHub để quản lý phiên bản, lưu lịch sử thay đổi và minh chứng đóng góp của từng thành viên.

Kho mã nguồn:

https://github.com/BaoHan210/ltweb-doan-nhom04

Lịch sử commit:

https://github.com/BaoHan210/ltweb-doan-nhom04/commits/main/

Mỗi thành viên thực hiện commit các tệp và chức năng được phân công. Lịch sử commit trên GitHub là căn cứ xác định đóng góp cá nhân.

Mã commit cuối cùng được ghi trong báo cáo bàn giao khi nhóm hoàn tất việc nộp bài.
8. Lưu ý khi kiểm thử
- Kiểm tra kết nối MySQL trước khi truy cập các chức năng sử dụng CSDL.
- Kiểm thử các biểu mẫu khi bật và tắt JavaScript.
- Kiểm tra phân quyền của tài khoản thường và tài khoản quản trị.
- Kiểm tra dữ liệu đầu vào không hợp lệ và các phản hồi HTTP.
- Kiểm tra PHP Warning/Notice và mã HTML bằng W3C Validator.
- Kiểm tra tài khoản ứng dụng chỉ có các quyền cần thiết trên CSDL của dự án.
- Không đưa dữ liệu cá nhân thật, thông tin đăng nhập thật hoặc các tệp cấu hình chứa bí mật lên GitHub.
Các minh chứng kiểm thử được lưu trong thư mục kiemtra/.