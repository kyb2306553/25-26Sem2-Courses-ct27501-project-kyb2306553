<?php

namespace App\Models;

use Config\Database;
use PDO;

class UserModel
{
    private PDO $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function findByEmail($email)
    {
        $sql = 'SELECT id, full_name, email, password_hash, role, phone FROM users WHERE email = :email LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function create($fullName, $email, $passwordHash, $phone, $role = 'user')
    {
        $sql = 'INSERT INTO users (full_name, email, password_hash, role, phone)
                VALUES (:full_name, :email, :password_hash, :role, :phone)';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':full_name', $fullName, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password_hash', $passwordHash, PDO::PARAM_STR);
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);
        $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
