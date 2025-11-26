<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/config/database.php';

require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/DashboardController.php';
require_once __DIR__ . '/../app/controllers/BukuController.php';

/* 
==========================================
(A) TAMBAHKAN FILE CONTROLLER PEMINJAMAN
==========================================
*/
require_once __DIR__ . '/../app/controllers/PeminjamanController.php';


$db = new Database();
$pdo = $db->getConnection();

$auth = new AuthController($pdo);
$dashboard = new DashboardController();
$buku = new BukuController($pdo);

/* 
==========================================
(B) TAMBAHKAN OBJECT PEMINJAMAN
==========================================
*/
$peminjaman = new PeminjamanController($pdo);


$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$uri = str_replace('basisdata_lanjut/public/', '', $uri);

/* LOGIN */
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

/* DASHBOARD */
if ($uri === 'dashboard') {
    $dashboard->index();
    exit;
}

/* BUKU */
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

//peminjaman
if ($uri === 'peminjaman') { $peminjaman->index(); exit; }
if ($uri === 'peminjaman/create') { $peminjaman->create(); exit; }
if ($uri === 'peminjaman/store') { $peminjaman->store(); exit; }

if (preg_match('/^peminjaman\/edit\/(\d+)$/', $uri, $m)) {
    $peminjaman->edit($m[1]);
    exit;
}

if ($uri === 'peminjaman/update') { $peminjaman->update(); exit; }

if (preg_match('/^peminjaman\/delete\/(\d+)$/', $uri, $m)) {
    $peminjaman->delete($m[1]);
    exit;
}

/* DEFAULT 404 */
http_response_code(404);
echo "404 Not Found";
