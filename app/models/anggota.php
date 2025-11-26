<?php

class Anggota {

    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function getAll() {
        $sql = "SELECT * FROM anggota ORDER BY id_anggota ASC";
        return $this->db->query($sql)->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM anggota WHERE id_anggota = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO anggota (nama, alamat, telepon)
                VALUES (:nama, :alamat, :telepon)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($data) {
        $sql = "UPDATE anggota SET
                    nama = :nama,
                    alamat = :alamat,
                    telepon = :telepon
                WHERE id_anggota = :id_anggota";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM anggota WHERE id_anggota = :id");
        return $stmt->execute(['id' => $id]);
    }
}
