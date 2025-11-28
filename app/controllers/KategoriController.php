<?php

require_once __DIR__ . '/../models/Kategori.php';

class KategoriController {

    private $kategori;

    public function __construct($pdo) {
        $this->kategori = new Kategori($pdo);
    }

    public function index() {
        $keyword = $_GET['search'] ?? '';
        $limit = 10;

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $totalData = $this->kategori->countData($keyword);
        $totalPage = ceil($totalData / $limit);

        $data = $this->kategori->getPagination($limit, $offset, $keyword);

        require_once __DIR__ . '/../views/kategori/index.php';
    }

    public function create() {
        require_once __DIR__ . '/../views/kategori/create.php';
    }

    public function store() {
        $data = [
            'nama_kategori' => $_POST['nama_kategori'],
            'deskripsi' => $_POST['deskripsi']
        ];

        $this->kategori->create($data);

        header("Location: " . BASE_URL . "kategori");
        exit;
    }

    public function edit($id) {
        $kategori = $this->kategori->getById($id);
        require_once __DIR__ . '/../views/kategori/edit.php';
    }

    public function update() {
        $data = [
            'nama_kategori' => $_POST['nama_kategori'],
            'deskripsi' => $_POST['deskripsi'],
            'id_kategori' => $_POST['id_kategori']
        ];

        $this->kategori->update($data);

        header("Location: " . BASE_URL . "kategori");
        exit;
    }

    public function delete($id) {
        $this->kategori->delete($id);
        header("Location: " . BASE_URL . "kategori");
        exit;
    }
}
