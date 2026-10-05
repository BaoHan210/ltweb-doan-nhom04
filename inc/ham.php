<?php
/**
 * Hàm chống XSS (mã hóa ký tự đặc biệt HTML)
 */
function e(?string $text): string {
    return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Hàm định dạng tiền tệ VNĐ
 */
function vnd(float|int $amount): string {
    return number_format($amount, 0, ',', '.') . ' đ';
}