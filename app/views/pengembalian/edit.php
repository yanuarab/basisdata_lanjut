<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<link rel="stylesheet" href="<?= BASE_URL ?>assets/createEdit.css">

<div class="content">

<div class="form-card">
    <h2 class="card-title">Edit Data Pengembalian</h2>

    <form action="<?= BASE_URL ?>pengembalian/update" method="POST">

        <input type="hidden" name="id_pengembalian" value="<?= htmlspecialchars($data['id_pengembalian'] ?? '') ?>">
        <input type="hidden" name="id_peminjaman" value="<?= htmlspecialchars($data['id_peminjaman'] ?? '') ?>">

        <div class="row-flex">

            <div class="col">
                <label>Anggota</label>
                <input type="text" class="input" value="<?= htmlspecialchars($data['nama_anggota'] ?? '') ?>" readonly>
            </div>

            <div class="col">
                <label>Buku</label>
                <input type="text" class="input" value="<?= htmlspecialchars($data['judul_buku'] ?? '') ?>" readonly>
            </div>

        </div>

        <label>Tanggal Pengembalian</label>
        <input type="date" class="input" name="tanggal_pengembalian" 
               value="<?= htmlspecialchars($data['tanggal_pengembalian'] ?? '') ?>">

        <label>Denda</label>
        <input type="number" class="input" name="denda" step="0.01"
               value="<?= htmlspecialchars($data['denda'] ?? 0) ?>">

        <button class="btn-submit" type="submit">Update</button>
        <a href="<?= BASE_URL ?>pengembalian" class="btn-back">← Kembali</a>

    </form>
</div>

</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
