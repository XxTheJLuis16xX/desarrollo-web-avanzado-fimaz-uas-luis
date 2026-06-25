<?php 
// 1. ACOPLAMIENTO DE LA PARTE SUPERIOR (Sándwich - Tapa superior)
// Carga el archivo header.php que contiene la sesión iniciada, el token CSRF generado,
// las etiquetas <head>, los estilos de Bootstrap y la barra de navegación superior.
require_once __DIR__ . '/../layouts/header.php'; 
?>

<div class="row justify-content-center">
    
    <div class="col-md-5">
        
        <div class="card shadow-sm">
            
            <div class="card-header bg-primary text-white">
                Iniciar sesión
            </div>
            
            <div class="card-body">
                
                <form action="index.php?route=auth/login" method="POST">
                    
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Usuario</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
                
            </div>
        </div>
    </div>
</div>

<?php 
// 3. ACOPLAMIENTO DE LA PARTE INFERIOR (Sándwich - Tapa inferior)
// Carga el archivo footer.php que se encarga de cerrar limpiamente las etiquetas 
// del contenedor principal (</div>), del cuerpo (</body>) y del HTML (</html>).
require_once __DIR__ . '/../layouts/footer.php'; 
?>