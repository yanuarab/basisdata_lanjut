<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<div class="content">
    <h2>Data Buku</h2>

    <a href="<?= BASE_URL ?>buku/create" class="btn btn-primary">+ Tambah Buku</a>
    <br><br>

    <table border="1" width="100%" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Tahun Terbit</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php foreach ($data as $row): ?>
        <tr>
            <td><?= $row['id_buku'] ?></td>
            <td><?= $row['judul'] ?></td>
            <td><?= $row['pengarang'] ?></td>
            <td><?= $row['tahun_terbit'] ?></td>
            <td><?= $row['stok'] ?></td>

            <td>
                <a href="<?= BASE_URL ?>buku/edit/<?= $row['id_buku'] ?>">Edit</a> |
                <a href="<?= BASE_URL ?>buku/delete/<?= $row['id_buku'] ?>" 
                   onclick="return confirm('Hapus buku ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
