<?php

require_once __DIR__ . '/../models/Kategori.php';

class KategoriController {

    private $kategori;

    // Konstruktor: menerima koneksi PDO dan membuat objek model Kategori
    public function __construct($pdo) {
        $this->kategori = new Kategori($pdo);
    }

    // Menampilkan halaman list kategori + fitur pencarian & pagination
    public function index() {
        $keyword = $_GET['search'] ?? ''; // keyword pencarian (jika ada)
        $limit = 10; // batas data per halaman

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // halaman aktif
        $offset = ($page - 1) * $limit; // posisi awal data

        $totalData = $this->kategori->countData($keyword); // total data berdasarkan pencarian
        $totalPage = ceil($totalData / $limit); // total halaman

        // Ambil data kategori sesuai limit & halaman
        $data = $this->kategori->getPagination($limit, $offset, $keyword);

        // Load tampilan index
        require_once __DIR__ . '/../views/kategori/index.php';
    }

    // Menampilkan form tambah kategori
    public function create() {
        require_once __DIR__ . '/../views/kategori/create.php';
    }

    // Menyimpan data kategori baru dari form
    public function store() {
        $data = [
            'nama_kategori' => $_POST['nama_kategori'],
            'deskripsi' => $_POST['deskripsi']
        ];

        $this->kategori->create($data); // simpan data

        header("Location: " . BASE_URL . "kategori"); // redirect ke halaman kategori
        exit;
    }

    // Menampilkan form edit berdasarkan ID
    public function edit($id) {
        $kategori = $this->kategori->getById($id); // ambil data kategori
        require_once __DIR__ . '/../views/kategori/edit.php'; // load tampilan edit
    }

    // Proses update data kategori
    public function update() {
        $data = [
            'nama_kategori' => $_POST['nama_kategori'],
            'deskripsi' => $_POST['deskripsi'],
            'id_kategori' => $_POST['id_kategori']
        ];

        $this->kategori->update($data); // update data

        header("Location: " . BASE_URL . "kategori"); // kembali ke halaman kategori
        exit;
    }

    // Menghapus data kategori
    public function delete($id) {
        $this->kategori->delete($id); // hapus berdasarkan ID
        header("Location: " . BASE_URL . "kategori"); // redirect
        exit;
    }
}
