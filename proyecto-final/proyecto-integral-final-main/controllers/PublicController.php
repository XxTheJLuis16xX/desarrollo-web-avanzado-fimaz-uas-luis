<?php
/**
 * Clase PublicController
 * Ubicada en el espacio de nombres (namespace) Controllers.
 * Gestiona las secciones públicas de la tienda a las que cualquier visitante 
 * puede acceder sin necesidad de iniciar sesión (como el catálogo de clientes).
 */
namespace Controllers;

// Importamos el modelo de productos para poder consultar el inventario disponible
use Models\ProductoModel;

class PublicController
{
    /**
     * Muestra el catálogo de productos disponible para el público general.
     * Permite filtrar los resultados si el usuario realiza una búsqueda de texto.
     * @return void
     */
    public function catalogo(): void
    {
        // Captura el término de búsqueda enviado por la URL mediante el método GET (ej: ?buscar=camisa).
        // Si no se escribió nada en la barra de búsqueda, le asigna una cadena vacía ('').
        // trim() elimina espacios innecesarios al inicio o al final del texto ingresado.
        $termino = trim($_GET['buscar'] ?? '');
        
        // Instancia el modelo de productos para interactuar con la base de datos
        $productoModel = new ProductoModel(); 
        
        // Ejecuta la consulta en el modelo pasándole el término de búsqueda.
        // Si $termino está vacío, el modelo traerá todos los productos; si tiene texto, filtrará por coincidencia.
        $productos = $productoModel->buscarPublico($termino);
        
        // Carga la interfaz gráfica (vista) pública del catálogo, donde se dibuja la cuadrícula de productos
        // utilizando los datos almacenados en la variable $productos.
        require_once __DIR__ . '/../views/public/catalogo.php';
    }
}
?>