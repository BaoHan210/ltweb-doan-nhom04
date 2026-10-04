<footer>
    <p>
      &copy; 2026 Cook with me - Nhóm 04
    </p>

    <nav aria-label="Điều hướng phụ">
      <ul class="menu">
        <li>
          <a href="gioi-thieu.php">
            Giới thiệu
          </a>
        </li>
        <li>
          <a href="lien-he.php">
            Liên hệ
          </a>
        </li>
      </ul>
    </nav>
  </footer>

  <!-- JavaScript dùng chung -->
  <script type="module" src="js/main.js"></script>

  <!-- JavaScript riêng của từng trang (nếu có) -->
  <?php if (isset($customJS)): ?>
    <script type="module" src="<?php echo $customJS; ?>"></script>
  <?php endif; ?>

</body>
</html>