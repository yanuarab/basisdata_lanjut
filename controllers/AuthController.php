<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../models/Admin.php";
session_start();

class AuthController {

    public function index() {
        include "../app/views/login.php";
    }

    public function login() {
        $db = new Database();
        $conn = $db->connect();
        $adminModel = new Admin($conn);

        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        $data = $adminModel->login($username);

        if ($data && password_verify($password, $data['password'])) {
            $_SESSION['admin'] = $data;
            header("Location: ../controllers/DashboardController.php");
        } else {
            $error = "Username atau password salah!";
            include "../app/views/login.php";
        }
    }

    public function logout() {
        session_destroy();
        header("Location: ../../public/index.php");
    }
}
