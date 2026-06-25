<?php
require_once("../controllers/controladorProductos.php");

$obj = new productosController();
$rows = $obj->getProductos();
?>

<?php include("template/header.php"); ?>

<h2 class="mb-4">Listado de Productos</h2>

<table class="table table-striped table-bordered shadow">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>PRODUCTO</th>
            <th>CANTIDAD</th>
            <th>PRECIO</th>
        </tr>
    </thead>

    <tbody>
        <?php if ($rows): ?>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['producto'] ?></td>
                    <td><?= $row['cantidad'] ?></td>
                    <td>$<?= $row['precio_unitario'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No hay productos</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include("template/footer.php"); ?>