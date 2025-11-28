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
.search-box button:hover {
    background: #222;
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
    <h2>Laporan Buku Lengkap</h2>

    <!-- Search -->
    <div class="search-box">
        <input 
            type="text" 
            id="search" 
            placeholder="Cari judul / kategori / penerbit..."
            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
        >
        <button id="btnSearch">Cari</button>
    </div>

    <table class="table">
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Penerbit</th>
            <th>Stok</th>
        </tr>

        <?php if (!empty($data)): ?>
            <?php $no = $offset + 1; ?>
            <?php foreach ($data as $row): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['judul']) ?></td>
                <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                <td><?= htmlspecialchars($row['nama_penerbit']) ?></td>
                <td><?= htmlspecialchars($row['stok']) ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" style="text-align:center;">Tidak ada data</td></tr>
        <?php endif; ?>
    </table>

    <!-- Pagination -->
    <div class="pagination" style="margin-top:15px;">
        <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <a href="<?= BASE_URL ?>laporan?page=<?= $i ?>&search=<?= urlencode($_GET['search'] ?? '') ?>"
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

document.getElementById("search").addEventListener("keyup", function () {
    clearTimeout(timer);
    timer = setTimeout(() => {
        window.location.href = "<?= BASE_URL ?>laporan?search=" 
            + encodeURIComponent(this.value);
    }, delay);
});

// tombol cari
document.getElementById("btnSearch").addEventListener("click", function () {
    const keyword = document.getElementById("search").value;
    window.location.href = "<?= BASE_URL ?>laporan?search=" 
        + encodeURIComponent(keyword);
});
</script>

<?php include __DIR__ . '/../template/footer.php'; ?>
