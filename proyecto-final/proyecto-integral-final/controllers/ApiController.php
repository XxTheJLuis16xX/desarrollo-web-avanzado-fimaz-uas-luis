<?php
/**
 * Clase ApiController
 * Ubicada en el espacio de nombres (namespace) Controllers.
 * Actúa como un endpoint de API REST que distribuye datos crudos en formato JSON.
 */
namespace Controllers;

// Importamos la clase de conexión a la base de datos y la gestión de excepciones de PDO
use Config\Database;
use PDOException;

class ApiController
{
    /**
     * Devuelve la lista completa de productos en formato JSON.
     * Configura las cabeceras HTTP necesarias y maneja respuestas de éxito o error estructuradas.
     * * @return void
     */
    public function productos(): void
    {
        // Establece la cabecera HTTP para indicarle al navegador o cliente (Postman, celular, etc.)
        // que la respuesta no es una página web común (HTML), sino datos estructurados en formato JSON codificados en UTF-8.
        header('Content-Type: application/json; charset=utf-8');

        // Bloque de control para procesar la consulta y reaccionar de forma limpia si algo falla
        try {
            // Instancia la clase Database y obtiene la conexión activa a MySQL mediante el método connect()
            $db = new Database();
            $conexion = $db->connect();

            // Define la consulta SQL para extraer todos los campos relevantes de la tabla productos.
            // Los ordena por ID de forma descendente (ORDER BY id DESC) para mostrar primero los más nuevos.
            $sql = "SELECT id, sku, nombre, descripcion, precio_compra, precio_venta, existencia, imagen, created_at, updated_at
                    FROM productos
                    ORDER BY id DESC";

            // Prepara la consulta SQL para proteger al sistema contra inyecciones SQL (SQL Injection).
            $stmt = $conexion->prepare($sql);
            // Ejecuta la consulta de manera segura en el servidor de bases de datos.
            $stmt->execute();

            // Extrae todas las filas resultantes de la consulta.
            // Gracias a la configuración previa en tu clase Database, esto devuelve un arreglo asociativo limpio.
            $productos = $stmt->fetchAll();

            // Imprime (echo) la respuesta en formato JSON estructurado.
            // Retorna un estado de éxito, el conteo total de productos encontrados y el arreglo con los datos.
            // Banderas utilizadas:
            // - JSON_UNESCAPED_UNICODE: Evita que convierta las eñes y acentos en caracteres extraños (ej: \u00e1).
            // - JSON_PRETTY_PRINT: Le da formato visual legible con espacios y saltos de línea (ideal para desarrollo).
            echo json_encode([
                'status' => 'success',
                'total' => count($productos),
                'data' => $productos
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        } catch (PDOException $e) {
            // --- FLUJO EN CASO DE ERROR DE BASE DE DATOS ---
            
            // Establece el código de estado HTTP en 500 (Internal Server Error) para avisar al cliente que el servidor falló.
            http_response_code(500);

            // Imprime una respuesta de error estandarizada en formato JSON.
            // Incluye el detalle técnico del error ($e->getMessage()) para facilitar la depuración por parte de los desarrolladores.
            echo json_encode([
                'status' => 'error',
                'mensaje' => 'Error al consultar productos',
                'detalle' => $e->getMessage()
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
    }
}
?>