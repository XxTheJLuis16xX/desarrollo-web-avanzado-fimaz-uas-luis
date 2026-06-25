<?php
/**
 * Clase ProductoController
 * Ubicada en el espacio de nombres (namespace) Controllers.
 * Controla todo el ciclo de vida de los productos (CRUD) y su paginación.
 */
namespace Controllers;

// Importamos los modelos requeridos para la base de datos y la bitácora
use Models\ProductoModel;
use Models\LogModel;

class ProductoController
{
    // Atributos privados para encapsular las instancias de los modelos
    private ProductoModel $productoModel;
    private LogModel $logModel;

    /**
     * Constructor de la clase.
     * Se ejecuta automáticamente al instanciar el controlador y prepara los modelos necesarios.
     */
    public function __construct()
    {
        $this->productoModel = new ProductoModel();
        $this->logModel = new LogModel();
    }

    /**
     * Método de seguridad interno (Middleware).
     * Asegura que el usuario tenga una sesión activa como administrador antes de operar el inventario.
     * @return void
     */
    private function verificarSesion(): void
    {
        // Si no se ha iniciado la sesión en el servidor, la inicia.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si la variable de sesión 'admin' no existe, significa que es un intruso; lo expulsa al login.
        if (!isset($_SESSION['admin'])) {
            header('Location: index.php?route=login');
            exit;
        }
    }

