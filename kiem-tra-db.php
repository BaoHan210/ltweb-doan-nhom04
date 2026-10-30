<?php
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';

$pdo = db();

$stmt = $pdo->query('SELECT COUNT(*) FROM mon_an');

echo 'Ket noi PDO thanh cong!<br>';
echo 'Tong so mon an: ' . (int) $stmt->fetchColumn();
