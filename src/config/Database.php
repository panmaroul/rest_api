<?php
namespace config;
use PDO;
use PDOException;

class Database
{
    private $password = '';
    private $conn;

    // DB Connect
    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host=' .
                'localhost' . ';dbname=' .
                'data_analysis',
                'root',
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}