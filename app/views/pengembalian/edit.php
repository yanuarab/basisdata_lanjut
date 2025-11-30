<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<link rel="stylesheet" href="<?= BASE_URL ?>assets/createEdit.css">

<div class="content">

<div class="form-card">
    <h2 class="card-title">Edit Data Pengembalian</h2>

    <form action="<?= BASE_URL ?>pengembalian/update" method="POST">

        <input type="hidden" name="id_pengembalian" value="<?= $data['id_pengembalian'] ?>">

        <div class="row-flex">

            <div class="col">
                <label>Anggota</label>
                <select name="id_anggota" class="input" required>
                    <?php foreach ($anggota as $a): ?>
                        <option value="<?= $a['id_anggota'] ?>" 
                            <?= $a['id_anggota'] == $data['id_anggota'] ? 'selected' : '' ?>>
                            <?= $a['nama'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col">
                <label>Buku</label>
                <select name="id_buku" class="input" required>
                    <?php foreach ($buku as $b): ?>
                        <option value="<?= $b['id_buku'] ?>" 
                            <?= $b['id_buku'] == $data['id_buku'] ? 'selected' : '' ?>>
                            <?= $b['judul'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>

        <label>Tanggal Kembali</label>
        <input type="date" class="input" name="tanggal_kembali" value="<?= $data['tanggal_kembali'] ?>" required>

        <label>Denda</label>
        <input type="number" class="input" name="denda" value="<?= $data['denda'] ?>">

        <button class="btn-submit" type="submit">Update</button>
        <a href="<?= BASE_URL ?>pengembalian" class="btn-back">← Kembali</a>

    </form>
</div>

</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
