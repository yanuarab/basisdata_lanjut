<?php
class Admin {
    private $conn;

    public function __construct(PDO $db) {
        $this->conn = $db;
    }

    public function findByUsername($username) {
        $query = "SELECT * FROM admins WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":username", $username);
        $stmt->execute();
        return $stmt->fetch();
    }
}
