<?php

require_once "Usuario.php";
require_once "Admin.php";
require_once "Alumno.php";

$usuarios = [];

try {

    $admin = new Admin("Carlos", "carlos@empresa.com");
    $usuarios[] = $admin;

    $alumno = new Alumno("Ana", "ana@universidad.com", "A12345");
    $usuarios[] = $alumno;

    $alumnoError = new Alumno("Luis", "correo_invalido", "A99999");
    $usuarios[] = $alumnoError;

} catch (Exception $e) {

    echo "<p style='color:red;'>Error detectado: " . $e->getMessage() . "</p>";

}

?>

<!DOCTYPE html>
<html>
<head>
<title>Sistema de Usuarios</title>
</head>

<body>

<h2>Lista de usuarios</h2>

<table border="1">

<tr>
<th>Nombre</th>
<th>Correo</th>
<th>Rol</th>
<th>Matrícula</th>
</tr>

<?php

foreach ($usuarios as $u) {

    echo "<tr>";

    echo "<td>".$u->getNombre()."</td>";
    echo "<td>".$u->getCorreo()."</td>";
    echo "<td>".$u->getRol()."</td>";

    if ($u instanceof Alumno) {
        echo "<td>".$u->getMatricula()."</td>";
    } else {
        echo "<td>-</td>";
    }

    echo "</tr>";
}

?>

</table>

</body>
</html>