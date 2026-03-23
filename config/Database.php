<?php

namespace Config;

use PDO;
use PDOException;

class Database
{
    private $host = "localhost";
    private $dbname = "sportstore";
    private $user = "postgres";
    private $pass = "huy1501";

    public function connect()
    {
        try {
            $pdo = new PDO(
                "pgsql:host=$this->host;dbname=$this->dbname",
                $this->user,
                $this->pass
            );

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;
        } catch (PDOException $e) {
            die("error: " . $e->getMessage());
        }
    }
}
