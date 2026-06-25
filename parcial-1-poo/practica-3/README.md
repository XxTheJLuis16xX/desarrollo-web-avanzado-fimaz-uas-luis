Práctica 3 - Sistema de Usuarios con Validaciones y Excepciones

Descripción del sistema

Sistema desarrollado en PHP utilizando Programación Orientada a Objetos.

Permite crear usuarios de tipo Administrador y Alumno mediante herencia, validando el formato del correo electrónico y utilizando excepciones para controlar errores.

Flujo de clases

Usuario
Admin
Alumno

La clase Usuario contiene:

nombre
correo

La clase Admin hereda de Usuario.

La clase Alumno hereda de Usuario y agrega:

matricula

Validaciones

Se valida que el correo electrónico tenga un formato correcto mediante:

filter_var()

Si el correo es incorrecto se genera una excepción.

Manejo de errores

Se utilizan bloques try/catch para capturar excepciones y mostrar mensajes controlados.

Evidencia

Herencia
Validación de correo
Excepciones
- try/catch
- Usuarios válidos
- Usuario inválido

## Alumno

José Luis Lizarraga Uribe