    /**
     * READ - Lista y pagina los productos en el panel de administración.
     * @return void
     */
    public function index(): void
    {
        // Aplica el filtro de seguridad para verificar que el usuario esté logueado
        $this->verificarSesion();
        
        // Captura el número de página de la URL (?pagina=X). Si no existe, por defecto es 1.
        $pagina = (int)($_GET['pagina'] ?? 1);

        // Fuerza a que si el usuario digita un número menor a 1, se inicialice en la página 1.
        if ($pagina < 1){
            $pagina = 1;
        }
        
        // Define cuántos registros se mostrarán por pantalla
        $limite = 5;
        // Calcula matemáticamente a partir de qué fila de la base de datos se empezará a leer
        $offset = ($pagina - 1) * $limite;
        
        // Solicita al modelo únicamente los productos que corresponden al bloque de la página actual
        $productos = $this->productoModel->obtenerPaginados($limite, $offset);
        // Cuenta el total absoluto de productos en la base de datos para calcular el paginado
        $totalProductos = $this->productoModel->contarProductos();
        // Redondea hacia arriba para obtener el número total de páginas (ej: 11 productos / 5 = 3 páginas)
        $totalPaginas = ceil($totalProductos / $limite);
        
        // Carga la interfaz gráfica (vista) que dibuja la tabla con los productos
        require_once __DIR__ . '/../views/productos/index.php';
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     * @return void
     */
    public function create(): void
    {
        $this->verificarSesion();
        require_once __DIR__ . '/../views/productos/create.php';
    }

    /**
     * CREATE - Procesa el envío del formulario e inserta el producto en la base de datos.
     * @return void
     */
    public function store(): void
    {
        $this->verificarSesion();

        // Sanitiza y recupera los campos de texto del formulario eliminando espacios extraños
        $data = [
            'sku' => trim($_POST['sku'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio_compra' => trim($_POST['precio_compra'] ?? ''),
            'precio_venta' => trim($_POST['precio_venta'] ?? ''),
            'existencia' => trim($_POST['existencia'] ?? '')
        ];

        // --- GESTIÓN DE SUBIDA DE IMAGEN ---
        $nombreImagen = null;
        // Revisa si se seleccionó un archivo y si no hubo errores en la transferencia temporal
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
            // Extrae la extensión del archivo (ej: png, jpg)
            $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            // Genera un nombre único aleatorio para evitar que imágenes con el mismo nombre se sobreescriban
            $nombreImagen = uniqid() . '.' . $extension;
            // Define la ruta física donde se guardará permanentemente en el servidor
            $rutaDestino = __DIR__ . '/../views/img/' . $nombreImagen;
            // Mueve el archivo desde el espacio temporal del servidor a la carpeta final de la tienda
            move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);
        }
        // Agrega el nombre final de la imagen al arreglo de datos
        $data['imagen'] = $nombreImagen;

        // --- VALIDACIONES DE REGLAS DE NEGOCIO ---
        
        // 1. Verifica que no existan campos de texto obligatorios vacíos
        if (
            $data['sku'] === '' || $data['nombre'] === '' || $data['descripcion'] === '' ||
            $data['precio_compra'] === '' || $data['precio_venta'] === '' || $data['existencia'] === ''
        ) {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            header('Location: index.php?route=productos/create');
            exit;
        }

        // 2. Comprueba que los campos que manejan dinero o stock sean estrictamente numéricos
        if (!is_numeric($data['precio_compra']) || !is_numeric($data['precio_venta']) || !is_numeric($data['existencia'])) {
            $_SESSION['error'] = 'Precio de compra, precio de venta y existencia deben ser numéricos.';
            header('Location: index.php?route=productos/create');
            exit;
        }
        
        // 3. Valida que los costos monetarios no sean inferiores a cero
        if ((float)$data['precio_compra'] < 0 || (float)$data['precio_venta'] < 0) {
            $_SESSION['error'] = 'No se permiten valores negativos.';
            header('Location: index.php?route=productos/create');
            exit;
        }
        
        // 4. Evita que el inventario físico tenga un stock menor a cero
        if ((int)$data['existencia'] < 0) {
            $_SESSION['error'] = 'La existencia no puede ser negativa.';
            header('Location: index.php?route=productos/create');
            exit;
        }

        // 5. Regla comercial fundamental: El precio de venta debe dejar margen de ganancia respecto a la compra
        if ((float)$data['precio_venta'] < (float)$data['precio_compra']) {
            $_SESSION['error'] = 'El precio de venta no puede ser menor al precio de compra.';
            header('Location: index.php?route=productos/create');
            exit;
        }

        // --- GUARDADO Y AUDITORÍA ---
        // Envía el arreglo de datos al modelo para que realice el INSERT SQL
        $resultado = $this->productoModel->crear($data);
        
        if ($resultado === "duplicado") {
            // El modelo detectó que el código SKU ya está registrado en otro producto
            $_SESSION['error'] = 'El SKU ya existe.';
        } elseif ($resultado) {
            // Éxito: Modifica los mensajes flash y guarda el evento en la bitácora histórica
            $_SESSION['success'] = 'Producto registrado correctamente.';
            $this->logModel->registrar($_SESSION['admin']['username'], 'Registró el producto: ' . $data['nombre']);
        } else {
            $_SESSION['error'] = 'No fue posible registrar el producto.';
        }

        header('Location: index.php?route=productos');
        exit;
    }

    /**
     * Muestra el formulario de edición con los datos cargados del producto específico.
     * @return void
     */
    public function edit(): void
    {
        $this->verificarSesion();

        // Lee el ID de la URL y lo convierte a entero por seguridad
        $id = (int)($_GET['id'] ?? 0);
        // Busca en la base de datos la información actual del producto
        $producto = $this->productoModel->obtenerPorId($id);

        // Si el producto no existe (ID alterado en la URL), rompe el flujo y vuelve al inicio
        if (!$producto) {
            $_SESSION['error'] = 'Producto no encontrado.';
            header('Location: index.php?route=productos');
            exit;
        }

        // Carga el formulario de edición pasándole la variable $producto automáticamente
        require_once __DIR__ . '/../views/productos/edit.php';
    }

    /**
     * UPDATE - Recibe los cambios del formulario de edición y modifica el registro.
     * @return void
     */
    public function update(): void
    {
        $this->verificarSesion();

        // El ID viaja de forma oculta en un input de tipo hidden del formulario POST
        $id = (int)$_POST['id'] ?? 0;

        $data = [
            'sku' => trim($_POST['sku'] ?? ''),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'precio_compra' => trim($_POST['precio_compra'] ?? ''),
            'precio_venta' => trim($_POST['precio_venta'] ?? ''),
            'existencia' => trim($_POST['existencia'] ?? '')
        ];

        // Obtiene el estado actual del producto para saber si ya tenía una imagen cargada previamente
        $productoActual = $this->productoModel->obtenerPorId($id);
        $nombreImagen = $productoActual['imagen'] ?? null;
        
        // Si el administrador subió una NUEVA imagen en este formulario...
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
            // Si ya existía una imagen anterior registrada, la elimina físicamente del disco para no dejar basura en el servidor
            if (!empty($nombreImagen)) {
                $rutaVieja = __DIR__ . '/../views/img/' . $nombreImagen;
                if (file_exists($rutaVieja)) { 
                    unlink($rutaVieja); // Borra el archivo viejo del servidor
                }
            }
            // Procesa y guarda la nueva foto asignándole un identificador único
            $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $nombreImagen = uniqid() . '.' . $extension;
            $rutaDestino = __DIR__ . '/../views/img/' . $nombreImagen;
            move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);
        }

