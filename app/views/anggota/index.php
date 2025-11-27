<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<style>
.table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 6px;
    overflow: hidden;
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
    margin-top: 15px;
    margin-bottom: 15px;
}
.search-box input {
    padding: 8px;
    width: 280px;
    border: 1px solid #aaa;
    border-radius: 4px;
}
.search-box button {
    padding: 8px 18px;
    background: #444;
    color: white;
    border: none;
    border-radius: 4px;
}
.pagination a {
    padding: 6px 12px;
    margin-right: 5px;
    border: 1px solid #555;
    text-decoration: none;
    border-radius: 4px;
}
.pagination .active {
    background: #444;
    color: white;
}
</style>

<div class="content">
    <h2>Data Anggota</h2>

    <a href="<?= BASE_URL ?>anggota/create" class="btn btn-primary">+ Tambah Anggota</a>

    <!-- Search -->
    <div class="search-box">
        <input type="text" id="search" 
            placeholder="Cari nama atau alamat..."
            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">

        <button id="btnSearch">Cari</button>
    </div>

    <table class="table">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>No HP</th>
            <th>Aksi</th>
        </tr>

        <?php if (!empty($data)): ?>
            <?php foreach ($data as $row): ?>
            <tr>
                <td><?= $row['id_anggota'] ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td><?= htmlspecialchars($row['no_hp']) ?></td>
                <td>
                    <a href="<?= BASE_URL ?>anggota/edit/<?= $row['id_anggota'] ?>">Edit</a> |
                    <a href="<?= BASE_URL ?>anggota/delete/<?= $row['id_anggota'] ?>"
                       onclick="return confirm('Hapus anggota ini?')">
                       Hapus
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" style="text-align:center">Tidak ada data</td></tr>
        <?php endif; ?>
    </table>

    <!-- Pagination -->
    <div class="pagination" style="margin-top:15px;">
        <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <a href="<?= BASE_URL ?>anggota?page=<?= $i ?>&search=<?= urlencode($_GET['search'] ?? '') ?>"
                class="<?= ($i == ($page ?? 1)) ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
</div>

<script>
// debounce
let timer;
let delay = 500;

document.getElementById("search").addEventListener("keyup", function() {
    clearTimeout(timer);
    const keyword = this.value;

    timer = setTimeout(() => {
        window.location.href = "<?= BASE_URL ?>anggota?search=" + encodeURIComponent(keyword);
    }, delay);
});

// tombol Cari
document.getElementById("btnSearch").addEventListener("click", function() {
    const keyword = document.getElementById("search").value;
    window.location.href = "<?= BASE_URL ?>anggota?search=" + encodeURIComponent(keyword);
});
</script>

<?php include __DIR__ . '/../template/footer.php'; ?>
