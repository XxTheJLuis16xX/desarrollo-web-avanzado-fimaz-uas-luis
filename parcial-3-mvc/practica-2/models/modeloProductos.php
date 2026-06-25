<?php
require_once("../config/DataBase.php");

class productosModel {
    private $db;

    public function __construct() {
        $this->db = (new DataBase())->connect();
    }

    public function insert($producto, $cantidad, $precio) {
        $sql = "INSERT INTO productos(producto, cantidad, precio_unitario) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$producto, $cantidad, $precio]);
    }

    public function getAll() {
        $sql = "SELECT * FROM productos";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>