<?php

class Anggota {

    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // Pagination + Search
    public function getPagination($limit, $offset, $keyword = '') {
        $keyword = "%$keyword%";

        $sql = "SELECT * FROM anggota 
                WHERE nama ILIKE :keyword OR alamat ILIKE :keyword
                ORDER BY id_anggota ASC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':keyword', $keyword);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function countData($keyword = '') {
        $keyword = "%$keyword%";

        $sql = "SELECT COUNT(*) AS total FROM anggota 
                WHERE nama ILIKE :keyword OR alamat ILIKE :keyword";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':keyword', $keyword);
        $stmt->execute();

        return $stmt->fetch()['total'];
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM anggota WHERE id_anggota = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO anggota (nama, alamat, no_hp)
                VALUES (:nama, :alamat, :no_hp)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($data) {
        $sql = "UPDATE anggota SET
                    nama = :nama,
                    alamat = :alamat,
                    no_hp = :no_hp
                WHERE id_anggota = :id_anggota";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM anggota WHERE id_anggota = :id");
        return $stmt->execute(['id' => $id]);
    }
}
