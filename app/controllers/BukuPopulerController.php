<?php

require_once __DIR__ . '/../models/BukuPopuler.php';

class BukuPopulerController {

    private $model;

    public function __construct($pdo) {
        $this->model = new BukuPopuler($pdo);
    }

    public function index() {
        $data = $this->model->getData();
        require_once __DIR__ . '/../views/buku_populer/index.php';
    }

    public function refresh() {
        $this->model->refreshView();

        $_SESSION['msg'] = "Materialized View berhasil di-refresh!";
        header("Location: " . BASE_URL . "buku_populer");
        exit;
    }
}
