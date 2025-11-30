<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<link rel="stylesheet" href="<?= BASE_URL ?>assets/createEdit.css">

<div class="content">
<div class="form-card">
    <h2 class="card-title">Tambah Pengembalian</h2>

    <form action="<?= BASE_URL ?>pengembalian/store" method="POST">

        <label>Peminjaman</label>
        <select name="id_peminjaman" class="input" required>
            <option value="">Pilih Peminjaman</option>
            <?php foreach ($peminjaman as $p): ?>
                <option value="<?= $p['id_peminjaman'] ?>">
                    <?= $p['id_peminjaman'] ?> - <?= htmlspecialchars($p['nama_anggota'] ?? '') ?> (<?= htmlspecialchars($p['judul_buku'] ?? '') ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <label>Tanggal Pengembalian</label>
        <input type="date" class="input" name="tanggal_pengembalian" value="">

        <label>Denda</label>
        <input type="number" class="input" name="denda" step="0.01" value="0">

        <button class="btn-submit" type="submit">Simpan</button>
        <a href="<?= BASE_URL ?>pengembalian" class="btn-back">← Kembali</a>

    </form>
</div>
</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
