<?php
require_once("../controllers/controladorProductos.php");

$producto = $_POST['txtProducto'];
$cantidad = $_POST['txtCantidad'];
$precio = $_POST['txtPrecio'];

$obj = new productosController();
$obj->saveProducto($producto, $cantidad, $precio);
?>