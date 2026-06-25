<?php
require_once("./template/header.php");
?>

<div class="mx-auto p-5">
    <div class="card text-center">
        <div class="card-header">
            MENÚ
            <h5 class="text-center mt-3">
    Alumno: José Luis Lizarraga Uribe
</h5>
        </div>

        <div class="card-body">

            <div class="row mb-3">

                <div class="col">
                    <div class="card text-center">
                        <div class="card-header">
                            CREAR TORNEO
                        </div>
                        <div class="card-body">
                            <a href="frmTorneos.php" class="btn btn-primary">
                                <img src="../../img/torneo-admin.png" alt="Crear un torneo" width="180" height="180">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card text-center">
                        <div class="card-header">
                            LISTA DE TORNEOS
                        </div>
                        <div class="card-body">
                            <a href="readAllTorneos.php" class="btn btn-primary">
                                <img src="../../img/lista-torneos-admin.png" alt="Listar torneos" width="180" height="180">
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row mb-3">

                <div class="col">
                    <div class="card text-center">
                        <div class="card-header">
                            ESTADÍSTICAS
                        </div>
                        <div class="card-body"></div>
                    </div>
                </div>

                <div class="col">
                    <div class="card text-center">
                        <div class="card-header">
                            ANUNCIOS
                        </div>
                        <div class="card-body"></div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card-footer text-body-secondary">
            Configuración de torneos. Web App Basket-Ball.
        </div>
    </div>
</div>

<?php
require_once("./template/footer.php");
?>