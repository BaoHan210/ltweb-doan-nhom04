<?php
// 500.php - trang tĩnh: KHÔNG require header, KHÔNG truy vấn CSDL
if (!headers_sent()) {
    http_response_code(500);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lỗi máy chủ - Cook with me</title>
  <link rel="stylesheet" href="/ltweb-doan-nhom04-main/css/01-bien.css">
  <link rel="stylesheet" href="/ltweb-doan-nhom04-main/css/02-chuan-hoa.css">
  <style>
    body { font-family: system-ui, sans-serif; margin: 0; color: #222; background: #fff; }
    .trang-loi { max-width: 40rem; margin: 0 auto; padding: 4rem 1rem; text-align: center; }
    .trang-loi .ma { font-size: 5rem; font-weight: 700; color: #b3261e; margin: 0; }
    .trang-loi h1 { font-size: 1.5rem; margin: 1rem 0; }
    .trang-loi p { color: #555; line-height: 1.6; }
    .trang-loi a { display: inline-block; margin-top: 1.5rem; padding: .75rem 1.5rem;
      background: #1e6b2e; color: #fff; text-decoration: none; border-radius: .25rem; }
  </style>
</head>
<body>
  <main class="trang-loi">
    <p class="ma">500</p>
    <h1>Xin lỗi, đã xảy ra lỗi máy chủ</h1>
    <p>Hệ thống đang gặp sự cố tạm thời. Lỗi đã được ghi nhận để khắc phục. Bạn vui lòng thử lại sau.</p>
    <a href="/ltweb-doan-nhom04-main/index.php">Quay lại trang chủ</a>
  </main>
</body>
</html>