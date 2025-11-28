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
.search-box {
    display: flex;
    gap: 10px;
    margin: 15px 0;
}
.search-box input {
    padding: 8px;
    width: 280px;
    border: 1px solid #aaa;
    border-radius: 4px;
}
.search-box button {
    padding: 8px 15px;
    background: #444;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
.pagination a {
    padding: 6px 12px;
    margin-right: 5px;
    border: 1px solid #666;
    text-decoration: none;
    border-radius: 4px;
}
.pagination .active {
    background: #444;
    color: white;
}
</style>

<div class="content">
    <h2>Kategori Buku</h2>

    <a href="<?= BASE_URL ?>kategori/create" class="btn btn-primary">+ Tambah Kategori</a>

    <div class="search-box">
        <input type="text" id="search" placeholder="Cari kategori..."
               value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button id="btnSearch">Cari</button>
    </div>

    <table class="table">
        <tr>
            <th>ID</th>
            <th>Nama Kategori</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>

        <?php if (!empty($data)): ?>
            <?php foreach ($data as $row): ?>
            <tr>
                <td><?= $row['id_kategori'] ?></td>
                <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                <td>
                    <a href="<?= BASE_URL ?>kategori/edit/<?= $row['id_kategori'] ?>">Edit</a> |
                    <a href="<?= BASE_URL ?>kategori/delete/<?= $row['id_kategori'] ?>"
                        onclick="return confirm('Hapus kategori ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4" style="text-align:center;">Tidak ada data</td></tr>
        <?php endif; ?>
    </table>

    <div class="pagination" style="margin-top:15px;">
        <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <a href="<?= BASE_URL ?>kategori?page=<?= $i ?>&search=<?= urlencode($_GET['search'] ?? '') ?>"
               class="<?= ($i == ($page ?? 1)) ? 'active' : '' ?>">
               <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
</div>

<script>
document.getElementById("search").addEventListener("keyup", function () {
    let keyword = this.value;
    clearTimeout(window.timer);
    window.timer = setTimeout(() => {
        window.location.href = "<?= BASE_URL ?>kategori?search=" + encodeURIComponent(keyword);
    }, 500);
});

document.getElementById("btnSearch").onclick = function () {
    const key = document.getElementById("search").value;
    window.location.href = "<?= BASE_URL ?>kategori?search=" + encodeURIComponent(key);
}
</script>

<?php include __DIR__ . '/../template/footer.php'; ?>
