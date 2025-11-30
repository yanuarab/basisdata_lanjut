<?php

class Pengembalian {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function anggotaList() {
        return $this->pdo->query("SELECT id_anggota, nama FROM anggota ORDER BY nama")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function bukuList() {
        return $this->pdo->query("SELECT id_buku, judul FROM buku ORDER BY judul")->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Daftar peminjaman (untuk create). Sertakan nama anggota & judul buku agar dropdown informatif.
     */
    public function peminjamanList() {
        $sql = "
            SELECT p.id_peminjaman, p.id_anggota, p.id_buku, p.tanggal_pinjam, p.tanggal_kembali, p.status,
                   a.nama AS nama_anggota, b.judul AS judul_buku
            FROM peminjaman p
            LEFT JOIN anggota a ON p.id_anggota = a.id_anggota
            LEFT JOIN buku b ON p.id_buku = b.id_buku
            ORDER BY p.id_peminjaman DESC
        ";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

public function store($id_peminjaman, $tanggal_pengembalian, $denda)
{
    try {
        $this->pdo->beginTransaction();

        // Ambil id_buku dari peminjaman
        $stmt = $this->pdo->prepare("SELECT id_buku FROM peminjaman WHERE id_peminjaman = ?");
        $stmt->execute([$id_peminjaman]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new Exception("Peminjaman tidak ditemukan");
        }

        $id_buku = $row['id_buku'];

        // Tambahkan stok buku
        $sqlStok = "UPDATE buku SET stok = stok + 1 WHERE id_buku = ?";
        $stmtStok = $this->pdo->prepare($sqlStok);
        $stmtStok->execute([$id_buku]);

        // Insert pengembalian
        $sql = "INSERT INTO pengembalian (id_peminjaman, tanggal_pengembalian, denda)
                VALUES (?, ?, ?)";

        $stmtInsert = $this->pdo->prepare($sql);
        $stmtInsert->execute([
            $id_peminjaman,
            $tanggal_pengembalian ?: null,
            $denda ?: 0
        ]);

        $this->pdo->commit();
        return true;

    } catch (Exception $e) {
        $this->pdo->rollBack();
        return $e->getMessage();
    }
}


    public function getPagination($limit, $offset, $search = "") {
        $sql = "
        SELECT 
            peng.id_pengembalian,
            peng.id_peminjaman,
            b.judul AS judul_buku,
            a.nama AS nama_anggota,
            pem.tanggal_pinjam,
            pem.tanggal_kembali AS tanggal_jatuh_tempo,
            peng.tanggal_pengembalian,
            peng.denda
        FROM pengembalian peng
        JOIN peminjaman pem ON peng.id_peminjaman = pem.id_peminjaman
        LEFT JOIN buku b ON pem.id_buku = b.id_buku
        LEFT JOIN anggota a ON pem.id_anggota = a.id_anggota
        WHERE (:search = '' OR b.judul ILIKE :search OR a.nama ILIKE :search)
        ORDER BY peng.id_pengembalian ASC
        LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->pdo->prepare($sql);
        $searchParam = $search === "" ? "" : "%$search%";
        $stmt->bindValue(':search', $searchParam);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countData($search = "") {
        $sql = "
        SELECT COUNT(*) AS total
        FROM pengembalian peng
        JOIN peminjaman pem ON peng.id_peminjaman = pem.id_peminjaman
        LEFT JOIN buku b ON pem.id_buku = b.id_buku
        LEFT JOIN anggota a ON pem.id_anggota = a.id_anggota
        WHERE (:search = '' OR b.judul ILIKE :search OR a.nama ILIKE :search)
        ";

        $stmt = $this->pdo->prepare($sql);
        $searchParam = $search === "" ? "" : "%$search%";
        $stmt->bindValue(':search', $searchParam);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['total'] : 0;
    }

    /**
     * Ambil satu pengembalian lengkap dengan info peminjaman/anggota/buku.
     */
    public function find($id) {
        $sql = "
        SELECT 
            peng.*,
            pem.id_peminjaman,
            pem.id_anggota,
            pem.id_buku,
            pem.tanggal_pinjam,
            pem.tanggal_kembali AS tanggal_jatuh_tempo,
            a.nama AS nama_anggota,
            b.judul AS judul_buku
        FROM pengembalian peng
        JOIN peminjaman pem ON peng.id_peminjaman = pem.id_peminjaman
        LEFT JOIN anggota a ON pem.id_anggota = a.id_anggota
        LEFT JOIN buku b ON pem.id_buku = b.id_buku
        WHERE peng.id_pengembalian = ?
        LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update: tetap meng-set id_peminjaman (dari hidden input), tanggal_pengembalian, denda.
     * Pastikan controller mengirimkan id_peminjaman yang valid (bukan NULL).
     */
    public function update($id_pengembalian, $tanggal_pengembalian, $denda) {
        $sql = "UPDATE pengembalian 
                SET id_peminjaman = ?, tanggal_pengembalian = ?, denda = ?
                WHERE id_pengembalian = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$tanggal_pengembalian ?: null, $denda ?: 0, $id_pengembalian]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM pengembalian WHERE id_pengembalian = ?");
        return $stmt->execute([$id]);
    }
}
