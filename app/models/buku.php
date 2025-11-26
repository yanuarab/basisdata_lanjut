<?php

class Buku {

    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function getAll() {
        $sql = "SELECT * FROM buku ORDER BY id_buku DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM buku WHERE id_buku = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO buku (judul, pengarang, tahun_terbit, stok)
                VALUES (:judul, :pengarang, :tahun_terbit, :stok)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($data) {
        $sql = "UPDATE buku SET
                judul = :judul,
                pengarang = :pengarang,
                tahun_terbit = :tahun_terbit,
                stok = :stok
                WHERE id_buku = :id_buku";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM buku WHERE id_buku = :id");
        return $stmt->execute(['id' => $id]);
    }
}
