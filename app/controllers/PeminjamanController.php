<?php
require_once __DIR__ . '/../models/Peminjaman.php';

class PeminjamanController
{
    private $model;
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->model = new Peminjaman($pdo);
    }

    public function index()
    {
        $data = $this->model->all();
        // view akan menerima $data
        require_once __DIR__ . '/../views/peminjaman/index.php';
    }

    public function create()
    {
        $anggota = $this->model->anggotaList();
        $buku = $this->model->bukuList();
        require_once __DIR__ . '/../views/peminjaman/create.php';
    }

    public function store()
    {
        // sanitasi minimal, kamu bisa tambah validasi
        $payload = [
            'id_anggota' => $_POST['id_anggota'] ?? null,
            'id_buku' => $_POST['id_buku'] ?? null,
            'tanggal_pinjam' => $_POST['tanggal_pinjam'] ?? date('Y-m-d'),
            'tanggal_kembali' => $_POST['tanggal_kembali'] ?: null,
            'status' => $_POST['status'] ?? 'Dipinjam'
        ];

        $this->model->store($payload);
        header("Location: " . BASE_URL . "peminjaman");
        exit;
    }

    public function edit($id)
    {
        $data = $this->model->find($id);
        $anggota = $this->model->anggotaList();
        $buku = $this->model->bukuList();
        require_once __DIR__ . '/../views/peminjaman/edit.php';
    }

    public function update()
    {
        $payload = [
            'id_peminjaman' => $_POST['id_peminjaman'],
            'id_anggota' => $_POST['id_anggota'] ?? null,
            'id_buku' => $_POST['id_buku'] ?? null,
            'tanggal_pinjam' => $_POST['tanggal_pinjam'] ?? date('Y-m-d'),
            'tanggal_kembali' => $_POST['tanggal_kembali'] ?: null,
            'status' => $_POST['status'] ?? 'Dipinjam'
        ];

        $this->model->update($payload);
        header("Location: " . BASE_URL . "peminjaman");
        exit;
    }

    public function delete($id)
    {
        $this->model->delete($id);
        header("Location: " . BASE_URL . "peminjaman");
        exit;
    }
}
