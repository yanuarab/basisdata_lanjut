<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<div class="content">
    <h2>Tambah Anggota</h2>

    <form method="POST" action="<?= BASE_URL ?>anggota/store">

        <label>Nama</label>
        <input type="text" name="nama" required><br><br>

        <label>Alamat</label>
        <input type="text" name="alamat" required><br><br>

        <label>Telepon</label>
        <input type="text" name="telepon" required><br><br>

        <button type="submit">Simpan</button>
        <a href="<?= BASE_URL ?>anggota">Kembali</a>

    </form>
</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
