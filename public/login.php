<?php
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

// start session once
if (session_status() === PHP_SESSION_NONE) session_start();

// init db
$db = new Database();
$pdo = $db->getConnection();

// init auth controller
$auth = new AuthController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth->login();
} else {
    $auth->index();
}
