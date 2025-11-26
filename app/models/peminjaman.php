<?php
class Peminjaman
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Ambil semua peminjaman -> termasuk nama anggota dan judul buku
     */
    public function all()
    {
        $sql = "
            SELECT
                p.id_peminjaman,
                p.id_anggota,
                p.id_buku,
                p.tanggal_pinjam,
                p.tanggal_kembali,
                p.status,
                a.nama AS nama_anggota,
                b.judul AS judul_buku
            FROM peminjaman p
            LEFT JOIN anggota a ON p.id_anggota = a.id_anggota
            LEFT JOIN buku b ON p.id_buku = b.id_buku
            ORDER BY p.id_peminjaman DESC
        ";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Ambil satu record (dipakai di edit)
     */
    public function find($id)
    {
        $sql = "
            SELECT
                p.id_peminjaman,
                p.id_anggota,
                p.id_buku,
                p.tanggal_pinjam,
                p.tanggal_kembali,
                p.status,
                a.nama AS nama_anggota,
                b.judul AS judul_buku
            FROM peminjaman p
            LEFT JOIN anggota a ON p.id_anggota = a.id_anggota
            LEFT JOIN buku b ON p.id_buku = b.id_buku
            WHERE p.id_peminjaman = :id
            LIMIT 1
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * List anggota (for dropdown)
     */
    public function anggotaList()
    {
        $stmt = $this->pdo->query("SELECT id_anggota, nama FROM anggota ORDER BY nama");
        return $stmt->fetchAll();
    }

    /**
     * List buku (for dropdown)
     */
    public function bukuList()
    {
        $stmt = $this->pdo->query("SELECT id_buku, judul FROM buku ORDER BY judul");
        return $stmt->fetchAll();
    }

    /**
     * store
     */
    public function store($data)
    {
        $sql = "INSERT INTO peminjaman (id_anggota, id_buku, tanggal_pinjam, tanggal_kembali, status)
                VALUES (:id_anggota, :id_buku, :tanggal_pinjam, :tanggal_kembali, :status)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_anggota' => $data['id_anggota'],
            ':id_buku' => $data['id_buku'],
            ':tanggal_pinjam' => $data['tanggal_pinjam'],
            ':tanggal_kembali' => $data['tanggal_kembali'] ?: null,
            ':status' => $data['status']
        ]);
    }

    /**
     * update
     */
    public function update($data)
    {
        $sql = "UPDATE peminjaman SET
                    id_anggota = :id_anggota,
                    id_buku = :id_buku,
                    tanggal_pinjam = :tanggal_pinjam,
                    tanggal_kembali = :tanggal_kembali,
                    status = :status
                WHERE id_peminjaman = :id_peminjaman";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_anggota' => $data['id_anggota'],
            ':id_buku' => $data['id_buku'],
            ':tanggal_pinjam' => $data['tanggal_pinjam'],
            ':tanggal_kembali' => $data['tanggal_kembali'] ?: null,
            ':status' => $data['status'],
            ':id_peminjaman' => $data['id_peminjaman']
        ]);
    }

    /**
     * delete
     */
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM peminjaman WHERE id_peminjaman = :id");
        return $stmt->execute([':id' => $id]);
    }
}
