<?php 
require_once "../helpers/auth.php";
mustLogin();
?>

<?php include "template/header.php"; ?>

<h1>Selamat datang, <?= $_SESSION['admin']['nama_lengkap']; ?>!</h1>
<p>Anda berada di Dashboard Sistem Perpustakaan.</p>

<a href="../controllers/AuthController.php?action=logout">Logout</a>

<?php include "template/footer.php"; ?>
