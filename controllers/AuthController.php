<?php
session_start();

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Admin.php';

class AuthController {

    public function index() {
        include __DIR__ . '/../views/auth/login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "login");
            exit;
        }

        $db = new Database();
        $pdo = $db->connect();
        $adminModel = new Admin($pdo);

        $username = htmlspecialchars($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $adminModel->findByUsername($username);

        if ($user && password_verify($password, $user['password_hash'] ?? '')) {
            $_SESSION['admin'] = $user;
            header("Location: " . BASE_URL . "dashboard");
            exit;
        } else {
            $error = "Username atau password salah!";
            include __DIR__ . '/../views/auth/login.php';
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');

        header("Location: " . BASE_URL . "login");
        exit;
    }
}
