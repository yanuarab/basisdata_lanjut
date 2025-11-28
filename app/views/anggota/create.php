<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<link rel="stylesheet" href="<?= BASE_URL ?>assets/createEdit.css">

<div class="content">

<div class="form-card">
    <h2 class="card-title">Tambah Anggota</h2>

    <form method="POST" action="<?= BASE_URL ?>anggota/store">

        <label>Nama</label>
        <input type="text" class="input" name="nama" required>

        <label>Alamat</label>
        <input type="text" class="input" name="alamat" required>

        <label>Telepon</label>
        <input type="text" class="input" name="no_hp" required>

        <button class="btn-submit" type="submit">Simpan</button>
        <a href="<?= BASE_URL ?>anggota" class="btn-back">← Kembali</a>

    </form>
</div>

</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
