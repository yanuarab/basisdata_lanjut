<?php
$DB_HOST = 'localhost';
$DB_PORT = '5433';
$DB_NAME = 'uts_perpustakaan';
$DB_USER = 'postgres';
$DB_PASS = '12345678';

try {
    $dsn = "pgsql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_NAME;";
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("DB connection failed: " . $e->getMessage());
}
