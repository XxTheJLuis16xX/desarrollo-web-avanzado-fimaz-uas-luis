<?php include_once('./template/header.php'); ?>

<h2>Agregar Producto</h2>

<form action="productosInsert.php" method="post">
    Producto: <input type="text" name="txtProducto"><br>
    Cantidad: <input type="text" name="txtCantidad"><br>
    Precio: <input type="text" name="txtPrecio"><br>
    <button type="submit">Guardar</button>
</form>

<?php include_once('./template/footer.php'); ?>