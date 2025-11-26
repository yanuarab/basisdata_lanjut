<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../helpers/auth.php';

mustLogin();
?>

<?php include __DIR__ . "/../template/header.php"; ?>
<?php include __DIR__ . "/../template/sidebar.php"; ?>

<div class="content">
    <h1 class="title">Selamat datang, <?= $_SESSION['admin']['username']; ?> 👋</h1>
    <p class="subtitle">Anda berada di Dashboard Sistem Perpustakaan.</p>

    <div class="cards">
        <div class="card">
            <h3>Total Buku</h3>
            <span>120</span>
        </div>
        <div class="card">
            <h3>Anggota</h3>
            <span>45</span>
        </div>
        <div class="card">
            <h3>Peminjaman Hari Ini</h3>
            <span>8</span>
        </div>
    </div>

    <a href="<?= BASE_URL ?>logout" class="logout-btn">Logout</a>
</div>

<?php include __DIR__ . "/../template/footer.php"; ?>
