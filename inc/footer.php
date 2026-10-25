<?php
/**
 * Tệp: inc/footer.php
 * Mục đích: Phần cuối trang dùng chung, nạp js/main.js và JS riêng của từng trang.
 * Dùng bởi: các trang công khai, trang quản trị và trang cá nhân thành viên.
 * Biến đầu vào: $goc (string, tùy chọn), $customJS (string, tùy chọn: đường dẫn JS riêng của trang)
 */

declare(strict_types=1);

$goc ??= '';
?>
  <footer>
    <p>&copy; 2026 Cook with me - Nhóm 04</p>
    <nav aria-label="Điều hướng phụ">
      <ul class="menu">
        <li><a href="<?= e($goc) ?>gioi-thieu.php">Giới thiệu</a></li>
        <li><a href="<?= e($goc) ?>lien-he.php">Liên hệ</a></li>
      </ul>
    </nav>
  </footer>

  <script type="module" src="<?= e($goc) ?>js/main.js"></script>

  <?php if (isset($customJS) && is_string($customJS) && $customJS !== ''): ?>
    <script type="module" src="<?= e($goc . $customJS) ?>"></script>
  <?php endif; ?>

</body>
</html>