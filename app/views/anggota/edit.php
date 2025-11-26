<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<div class="content">
    <h2>Edit Anggota</h2>

    <form method="POST" action="<?= BASE_URL ?>anggota/update">

        <input type="hidden" name="id_anggota" value="<?= $anggota['id_anggota']; ?>">

        <label>Nama</label>
        <input type="text" name="nama" value="<?= $anggota['nama']; ?>" required><br><br>

        <label>Alamat</label>
        <input type="text" name="alamat" value="<?= $anggota['alamat']; ?>" required><br><br>

        <label>Telepon</label>
        <input type="text" name="telepon" value="<?= $anggota['telepon']; ?>" required><br><br>

        <button type="submit">Update</button>
        <a href="<?= BASE_URL ?>anggota">Kembali</a>

    </form>
</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
