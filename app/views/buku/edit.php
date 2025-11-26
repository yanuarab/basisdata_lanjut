<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<div class="content">
    <h2>Edit Buku</h2>

    <form method="POST" action="<?= BASE_URL ?>buku/update">

        <input type="hidden" name="id_buku" value="<?= $buku['id_buku']; ?>">

        <label>Judul Buku</label>
        <input type="text" name="judul" value="<?= $buku['judul']; ?>" required><br><br>

        <label>Pengarang</label>
        <input type="text" name="pengarang" value="<?= $buku['pengarang']; ?>" required><br><br>

        <label>Tahun Terbit</label>
        <input type="number" name="tahun_terbit" value="<?= $buku['tahun_terbit']; ?>" required><br><br>

        <label>Stok</label>
        <input type="number" name="stok" value="<?= $buku['stok']; ?>" required><br><br>

        <button type="submit">Update</button>
        <a href="<?= BASE_URL ?>buku">Kembali</a>

    </form>
</div>

<?php include __DIR__ . '/../template/footer.php'; ?>