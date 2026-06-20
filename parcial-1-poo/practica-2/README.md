# Práctica 2: Herencia y reutilización de código en PHP

## Explicación de la herencia aplicada

La clase Admin hereda de la clase Usuario utilizando la palabra reservada extends.

Gracias a la herencia, la clase Admin puede reutilizar los métodos getNombre() y getCorreo() sin volver a programarlos.

## Diferencias entre Usuario y Admin

Usuario contiene los atributos nombre y correo.

Admin hereda esos atributos y agrega el método getRol() que devuelve "Administrador".

## Evidencia de ejecución

Al ejecutar index.php se muestran:

- Nombre
- Correo
- Rol

## Alumno

José Luis Lizarraga Uribe