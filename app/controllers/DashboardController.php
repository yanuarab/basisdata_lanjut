<?php
require_once __DIR__ . '/../models/Buku.php';
require_once __DIR__ . '/../models/Anggota.php';
require_once __DIR__ . '/../models/Peminjaman.php';
require_once __DIR__ . '/../models/BukuPopuler.php';
class DashboardController 
{
    private $buku;
    private $anggota;
    private $peminjaman;
    private $populer;

    public function __construct($pdo) {
        $this->buku        = new Buku($pdo);
        $this->anggota     = new Anggota($pdo);
        $this->peminjaman  = new Peminjaman($pdo);
        $this->populer     = new BukuPopuler($pdo);
    }

    public function index() 
    {

        // Cek login
        if (!isset($_SESSION['admin'])) {
            header("Location: " . BASE_URL . "login");
            exit;
        }

        $data = [
            "total_buku"        => $this->buku->getTotalBuku(),
            "stok_max"          => $this->buku->getBukuStokMax(),
            "stok_min"          => $this->buku->getBukuStokMin(),
            "buku_menipis"      => $this->buku->getBukuMenipis(),
            "total_anggota"     => $this->anggota->getTotalAnggota(),
            "pinjam_hari_ini"   => $this->peminjaman->getPeminjamanHariIni(),
            "buku_populer"      => $this->populer->getBukuPalingPopuler()
        ];

        // Tampilkan view
        include __DIR__ . '/../views/dashboard/index.php';
    }
}
