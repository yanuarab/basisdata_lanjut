<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>


<link rel="stylesheet" href="<?= BASE_URL ?>assets/createEdit.css">

<div class="content">
    <div class="form-card">

        <h2 class="card-title">Edit Buku</h2>

        <form method="POST" action="<?= BASE_URL ?>buku/update">

            <input type="hidden" name="id_buku" value="<?= $buku['id_buku']; ?>">

            <label>Judul Buku</label>
            <input type="text" class="input" name="judul" 
                   value="<?= htmlspecialchars($buku['judul']); ?>" required>

            <label>Pengarang</label>
            <input type="text" class="input" name="pengarang" 
                   value="<?= htmlspecialchars($buku['pengarang']); ?>" required>

            <label>Tahun Terbit</label>
            <input type="number" class="input" name="tahun_terbit" 
                   value="<?= $buku['tahun_terbit']; ?>" required>

            <div class="row-flex">

                <div class="col">
                    <label>Kategori</label>
                    <select class="input" name="id_kategori" required>
                        <?php foreach ($kategori as $k): ?>
                            <option value="<?= $k['id_kategori'] ?>"
                                <?= ($buku['id_kategori'] == $k['id_kategori']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($k['nama_kategori']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col">
                    <label>Penerbit</label>
                    <select class="input" name="id_penerbit" required>
                        <?php foreach ($penerbit as $p): ?>
                            <option value="<?= $p['id_penerbit'] ?>"
                                <?= ($buku['id_penerbit'] == $p['id_penerbit']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($p['nama_penerbit']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <label>Stok</label>
            <input type="number" class="input" name="stok" 
                   value="<?= $buku['stok']; ?>" required>

            <button class="btn-submit" type="submit">Update Buku</button>
            <a href="<?= BASE_URL ?>buku" class="btn-back">← Kembali</a>

        </form>

    </div>
</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
