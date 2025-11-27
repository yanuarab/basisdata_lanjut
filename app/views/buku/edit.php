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

        <label>Kategori</label>
        <select name="id_kategori" required>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= $k['id_kategori'] ?>"
                    <?= ($buku['id_kategori'] == $k['id_kategori']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($k['nama_kategori']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label>Penerbit</label>
        <select name="id_penerbit" required>
            <?php foreach ($penerbit as $p): ?>
                <option value="<?= $p['id_penerbit'] ?>"
                    <?= ($buku['id_penerbit'] == $p['id_penerbit']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['nama_penerbit']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label>Stok</label>
        <input type="number" name="stok" value="<?= $buku['stok']; ?>" required><br><br>

        <button type="submit">Update</button>
        <a href="<?= BASE_URL ?>buku">Kembali</a>

    </form>
</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
