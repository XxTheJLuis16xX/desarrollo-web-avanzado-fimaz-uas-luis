<?php
class DataBase {
    private $host = "localhost";
    private $db = "productos";
    private $user = "root";
    private $pass = "";

    public function connect() {
        try {
            $conexion = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
            return $conexion;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
?>