<?php

class Kategori {

    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    /** Pagination + Search */
    public function getPagination($limit, $offset, $keyword = '') {
        $keyword = "%$keyword%";

        $sql = "SELECT * FROM kategori_buku
                WHERE nama_kategori ILIKE :keyword
                ORDER BY id_kategori ASC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':keyword', $keyword);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /** Count */
    public function countData($keyword = '') {
        $keyword = "%$keyword%";

        $sql = "SELECT COUNT(*) AS total FROM kategori_buku
                WHERE nama_kategori ILIKE :keyword";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':keyword', $keyword);
        $stmt->execute();
        return $stmt->fetch()['total'];
    }

    /** Ambil satu kategori */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM kategori_buku WHERE id_kategori = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /** Create */
    public function create($data) {
        $sql = "INSERT INTO kategori_buku (nama_kategori, deskripsi)
                VALUES (:nama_kategori, :deskripsi)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nama_kategori' => $data['nama_kategori'],
            ':deskripsi' => $data['deskripsi']
        ]);
    }

    /** Update */
    public function update($data) {
        $sql = "UPDATE kategori_buku SET
                    nama_kategori = :nama_kategori,
                    deskripsi = :deskripsi
                WHERE id_kategori = :id_kategori";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nama_kategori' => $data['nama_kategori'],
            ':deskripsi' => $data['deskripsi'],
            ':id_kategori' => $data['id_kategori']
        ]);
    }

    /** Delete */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM kategori_buku WHERE id_kategori = :id");
        return $stmt->execute(['id' => $id]);
    }
}
