<?php

require_once 'Admin.php';

$admin = new Admin(
    "José Luis Lizarraga Uribe",
    "joseluis40guapo50@gmail.com"
);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 2 - Herencia</title>
</head>
<body>

    <h1>Práctica 2: Herencia y reutilización de código</h1>

    <p><strong>Nombre:</strong> <?= $admin->getNombre(); ?></p>

    <p><strong>Correo:</strong> <?= $admin->getCorreo(); ?></p>

    <p><strong>Rol:</strong> <?= $admin->getRol(); ?></p>

</body>
</html>