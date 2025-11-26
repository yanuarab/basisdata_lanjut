<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/DashboardController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$uri = str_replace('basisdata_lanjut/public/', '', $uri);

$auth = new AuthController();
$dashboard = new DashboardController();

// ROUTING

// halaman login
if ($uri === '' || $uri === 'login') {
    if (isset($_SESSION['admin'])) {
        header("Location: " . BASE_URL . "dashboard");
        exit;
    }
    $auth->index();
    exit;
}

// proses login
if ($uri === 'login/process') {
    $auth->login();
    exit;
}

// logout
if ($uri === 'logout') {
    $auth->logout();
    exit;
}

// dashboard
if ($uri === 'dashboard') {

    if (!isset($_SESSION['admin'])) {
        header("Location: " . BASE_URL . "login");
        exit;
    }

    $dashboard->index();
    exit;
}

// 404
http_response_code(404);
echo "404 Not Found";
