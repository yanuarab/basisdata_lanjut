<?php
require_once __DIR__ . "/../models/Buku.php";

class BukuController {
    private $buku;

    public function __construct($pdo) {
        $this->buku = new Buku($pdo);
        
    }

    // ===========================
    // LIST DATA (INDEX)
    // ===========================
public function index() {
    $limit  = 10;

    // Ambil parameter GET + trim
    $page      = intval($_GET['page']      ?? 1);
    $search    = trim($_GET['search']      ?? '');
    $kategori  = trim($_GET['kategori']    ?? '');
    $penerbit  = trim($_GET['penerbit']    ?? '');
    $tahun     = trim($_GET['tahun']       ?? '');

    // Minimal page = 1
    if ($page < 1) $page = 1;

    $offset = ($page - 1) * $limit;

    // Ambil data buku
    $buku       = $this->buku->getPagination($limit, $offset, $search, $kategori, $penerbit, $tahun);
    $totalData  = $this->buku->getTotalData($search, $kategori, $penerbit, $tahun);

    // Data dropdown
    $kategoriList = $this->buku->getKategoriList();
    $penerbitList = $this->buku->getPenerbitList();

    $totalPage = ceil($totalData / $limit);

    include __DIR__ . '/../views/buku/index.php';
}



    // ===========================
    // FORM TAMBAH
    // ===========================
    public function create() {
        $kategori = $this->buku->getKategoriList();
        $penerbit = $this->buku->getPenerbitList();

        include __DIR__ . "/../views/buku/create.php";
    }

    // ===========================
    // STORE DATA
    // ===========================
    public function store() {
        $data = [
            'judul'         => $_POST['judul'],
            'pengarang'     => $_POST['pengarang'],
            'tahun_terbit'  => $_POST['tahun_terbit'],
            'id_kategori'   => $_POST['id_kategori'],
            'id_penerbit'   => $_POST['id_penerbit'],
            'stok'          => $_POST['stok'],
            'isbn'          => $_POST['isbn']
        ];

        $this->buku->create($data);
        header("Location: " . BASE_URL . "buku?msg=created");
        exit;

    }


    // ===========================
    // FORM EDIT
    // ===========================
public function edit($id)
{
    $buku = $this->buku->getById($id);

    if (!$buku) {
        die("Data buku tidak ditemukan!");
    }

    $kategori = $this->buku->getKategoriList();
    $penerbit = $this->buku->getPenerbitList();


    require_once __DIR__ . '/../views/buku/edit.php';
}


    

    // ===========================
    // UPDATE DATA
    // ===========================
    public function update() {
        $id = $_POST['id_buku'];

        $data = [
            'judul'         => $_POST['judul'],
            'pengarang'     => $_POST['pengarang'],
            'tahun_terbit'  => $_POST['tahun_terbit'],
            'id_kategori'   => $_POST['id_kategori'],
            'id_penerbit'   => $_POST['id_penerbit'],
            'stok'          => $_POST['stok'],
            'isbn'          => $_POST['isbn']
        ];

        $this->buku->update($id, $data);
        header("Location: " . BASE_URL . "buku?msg=updated");
        exit;
    }
    

    // ===========================
    // HAPUS DATA
    // ===========================
    public function delete() {
        $id = $_GET['id'];
        $this->buku->delete($id);
        header("Location: " . BASE_URL . "buku?msg=deleted");
        exit;
    }
}
?>
