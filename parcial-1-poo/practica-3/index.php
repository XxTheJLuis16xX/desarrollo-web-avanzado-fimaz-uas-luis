<?php

require_once __DIR__ . '/clases/Admin.php';
require_once __DIR__ . '/clases/Alumno.php';

function mostrarUsuario(Usuario $usuario): void
{
    echo "Nombre: " . $usuario->getNombre() . "<br>";
    echo "Correo: " . $usuario->getCorreo() . "<br>";
    echo "Rol: " . $usuario->getRol() . "<br>";

    if ($usuario instanceof Alumno) {
        echo "Matrícula: " . $usuario->getMatricula() . "<br>";
    }

    echo "<hr>";
}

echo "<h1>Sistema de Usuarios con Validaciones y Excepciones</h1>";

try {
    echo "<h2>Usuarios válidos</h2>";

    $admin = new Admin(
        "José Luis Lizarraga Uribe",
        "admin@fimaz.uas.edu.mx"
    );

    $alumno = new Alumno(
        "Carlos Pérez",
        "alumno@uas.edu.mx",
        "A123456"
    );

    mostrarUsuario($admin);
    mostrarUsuario($alumno);

} catch (Exception $e) {
    echo "<p style='color:green;'>Error: " . $e->getMessage() . "</p>";
}

try {
    echo "<h2>Usuario inválido</h2>";

    $usuarioInvalido = new Alumno(
        "María López",
        "correo-invalido",
        "A654321"
    );

    mostrarUsuario($usuarioInvalido);

} catch (Exception $e) {
    echo "<p style='color:red;'>Error controlado: " . $e->getMessage() . "</p>";
}