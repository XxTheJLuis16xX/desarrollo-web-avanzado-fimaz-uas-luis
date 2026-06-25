<?php include_once('./template/header.php'); ?>

<h2 class="mb-4">Agregar Producto</h2>

<form action="productosInsert.php" method="post" class="card p-4 shadow">

    <div class="mb-3">
        <label>Producto</label>
        <input type="text" name="txtProducto" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Cantidad</label>
        <input type="number" name="txtCantidad" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Precio</label>
        <input type="number" step="0.01" name="txtPrecio" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
</form>

<?php include_once('./template/footer.php'); ?>