        // Conserva el nombre de la imagen vieja (si no se cambió) o el de la nueva (si se subió una)
        $data['imagen'] = $nombreImagen;

        // --- VALIDACIONES DE SEGURIDAD Y DATOS (Idénticas a las de Store) ---
        if ($id <= 0) {
            $_SESSION['error'] = 'ID inválido.';
            header('Location: index.php?route=productos');
            exit;
        }

        if (
            $data['sku'] === '' || $data['nombre'] === '' || $data['descripcion'] === '' ||
            $data['precio_compra'] === '' || $data['precio_venta'] === '' || $data['existencia'] === ''
        ) {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            header('Location: index.php?route=productos/edit&id=' . $id);
            exit;
        }

        if (!is_numeric($data['precio_compra']) || !is_numeric($data['precio_venta']) || !is_numeric($data['existencia'])) {
            $_SESSION['error'] = 'Precio de compra, precio de venta y existencia deben ser numéricos.';
            header('Location: index.php?route=productos/edit&id=' . $id);
            exit;
        }

        if ((float)$data['precio_compra'] < 0 || (float)$data['precio_venta'] < 0) {
            $_SESSION['error'] = 'No se permiten valores negativos.';
            header('Location: index.php?route=productos/edit&id=' . $id);
            exit;
        }

        if ((int)$data['existencia'] < 0) {
            $_SESSION['error'] = 'La existencia no puede ser negativa.';
            header('Location: index.php?route=productos/edit&id=' . $id);
            exit;
        }
        
        if ((float)$data['precio_venta'] < (float)$data['precio_compra']) {
            $_SESSION['error'] = 'El precio de venta no puede ser menor al precio de compra.';
            header('Location: index.php?route=productos/edit&id=' . $id);
            exit;
        }

        // --- EJECUCIÓN DE LA ACTUALIZACIÓN ---
        if ($this->productoModel->actualizar($id, $data)) {
            $_SESSION['success'] = 'Producto actualizado correctamente.';
            // Deja registro en auditoría del cambio realizado
            $this->logModel->registrar($_SESSION['admin']['username'], 'Actualizó el producto: ' . $data['nombre']);
        } else {
            $_SESSION['error'] = 'No fue posible actualizar el producto.';
        }

        header('Location: index.php?route=productos');
        exit;
    }

    /**
     * DELETE - Remueve de forma definitiva un producto del sistema.
     * @return void
     */
    public function delete(): void
    {
        $this->verificarSesion();

        // Obtiene el ID mediante POST para evitar borrados accidentales o maliciosos por URL (GET)
        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['error'] = 'ID inválido.';
            header('Location: index.php?route=productos');
            exit;
        }
        
        // Obtiene los datos del producto antes de borrarlo únicamente para recuperar su nombre para la bitácora
        $producto = $this->productoModel->obtenerPorId($id);
        
        // Ejecuta la sentencia DELETE en el modelo
        if ($this->productoModel->eliminar($id)) {
            $_SESSION['success'] = 'Producto eliminado correctamente.';
            // Almacena en la bitácora la eliminación del registro
            $this->logModel->registrar($_SESSION['admin']['username'], 'Eliminó el producto: ' . $producto['nombre']);
        } else {
            $_SESSION['error'] = 'No fue posible eliminar el producto.';
        }

        header('Location: index.php?route=productos');
        exit;
    }
}
?>