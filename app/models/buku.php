<?php

class Buku {

    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    /**
     * Pagination + Search — sekarang pakai JOIN untuk nama kategori & penerbit
     */
    public function getPagination($limit, $offset, $keyword = '') {
        $keyword = "%$keyword%";

        $sql = "SELECT b.*, k.nama_kategori, p.nama_penerbit
                FROM buku b
                LEFT JOIN kategori_buku k ON k.id_kategori = b.id_kategori
                LEFT JOIN penerbit p ON p.id_penerbit = b.id_penerbit
                WHERE b.judul ILIKE :keyword
                   OR b.pengarang ILIKE :keyword
                ORDER BY b.id_buku ASC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':keyword', $keyword);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Count (tetap sederhana)
     */
    public function countData($keyword = '') {
        $keyword = "%$keyword%";

        $sql = "SELECT COUNT(*) AS total FROM buku
                WHERE judul ILIKE :keyword 
                   OR pengarang ILIKE :keyword";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':keyword', $keyword);
        $stmt->execute();

        return $stmt->fetch()['total'];
    }

    /**
     * Ambil satu buku lengkap (dengan nama kategori & penerbit)
     */
    public function getById($id) {
        $sql = "SELECT b.*, k.nama_kategori, p.nama_penerbit
                FROM buku b
                LEFT JOIN kategori_buku k ON k.id_kategori = b.id_kategori
                LEFT JOIN penerbit p ON p.id_penerbit = b.id_penerbit
                WHERE b.id_buku = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getAllKategori() {
        $stmt = $this->db->query("SELECT * FROM kategori_buku ORDER BY nama_kategori ASC");
        return $stmt->fetchAll();
    }

    public function getAllPenerbit() {
        $stmt = $this->db->query("SELECT * FROM penerbit ORDER BY nama_penerbit ASC");
        return $stmt->fetchAll();
    }

    /**
     * Create (pastikan placeholder & kolom sesuai)
     */
    public function create($data) {
        $sql = "INSERT INTO buku (judul, pengarang, tahun_terbit, id_kategori, id_penerbit, stok)
                VALUES (:judul, :pengarang, :tahun_terbit, :id_kategori, :id_penerbit, :stok)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':judul' => $data['judul'],
            ':pengarang' => $data['pengarang'],
            ':tahun_terbit' => $data['tahun_terbit'],
            ':id_kategori' => $data['id_kategori'],
            ':id_penerbit' => $data['id_penerbit'],
            ':stok' => $data['stok'],
        ]);
    }

    /**
     * Update
     */
    public function update($data) {
        $sql = "UPDATE buku SET
                    judul = :judul,
                    pengarang = :pengarang,
                    tahun_terbit = :tahun_terbit,
                    id_kategori = :id_kategori,
                    id_penerbit = :id_penerbit,
                    stok = :stok
                WHERE id_buku = :id_buku";
                 
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':judul' => $data['judul'],
            ':pengarang' => $data['pengarang'],
            ':tahun_terbit' => $data['tahun_terbit'],
            ':id_kategori' => $data['id_kategori'],
            ':id_penerbit' => $data['id_penerbit'],
            ':stok' => $data['stok'],
            ':id_buku' => $data['id_buku']
        ]);
    }

    /**
     * Delete
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM buku WHERE id_buku = :id");
        return $stmt->execute(['id' => $id]);
    }
}
