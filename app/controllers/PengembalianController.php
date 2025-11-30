<?php
require_once __DIR__ . '/../models/Pengembalian.php';

class PengembalianController {

    private $model;

    public function __construct($pdo) {
        $this->model = new Pengembalian($pdo);
    }

    public function index() {
        $keyword = $_GET['search'] ?? '';

        $limit = 10;
        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
        $offset = ($page - 1) * $limit;

        $totalData = $this->model->countData($keyword);
        $totalPage = (int) ceil($totalData / $limit);

        $data = $this->model->getPagination($limit, $offset, $keyword);

        require_once __DIR__ . '/../views/pengembalian/index.php';
    }

    public function create() {
        $anggota = $this->model->anggotaList();
        $buku = $this->model->bukuList();
        $peminjaman = $this->model->peminjamanList();

        require_once __DIR__ . '/../views/pengembalian/create.php';
    }

    public function store() {
        // Basic validation: pastikan id_peminjaman ada
        $id_peminjaman = $_POST['id_peminjaman'] ?? null;
        $tanggal_pengembalian = $_POST['tanggal_pengembalian'] ?? null;
        $denda = $_POST['denda'] ?? 0;

        if (empty($id_peminjaman)) {
            // bisa set flash message atau redirect dengan pesan error
            header("Location: " . BASE_URL . "pengembalian/create");
            exit;
        }

        $this->model->store($id_peminjaman, $tanggal_pengembalian, $denda);

        header("Location: " . BASE_URL . "pengembalian");
        exit;
    }

    public function edit($id) {
        $data = $this->model->find($id);

        if (!$data) {
            // item tidak ditemukan
            header("Location: " . BASE_URL . "pengembalian");
            exit;
        }

        require_once __DIR__ . '/../views/pengembalian/edit.php';
    }

    public function update() {
        // Pastikan field penting ada
        $id_pengembalian = $_POST['id_pengembalian'] ?? null;
        $id_peminjaman = $_POST['id_peminjaman'] ?? null; // harus dikirim sebagai hidden
        $tanggal_pengembalian = $_POST['tanggal_pengembalian'] ?? null;
        $denda = $_POST['denda'] ?? 0;

        if (empty($id_pengembalian) || empty($id_peminjaman)) {
            // invalid request, redirect ke list
            header("Location: " . BASE_URL . "pengembalian");
            exit;
        }

        $this->model->update($id_pengembalian, $id_peminjaman, $tanggal_pengembalian, $denda);

        header("Location: " . BASE_URL . "pengembalian");
        exit;
    }

    public function delete($id) {
        $this->model->delete($id);
        header("Location: " . BASE_URL . "pengembalian");
        exit;
    }
}
