-- Tao tai khoan rieng cho ung dung Cook with me.
-- Thay mat khau mau bang mat khau manh truoc khi chay tren moi truong moi.
-- Khong dua mat khau that vao Git.

CREATE USER IF NOT EXISTS 'nhom04_app'@'localhost'
IDENTIFIED BY 'Hi123456';

-- Chi cap cac quyen CRUD tren co so du lieu cua du an.
GRANT SELECT, INSERT, UPDATE, DELETE
ON `ltweb_nhom04`.*
TO 'nhom04_app'@'localhost';
