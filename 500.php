<?php
/**
 * Tệp: 500.php
 * Trang lỗi máy chủ. Không truy vấn CSDL, không gọi nguoiDungHienTai().
 */
if (!headers_sent()) {
    http_response_code(500);
}
$goc = defined('URL_GOC') ? URL_GOC : './';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lỗi máy chủ - Cook with me</title>
  <link rel="stylesheet" href="<?= htmlspecialchars($goc, ENT_QUOTES, 'UTF-8') ?>css/06-trang-loi.css">
</head>
<body class="trang-loi-body">
  <main class="trang-loi trang-loi-500">
    <p class="ma">500</p>
    <h1>Xin lỗi, đã xảy ra lỗi máy chủ</h1>
    <p>Hệ thống đang gặp sự cố tạm thời. Lỗi đã được ghi nhận để khắc phục. Bạn vui lòng thử lại sau.</p>
    <a href="<?= htmlspecialchars($goc, ENT_QUOTES, 'UTF-8') ?>index.php">Quay lại trang chủ</a>
  </main>
</body>
</html>