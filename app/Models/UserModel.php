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
        $stmt->bindValue(':email', trim((string) $email), PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function findByPhone($phone)
    {
        $sql = 'SELECT id, full_name, email, password_hash, role, phone FROM users WHERE phone = :phone LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':phone', $this->normalizePhone($phone), PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? $user : null;
    }

    public function phoneExists($phone)
    {
        $sql = 'SELECT id FROM users WHERE phone = :phone LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':phone', $this->normalizePhone($phone), PDO::PARAM_STR);
        $stmt->execute();

        return (bool) $stmt->fetchColumn();
    }

    public function create($fullName, $email, $passwordHash, $phone, $role = 'user')
    {
        $sql = 'INSERT INTO users (full_name, email, password_hash, role, phone)
                VALUES (:full_name, :email, :password_hash, :role, :phone)';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':full_name', trim((string) $fullName), PDO::PARAM_STR);

        $cleanEmail = trim((string) $email);
        if ($cleanEmail === '') {
            $stmt->bindValue(':email', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':email', $cleanEmail, PDO::PARAM_STR);
        }

        $stmt->bindValue(':password_hash', $passwordHash, PDO::PARAM_STR);
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);
        $stmt->bindValue(':phone', $this->normalizePhone($phone), PDO::PARAM_STR);

        return $stmt->execute();
    }

    private function normalizePhone($phone)
    {
        return preg_replace('/\s+/', '', trim((string) $phone));
    }
}
