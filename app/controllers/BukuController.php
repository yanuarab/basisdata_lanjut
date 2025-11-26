<?php

require_once __DIR__ . '/../models/Buku.php';

class BukuController {

    private $buku;

    public function __construct($pdo) {
        $this->buku = new Buku($pdo);
    }

    public function index() {
        $data = $this->buku->getAll();
        require_once __DIR__ . '/../views/buku/index.php';
    }

    public function create() {
        require_once __DIR__ . '/../views/buku/create.php';
    }

    public function store() {
        $data = [
            'judul'        => $_POST['judul'],
            'pengarang'    => $_POST['pengarang'],
            'tahun_terbit' => $_POST['tahun_terbit'],
            'stok'         => $_POST['stok']
        ];

        $this->buku->create($data);
        header("Location: " . BASE_URL . "buku");
        exit;
    }

    public function edit($id) {
        $buku = $this->buku->getById($id);
        require_once __DIR__ . '/../views/buku/edit.php';
    }

    public function update() {
        $data = [
            'judul'        => $_POST['judul'],
            'pengarang'    => $_POST['pengarang'],
            'tahun_terbit' => $_POST['tahun_terbit'],
            'stok'         => $_POST['stok'],
            'id_buku'      => $_POST['id_buku']
        ];

        $this->buku->update($data);

        header("Location: " . BASE_URL . "buku");
        exit;
    }

    public function delete($id) {
        $this->buku->delete($id);
        header("Location: " . BASE_URL . "buku");
        exit;
    }
}
