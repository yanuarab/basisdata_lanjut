<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<style>
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
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
    margin-top: 10px;
}

.search-box input {
    padding: 8px;
    width: 280px;
    border: 1px solid #aaa;
    border-radius: 4px;
}

.search-box button {
    padding: 8px 15px;
    border: none;
    background: #444;
    color: white;
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
    <h2>Data Peminjaman</h2>

    <a href="<?= BASE_URL ?>peminjaman/create" class="btn btn-primary">+ Tambah Peminjaman</a>

    <!-- Search Bar -->
    <div class="search-box">
        <input 
            type="text" 
            id="search"
            placeholder="Cari nama anggota atau judul buku..."
            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
        >

        <button id="btnSearch">Cari</button>
    </div>

    <!-- Table -->
    <table class="table">
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
                <td><?= htmlspecialchars($row['nama_anggota'] ?? 'Tidak ada') ?></td>
                <td><?= htmlspecialchars($row['judul_buku'] ?? 'Tidak ada') ?></td>
                <td><?= htmlspecialchars($row['tanggal_pinjam']) ?></td>
                <td><?= htmlspecialchars($row['tanggal_kembali'] ?? '-') ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>

                <td>
                    <a href="<?= BASE_URL ?>peminjaman/edit/<?= $row['id_peminjaman'] ?>">Edit</a> |
                    <a href="<?= BASE_URL ?>peminjaman/delete/<?= $row['id_peminjaman'] ?>" 
                        onclick="return confirm('Hapus data ini?')">
                        Hapus
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="text-align:center; padding:15px;">Tidak ada data</td>
            </tr>
        <?php endif; ?>
    </table>

    <!-- Pagination -->
    <div class="pagination" style="margin-top:15px;">
        <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <a
                href="<?= BASE_URL ?>peminjaman?page=<?= $i ?>&search=<?= urlencode($_GET['search'] ?? '') ?>"
                class="<?= ($i == ($page ?? 1)) ? 'active' : '' ?>"
            ><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>

<script>
let typingTimer;
let delay = 500; // 0.5 detik debounce

// Search realtime
document.getElementById("search").addEventListener("keyup", function () {
    clearTimeout(typingTimer);

    const keyword = this.value;

    typingTimer = setTimeout(() => {
        window.location.href =
            "<?= BASE_URL ?>peminjaman?search=" + encodeURIComponent(keyword);
    }, delay);
});

// Tombol Cari
document.getElementById("btnSearch").addEventListener("click", function () {
    const keyword = document.getElementById("search").value;
    window.location.href =
        "<?= BASE_URL ?>peminjaman?search=" + encodeURIComponent(keyword);
});
</script>

<?php include __DIR__ . '/../template/footer.php'; ?>
