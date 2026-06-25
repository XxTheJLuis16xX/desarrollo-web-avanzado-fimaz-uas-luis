<?php
require_once("../controllers/controladorProductos.php");
include_once('./template/header.php');

$obj = new productosController();
$rows = $obj->getProductos();
?>

<h2>Listado de Productos</h2>

<table border="1">
<tr>
    <th>ID</th>
    <th>PRODUCTO</th>
    <th>CANTIDAD</th>
    <th>PRECIO</th>
</tr>

<?php if ($rows): ?>
    <?php foreach ($rows as $row): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['producto'] ?></td>
            <td><?= $row['cantidad'] ?></td>
            <td><?= $row['precio_unitario'] ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr><td colspan="4">No hay productos</td></tr>
<?php endif; ?>

</table>

<?php include_once('./template/footer.php'); ?>