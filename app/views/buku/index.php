<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<?php
$search   = trim($_GET['search']   ?? '');
$kategori = trim($_GET['kategori'] ?? '');
$penerbit = trim($_GET['penerbit'] ?? '');
$tahun    = trim($_GET['tahun']    ?? '');

?>

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

/* ACTION BUTTON */
.action-group {
    display: flex;
    gap: 8px;
    justify-content: center;
}

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

.action-btn:hover {
    width: 85px;
    border-radius: 50px;
}

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
    transform: translate(-50%, -50%) translateY(-3px);
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
    transform: translate(-50%, -50%) translateY(-3px);
}

/* Icon slide */
.action-btn:hover i {
    transform: translateY(80%);
    font-size: 26px;
}

.alert-success {
    padding: 10px;
    background: #d4edda8e;
    border-left: 5px solid #28a74698;
    margin-top: 10px;
    border-radius: 5px;
    color: #226231ff;
}

.alert-danger {
    padding: 10px;
    background: #edd4d48e;
    border-left: 5px solid #a7282898;
    margin-top: 10px;
    border-radius: 5px;
    color: #622222ff;
}
</style>


<div class="content">
    <h2>Data Buku</h2>

    <a href="<?= BASE_URL ?>buku/create" class="btn-add">
        <i class="fas fa-plus"></i> Tambah Buku
    </a>

    <div style="margin-top: 20px;">
    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'created'): ?>
        <div class="alert alert-success">
            Buku telah dibuat!
        </div>
    <?php endif; ?>

    <div style="margin-top: 20px;">
    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'updated'): ?>
        <div class="alert alert-success">
            Buku telah diedit!
        </div>
    <?php endif; ?>

    <div style="margin-top: 20px;">
    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
        <div class="alert alert-danger">
            Buku telah dihapus!
        </div>
    <?php endif; ?>

    <!-- FILTER -->
    <form method="GET" style="margin-top:15px; display:flex; gap:10px; flex-wrap:wrap;">
        <input type="text" name="search" placeholder="Cari judul atau pengarang..."
               value="<?= htmlspecialchars($search) ?>"
               style="padding:8px; width:250px;">

        <select name="kategori" style="padding:8px;">
            <option value="">Semua Kategori</option>
            <?php foreach ($kategoriList as $k): ?>
                <option value="<?= $k['id_kategori'] ?>"
                    <?= ($kategori == $k['id_kategori']) ? 'selected' : '' ?>>
                    <?= $k['nama_kategori'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="penerbit" style="padding:8px;">
            <option value="">Semua Penerbit</option>
            <?php foreach ($penerbitList as $p): ?>
                <option value="<?= $p['id_penerbit'] ?>"
                    <?= ($penerbit == $p['id_penerbit']) ? 'selected' : '' ?>>
                    <?= $p['nama_penerbit'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="number" name="tahun" placeholder="Tahun"
               value="<?= htmlspecialchars(trim($tahun)) ?>"
               style="padding:8px; width:110px;">

        <button type="submit" style="padding:8px 16px; background:#444; color:white;">Filter</button>

        <a href="<?= BASE_URL ?>buku" 
           style="padding:8px 16px; background:#aaa; border-radius:4px; text-decoration:none; color:black;">
           Reset
        </a>
    </form>

    <table class="table">
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Tahun Terbit</th>
            <th>Kategori</th>
            <th>Penerbit</th>
            <th>Stok</th>
            <!-- <th>ISBN</th> -->
            <th>Aksi</th>
        </tr>

        <?php if (!empty($buku)): ?>
            <?php foreach ($buku as $row): ?>
            <tr>
                <td><?= $row['id_buku'] ?></td>
                <td><?= htmlspecialchars($row['judul']) ?></td>
                <td><?= htmlspecialchars($row['pengarang']) ?></td>
                <td><?= $row['tahun_terbit'] ?></td>
                <td><?= $row['nama_kategori'] ?></td>
                <td><?= $row['nama_penerbit'] ?></td>
                <td><?= $row['stok'] ?></td>


                <td>
                    <div class="action-group">
                        <a href="<?= BASE_URL ?>buku/edit/<?= $row['id_buku'] ?>">
                            <button class="action-btn btn-edit"><i class="fas fa-pen"></i></button>
                        </a>
                        <a href="<?= BASE_URL ?>buku/delete/<?= $row['id_buku'] ?>"
                           onclick="return confirm('Hapus buku ini?')">
                            <button class="action-btn btn-delete"><i class="fas fa-trash"></i></button>
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="9" style="padding:15px;">Tidak ada data</td></tr>
        <?php endif; ?>
    </table>

<div class="pagination" style="margin-top:15px;">
<?php for ($i = 1; $i <= $totalPage; $i++): ?>
    <a href="<?= BASE_URL ?>buku?page=<?= $i ?>&search=<?= urlencode($search) ?>&kategori=<?= urlencode($kategori) ?>&penerbit=<?= urlencode($penerbit) ?>&tahun=<?= urlencode($tahun) ?>"
       class="<?= ($i == $page) ? 'active' : '' ?>">
        <?= $i ?>
    </a>
<?php endfor; ?>
</div>


    </div>
</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
