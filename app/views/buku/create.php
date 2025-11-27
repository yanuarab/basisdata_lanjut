<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<style>
/* ============================
   CARD CONTAINER
============================ */
.form-card {
    width: 380px;                       /* KECILKAN card */
    margin: 20px auto;
    padding: 42px;
    background: rgba(217, 217, 217, 0.45);
    border: 1px solid #fff;
    box-shadow: 10px 14px 40px rgba(0, 0, 0, 0.15);
    backdrop-filter: blur(6px);
    border-radius: 15px;
    transition: 0.35s;
}

.form-card:hover {
    transform: scale(1.01);
    border: 1px solid #888;
}

/* ============================
   INPUT UIVERSE (compact)
============================ */
.input {
    width: 100%;             /* FULL tapi tetap kecil */
    height: 32px;            /* << kecil & rapi */
    padding: 5px 10px;
    border-radius: 10px;
    border: 1.5px solid #ccc;
    outline: none;
    transition: 0.25s;
    font-size: 14px;         /* kecilkan teks */
    margin-bottom: 12px;
}

.input:hover {
    border: 1.5px solid #b7b7b7;
}

.input:focus {
    border: 2px solid #555;
}

/* ============================
   DROPDOWN
============================ */
select.input {
    background: white;
    cursor: pointer;
}

/* ============================
    LABEL
============================ */
label {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 4px;
    display: block;
}

/* ============================
   ROW FLEX
============================ */
.row-flex {
    display: flex;
    gap: 10px;
}

.row-flex .col {
    flex: 1;
}

/* ============================
   BUTTON STYLE
============================ */
.btn-submit {
    width: 100%;
    padding: 9px;              /* kecilkan */
    margin-top: 5px;
    border-radius: 10px;
    border: none;
    background: #333;
    color: white;
    font-size: 15px;
    cursor: pointer;
    transition: 0.25s;
}

.btn-submit:hover {
    background: #000;
}

.btn-back {
    display: inline-block;
    margin-top: 10px;
    text-decoration: none;
    color: #333;
    font-size: 14px;
}
.btn-back:hover {
    text-decoration: underline;
}

</style>

<div class="content">
    <h2 style="text-align:center; margin-bottom:20px;">Tambah Buku</h2>

    <div class="form-card">

        <form method="POST" action="<?= BASE_URL ?>buku/store">

            <!-- JUDUL -->
            <label>Judul Buku</label>
            <input type="text" class="input" name="judul" required>

            <!-- PENGARANG -->
            <label>Pengarang</label>
            <input type="text" class="input" name="pengarang" required>

            <!-- TAHUN TERBIT -->
            <label>Tahun Terbit</label>
            <input type="number" class="input" name="tahun_terbit" required>

            <!-- KATEGORI & PENERBIT sejajar -->
            <div class="row-flex">
                <div class="col">
                    <label>Kategori</label>
                    <select class="input" name="id_kategori" required>
                        <option value="">-- Pilih --</option>
                        <?php foreach ($kategori as $k): ?>
                            <option value="<?= $k['id_kategori'] ?>">
                                <?= htmlspecialchars($k['nama_kategori']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col">
                    <label>Penerbit</label>
                    <select class="input" name="id_penerbit" required>
                        <option value="">-- Pilih --</option>
                        <?php foreach ($penerbit as $p): ?>
                            <option value="<?= $p['id_penerbit'] ?>">
                                <?= htmlspecialchars($p['nama_penerbit']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- STOK -->
            <label>Stok</label>
            <input type="number" class="input" name="stok" required>

            <!-- BUTTON -->
            <button class="btn-submit" type="submit">Buat Buku</button>
            <a href="<?= BASE_URL ?>buku" class="btn-back">← Kembali</a>

        </form>
    </div>
</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
