<?php

require_once 'Usuario.php';

$usuario = new Usuario(
    "Jose Luis Lizarraga Uribe",
    "joseluis40guapo50@gmail.com"
);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 1</title>
</head>
<body>

<h1>Práctica 1 - Clases y Encapsulamiento en PHP</h1>

<p><strong>Nombre:</strong> <?php echo $usuario->getNombre(); ?></p>

<p><strong>Correo:</strong> <?php echo $usuario->getCorreo(); ?></p>

</body>
</html>