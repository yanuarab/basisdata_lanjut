<?php

class BukuPopuler {

    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // Ambil data dari MV
    public function getData() {
        $sql = "SELECT * FROM mv_buku_populer ORDER BY total_pinjam DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    // Refresh MV
    public function refreshView() {
        $sql = "REFRESH MATERIALIZED VIEW mv_buku_populer";
        return $this->db->exec($sql);
    }

    // TAMPILAN DASHBOARD
    public function getBukuPalingPopuler() {
        $sql = "SELECT * FROM mv_buku_populer ORDER BY total_pinjam DESC LIMIT 1";
        return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
}
