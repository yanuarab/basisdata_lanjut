<?php

require_once __DIR__ . '/../models/Anggota.php';

class AnggotaController {

    private $anggota;

    public function __construct($pdo) {
        $this->anggota = new Anggota($pdo);
    }

    public function index() {

        $keyword = $_GET['search'] ?? '';
        $limit = 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $totalData = $this->anggota->countData($keyword);
        $totalPage = ceil($totalData / $limit);

        $data = $this->anggota->getPagination($limit, $offset, $keyword);

        require_once __DIR__ . '/../views/anggota/index.php';
    }

    public function create() {
        require_once __DIR__ . '/../views/anggota/create.php';
    }

    public function store() {
        $data = [
            'nama'   => $_POST['nama'],
            'alamat' => $_POST['alamat'],
            'no_hp'  => $_POST['no_hp']
        ];

        $this->anggota->create($data);
        header("Location: " . BASE_URL . "anggota");
        exit;
    }

    public function edit($id) {
        $anggota = $this->anggota->getById($id);
        require_once __DIR__ . '/../views/anggota/edit.php';
    }

    public function update() {
        $data = [
            'nama'       => $_POST['nama'],
            'alamat'     => $_POST['alamat'],
            'no_hp'      => $_POST['no_hp'],
            'id_anggota' => $_POST['id_anggota']
        ];

        $this->anggota->update($data);
        header("Location: " . BASE_URL . "anggota");
        exit;
    }

    public function delete($id) {
        $this->anggota->delete($id);
        header("Location: " . BASE_URL . "anggota");
        exit;
    }
}

