<?php

require_once __DIR__ . '/clases/Admin.php';
require_once __DIR__ . '/clases/Alumno.php';
require_once __DIR__ . '/clases/Invitado.php';

$usuarios = [];
$error = "";

try {

    $usuarios[] = new Admin(
        "José Luis Lizarraga Uribe",
        "joseluis@gmail.com"
    );

    $usuarios[] = new Alumno(
        "Carlos Ramírez",
        "carlos@gmail.com",
        "A2026001"
    );

    $usuarios[] = new Invitado(
        "María López",
        "maria@gmail.com",
        "FIMAZ"
    );

    $usuarios[] = new Alumno(
        "Usuario Error",
        "correo-invalido",
        "A999999"
    );

} catch (Exception $e) {
    $error = "Error controlado: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Práctica 4</title>

<style>

body{
font-family: Arial, sans-serif;
margin:40px;
}

table{
width:100%;
border-collapse:collapse;
}

th,td{
border:1px solid #000;
padding:10px;
text-align:center;
}

th{
background:#003366;
color:white;
}

.error{
background:#ffdddd;
border:1px solid red;
padding:10px;
margin-bottom:20px;
}

</style>

</head>

<body>

<h1>Práctica 4 - Integración POO + Herencia + Validaciones + Excepciones</h1>

<?php if(!empty($error)): ?>
<div class="error">
    <?= $error ?>
</div>
<?php endif; ?>

<table>

<tr>
    <th>Nombre</th>
    <th>Correo</th>
    <th>Rol</th>
    <th>Matrícula</th>
    <th>Empresa</th>
</tr>

<?php foreach($usuarios as $usuario): ?>

<tr>

<td><?= $usuario->getNombre(); ?></td>

<td><?= $usuario->getCorreo(); ?></td>

<td><?= $usuario->getRol(); ?></td>

<td>
<?= method_exists($usuario,'getMatricula')
? $usuario->getMatricula()
: "—"; ?>
</td>

<td>
<?= method_exists($usuario,'getEmpresa')
? $usuario->getEmpresa()
: "—"; ?>
</td>

</tr>

<?php endforeach; ?>

</table>

</body>
</html>