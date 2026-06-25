# Examen Parcia 1
## Descripción del Proyecto

El presente proyecto consiste en el desarrollo de un sistema web en PHP que permite la autenticación de usuarios mediante un formulario de inicio de sesión, diferenciando el acceso según el rol asignado a cada usuario.

El sistema fue diseñado aplicando principios de Programación Orientada a Objetos (POO), validación de credenciales, uso de sesiones y redirección dinámica hacia páginas específicas para Administrador y Alumno.

---

## Objetivo

Implementar un sistema funcional de login que permita:

- Validar usuario y contraseña.
- Identificar el tipo de usuario.
- Redireccionar al panel correspondiente según el rol.
- Restringir accesos no autorizados.
- Aplicar buenas prácticas en PHP orientado a objetos.

---

## Tecnologías Utilizadas

- PHP
- HTML5
- CSS3
- Programación Orientada a Objetos
- Sesiones PHP
- XAMPP / Apache Server

---

## Estructura del Proyecto

```bash
/examen
│── index.php
│── Usuario.php
│── admin.php
│── alumno.php
│── README.md
```

---

## Descripción de Archivos

### index.php
Archivo principal que contiene el formulario de inicio de sesión donde el usuario ingresa:

- nombre de usuario
- contraseña

El sistema procesa la información y envía los datos para validación.

---

### Usuario.php
Clase principal del sistema.

Aquí se implementa:

- atributos del usuario,
- constructor,
- método de validación,
- verificación de credenciales,
- asignación de rol.

Se hace uso de Programación Orientada a Objetos para encapsular la lógica del login.

---

### admin.php
Pantalla de bienvenida para el usuario con rol de **Administrador**.

Solo se muestra si las credenciales corresponden a dicho tipo de usuario.

---

### alumno.php
Pantalla de bienvenida para el usuario con rol de **Alumno**.

Se accede únicamente cuando el sistema detecta este perfil.

---

## Funcionamiento del Sistema

1. El usuario accede al formulario principal.
2. Ingresa su nombre de usuario y contraseña.
3. El sistema instancia un objeto de la clase `Usuario`.
4. Se validan las credenciales registradas.
5. Dependiendo del rol:
   - si es Administrador → redirige a `admin.php`
   - si es Alumno → redirige a `alumno.php`
6. Si los datos son incorrectos, se muestra mensaje de acceso denegado.

---

## Características Implementadas

- Inicio de sesión dinámico
- Validación de datos
- Redirección automática
- Manejo de objetos en PHP
- Separación de vistas según usuario
- Código modular y organizado

---

## Ejecución del Proyecto

Para ejecutar este sistema se requiere:

1. Instalar XAMPP o cualquier servidor Apache con PHP.
2. Colocar la carpeta del proyecto dentro de `htdocs`.
3. Iniciar Apache desde el panel de control.
4. Abrir navegador y acceder a:

```bash
http://localhost:8080/examen/index.php
```

5. Ingresar con los usuarios definidos en el sistema.

---

## Pruebas Realizadas

Se verificó:

- acceso correcto para Administrador,
- acceso correcto para Alumno,
- denegación con credenciales incorrectas,
- navegación entre páginas,
- funcionamiento del modelo orientado a objetos.

---

## Evidencias

El repositorio incluye las capturas de pantalla y/o video de demostración donde se observa:

- formulario de login,
- acceso como administrador,
- acceso como alumno,
- validación de errores.

---

## Alumno

**José Luis Lizárraga Uribe**

---

## Materia

Programación Web / PHP

---

## ✅Resultado Final

Se desarrolló satisfactoriamente un sistema de autenticación de usuarios en PHP utilizando Programación Orientada a Objetos.
