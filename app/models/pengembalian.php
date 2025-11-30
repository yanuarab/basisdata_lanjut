<?php

class Pengembalian {
    private $pdo;
    // private $table = "pengembalian";

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // ===========================
    // GET ALL + PAGINATION + SEARCH
    // ===========================
public function getPagination($limit, $offset, $search = "") {
    $sql = "
    SELECT 
        peng.id_pengembalian,
        pem.id_peminjaman,
        buku.judul AS judul_buku,
        anggota.nama AS nama_anggota,
        pem.tanggal_pinjam,
        pem.tanggal_kembali,
        peng.tanggal_pengembalian,
        peng.denda,
        CASE 
            WHEN peng.tanggal_pengembalian IS NULL THEN 'Dipinjam'
            ELSE 'Kembali'
        END AS status
    FROM pengembalian peng
    JOIN peminjaman pem ON peng.id_peminjaman = pem.id_peminjaman
    JOIN buku ON pem.id_buku = buku.id_buku
    JOIN anggota ON pem.id_anggota = anggota.id_anggota
    WHERE buku.judul LIKE :search OR anggota.nama LIKE :search
    ORDER BY peng.id_pengembalian ASC
    LIMIT :limit OFFSET :offset

    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':search', "%$search%");
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function countAll($search = "") {
    $sql = "
        SELECT COUNT(*) AS total
        FROM pengembalian peng
        JOIN peminjaman pem ON peng.id_peminjaman = pem.id_peminjaman
        JOIN buku ON pem.id_buku = buku.id_buku
        JOIN anggota ON pem.id_anggota = anggota.id_anggota
        WHERE buku.judul LIKE :search OR anggota.nama LIKE :search
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':search', "%$search%");
    $stmt->execute();
    return $stmt->fetch()['total'];
}


    // ===========================
    // CREATE / STORE
    // ===========================
    public function insert($id_peminjaman, $tanggal_pengembalian, $denda) {
        $sql = "INSERT INTO pengembalian (id_peminjaman, tanggal_pengembalian, denda)
                VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id_peminjaman, $tanggal_pengembalian, $denda]);
    }

    public function store($id_peminjaman, $tanggal_pengembalian, $denda) {
        return $this->insert($id_peminjaman, $tanggal_pengembalian, $denda);
    }

    // ===========================
    // GET BY ID
    // ===========================
    public function find($id) {
        $sql = "SELECT * FROM pengembalian WHERE id_pengembalian = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ===========================
    // UPDATE
    // ===========================
    public function update($id, $id_peminjaman, $tanggal_pengembalian, $denda) {
        $sql = "UPDATE pengembalian 
                SET id_peminjaman = ?, tanggal_pengembalian = ?, denda = ?
                WHERE id_pengembalian = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id_peminjaman, $tanggal_pengembalian, $denda, $id]);
    }

    // ===========================
    // DELETE
    // ===========================
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM pengembalian WHERE id_pengembalian = ?");
        return $stmt->execute([$id]);
    }

    // ===========================
    // PEMINJAMAN LIST
    // ===========================
    public function peminjamanList() {
        $stmt = $this->pdo->query("SELECT * FROM peminjaman ORDER BY id_peminjaman ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ===========================
    // COUNT DATA (wrapper)
    // ===========================
    public function countData($search = "") {
        return $this->countAll($search);
    }
}
