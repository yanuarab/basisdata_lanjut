<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<div class="content">
    <h2>Data Anggota</h2>

    <a href="<?= BASE_URL ?>anggota/create" class="btn btn-primary">+ Tambah Anggota</a>
    <br><br>

    <table border="1" width="100%" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>No HP</th>
            <th>Aksi</th>
        </tr>

        <?php foreach ($data as $row): ?>
        <tr>
            <td><?= $row['id_anggota'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['alamat'] ?></td>
            <td><?= $row['no_hp'] ?></td>

            <td>
                <a href="<?= BASE_URL ?>anggota/edit/<?= $row['id_anggota'] ?>">Edit</a> |
                <a href="<?= BASE_URL ?>anggota/delete/<?= $row['id_anggota'] ?>"
                   onclick="return confirm('Hapus anggota ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
