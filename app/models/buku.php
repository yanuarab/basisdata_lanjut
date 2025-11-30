<?php  
class Buku {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    // ============================================================
    // GET DATA + FILTER + PAGINATION
    // ============================================================
    public function getPagination($limit, $offset, $search = '', $kategori = '', $penerbit = '', $tahun = '') {

        $params = [];
        $sql = "SELECT b.*, k.nama_kategori, p.nama_penerbit
                FROM buku b
                LEFT JOIN kategori_buku k ON b.id_kategori = k.id_kategori
                LEFT JOIN penerbit p ON b.id_penerbit = p.id_penerbit
                WHERE 1=1";

        // Filter Search
        if ($search !== null && trim($search) !== '') {
            $sql .= " AND (b.judul ILIKE :search OR b.pengarang ILIKE :search)";
            $params[':search'] = "%$search%";
        }

        // Filter Kategori
        if ($kategori !== null && trim($kategori) !== '') {
            $sql .= " AND b.id_kategori = :kategori";
            $params[':kategori'] = $kategori;
        }

        // Filter Penerbit
        if ($penerbit !== null && trim($penerbit) !== '') {
            $sql .= " AND b.id_penerbit = :penerbit";
            $params[':penerbit'] = $penerbit;
        }

        // Filter Tahun Terbit
        if ($tahun !== null && trim($tahun) !== '') {
            $sql .= " AND b.tahun_terbit = :tahun";
            $params[':tahun'] = $tahun;
        }

        $sql .= " ORDER BY b.id_buku ASC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ============================================================
    // TOTAL DATA
    // ============================================================
    public function getTotalData($search = '', $kategori = '', $penerbit = '', $tahun = '') {

        $params = [];
        $sql = "SELECT COUNT(*) AS total
                FROM buku b
                LEFT JOIN kategori_buku k ON b.id_kategori = k.id_kategori
                LEFT JOIN penerbit p ON b.id_penerbit = p.id_penerbit
                WHERE 1=1";

        if ($search !== null && trim($search) !== '') {
            $sql .= " AND (b.judul ILIKE :search OR b.pengarang ILIKE :search)";
            $params[':search'] = "%$search%";
        }

        if ($kategori !== null && trim($kategori) !== '') {
            $sql .= " AND b.id_kategori = :kategori";
            $params[':kategori'] = $kategori;
        }

        if ($penerbit !== null && trim($penerbit) !== '') {
            $sql .= " AND b.id_penerbit = :penerbit";
            $params[':penerbit'] = $penerbit;
        }

        if ($tahun !== null && trim($tahun) !== '') {
            $sql .= " AND b.tahun_terbit = :tahun";
            $params[':tahun'] = $tahun;
        }

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // ============================================================
    // GET BY ID
    // ============================================================
    public function getById($id) {
        $sql = "SELECT * FROM buku WHERE id_buku = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ============================================================
    // CREATE
    // ============================================================
    public function create($data) {
        $sql = "INSERT INTO buku (judul, pengarang, tahun_terbit, id_kategori, id_penerbit, stok, isbn)
                VALUES (:judul, :pengarang, :tahun_terbit, :kategori, :penerbit, :stok, :isbn)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':judul', $data['judul']);
        $stmt->bindValue(':pengarang', $data['pengarang']);
        $stmt->bindValue(':tahun_terbit', $data['tahun_terbit']);
        $stmt->bindValue(':kategori', $data['id_kategori']);
        $stmt->bindValue(':penerbit', $data['id_penerbit']);
        $stmt->bindValue(':stok', $data['stok']);
        $stmt->bindValue(':isbn', $data['isbn']);

        return $stmt->execute();
    }

    // ============================================================
    // UPDATE
    // ============================================================
    public function update($id, $data) {

        $sql = "UPDATE buku SET
                    judul = :judul,
                    pengarang = :pengarang,
                    tahun_terbit = :tahun_terbit,
                    id_kategori = :kategori,
                    id_penerbit = :penerbit,
                    stok = :stok,
                    isbn = :isbn
                WHERE id_buku = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':judul', $data['judul']);
        $stmt->bindValue(':pengarang', $data['pengarang']);
        $stmt->bindValue(':tahun_terbit', $data['tahun_terbit']);
        $stmt->bindValue(':kategori', $data['id_kategori']);
        $stmt->bindValue(':penerbit', $data['id_penerbit']);
        $stmt->bindValue(':stok', $data['stok']);
        $stmt->bindValue(':isbn', $data['isbn']);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }

    // ============================================================
    // DELETE
    // ============================================================
    public function delete($id) {
        $sql = "DELETE FROM buku WHERE id_buku = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id);
        return $stmt->execute();
    }


    public function getKategoriList() {
        return $this->db->query("SELECT * FROM kategori_buku ORDER BY nama_kategori")
                        ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPenerbitList() {
        return $this->db->query("SELECT * FROM penerbit ORDER BY nama_penerbit")
                        ->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>
