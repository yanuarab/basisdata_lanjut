<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<style>
.table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 6px;
    overflow: hidden;
    margin-top: 10px;
}
.table th {
    background: #444;
    color: white;
    padding: 10px;
}
.table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}
.table tr:hover {
    background: #f2f2f2;
}

.table td, 
.table th {
    text-align: left;
}
</style>

<div class="content">
    <h2>Buku Paling Populer</h2>

    <?php if (!empty($_SESSION['msg'])): ?>
        <div style="background:#c7ffd0;padding:10px;border-radius:5px;margin:10px 0;">
            <?= $_SESSION['msg']; unset($_SESSION['msg']); ?>
        </div>
    <?php endif; ?>

    <a href="<?= BASE_URL ?>buku-populer/refresh" 
       class="btn btn-primary" 
       style="margin-bottom:10px;display:inline-block;">
        🔄 Refresh Data
    </a>

    <table class="table">
        <tr>
            <th>No</th>
            <th>Judul Buku</th>
            <th>Total Dipinjam</th>
        </tr>

        <?php $no = 1; ?>
        <?php foreach ($data as $row): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['judul']) ?></td>
            <td><?= $row['total_pinjam'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

</div>

<?php include __DIR__ . '/../template/footer.php'; ?>