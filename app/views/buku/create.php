<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<div class="content">
    <h2>Tambah Buku</h2>

    <form method="POST" action="<?= BASE_URL ?>buku/store">

        <label>Judul Buku</label>
        <input type="text" name="judul" required><br><br>

        <label>Pengarang</label>
        <input type="text" name="pengarang" required><br><br>

        <label>Tahun Terbit</label>
        <input type="number" name="tahun_terbit" required><br><br>

        <label>Stok</label>
        <input type="number" name="stok" required><br><br>

        <button type="submit">Simpan</button>
        <a href="<?= BASE_URL ?>buku">Kembali</a>

    </form>
</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
