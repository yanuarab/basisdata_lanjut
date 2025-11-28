<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<div class="content">

<div class="form-card">
    <h3 style="text-align:center;margin-bottom:15px;">Edit Kategori</h3>

    <form method="POST" action="<?= BASE_URL ?>kategori/update">

        <input type="hidden" name="id_kategori" value="<?= $kategori['id_kategori'] ?>">

        <label>Nama Kategori</label>
        <input type="text" class="input" 
               name="nama_kategori" 
               value="<?= htmlspecialchars($kategori['nama_kategori']) ?>" required>

        <label>Deskripsi</label>
        <textarea class="input" name="deskripsi" required><?= htmlspecialchars($kategori['deskripsi']) ?></textarea>

        <button class="btn-submit" type="submit">Update</button>
        <a href="<?= BASE_URL ?>kategori" class="btn-back">← Kembali</a>

    </form>
</div>

</div>

<?php include __DIR__ . '/../template/footer.php'; ?>