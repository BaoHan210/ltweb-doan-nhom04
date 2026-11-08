-- BAI TAP NHOM 6 - NHOM 04
-- Website Cook with me
-- Khoi tao CSDL MySQL

-- chi_tiet_lan_di_cho.ten_mon và ngan_sach_tham_khao: LƯU LẶP có chủ đích.
-- Tên và giá món có thể đổi sau này, nhưng lịch sử đi chợ phải giữ đúng giá lúc chốt.

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS ltweb_nhom04;

CREATE DATABASE ltweb_nhom04
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE ltweb_nhom04;

-- 1. BANG DANH MUC
CREATE TABLE danh_muc (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- 2. BANG NGUOI DUNG
CREATE TABLE nguoi_dung (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ho_ten VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mat_khau VARCHAR(255) NOT NULL,
    vai_tro ENUM('quan_tri', 'khach_hang')
        NOT NULL DEFAULT 'khach_hang',
    ngay_tao DATETIME NOT NULL
        DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. BANG MON AN
CREATE TABLE mon_an (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(150) NOT NULL UNIQUE,
    danh_muc_id INT UNSIGNED NOT NULL,
    ten VARCHAR(200) NOT NULL,
    thoi_gian SMALLINT UNSIGNED NOT NULL,
    khau_phan SMALLINT UNSIGNED NOT NULL,
    do_kho VARCHAR(30) NOT NULL,
    ngan_sach INT UNSIGNED NOT NULL,
    ton_kho INT UNSIGNED NOT NULL DEFAULT 0,
    hinh_anh VARCHAR(255),
    mo_ta TEXT,
    video VARCHAR(255),
    danh_gia DECIMAL(3,2) DEFAULT 0,
    so_luot_danh_gia INT UNSIGNED DEFAULT 0,
    ngay_tao DATETIME NOT NULL
        DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_mon_an_danh_muc
        FOREIGN KEY (danh_muc_id)
        REFERENCES danh_muc(id)
        ON DELETE RESTRICT,

    CONSTRAINT chk_mon_an_thoi_gian
        CHECK (thoi_gian > 0),

    CONSTRAINT chk_mon_an_khau_phan
        CHECK (khau_phan > 0),

    CONSTRAINT chk_mon_an_ngan_sach
        CHECK (ngan_sach >= 1000),

    INDEX idx_mon_an_danh_muc_ngan_sach
        (danh_muc_id, ngan_sach)
) ENGINE=InnoDB;

-- 4. BẢNG LẦN ĐI CHỢ
CREATE TABLE lan_di_cho (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nguoi_dung_id INT UNSIGNED NOT NULL,
  ngay_chot     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  trang_thai    ENUM('moi','da_di_cho','da_huy') NOT NULL DEFAULT 'moi',
  FOREIGN KEY (nguoi_dung_id) REFERENCES nguoi_dung(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 5. BANG CHI TIET LAN DI CHO
CREATE TABLE chi_tiet_lan_di_cho (
  lan_id              INT UNSIGNED NOT NULL,
  mon_an_id           INT UNSIGNED NOT NULL,
  ten_mon             VARCHAR(200) NOT NULL,
  so_suat             TINYINT UNSIGNED NOT NULL,
  ngan_sach_tham_khao INT UNSIGNED NOT NULL,
  PRIMARY KEY (lan_id, mon_an_id),
  FOREIGN KEY (lan_id)    REFERENCES lan_di_cho(id) ON DELETE CASCADE,
  FOREIGN KEY (mon_an_id) REFERENCES mon_an(id) ON DELETE RESTRICT,
  CHECK (so_suat BETWEEN 1 AND 10)
) ENGINE=InnoDB;

-- 6. BANG LIEN HE
CREATE TABLE lien_he (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nguoi_dung_id INT UNSIGNED NULL,
    ho_ten VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    noi_dung TEXT NOT NULL,
    hinh_anh VARCHAR(255),
    ngay_gui DATETIME NOT NULL
        DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (nguoi_dung_id)
        REFERENCES nguoi_dung(id)
        ON DELETE SET NULL
) ENGINE=InnoDB;

-- 7. BANG NGUYEN LIEU
CREATE TABLE nguyen_lieu (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(150) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- 8. BANG MON AN - NGUYEN LIEU
CREATE TABLE mon_an_nguyen_lieu (
    mon_an_id INT UNSIGNED NOT NULL,
    nguyen_lieu_id INT UNSIGNED NOT NULL,
    so_luong VARCHAR(100) NOT NULL,

    PRIMARY KEY (mon_an_id, nguyen_lieu_id),

    FOREIGN KEY (mon_an_id)
        REFERENCES mon_an(id)
        ON DELETE CASCADE,

    FOREIGN KEY (nguyen_lieu_id)
        REFERENCES nguyen_lieu(id)
        ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 9. BANG BUOC NAU
CREATE TABLE buoc_nau (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mon_an_id INT UNSIGNED NOT NULL,
    thu_tu SMALLINT UNSIGNED NOT NULL,
    noi_dung TEXT NOT NULL,

    UNIQUE (mon_an_id, thu_tu),

    FOREIGN KEY (mon_an_id)
        REFERENCES mon_an(id)
        ON DELETE CASCADE,

    CHECK (thu_tu > 0)
) ENGINE=InnoDB;


-- Giỏ đi chợ: mỗi người dùng một danh sách (quan hệ 1 – 1 với nguoi_dung)
CREATE TABLE danh_sach_di_cho (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nguoi_dung_id INT UNSIGNED NOT NULL UNIQUE,   -- UNIQUE để ON DUPLICATE KEY hoạt động
    FOREIGN KEY (nguoi_dung_id) REFERENCES nguoi_dung(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Quan hệ n – n giữa danh sách và món, khóa chính ghép
CREATE TABLE chi_tiet_di_cho (
    danh_sach_id INT UNSIGNED NOT NULL,
    mon_an_id    INT UNSIGNED NOT NULL,
    so_suat      SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    PRIMARY KEY (danh_sach_id, mon_an_id),
    CONSTRAINT chk_di_cho_so_suat CHECK (so_suat BETWEEN 1 AND 10),
    FOREIGN KEY (danh_sach_id) REFERENCES danh_sach_di_cho(id) ON DELETE CASCADE,
    FOREIGN KEY (mon_an_id)    REFERENCES mon_an(id)           ON DELETE CASCADE
) ENGINE=InnoDB;

-- Phần B - Bảng thanh_vien (mỗi thành viên một dòng)
CREATE TABLE thanh_vien (
  mssv          CHAR(10) PRIMARY KEY,
  ho_ten        VARCHAR(100) NOT NULL,
  nguoi_dung_id INT UNSIGNED NULL UNIQUE,
  FOREIGN KEY (nguoi_dung_id) REFERENCES nguoi_dung(id)
    ON DELETE SET NULL
) ENGINE=InnoDB;

-- Phần B - Bảng riêng của Bảo Hân (tên bắt đầu bằng tv_)
CREATE TABLE tv_du_an (
  id    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  mssv  CHAR(10) NOT NULL,
  ten   VARCHAR(100) NOT NULL,
  mo_ta VARCHAR(500) NULL,
  nam   SMALLINT UNSIGNED NOT NULL,
  CHECK (nam BETWEEN 2000 AND 2100),
  FOREIGN KEY (mssv) REFERENCES thanh_vien(mssv) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE tv_phien_ban (
  id    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  mssv  CHAR(10) NOT NULL,
  ma    VARCHAR(20) NOT NULL,
  ten   VARCHAR(100) NOT NULL,
  ngay  DATE NOT NULL,
  nhom  VARCHAR(20) NOT NULL,
  mo_ta VARCHAR(500) NULL,
  CHECK (nhom IN ('giao-dien', 'tinh-nang', 'sua-loi')),
  FOREIGN KEY (mssv) REFERENCES thanh_vien(mssv) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 11. Bang so luu but cua Trinh
CREATE TABLE tv_trinh_luu_but (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mssv CHAR(10) NOT NULL,
    ten_khach VARCHAR(50) NOT NULL,
    loi_nhan VARCHAR(500) NOT NULL,
    thoi_gian DATETIME NOT NULL
        DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (mssv)
        REFERENCES thanh_vien(mssv)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- 12. Bang luot xem trang cua Trinh
CREATE TABLE tv_trinh_luot_xem (
    mssv CHAR(10) NOT NULL,
    ngay DATE NOT NULL,
    so_luot INT UNSIGNED NOT NULL DEFAULT 0,

    PRIMARY KEY (mssv, ngay),

    FOREIGN KEY (mssv)
        REFERENCES thanh_vien(mssv)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- PHAN B - BANG RIENG CUA NGUYEN THI NGOC BINH
-- MSSV: 3120224013
-- =====================================================

CREATE TABLE tv_binh_danh_gia (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mssv CHAR(10) NOT NULL,
    mon_an_id INT UNSIGNED NOT NULL,
    so_sao TINYINT UNSIGNED NOT NULL,
    nhan_xet VARCHAR(500),
    thoi_gian DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_tv_binh_thanh_vien
        FOREIGN KEY (mssv)
        REFERENCES thanh_vien(mssv)
        ON DELETE CASCADE,

    CONSTRAINT fk_tv_binh_mon_an
        FOREIGN KEY (mon_an_id)
        REFERENCES mon_an(id),

    CONSTRAINT chk_tv_binh_so_sao
        CHECK (so_sao BETWEEN 1 AND 5)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- Phần B - Dự án cá nhân của Lê Thị A Na
CREATE TABLE tv_du_an_ca_nhan (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mssv CHAR(10) NOT NULL,
    ten_du_an VARCHAR(150) NOT NULL,
    cong_nghe VARCHAR(255) NOT NULL,
    trang_thai VARCHAR(50) NOT NULL,
    mo_ta TEXT NULL,
    FOREIGN KEY (mssv) REFERENCES thanh_vien(mssv) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- 13. Bang theo doi so lan dang nhap that bai
CREATE TABLE dang_nhap_sai (
    email_hash CHAR(64) NOT NULL PRIMARY KEY,
    so_lan_sai TINYINT UNSIGNED NOT NULL DEFAULT 0,
    bat_dau DATETIME NOT NULL,
    khoa_den DATETIME NULL,
    cap_nhat DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_dang_nhap_sai_khoa_den (khoa_den)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
