<?php
/**
 * inc/db.php
 * Kết nối cơ sở dữ liệu MySQL bằng PDO.
 * Thông tin kết nối được lấy từ tệp .env.
 */

function db(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];
        $database = $_ENV['DB_DATABASE'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $host,
            $port,
            $database
        );

        $pdo = new PDO(
            $dsn,
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }

    return $pdo;
}