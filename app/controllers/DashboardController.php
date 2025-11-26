<?php

class DashboardController 
{
    public function index() 
    {
        // Cek login
        if (!isset($_SESSION['admin'])) {
            header("Location: " . BASE_URL . "login");
            exit;
        }

        // Tampilkan view
        include __DIR__ . '/../views/dashboard/index.php';
    }
}
