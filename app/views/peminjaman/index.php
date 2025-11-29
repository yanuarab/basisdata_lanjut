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

.table td, 
.table th {
    text-align: center;
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
    color: black;
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

/* Button Tambah Data */
.btn-add {
    padding: 12px 28px;
    text-decoration: none;
    color: black;
    border-radius: 50px;
    cursor: pointer;
    border: 0;
    background-color: white;
    box-shadow: rgb(0 0 0 / 5%) 0 0 8px;
    letter-spacing: 1px;
    font-size: 15px;
    transition: all 0.4s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-add:hover {
    letter-spacing: 2px;
    background-color: hsl(261deg 80% 48%);
    color: white;
    box-shadow: rgb(93 24 220) 0px 7px 29px 0px;
}

.btn-add:active {
    background-color: hsl(261deg 80% 48%);
    color: white;
    transform: translateY(5px);
}


.action-btn,
.action-btn:focus,
.action-btn:active {
    outline: none !important;
    box-shadow: none !important;
}

.action-group a:focus {
    outline: none !important;
}

/* container tombol agar sejajar */
.action-group {
    display: flex;
    gap: 8px;
    justify-content: center;
}

/* button edit & delete */
.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background-color: #444;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: .25s ease;
    overflow: hidden;
    position: relative;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.15);
}

.action-btn i {
    font-size: 14px;
    color: white;
    transition: .25s ease;
}

/* Lebar hover lebih kecil (tidak lebay) */
.action-btn:hover {
    width: 85px;
    border-radius: 50px;
}

/* TEXT CENTER FIX */
.action-btn::before {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) translateY(12px); 
    font-size: 1px;
    color: white;
    opacity: 0;
    transition: all .25s ease;
}

/* EDIT */
.btn-edit::before {
    content: "Edit";
}

.btn-edit:hover {
    background-color: #10d382;
}

.btn-edit:hover::before {
    opacity: 1;
    font-size: 12px;
    transform: translate(-50%, -50%) translateY(-3px); /* naik dikit */
}

/* DELETE */
.btn-delete::before {
    content: "Delete";
}

.btn-delete:hover {
    background-color: #ff4545;
}

.btn-delete:hover::before {
    opacity: 1;
    font-size: 12px;
    transform: translate(-50%, -50%) translateY(-3px); /* naik dikit */
}

/* Icon sliding lebih halus & tidak terlalu jauh */
.action-btn:hover i {
    transform: translateY(80%);
    font-size: 26px;
}



</style>

<div class="content">
    <h2>Data Peminjaman</h2>

    <a href="<?= BASE_URL ?>peminjaman/create" class="btn-add">
        <i class="fas fa-plus"></i> Tambah Peminjaman
    </a>

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
    <div class="action-group">
        <a href="<?= BASE_URL ?>peminjaman/edit/<?= $row['id_peminjaman'] ?>">
            <button class="action-btn btn-edit">
                <i class="fas fa-pen"></i>
            </button>
        </a>

        <a href="<?= BASE_URL ?>peminjaman/delete/<?= $row['id_peminjaman'] ?>"
           onclick="return confirm('Hapus data ini?')">
            <button class="action-btn btn-delete">
                <i class="fas fa-trash"></i>
            </button>
        </a>
    </div>
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
