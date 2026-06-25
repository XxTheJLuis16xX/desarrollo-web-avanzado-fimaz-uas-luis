<?php

require_once("./template/header.php");
require_once("../../controllers/torneosController.php");

$objTorneosController = new torneosController();
$lstTorneo = $objTorneosController->readOneTorneo($_GET['id']);

?>

<div class="mx-auto p-5">
    <div class="card">
        <div class="card-header">
            INFORMACIÓN DEL TORNEO.
        </div>

        <div class="card-body">
            <form action="#" method="post">

                <div class="mb-3">
                    <label class="form-label">NOMBRE DEL TORNEO (ID: <?= $lstTorneo['id'] ?>)</label>
                    <input type="text" class="form-control" value="<?= $lstTorneo['nombreTorneo'] ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">ORGANIZADOR (nombre completo)</label>
                    <input type="text" class="form-control" value="<?= $lstTorneo['organizador'] ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">PATROCINADOR(ES)</label>
                    <textarea class="form-control" cols="30" rows="2" readonly><?= $lstTorneo['patrocinadores'] ?></textarea>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">SEDE (cancha)</label>
                        <input type="text" class="form-control" value="<?= $lstTorneo['sede'] ?>" readonly>
                    </div>

                    <div class="col mb-3">
                        <label class="form-label">CATEGORÍA</label>
                        <input type="text" class="form-control" value="<?= $lstTorneo['categoria'] ?>" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">PREMIO 1ER. LUGAR</label>
                        <input type="text" class="form-control" value="<?= $lstTorneo['premio1'] ?>" readonly>
                    </div>

                    <div class="col mb-3">
                        <label class="form-label">PREMIO 2DO. LUGAR</label>
                        <input type="text" class="form-control" value="<?= $lstTorneo['premio2'] ?>" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">PREMIO 3ER. LUGAR</label>
                        <input type="text" class="form-control" value="<?= $lstTorneo['premio3'] ?>" readonly>
                    </div>

                    <div class="col mb-3">
                        <label class="form-label">OTRO PREMIO</label>
                        <input type="text" class="form-control" value="<?= $lstTorneo['otroPremio'] ?>" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">USUARIO</label>
                        <input type="text" class="form-control" value="<?= $lstTorneo['usuario'] ?>" readonly>
                    </div>

                    <div class="col mb-3">
                        <label class="form-label">CONTRASEÑA</label>
                        <input type="text" class="form-control" value="<?= $lstTorneo['contrasena'] ?>" readonly>
                    </div>
                </div>

                <div class="row">
                    <a href="readAllTorneos.php" class="btn btn-success">REGRESAR</a>
                </div>

            </form>
        </div>

        <div class="card-footer text-body-secondary">
            DETALLE DE TORNEO.
        </div>
    </div>
</div>

<?php
require_once("./template/footer.php");
?>