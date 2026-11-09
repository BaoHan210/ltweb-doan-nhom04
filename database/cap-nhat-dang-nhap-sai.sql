-- Luu lai bang theo doi dang nhap sai cu.
RENAME TABLE dang_nhap_sai TO dang_nhap_sai_cu;

-- Tao bang moi, luu tung lan dang nhap sai.
CREATE TABLE dang_nhap_sai (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(254) NOT NULL,
    ip VARCHAR(45) NOT NULL,
    thoi_gian DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_dang_nhap_sai_email_thoi_gian (email, thoi_gian)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
