<?php
class Peminjaman
{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    // PAGINATION + SEARCH
    public function getPagination($limit, $offset, $keyword = '')
    {
        $keyword = "%$keyword%";

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
            WHERE a.nama ILIKE :keyword OR b.judul ILIKE :keyword
            ORDER BY p.id_peminjaman ASC
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':keyword', $keyword);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // HITUNG TOTAL DATA UNTUK PAGINATION
    public function countData($keyword = '')
    {
        $keyword = "%$keyword%";

        $sql = "
            SELECT COUNT(*) AS total
            FROM peminjaman p
            LEFT JOIN anggota a ON p.id_anggota = a.id_anggota
            LEFT JOIN buku b ON p.id_buku = b.id_buku
            WHERE a.nama ILIKE :keyword OR b.judul ILIKE :keyword
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':keyword', $keyword);
        $stmt->execute();

        return $stmt->fetch()['total'];
    }

    public function find($id)
    {
        $sql = "
            SELECT
                p.*,
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

    public function anggotaList()
    {
        return $this->pdo->query("SELECT id_anggota, nama FROM anggota ORDER BY nama")->fetchAll();
    }

    public function bukuList()
    {
        return $this->pdo->query("SELECT id_buku, judul FROM buku ORDER BY judul")->fetchAll();
    }

    /**
     * Store peminjaman
     * - kurangi stok hanya sekali
     * - set status = 'Dipinjam' secara otomatis
     */
    public function store($data)
    {
        try {
            $this->pdo->beginTransaction();

            // Kurangi stok buku (hanya jika stok > 0)
            $sqlStok = "UPDATE buku SET stok = stok - 0 WHERE id_buku = :id_buku AND stok > 0";
            $stmtStok = $this->pdo->prepare($sqlStok);
            $stmtStok->execute([':id_buku' => $data['id_buku']]);

            if ($stmtStok->rowCount() == 0) {
                throw new Exception("Stok buku habis!");
            }

            // Insert peminjaman (tanggal_kembali tidak diisi di sini)
            $sql = "
                INSERT INTO peminjaman (id_anggota, id_buku, tanggal_pinjam, status)
                VALUES (:id_anggota, :id_buku, :tanggal_pinjam, :status)
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id_anggota' => $data['id_anggota'],
                ':id_buku'    => $data['id_buku'],
                ':tanggal_pinjam' => $data['tanggal_pinjam'],
                ':status' => 'Dipinjam'
            ]);

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) $this->pdo->rollBack();
            return $e->getMessage();
        }
    }

    /**
     * Update peminjaman.
     * Jika buku diganti, stok lama dikembalikan dan stok baru dikurangi (dalam 1 transaksi).
     */
    public function update($data)
    {
        try {
            $this->pdo->beginTransaction();

            // Ambil data lama
            $stmtOld = $this->pdo->prepare("SELECT id_buku FROM peminjaman WHERE id_peminjaman = ?");
            $stmtOld->execute([$data['id_peminjaman']]);
            $old = $stmtOld->fetch(PDO::FETCH_ASSOC);

            if (!$old) {
                throw new Exception("Data peminjaman tidak ditemukan");
            }

            $oldBook = $old['id_buku'];
            $newBook = $data['id_buku'];

            // Jika buku diganti
            if ($oldBook != $newBook) {

                // Balikkan stok buku lama
                $sqlAdd = "UPDATE buku SET stok = stok + 1 WHERE id_buku = ?";
                $stmtAdd = $this->pdo->prepare($sqlAdd);
                $stmtAdd->execute([$oldBook]);

                // Kurangi stok buku baru (cek stok > 0)
                $sqlMin = "UPDATE buku SET stok = stok - 1 WHERE id_buku = ? AND stok > 0";
                $stmtMin = $this->pdo->prepare($sqlMin);
                $stmtMin->execute([$newBook]);

                if ($stmtMin->rowCount() == 0) {
                    throw new Exception("Stok buku baru tidak mencukupi");
                }
            }

            // Update peminjaman (tanggal_kembali boleh diisi saat update jika memang mengembalikan)
            $sql = "
                UPDATE peminjaman SET
                    id_anggota = :id_anggota,
                    id_buku = :id_buku,
                    tanggal_pinjam = :tanggal_pinjam,
                    tanggal_kembali = :tanggal_kembali,
                    status = :status
                WHERE id_peminjaman = :id_peminjaman
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id_peminjaman' => $data['id_peminjaman'],
                ':id_anggota' => $data['id_anggota'],
                ':id_buku' => $data['id_buku'],
                ':tanggal_pinjam' => $data['tanggal_pinjam'],
                ':tanggal_kembali' => $data['tanggal_kembali'] ?: null,
                ':status' => $data['status'],
            ]);

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) $this->pdo->rollBack();
            return $e->getMessage();
        }
    }

    /**
     * Delete peminjaman:
     * - hanya bisa dihapus jika belum ada pengembalian
     * - stok dikembalikan +1
     */
    public function delete($id)
    {
        try {
            $this->pdo->beginTransaction();

            // Cek apakah sudah pernah dikembalikan
            $stmtCheck = $this->pdo->prepare("SELECT 1 FROM pengembalian WHERE id_peminjaman = ?");
            $stmtCheck->execute([$id]);

            if ($stmtCheck->fetch()) {
                throw new Exception("Tidak dapat menghapus: peminjaman sudah dikembalikan");
            }

            // Ambil id_buku
            $stmt = $this->pdo->prepare("SELECT id_buku FROM peminjaman WHERE id_peminjaman = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                throw new Exception("Data peminjaman tidak ditemukan");
            }

            $id_buku = $row['id_buku'];

            // Kembalikan stok buku
            $sqlStok = "UPDATE buku SET stok = stok + 1 WHERE id_buku = ?";
            $stmtStok = $this->pdo->prepare($sqlStok);
            $stmtStok->execute([$id_buku]);

            // Hapus peminjaman
            $stmtDel = $this->pdo->prepare("DELETE FROM peminjaman WHERE id_peminjaman = ?");
            $stmtDel->execute([$id]);

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) $this->pdo->rollBack();
            return $e->getMessage();
        }
    }

    // TAMPILAN DASHBOARD
    public function getPeminjamanHariIni() {
        $sql = "SELECT COUNT(*) AS total
                FROM peminjaman
                WHERE DATE(tanggal_pinjam) = CURRENT_DATE";

        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC)['total'];
    }

}
