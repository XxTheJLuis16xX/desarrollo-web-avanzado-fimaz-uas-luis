<?php
/**
 * Clase ProductoModel
 * Ubicada en el espacio de nombres (namespace) Models.
 * Se encarga de gestionar de forma directa la persistencia y operaciones lógicas (CRUD)
 * sobre la tabla 'productos' utilizando PDO.
 */
namespace Models;

// Importación de la clase de conexión y las herramientas nativas de PDO
use Config\Database;
use PDO;
use PDOException;

class ProductoModel
{
    // Atributo que almacena el objeto de conexión PDO activo
    private PDO $conexion;

    /**
     * Constructor de la clase.
     * Inicializa de forma automática la conexión con la base de datos MySQL.
     */
    public function __construct()
    {
        $db = new Database();
        $this->conexion = $db->connect();
    }

    /**
     * Obtiene la lista completa de todos los productos de la tienda sin paginar.
     * @return array Listado de productos (vacío si no hay registros o si ocurre un error).
     */
    public function obtenerTodos(): array
    {
        try {
            // Consulta directa ordenada desde el último ID registrado hacia atrás
            $sql = 'SELECT * FROM productos ORDER BY id DESC';
            // Ejecuta una consulta directa rápida (query) ideal para listados fijos
            $stmt = $this->conexion->query($sql);
            // Retorna los datos como arreglo asociativo; si devuelve 'false', lo fuerza a un array vacío []
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            return []; // Failsafe: Si truena la base de datos, el sistema no se cae, devuelve array vacío
        }
    }

