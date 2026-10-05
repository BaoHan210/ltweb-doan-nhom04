<?php $goc ??= ''; ?>
  <footer>
    <p>&copy; 2026 Cook with me - Nhóm 04</p>
    <nav aria-label="Điều hướng phụ">
      <ul class="menu">
        <li><a href="<?= $goc ?>gioi-thieu.php">Giới thiệu</a></li>
        <li><a href="<?= $goc ?>lien-he.php">Liên hệ</a></li>
      </ul>
    </nav>
  </footer>

  <script type="module" src="<?= $goc ?>js/main.js"></script>
  <?php if (isset($customJS)): ?>
    <script type="module" src="<?= $goc . e($customJS) ?>"></script>
  <?php endif; ?>
</body>
</html>