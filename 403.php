<?php
// 403.php: không truy vấn CSDL, không gọi nguoiDung() hay header có session
$goc = defined('URL_GOC') ? URL_GOC : './';

if (!headers_sent()) {
    http_response_code(403);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Không có quyền truy cập - Cook with me</title>
  <link rel="stylesheet" href="<?= htmlspecialchars($goc, ENT_QUOTES, 'UTF-8') ?>css/06-trang-loi.css">
</head>
<body class="trang-loi-body">
  <main class="trang-loi">
    <p class="ma">403</p>
    <h1>Bạn không có quyền truy cập trang này</h1>
    <p>Trang này chỉ dành cho tài khoản có quyền phù hợp. Hãy đăng nhập bằng tài khoản khác hoặc quay về trang chủ.</p>
    <a href="<?= htmlspecialchars($goc, ENT_QUOTES, 'UTF-8') ?>index.php">Về trang chủ</a>
  </main>
</body>
</html>