    /**
     * READ (Paginado) - Trae un bloque limitado de productos para optimizar la carga del sistema.
     * @param int $limite Cantidad máxima de productos a traer por página.
     * @param int $offset Punto de partida (fila) desde donde se iniciará la lectura.
     * @return array
     */
    public function obtenerPaginados(int $limite, int $offset): array
    {
        try {
            // Consulta SQL parametrizada con LIMIT y OFFSET
            $sql = "
                SELECT *
                FROM productos
                ORDER BY id DESC
                LIMIT :limite OFFSET :offset
            ";
            
            $stmt = $this->conexion->prepare($sql);
            // Vinculación explícita especificando que los valores deben tratarse estrictamente como enteros (PARAM_INT)
            $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Cuenta el volumen total de productos guardados en el inventario.
     * Utilizado para calcular la paginación matemática desde el controlador.
     * @return int
     */
    public function contarProductos(): int
    {
        try {
            $sql = "SELECT COUNT(*) AS total FROM productos";
            $stmt = $this->conexion->query($sql);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            // Retorna el valor convirtiéndolo explícitamente a tipo entero
            return (int)$resultado['total'];
        } catch (PDOException $e) {
            return 0;
        }
    }

    /**
     * Buscador público. Filtra productos por coincidencia en su nombre o su descripción.
     * @param string $termino Palabra o fragmento de texto a buscar.
     * @return array
     */
    public function buscarPublico(string $termino = ''): array
    {
        try {
            // Si el término está vacío, ahorra recursos y hereda todos los productos del método obtenerTodos()
            if (trim($termino) === '') {
                return $this->obtenerTodos();
            }

            // Uso del operador LIKE para buscar coincidencias parciales dentro de las columnas
            $sql = 'SELECT * FROM productos WHERE nombre LIKE :termino OR descripcion LIKE :termino ORDER BY id DESC';
            $stmt = $this->conexion->prepare($sql);
            // Envuelve el término entre comodines de porcentaje (%) para que busque al inicio, en medio o al final
            $busqueda = '%' . $termino . '%';
            $stmt->bindParam(':termino', $busqueda);
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Busca un único producto utilizando su llave primaria ID.
     * @param int $id Identificador del producto.
     * @return array|null Retorna el producto encontrado o NULL si no existe en la base de datos.
     */
    public function obtenerPorId(int $id): ?array
    {
        try {
            $sql = 'SELECT * FROM productos WHERE id = :id LIMIT 1';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $producto = $stmt->fetch();
            // Operador ternario: si fetch() devuelve falso, se retorna null de forma limpia
            return $producto ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * CREATE - Registra un nuevo producto controlando la duplicidad de SKU y usando Transacciones Seguras.
     * @param array $data Contiene los valores limpios recolectados del formulario.
     * @return bool|string Retorna true si fue exitoso, false si falló y "duplicado" si el SKU ya existía.
     */
    public function crear(array $data)
    {
        try {
            // Inicia una transacción segura. Congela temporalmente la tabla para asegurar que los datos
            // se guarden de forma atómica y consistente, evitando la corrupción de datos.
            $this->conexion->beginTransaction();
            
            // --- VERIFICACIÓN DE SKU DUPLICADO ---
            $check = $this->conexion->prepare("
                SELECT id
                FROM productos
                WHERE sku = :sku
            ");
            $check->bindParam(':sku', $data['sku']);
            $check->execute();
            
            // Si la consulta arroja una fila o más, significa que otro producto ya tiene ese SKU asignado
            if ($check->rowCount() > 0) {
                // Cancela la transacción para liberar la base de datos de inmediato
                $this->conexion->rollBack();
                return "duplicado";
            }

            // --- INSERCIÓN DEL REGISTRO (Incluyendo la ruta de la imagen física) ---
            $sql = "INSERT INTO productos (sku, nombre, descripcion, precio_compra, precio_venta, existencia, imagen)
                    VALUES (:sku, :nombre, :descripcion, :precio_compra, :precio_venta, :existencia, :imagen)";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':sku', $data['sku']);
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':descripcion', $data['descripcion']);
            $stmt->bindParam(':precio_compra', $data['precio_compra']);
            $stmt->bindParam(':precio_venta', $data['precio_venta']);
            $stmt->bindParam(':existencia', $data['existencia'], PDO::PARAM_INT);
            $stmt->bindParam(':imagen', $data['imagen']);

            $resultado = $stmt->execute();
            
            // Si la base de datos rechaza la inserción por cualquier motivo secundario...
            if (!$resultado) {
                // Hace un rollback para revertir cualquier intento de cambio previo y mantener todo limpio
                $this->conexion->rollBack();
                return false;
            }

            // Confirma físicamente la transacción en el disco duro. Los cambios ahora son permanentes.
            $this->conexion->commit();
            return true;
            
        } catch (PDOException $e) {
            // Si ocurre un error de hardware o de sintaxis dentro del bloque try, revisa si hay una transacción abierta
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack(); // Deshace los cambios colaterales para proteger la integridad del sistema
            }
            return false;
        }
    }

    /**
     * UPDATE - Modifica todos los valores de un producto existente localizándolo por su ID.
     * @param int $id Identificador del producto a modificar.
     * @param array $data Arreglo asociativo con los nuevos valores.
     * @return bool
     */
    public function actualizar(int $id, array $data): bool
    {
        try {
            $this->conexion->beginTransaction();

            $sql = 'UPDATE productos SET
                        sku = :sku,
                        nombre = :nombre,
                        descripcion = :descripcion,
                        precio_compra = :precio_compra,
                        precio_venta = :precio_venta,
                        existencia = :existencia,
                        imagen = :imagen
                    WHERE id = :id';

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':sku', $data['sku']);
            $stmt->bindParam(':nombre', $data['nombre']);
            $stmt->bindParam(':descripcion', $data['descripcion']);
            $stmt->bindParam(':precio_compra', $data['precio_compra']);
            $stmt->bindParam(':precio_venta', $data['precio_venta']);
            $stmt->bindParam(':existencia', $data['existencia'], PDO::PARAM_INT);
            $stmt->bindParam(':imagen', $data['imagen']);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $this->conexion->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return false;
        }
    }

    /**
     * DELETE - Borra permanentemente un producto de la base de datos a través de su ID.
     * @param int $id Identificador del producto a remover.
     * @return bool
     */
    public function eliminar(int $id): bool
    {
        try {
            $this->conexion->beginTransaction();
            $sql = 'DELETE FROM productos WHERE id = :id';
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Si rowCount devuelve 0, significa que el ID no existía y no se borró nada realmente
            if ($stmt->rowCount() === 0) {
                $this->conexion->rollBack();
                return false;
            }

            $this->conexion->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            return false;
        }
    }
}
?>