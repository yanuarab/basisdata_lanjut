<?php include __DIR__ . '/../template/header.php'; ?>
<?php include __DIR__ . '/../template/sidebar.php'; ?>

<style>
    @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');

    body {
        background: #f5f7fb;
    }

    .content {
        padding: 30px;
        font-family: 'Inter', Arial, sans-serif;
        color: #2c3e50;
    }

    h1 {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .top-cards {
        display: flex;
        gap: 20px;
        margin-top: 25px;
    }

    .top-card {
        flex: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 22px;
        background: rgba(255, 255, 255, 0.55);
        border-radius: 22px;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 14px rgba(0,0,0,0.07);
        border: 1px solid rgba(255,255,255,0.65);
        transition: .25s;
    }

    .top-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.10);
    }

    .top-card-title {
        font-size: 14px;
        font-weight: 600;
        color: #555;
        margin-bottom: 4px;
    }

    .top-card-number {
        font-size: 28px;
        font-weight: 700;
        color: #1e88e5;
    }

    .top-card-icon i {
        font-size: 33px;
        color: #1e88e5;
        opacity: .9;
    }

    /* Statistik Cards */
    .cards {
        display: flex;
        justify-content: center;
        gap: 18px;
        margin-top: 25px;
    }

    .card {
        width: 260px;
        padding: 18px;
        background: rgba(255, 255, 255, 0.55);
        border-radius: 18px;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 14px rgba(0,0,0,0.07);
        border: 1px solid rgba(255,255,255,0.65);
        transition: .25s;
        text-align: center;
    }

    .card:hover {
        transform: translateY(-4px);
    }

    .card i {
        font-size: 28px;
        margin-bottom: 6px;
        color: #1e88e5;
    }

    .card h3 {
        font-size: 15px;
        margin-bottom: 8px;
        color: #333;
    }

    .card span {
        font-size: 22px;
        font-weight: 700;
        color: #1e88e5;
    }

    /* TABLE */
    .table-card {
        margin-top: 25px;
        padding: 22px;
        background: rgba(255,255,255,0.55);
        border-radius: 18px;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 14px rgba(0,0,0,0.07);
        border: 1px solid rgba(255,255,255,0.65);
    }

    table {
        width: 100%;
        font-size: 14px;
        border-collapse: collapse;
        margin-top: 12px;
    }

    th, td {
        padding: 10px 12px;
        border-bottom: 1px solid #e5e5e5;
    }

    th {
        text-align: left;
        background: #f0f2f6;
        font-weight: 700;
    }

    tr:hover {
        background: #f9fbff;
        transition: .15s;
    }

</style>

<div class="content">

    <h1>Halo, Admin <i class="fa-solid fa-hand-peace"></i></h1>
    <p>Selamat datang di halaman <b>Dashboard</b></p>

    <!-- ======== TOP CARDS (Rectangular) ======== -->
    <div class="top-cards">

        <div class="top-card">
            <div>
                <div class="top-card-title">Total Buku</div>
                <div class="top-card-number"><?= $data['total_buku']; ?></div>
            </div>
            <div class="top-card-icon">
                <i class="fa-solid fa-book"></i>
            </div>
        </div>

        <div class="top-card">
            <div>
                <div class="top-card-title">Total Anggota</div>
                <div class="top-card-number"><?= $data['total_anggota']; ?></div>
            </div>
            <div class="top-card-icon">
                <i class="fa-solid fa-user-group"></i>
            </div>
        </div>

        <div class="top-card">
            <div>
                <div class="top-card-title">Peminjaman Hari Ini</div>
                <div class="top-card-number"><?= $data['pinjam_hari_ini']; ?></div>
            </div>
            <div class="top-card-icon">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
        </div>

    </div>

    <!-- ======== STATISTIK BUKU ======== -->
    <h2 style="margin-top: 35px;">📘 Statistik Buku</h2>

    <div class="cards">

        <div class="card">
            <i class="fa-solid fa-arrow-up-wide-short"></i>
            <h3>Stok Terbanyak</h3>
            <p><b><?= $data['stok_max']['judul']; ?></b></p>
            <span><?= $data['stok_max']['stok']; ?></span>
        </div>

        <div class="card">
            <i class="fa-solid fa-arrow-down-short-wide"></i>
            <h3>Stok Tersedikit</h3>
            <p><b><?= $data['stok_min']['judul']; ?></b></p>
            <span><?= $data['stok_min']['stok']; ?></span>
        </div>

        <div class="card">
            <i class="fa-solid fa-fire"></i>
            <h3>Buku Paling Populer</h3>
            <p><b><?= $data['buku_populer']['judul']; ?></b></p>
            <span><?= $data['buku_populer']['total_pinjam']; ?>x</span>
        </div>

    </div>

    <!-- ======== STOK MENIPIS (TABLE) ======== -->
    <div class="table-card">
        <h2>📉 Stok Buku Menipis</h2>

        <table>
            <thead>
                <tr>
                    <th>Nama Buku</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    // ambil hanya 5 buku terendah
                    $list = array_slice($data['buku_menipis'], 0, 5);
                ?>
                <?php foreach ($list as $b): ?>
                    <tr>
                        <td><?= $b['judul']; ?></td>
                        <td><?= $b['stok']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</div>

<?php include __DIR__ . '/../template/footer.php'; ?>
