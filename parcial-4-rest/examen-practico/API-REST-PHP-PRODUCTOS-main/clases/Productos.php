<?php

class Productos {

    private $conn;
    private $tabla = "productos";

    public $idProducto;
    public $nombreproducto;
    public $descripcion;
    public $precioCompra;
    public $precioVenta;
    public $existencia;

    public function __construct($db) {

        $this->conn = $db;
    }

    public function getProductos() {

        $consultaSQL = "SELECT
                            idProducto,
                            nombreproducto,
                            descripcion,
                            precioCompra,
                            precioVenta,
                            existencia
                        FROM " . $this->tabla;

        $stmt = $this->conn->prepare($consultaSQL);

        $stmt->execute();

        return $stmt;
    }

    public function getProducto() {

        $consultaSQL = "SELECT
                            idProducto,
                            nombreproducto,
                            descripcion,
                            precioCompra,
                            precioVenta,
                            existencia
                        FROM " . $this->tabla . "
                        WHERE idProducto = ?
                        LIMIT 0,1";

        $stmt = $this->conn->prepare($consultaSQL);

        $stmt->bindParam(1, $this->idProducto);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if($dataRow) {

            $this->nombreproducto = $dataRow['nombreproducto'];
            $this->descripcion = $dataRow['descripcion'];
            $this->precioCompra = $dataRow['precioCompra'];
            $this->precioVenta = $dataRow['precioVenta'];
            $this->existencia = $dataRow['existencia'];

            return true;
        }

        return false;
    }

    public function setProductos() {

        $consultaSQL = "INSERT INTO " . $this->tabla . "
                        SET
                            nombreproducto = :nombreproducto,
                            descripcion = :descripcion,
                            precioCompra = :precioCompra,
                            precioVenta = :precioVenta,
                            existencia = :existencia";

        $stmt = $this->conn->prepare($consultaSQL);

        $stmt->bindParam(":nombreproducto", $this->nombreproducto);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":precioCompra", $this->precioCompra);
        $stmt->bindParam(":precioVenta", $this->precioVenta);
        $stmt->bindParam(":existencia", $this->existencia);

        if($stmt->execute()) {

            return true;
        }

        return false;
    }

    public function borrarProducto() {

        $consultaSQL = "DELETE FROM " . $this->tabla . "
                        WHERE idProducto = ?";

        $stmt = $this->conn->prepare($consultaSQL);

        $stmt->bindParam(1, $this->idProducto);

        if($stmt->execute()) {

            return true;
        }

        return false;
    }

    public function updateProducto() {

        $consultaSQL = "UPDATE " . $this->tabla . "
                        SET
                            nombreproducto = :nombreproducto,
                            descripcion = :descripcion,
                            precioCompra = :precioCompra,
                            precioVenta = :precioVenta,
                            existencia = :existencia
                        WHERE idProducto = :idProducto";

        $stmt = $this->conn->prepare($consultaSQL);

        $stmt->bindParam(":idProducto", $this->idProducto);
        $stmt->bindParam(":nombreproducto", $this->nombreproducto);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":precioCompra", $this->precioCompra);
        $stmt->bindParam(":precioVenta", $this->precioVenta);
        $stmt->bindParam(":existencia", $this->existencia);

        return $stmt->execute();
    }
}

?>