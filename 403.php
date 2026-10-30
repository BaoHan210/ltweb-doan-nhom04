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
  <style>
    body { font-family: system-ui, sans-serif; margin: 0; color: #222; background: #fff; }
    .trang-loi { max-width: 40rem; margin: 0 auto; padding: 4rem 1rem; text-align: center; }
    .trang-loi .ma { font-size: 5rem; font-weight: 700; color: #b3261e; margin: 0; }
    .trang-loi h1 { font-size: 1.5rem; margin: 1rem 0; }
    .trang-loi p { color: #555; line-height: 1.6; }
    .trang-loi a { display: inline-block; margin: 1.5rem .5rem 0; padding: .75rem 1.5rem;
      background: #1e6b2e; color: #fff; text-decoration: none; border-radius: .25rem; }
  </style>
</head>
<body>
  <main class="trang-loi">
    <p class="ma">403</p>
    <h1>Bạn không có quyền truy cập trang này</h1>
    <p>Trang này chỉ dành cho tài khoản có quyền phù hợp. Hãy đăng nhập bằng tài khoản khác hoặc quay về trang chủ.</p>
    <a href="<?= htmlspecialchars($goc, ENT_QUOTES, 'UTF-8') ?>index.php">Về trang chủ</a>
  </main>
</body>
</html>