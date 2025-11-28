<?php

require_once __DIR__ . '/../models/Laporan.php';

class LaporanController {

    private $laporan;

    public function __construct($pdo) {
        $this->laporan = new Laporan($pdo);
    }

    public function index() {

        $keyword = $_GET['search'] ?? '';
        $limit = 10;

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $totalData = $this->laporan->countData($keyword);
        $totalPage = ceil($totalData / $limit);

        $data = $this->laporan->getPagination($limit, $offset, $keyword);

        require_once __DIR__ . '/../views/laporan/index.php';
    }
}
