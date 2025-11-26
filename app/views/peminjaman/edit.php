<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<div class="content">
    <div class="card">

        <div class="card-header">
            <h2>Edit Data Peminjaman</h2>
            <a href="<?= BASE_URL ?>peminjaman" class="btn btn-secondary">Kembali</a>
        </div>

        <div class="card-body">
            <form action="<?= BASE_URL ?>peminjaman/update" method="POST">

                <input type="hidden" name="id_peminjaman" value="<?= $data['id_peminjaman'] ?>">

                <label>Anggota</label>
                <select name="id_anggota" required>
                    <?php foreach ($anggota as $a): ?>
                        <option value="<?= $a['id_anggota'] ?>" 
                            <?= $a['id_anggota'] == $data['id_anggota'] ? 'selected' : '' ?>>
                            <?= $a['nama'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Buku</label>
                <select name="id_buku" required>
                    <?php foreach ($buku as $b): ?>
                        <option value="<?= $b['id_buku'] ?>" 
                            <?= $b['id_buku'] == $data['id_buku'] ? 'selected' : '' ?>>
                            <?= $b['judul'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" value="<?= $data['tanggal_pinjam'] ?>" required>

                <label>Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" value="<?= $data['tanggal_kembali'] ?>" required>

                <label>Status</label>
                <select name="status" required>
                    <option value="Dipinjam" <?= $data['status']=='Dipinjam'?'selected':'' ?>>Dipinjam</option>
                    <option value="Dikembalikan" <?= $data['status']=='Dikembalikan'?'selected':'' ?>>Dikembalikan</option>
                </select>

                <button type="submit" class="btn btn-primary">Update</button>

            </form>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
