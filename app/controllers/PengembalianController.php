<?php
require_once __DIR__ . '/../models/Pengembalian.php';

class PengembalianController {
    private $model;

    public function __construct($pdo) {
        $this->model = new Pengembalian($pdo);
    }

    // ===========================
    // LIST / INDEX
    // ===========================
    public function index()
    {
        $keyword = $_GET['search'] ?? '';

        $limit = 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $totalData = $this->model->countData($keyword);
        $totalPage = ceil($totalData / $limit);

        $data = $this->model->getPagination($limit, $offset, $keyword);

        require_once __DIR__ . '/../views/pengembalian/index.php';
    }

    // ===========================
    // CREATE / STORE
    // ===========================
    public function store($id_peminjaman, $tanggal_pengembalian, $denda) {
        return $this->model->store($id_peminjaman, $tanggal_pengembalian, $denda);
    }

    // ===========================
    // GET BY ID
    // ===========================
    public function find($id) {
        return $this->model->find($id);
    }

    // ===========================
    // UPDATE
    // ===========================
    public function update($id, $id_peminjaman, $tanggal_pengembalian, $denda) {
        return $this->model->update($id, $id_peminjaman, $tanggal_pengembalian, $denda);
    }

    // ===========================
    // DELETE
    // ===========================
    public function delete($id) {
        return $this->model->delete($id);
    }

    // ===========================
    // PEMINJAMAN LIST
    // ===========================
    public function peminjamanList() {
        return $this->model->peminjamanList();
    }
}
