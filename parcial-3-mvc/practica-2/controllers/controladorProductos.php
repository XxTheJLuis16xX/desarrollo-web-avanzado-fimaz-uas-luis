<?php
require_once("../models/modeloProductos.php");

class productosController {

    private $model;

    public function __construct() {
        $this->model = new productosModel();
    }

    public function saveProducto($producto, $cantidad, $precio) {
        $ok = $this->model->insert($producto, $cantidad, $precio);

        if ($ok) {
            header("Location: ../views/index.php");
        } else {
            header("Location: ../views/frmProductos.php");
        }
    }

    public function getProductos() {
        return $this->model->getAll();
    }
}
?>