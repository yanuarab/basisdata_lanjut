<?php
require_once __DIR__ . '/../helpers/auth.php';

class DashboardController {
    public function index() {
        // mustLogin(); // kalau belum login → ke login.php
        include __DIR__ . '/../views/dashboard/index.php';
    }
}
