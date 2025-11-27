<?php
require_once __DIR__ . '/../models/Peminjaman.php';

class PeminjamanController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new Peminjaman($pdo);
    }

    public function index()
    {
        $keyword = $_GET['search'] ?? '';

        $limit = 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $totalData = $this->model->countData($keyword);
        $totalPage = ceil($totalData / $limit);

        $data = $this->model->getPagination($limit, $offset, $keyword);

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
        $this->model->store([
            'id_anggota' => $_POST['id_anggota'],
            'id_buku' => $_POST['id_buku'],
            'tanggal_pinjam' => $_POST['tanggal_pinjam'],
            'tanggal_kembali' => $_POST['tanggal_kembali'] ?: null,
            'status' => $_POST['status']
        ]);

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
        $this->model->update([
            'id_peminjaman' => $_POST['id_peminjaman'],
            'id_anggota' => $_POST['id_anggota'],
            'id_buku' => $_POST['id_buku'],
            'tanggal_pinjam' => $_POST['tanggal_pinjam'],
            'tanggal_kembali' => $_POST['tanggal_kembali'] ?: null,
            'status' => $_POST['status']
        ]);

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
