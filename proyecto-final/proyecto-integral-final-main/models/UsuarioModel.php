<?php
/**
 * Clase UsuarioModel
 * Ubicada en el espacio de nombres (namespace) Models.
 * Se encarga de gestionar las consultas directas sobre la tabla 'usuarios'
 * de la base de datos (por ejemplo, para procesos de login).
 */
namespace Models;

// Importamos la clase de configuración de la base de datos y las herramientas de PDO
use Config\Database;
use PDO;
use PDOException;

class UsuarioModel
{
    // Atributo privado que guardará el objeto de conexión PDO activo
    private PDO $conexion;

    /**
     * Constructor de la clase.
     * Se ejecuta de forma automática al instanciar el modelo e inicializa la conexión con MySQL.
     */
    public function __construct()
    {
        // Instancia la clase constructora de la base de datos
        $db = new Database();
        // Llama al método connect() para enlazar la "tubería" PDO y guardarla en el atributo
        $this->conexion = $db->connect();
    }

    /**
     * Busca un registro de usuario en la base de datos utilizando su 'username'.
     * * @param string $username El nombre de usuario ingresado en el formulario.
     * @return array|null Retorna un arreglo asociativo con los datos del usuario si se encuentra,
     * o NULL si no existe o si ocurre un error en el servidor.
     */
    public function buscarPorUsername(string $username): ?array
    {
        // Bloque try-catch para capturar excepciones de la base de datos sin romper la aplicación
        try {
            // Define la consulta SQL utilizando un marcador de posición (:username).
            // 'LIMIT 1' optimiza la consulta para que el motor de MySQL deje de buscar en cuanto encuentre la primera coincidencia,
            // ya que los nombres de usuario deben ser únicos.
            $sql = 'SELECT * FROM usuarios WHERE username = :username LIMIT 1';
            
            // Prepara la consulta SQL para compilar su estructura de forma segura en el servidor de la base de datos
            $stmt = $this->conexion->prepare($sql);
            
            // Vinculación de parámetros (Data Binding):
            // Inyecta el string limpio de la variable PHP directamente en el marcador de posición de la consulta.
            // Esto neutraliza cualquier intento de ataque por inyección SQL.
            $stmt->bindParam(':username', $username);
            
            // Ejecuta la consulta estructurada en la base de datos
            $stmt->execute();
            
            // Recupera la fila resultante. Si el usuario existe, fetch() devuelve el arreglo de datos;
            // si no existe, devuelve el valor booleano 'false'.
            $usuario = $stmt->fetch();
            
            // Operador ternario: Si $usuario tiene datos, los retorna. Si es falso, devuelve null limpiamente.
            return $usuario ?: null;
            
        } catch (PDOException $e) {
            // Failsafe: Si ocurre un error grave en la base de datos, captura la excepción y retorna null
            // para evitar que el sistema colapse o muestre mensajes de error internos al cliente.
            return null;
        }
    }
}
?>