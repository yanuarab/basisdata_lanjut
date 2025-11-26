<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<div class="content">
    <div class="card">

        <div class="card-header">
            <h2>Tambah Peminjaman</h2>
            <a href="<?= BASE_URL ?>peminjaman" class="btn btn-secondary">Kembali</a>
        </div>

        <div class="card-body">
            <form action="<?= BASE_URL ?>peminjaman/store" method="POST">

                <label>Anggota</label>
                <select name="id_anggota" required>
                    <option value="">-- pilih anggota --</option>
                    <?php foreach ($anggota as $a): ?>
                        <option value="<?= $a['id_anggota'] ?>"><?= $a['nama'] ?></option>
                    <?php endforeach; ?>
                </select>

                <label>Buku</label>
                <select name="id_buku" required>
                    <option value="">-- pilih buku --</option>
                    <?php foreach ($buku as $b): ?>
                        <option value="<?= $b['id_buku'] ?>"><?= $b['judul'] ?></option>
                    <?php endforeach; ?>
                </select>

                <label>Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" required>

                <label>Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" required>

                <label>Status</label>
                <select name="status" required>
                    <option value="Dipinjam">Dipinjam</option>
                    <option value="Dikembalikan">Dikembalikan</option>
                </select>

                <button type="submit" class="btn btn-primary">Simpan</button>

            </form>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
