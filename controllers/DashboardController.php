<?php
require_once "../helpers/auth.php";
mustLogin();

class DashboardController {
    public function index() {
        include "../views/dashboard.php";
    }
}

$dashboard = new DashboardController();
$dashboard->index();
