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
            <form action="torneoUpdate.php" method="post">

                <div class="mb-3">
                    <label class="form-label">ID DEL TORNEO</label>
                    <input type="text" class="form-control" name="txtIdTorneo" value="<?= $lstTorneo['id'] ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">NOMBRE DEL TORNEO</label>
                    <input type="text" class="form-control" name="txtNombreTorneo" value="<?= $lstTorneo['nombreTorneo'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">ORGANIZADOR</label>
                    <input type="text" class="form-control" name="txtOrganizador" value="<?= $lstTorneo['organizador'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">PATROCINADOR(ES)</label>
                    <textarea name="txtPatrocinador" cols="30" rows="2" class="form-control"><?= $lstTorneo['patrocinadores'] ?></textarea>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">SEDE</label>
                        <input type="text" class="form-control" name="txtSede" value="<?= $lstTorneo['sede'] ?>">
                    </div>

                    <div class="col mb-3">
                        <label class="form-label">CATEGORÍA</label>
                        <input list="lstCategorias" name="txtCategoria" class="form-control" value="<?= $lstTorneo['categoria'] ?>">

                        <datalist id="lstCategorias">
                            <option value="1ra. fuerza">
                            <option value="2da. fuerza">
                            <option value="Veteranos">
                            <option value="Libre">
                            <option value="Juvenil">
                            <option value="Femenil">
                            <option value="Empresarial">
                            <option value="Infantil">
                            <option value="Minibasket">
                        </datalist>
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">PREMIO 1ER. LUGAR</label>
                        <input type="text" class="form-control" name="txtPremio1" value="<?= $lstTorneo['premio1'] ?>">
                    </div>

                    <div class="col mb-3">
                        <label class="form-label">PREMIO 2DO. LUGAR</label>
                        <input type="text" class="form-control" name="txtPremio2" value="<?= $lstTorneo['premio2'] ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">PREMIO 3ER. LUGAR</label>
                        <input type="text" class="form-control" name="txtPremio3" value="<?= $lstTorneo['premio3'] ?>">
                    </div>

                    <div class="col mb-3">
                        <label class="form-label">OTRO PREMIO</label>
                        <input type="text" class="form-control" name="txtOtroPremio" value="<?= $lstTorneo['otroPremio'] ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">USUARIO</label>
                        <input type="text" class="form-control" name="txtUsuario" value="<?= $lstTorneo['usuario'] ?>">
                    </div>

                    <div class="col mb-3">
                        <label class="form-label">CONTRASEÑA</label>
                        <input type="text" class="form-control" name="txtContrasena" value="">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="readAllTorneos.php" class="btn btn-danger">Cancelar</a>

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