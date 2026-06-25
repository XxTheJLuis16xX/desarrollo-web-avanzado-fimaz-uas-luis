<?php
/**
 * Registro del Autoloader de Clases
 * * spl_autoload_register permite registrar una función anónima (callback) que PHP 
 * ejecutará automáticamente cada vez que intentes usar una clase, interfaz o trait 
 * que aún no haya sido cargada en memoria.
 */
spl_autoload_register(function ($class) {
    
    // 1. Definir el directorio raíz del proyecto.
    // __DIR__ da la ruta de la carpeta actual, y '/../' sube un nivel para posicionarse en la raíz.
    $baseDir = __DIR__ . '/../';
    
    // 2. Normalizar los Namespaces a rutas de archivos del sistema operativo.
    // Convierte las barras invertidas de los namespaces (ej. Controllers\AuthController) 
    // en barras diagonales (ej. Controllers/AuthController) usadas en las rutas de archivos.
    $class = str_replace('\\', '/', $class);
    
    // 3. Romper la ruta de la clase en partes (un arreglo).
    // Si la clase es "Controllers/AuthController", crea un arreglo: ['Controllers', 'AuthController']
    $parts = explode('/', $class);
    
    // 4. Adaptar el nombre de la carpeta raíz a minúsculas.
    // Comprueba si el arreglo no está vacío, y transforma el primer elemento (ej. 'Controllers') 
    // a minúsculas ('controllers') para que coincida exactamente con el nombre físico de tus carpetas.
    if (!empty($parts)) {
        $parts[0] = strtolower($parts[0]);
    }
    
    // 5. Construir la ruta absoluta final del archivo PHP.
    // Une de nuevo las partes del arreglo con '/' (ej. 'controllers/AuthController') 
    // y le concatena la extensión de archivo '.php' al final de la ruta raíz.
    $file = $baseDir . implode('/', $parts) . '.php';
    
    // 6. Carga segura del archivo.
    // Verifica físicamente en el disco duro si el archivo mapeado existe.
    if (file_exists($file)) {
        // Si el archivo existe, lo incluye una sola vez, dejando la clase lista para ser usada.
        require_once $file;
    }
});