<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| GLOBAL CONFIG & DATABASE
|--------------------------------------------------------------------------
*/
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/config/database.php';

/*
|--------------------------------------------------------------------------
| LOAD CONTROLLERS (Tanpa config/database lagi)
|--------------------------------------------------------------------------
*/
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/DashboardController.php';
require_once __DIR__ . '/../app/controllers/BukuController.php';
require_once __DIR__ . '/../app/controllers/AnggotaController.php';

/*
|--------------------------------------------------------------------------
| INIT
|--------------------------------------------------------------------------
*/
$db = new Database();
$pdo = $db->getConnection();

$auth = new AuthController($pdo);
$dashboard = new DashboardController();
$buku = new BukuController($pdo);
$anggota = new AnggotaController($pdo);

/*
|--------------------------------------------------------------------------
| ROUTER
|--------------------------------------------------------------------------
*/
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$uri = str_replace('basisdata_lanjut/public/', '', $uri);

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
if ($uri === '' || $uri === 'login') {
    $auth->index();
    exit;
}

if ($uri === 'login/process') {
    $auth->login();
    exit;
}

if ($uri === 'logout') {
    $auth->logout();
    exit;
}

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
if ($uri === 'dashboard') {
    $dashboard->index();
    exit;
}

/*
|--------------------------------------------------------------------------
| BUKU MODULE
|--------------------------------------------------------------------------
*/
if ($uri === 'buku') { $buku->index(); exit; }
if ($uri === 'buku/create') { $buku->create(); exit; }
if ($uri === 'buku/store') { $buku->store(); exit; }

if (preg_match('/^buku\/edit\/(\d+)$/', $uri, $m)) {
    $buku->edit($m[1]);
    exit;
}

if ($uri === 'buku/update') { $buku->update(); exit; }

if (preg_match('/^buku\/delete\/(\d+)$/', $uri, $m)) {
    $buku->delete($m[1]);
    exit;
}

/*
|--------------------------------------------------------------------------
| ANGGOTA MODULE
|--------------------------------------------------------------------------
*/

if ($uri === 'anggota') { 
    $anggota->index(); 
    exit;
}

if ($uri === 'anggota/create') { 
    $anggota->create(); 
    exit; 
}

if ($uri === 'anggota/store') { 
    $anggota->store(); 
    exit; 
}

if (preg_match('/^anggota\/edit\/(\d+)$/', $uri, $m)) {
    $anggota->edit($m[1]);
    exit;
}

if ($uri === 'anggota/update') { 
    $anggota->update(); 
    exit; 
}

if (preg_match('/^anggota\/delete\/(\d+)$/', $uri, $m)) {
    $anggota->delete($m[1]);
    exit;
}


/*
|--------------------------------------------------------------------------
| 404
|--------------------------------------------------------------------------
*/
http_response_code(404);
echo "404 Not Found";
