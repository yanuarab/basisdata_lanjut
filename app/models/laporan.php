<?php

class Laporan {

    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // Pagination + Search
    public function getPagination($limit, $offset, $keyword = '') {
        $keyword = "%$keyword%";

        $sql = "SELECT *
                FROM view_buku_lengkap
                WHERE judul ILIKE :keyword
                   OR nama_kategori ILIKE :keyword
                   OR nama_penerbit ILIKE :keyword
                ORDER BY judul ASC
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

        $sql = "SELECT COUNT(*) AS total
                FROM view_buku_lengkap
                WHERE judul ILIKE :keyword
                   OR nama_kategori ILIKE :keyword
                   OR nama_penerbit ILIKE :keyword";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':keyword', $keyword);
        $stmt->execute();

        return $stmt->fetch()['total'];
    }
}
