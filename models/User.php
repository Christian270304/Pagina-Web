<?php
require 'config/database.php';

class User {
    private $pdo;

    public function __construct() {
        global $pdo;
        if ($pdo instanceof PDO) {
            $this->pdo = $pdo;
        } else {
            throw new Exception("Error al conectar a la base de datos");
        }
    }

    public function register($username,$email, $password) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, creado_el) VALUES (:username,:email, :password, NOW())");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);

        return $stmt->execute();
    }

    public function usrVerify($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return true;
        } else {
            return false;
        }
    }

    public function authenticate($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserId($username) {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user['id'];
    }

    public function getUser($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>