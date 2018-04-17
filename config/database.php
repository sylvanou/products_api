<?php
class Database {
    // specify your own db credentials
    private $host = 'localhost';
    private $db_name = 'php_react_crud';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
        } catch(PDOException $exception) {
            echo 'Connection error: ' . $exception->getMessage();
        }

        return $this->conn;
    }
}