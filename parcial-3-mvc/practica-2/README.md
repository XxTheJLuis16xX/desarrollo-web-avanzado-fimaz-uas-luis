# Model-View-Controller - Sistema de Productos en PHP

## Descripción del Proyecto
Este proyecto consiste en la implementación del patrón de arquitectura **Modelo - Vista - Controlador (MVC)** utilizando el lenguaje de programación **PHP** y gestor de base de datos **MySQL**.

El sistema desarrollado permite realizar el registro y visualización de productos, separando correctamente cada una de las capas del patrón MVC para una mejor organización, mantenimiento y escalabilidad del código.

---

## Objetivo
Aplicar en un ejemplo práctico la arquitectura MVC, comprendiendo la función de cada una de sus capas:

- **Modelo (Model):** Manejo y acceso a los datos.
- **Vista (View):** Interfaz visual para el usuario.
- **Controlador (Controller):** Lógica de control entre modelo y vista.

---

## Estructura del Proyecto

```bash
Model-View-Controller/
│
├── config/
│   └── DataBase.php
│
├── controllers/
│   └── controladorProductos.php
│
├── models/
│   └── modeloProductos.php
│
├── views/
│   ├── index.php
│   ├── frmProductos.php
│   ├── lstProductos.php
│   ├── productosInsert.php
│   └── template/
│       ├── header.php
│       └── footer.php
