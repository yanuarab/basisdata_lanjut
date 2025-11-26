<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/AuthController.php';

// start session once
if (session_status() === PHP_SESSION_NONE) session_start();

$auth = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth->login();
} else {
    $auth->index();
}
