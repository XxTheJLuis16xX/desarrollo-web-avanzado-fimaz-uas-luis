Práctica - Manejo de Errores y Transacciones en PDO (PHP)

Descripción del Proyecto

Este proyecto corresponde a la práctica del Tema 3: Manejo de Errores y Transacciones en PDO (PHP)** de la materia Desarrollo Web Avanzado.

La aplicación consiste en un sistema web desarrollado en PHP que permite registrar alumnos en una base de datos MySQL utilizando:

Conexión mediante PDO
Manejo de errores con `try/catch`
Uso de `namespaces`
Carga automática de clases con `autoload`
Implementación de transacciones (`beginTransaction`, `commit`, `rollBack`)
Simulación de errores para comprobar integridad de datos

El objetivo principal es garantizar que las operaciones SQL se ejecuten de forma segura y consistente.

Objetivos de la práctica

Aplicar buenas prácticas de desarrollo en PHP.
Implementar manejo profesional de excepciones.
Aprender el uso correcto de transacciones en PDO.
Evitar inconsistencias en la base de datos.
Organizar el código usando arquitectura modular.

Tecnologías Utilizadas

PHP 8+
MySQL / MariaDB
PDO
XAMPP
HTML5
CSS3
GitHub

Estructura del Proyecto

bash
practica-transacciones/
config/
Database.php
models/
Alumno.php
services/
RegistroService.php
autoload.php
index.php
README.md
