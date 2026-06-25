-- Base de datos para el Proyecto Integrador MVC + API REST
CREATE DATABASE IF NOT EXISTS tienda CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tienda;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre_completo VARCHAR(120) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(50) NOT NULL UNIQUE,
    nombre VARCHAR(120) NOT NULL,
    descripcion TEXT NULL,
    precio_compra DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    precio_venta DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    existencia INT NOT NULL DEFAULT 0,
    imagen VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    accion VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Usuario administrador de prueba
-- Usuario: admin
-- Contraseña: admin123
INSERT INTO usuarios (username, password, nombre_completo)
VALUES (
    'admin',
    '$2y$10$3wP4VrwlXVX7gvY1P8aPBeH72Jdytzwkb20i/tlP1e.Fu6Vh1URCe',
    'Administrador del Sistema'
)
ON DUPLICATE KEY UPDATE username = username;

INSERT INTO productos (sku, nombre, descripcion, precio_compra, precio_venta, existencia, imagen) VALUES
('PROD-001', 'Laptop Lenovo', 'Laptop para trabajo y estudio.', 8500.00, 10999.00, 8, NULL),
('PROD-002', 'Mouse inalámbrico', 'Mouse ergonómico con conexión USB.', 120.00, 249.00, 25, NULL),
('PROD-003', 'Teclado mecánico', 'Teclado retroiluminado para computadora.', 450.00, 799.00, 12, NULL)
ON DUPLICATE KEY UPDATE sku = sku;
