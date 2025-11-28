<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<link rel="stylesheet" href="<?= BASE_URL ?>assets/createEdit.css">

<div class="content">
    <div class="form-card">

        <h2 class="card-title">Tambah Buku</h2>

        <form method="POST" action="<?= BASE_URL ?>buku/store">

            <label>Judul Buku</label>
            <input type="text" class="input" name="judul" required>

            <label>Pengarang</label>
            <input type="text" class="input" name="pengarang" required>

            <label>Tahun Terbit</label>
            <input type="number" class="input" name="tahun_terbit" required>

            <div class="row-flex">

                <div class="col">
                    <label>Kategori</label>
                    <select class="input" name="id_kategori" required>
                        <option value="">-- Pilih --</option>
                        <?php foreach ($kategori as $k): ?>
                            <option value="<?= $k['id_kategori'] ?>">
                                <?= htmlspecialchars($k['nama_kategori']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col">
                    <label>Penerbit</label>
                    <select class="input" name="id_penerbit" required>
                        <option value="">-- Pilih --</option>
                        <?php foreach ($penerbit as $p): ?>
                            <option value="<?= $p['id_penerbit'] ?>">
                                <?= htmlspecialchars($p['nama_penerbit']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <label>Stok</label>
            <input type="number" class="input" name="stok" required>

            <button class="btn-submit" type="submit">Buat Buku</button>
            <a href="<?= BASE_URL ?>buku" class="btn-back">← Kembali</a>

        </form>
    </div>
</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
