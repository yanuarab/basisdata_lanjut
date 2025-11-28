<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<!-- load css -->
<link rel="stylesheet" href="<?= BASE_URL ?>assets/createEdit.css">

<div class="content">
    <div class="form-card">
        <h3 class="card-title">Tambah Kategori Buku</h3>

        <form method="POST" action="<?= BASE_URL ?>kategori/store">

            <label>Nama Kategori</label>
            <input type="text" class="input" name="nama_kategori" required>

            <label>Deskripsi</label>
            <textarea class="input" name="deskripsi" required></textarea>

            <button class="btn-submit" type="submit">Simpan</button>
            <a href="<?= BASE_URL ?>kategori" class="btn-back">← Kembali</a>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
