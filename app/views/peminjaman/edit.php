<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<link rel="stylesheet" href="<?= BASE_URL ?>assets/createEdit.css">

<div class="content">

<div class="form-card">
    <h2 class="card-title">Edit Data Peminjaman</h2>

    <form action="<?= BASE_URL ?>peminjaman/update" method="POST">

        <input type="hidden" name="id_peminjaman" value="<?= $data['id_peminjaman'] ?>">

        <div class="row-flex">

            <div class="col">
                <label>Anggota</label>
                <select name="id_anggota" class="input" required>
                    <?php foreach ($anggota as $a): ?>
                        <option value="<?= $a['id_anggota'] ?>" 
                            <?= $a['id_anggota'] == $data['id_anggota'] ? 'selected' : '' ?>>
                            <?= $a['nama'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col">
                <label>Buku</label>
                <select name="id_buku" class="input" required>
                    <?php foreach ($buku as $b): ?>
                        <option value="<?= $b['id_buku'] ?>" 
                            <?= $b['id_buku'] == $data['id_buku'] ? 'selected' : '' ?>>
                            <?= $b['judul'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>

        <label>Tanggal Pinjam</label>
        <input type="date" class="input" name="tanggal_pinjam" value="<?= $data['tanggal_pinjam'] ?>" required>

        <label>Tanggal Kembali</label>
        <input 
            type="date" 
            class="input" 
            name="tanggal_kembali" 
            value="<?= $data['tanggal_kembali'] !== null ? $data['tanggal_kembali'] : '' ?>"
        >

        <label>Status</label>
        <select name="status" class="input" required>
            <option value="Dipinjam" <?= $data['status']=='Dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
            <option value="Dikembalikan" <?= $data['status']=='Dikembalikan' ? 'selected' : '' ?>>Dikembalikan</option>
        </select>

        <button class="btn-submit" type="submit">Update</button>
        <a href="<?= BASE_URL ?>peminjaman" class="btn-back">← Kembali</a>

    </form>
</div>

</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
