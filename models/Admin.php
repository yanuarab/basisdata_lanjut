<?php
class Admin {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($username) {
        $query = "SELECT * FROM admins WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":username", $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
