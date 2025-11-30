<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<link rel="stylesheet" href="<?= BASE_URL ?>assets/createEdit.css">

<div class="content">

<div class="form-card">
    <h2 class="card-title">Tambah Data Pengembalian</h2>

    <form action="<?= BASE_URL ?>pengembalian/store" method="POST">

        <div class="row-flex">

            <div class="col">
                <label>Anggota</label>
                <select name="id_anggota" class="input" required>
                    <option value="">-- Pilih --</option>
                    <?php foreach ($anggota as $a): ?>
                        <option value="<?= $a['id_anggota'] ?>"><?= $a['nama'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col">
                <label>Buku</label>
                <select name="id_buku" class="input" required>
                    <option value="">-- Pilih --</option>
                    <?php foreach ($buku as $b): ?>
                        <option value="<?= $b['id_buku'] ?>"><?= $b['judul'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>

        <label>Tanggal Kembali</label>
        <input type="date" class="input" name="tanggal_kembali" required>

        <label>Denda</label>
        <input type="number" class="input" name="denda" placeholder="Masukkan denda (jika ada)">

        <button class="btn-submit" type="submit">Simpan</button>
        <a href="<?= BASE_URL ?>pengembalian" class="btn-back">← Kembali</a>

    </form>
</div>

</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
