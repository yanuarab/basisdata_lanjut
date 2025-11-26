<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<div class="content">
    <h2>Data Peminjaman</h2>

    <a href="<?= BASE_URL ?>peminjaman/create" class="btn btn-primary">+ Tambah Peminjaman</a>
    <br><br>

    <table border="1" width="100%" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nama Anggota</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php if (!empty($data)): ?>
            <?php foreach ($data as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['id_peminjaman']) ?></td>
                <td><?= htmlspecialchars($row['nama_anggota'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['judul_buku'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['tanggal_pinjam']) ?></td>
                <td><?= htmlspecialchars($row['tanggal_kembali']?? '') ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>

                <td>
                    <a href="<?= BASE_URL ?>peminjaman/edit/<?= $row['id_peminjaman'] ?>">Edit</a> |
                    <a href="<?= BASE_URL ?>peminjaman/delete/<?= $row['id_peminjaman'] ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7" style="text-align:center">Belum ada data peminjaman</td></tr>
        <?php endif; ?>
    </table>

</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
