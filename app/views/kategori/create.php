<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<div class="content">

<style>
.form-card {
    width: 380px;
    margin: 20px auto;
    padding: 30px;
    background: rgba(217, 217, 217, 0.45);
    border: 1px solid #fff;
    box-shadow: 10px 14px 40px rgba(0, 0, 0, 0.15);
    backdrop-filter: blur(6px);
    border-radius: 15px;
}
.input {
    width: 100%;
    height: 32px;
    padding: 5px 10px;
    border-radius: 10px;
    border: 1.5px solid #ccc;
    margin-bottom: 12px;
}
textarea.input {
    height: 70px;
    resize: none;
}
.btn-submit {
    width: 100%;
    padding: 9px;
    border-radius: 10px;
    border: none;
    background: #333;
    color: white;
    font-size: 15px;
}
</style>

    <div class="form-card">
        <h3 style="text-align:center;margin-bottom:15px;">Tambah Kategori</h3>

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
