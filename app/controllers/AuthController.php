<?php

class AuthController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = $this->pdo->prepare("SELECT * FROM admins WHERE username = :u LIMIT 1");
        $query->execute(['u' => $username]);
        $admin = $query->fetch();

        if ($admin && password_verify($password, $admin['password_hash'])) {
            $_SESSION['admin'] = $admin;
            header("Location: " . BASE_URL . "dashboard");
            exit;
        }

        $_SESSION['error'] = "Username atau password salah!";
        header("Location: " . BASE_URL . "login");
        exit;
    }

    public function logout()
    {
        session_destroy();
        header("Location: " . BASE_URL . "login");
        exit;
    }
}
