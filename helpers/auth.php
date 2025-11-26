<?php
require_once __DIR__ . '/../config/config.php';

function isLogin() {
    return isset($_SESSION['admin']);
}

function mustLogin() {
    if (!isLogin()) {
        header("Location: " . BASE_URL . "login.php");
        exit;
    }
}
