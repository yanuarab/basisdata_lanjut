<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/config/database.php';

/* LOAD CONTROLLERS */
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/DashboardController.php';
require_once __DIR__ . '/../app/controllers/BukuController.php';
require_once __DIR__ . '/../app/controllers/AnggotaController.php';
require_once __DIR__ . '/../app/controllers/PeminjamanController.php';
require_once __DIR__ . '/../app/controllers/PengembalianController.php';
require_once __DIR__ . '/../app/controllers/LaporanController.php';
require_once __DIR__ . '/../app/controllers/BukuPopulerController.php';
require_once __DIR__ . '/../app/controllers/KategoriController.php';

$db = new Database();
$pdo = $db->getConnection();

/* INISIASI OBJEK */
$auth          = new AuthController($pdo);
$dashboard     = new DashboardController();
$buku          = new BukuController($pdo);
$anggota       = new AnggotaController($pdo);
$peminjaman    = new PeminjamanController($pdo);
$pengembalian  = new PengembalianController($pdo);
$laporan       = new LaporanController($pdo);
$bukuPopuler   = new BukuPopulerController($pdo);
$kategori      = new KategoriController($pdo);

/* ============================================
   NORMALISASI URL
============================================= */

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

/* Hapus folder project jika masih nempel */
$uri = str_replace(['basisdata_lanjut/public/', 'basisdata_lanjut/public'], '', $uri);
$uri = ltrim($uri, '/');


/* ============================================
   ROUTING LOGIN
============================================= */
if ($uri === '' || $uri === 'login') { $auth->index(); exit; }
if ($uri === 'login/process') { $auth->login(); exit; }
if ($uri === 'logout') { $auth->logout(); exit; }

/* ============================================
   DASHBOARD
============================================= */
if ($uri === 'dashboard') { $dashboard->index(); exit; }

/* ============================================
   BUKU
============================================= */
if ($uri === 'buku') { $buku->index(); exit; }
if ($uri === 'buku/create') { $buku->create(); exit; }
if ($uri === 'buku/store') { $buku->store(); exit; }
if (preg_match('/^buku\/edit\/(\d+)$/', $uri, $m)) { $buku->edit($m[1]); exit; }
if ($uri === 'buku/update') { $buku->update(); exit; }
if (preg_match('/^buku\/delete\/(\d+)$/', $uri, $m)) { $buku->delete($m[1]); exit; }

/* ============================================
   ANGGOTA
============================================= */
if ($uri === 'anggota') { $anggota->index(); exit; }
if ($uri === 'anggota/create') { $anggota->create(); exit; }
if ($uri === 'anggota/store') { $anggota->store(); exit; }
if (preg_match('/^anggota\/edit\/(\d+)$/', $uri, $m)) { $anggota->edit($m[1]); exit; }
if ($uri === 'anggota/update') { $anggota->update(); exit; }
if (preg_match('/^anggota\/delete\/(\d+)$/', $uri, $m)) { $anggota->delete($m[1]); exit; }

/* ============================================
   KATEGORI
============================================= */
if ($uri === 'kategori') { $kategori->index(); exit; }
if ($uri === 'kategori/create') { $kategori->create(); exit; }
if ($uri === 'kategori/store') { $kategori->store(); exit; }
if (preg_match('/^kategori\/edit\/(\d+)$/', $uri, $m)) { $kategori->edit($m[1]); exit; }
if ($uri === 'kategori/update') { $kategori->update(); exit; }
if (preg_match('/^kategori\/delete\/(\d+)$/', $uri, $m)) { $kategori->delete($m[1]); exit; }

/* ============================================
   PEMINJAMAN
============================================= */
if ($uri === 'peminjaman') { $peminjaman->index(); exit; }
if ($uri === 'peminjaman/create') { $peminjaman->create(); exit; }
if ($uri === 'peminjaman/store') { $peminjaman->store(); exit; }
if (preg_match('/^peminjaman\/edit\/(\d+)$/', $uri, $m)) { $peminjaman->edit($m[1]); exit; }
if ($uri === 'peminjaman/update') { $peminjaman->update(); exit; }
if (preg_match('/^peminjaman\/delete\/(\d+)$/', $uri, $m)) { $peminjaman->delete($m[1]); exit; }


/* ============================================
   PENGEMBALIAN
============================================= */

// LIST
if ($uri === 'pengembalian') { 
    $data = $pengembalian->index(); 
    // contoh: include view pengembalian/index.php di sini
    exit;
}

// FORM CREATE
if ($uri === 'pengembalian/create') { 
    // biasanya hanya load view form create
    include __DIR__ . '/../app/views/pengembalian/create.php';
    exit; 
}

// STORE (POST)
if ($uri === 'pengembalian/store') { 
    $id_peminjaman = $_POST['id_peminjaman'] ?? null;
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'] ?? null;
    $denda = $_POST['denda'] ?? 0;

    $pengembalian->store($id_peminjaman, $tanggal_pengembalian, $denda);
    header('Location: /pengembalian'); // redirect ke list
    exit; 
}

// FORM EDIT
if (preg_match('/^pengembalian\/edit\/(\d+)$/', $uri, $m)) { 
    $id = $m[1];
    $item = $pengembalian->find($id);
    include __DIR__ . '/../app/views/pengembalian/edit.php';
    exit; 
}

// UPDATE (POST)
if ($uri === 'pengembalian/update') { 
    $id = $_POST['id'] ?? null;
    $id_peminjaman = $_POST['id_peminjaman'] ?? null;
    $tanggal_pengembalian = $_POST['tanggal_pengembalian'] ?? null;
    $denda = $_POST['denda'] ?? 0;

    $pengembalian->update($id, $id_peminjaman, $tanggal_pengembalian, $denda);
    header('Location: /pengembalian'); // redirect ke list
    exit; 
}

// DELETE
if (preg_match('/^pengembalian\/delete\/(\d+)$/', $uri, $m)) { 
    $id = $m[1];
    $pengembalian->delete($id);
    header('Location: /pengembalian'); // redirect ke list
    exit; 
}


/* ============================================
   LAPORAN
============================================= */
if ($uri === 'laporan') { $laporan->index(); exit; }

/* ============================================
   BUKU POPULER
============================================= */
if ($uri === 'buku_populer') { $bukuPopuler->index(); exit; }
if ($uri === 'buku-populer/refresh') { $bukuPopuler->refresh(); exit; }

/* ============================================
   404
============================================= */
http_response_code(404);
echo "404 Not Found";
