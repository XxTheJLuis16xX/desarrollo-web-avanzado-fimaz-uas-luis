<?php

require_once("../../config/DataBase.php");

class torneosModel
{
    public $PDO;

    public function __construct()
    {
        $connection = new DataBase();
        $this->PDO = $connection->connect();
    }

    public function insert($nombreTorneo, $organizador, $patrocinadores, $sede, $categoria, $premio1, $premio2, $premio3, $otroPremio, $usuario, $contrasena)
    {
        $statement = $this->PDO->prepare(
            "INSERT INTO torneos 
            VALUES(null, :nombreTorneo, :organizador, :patrocinadores, :sede, :categoria, :premio1, :premio2, :premio3, :otroPremio, :usuario, :contrasena)"
        );

        $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

        $statement->bindParam(":nombreTorneo", $nombreTorneo);
        $statement->bindParam(":organizador", $organizador);
        $statement->bindParam(":patrocinadores", $patrocinadores);
        $statement->bindParam(":sede", $sede);
        $statement->bindParam(":categoria", $categoria);
        $statement->bindParam(":premio1", $premio1);
        $statement->bindParam(":premio2", $premio2);
        $statement->bindParam(":premio3", $premio3);
        $statement->bindParam(":otroPremio", $otroPremio);
        $statement->bindParam(":usuario", $usuario);
        $statement->bindParam(":contrasena", $contrasena);

        return ($statement->execute()) ? $this->PDO->lastInsertId() : false;
    }

    public function read()
    {
        $statement = $this->PDO->prepare("SELECT * FROM torneos");
        return ($statement->execute()) ? $statement->fetchAll() : false;
    }

    public function readOne($id)
    {
        $statement = $this->PDO->prepare("SELECT * FROM torneos WHERE id = :id LIMIT 1");
        $statement->bindParam(":id", $id);
        return ($statement->execute()) ? $statement->fetch() : false;
    }

    public function update($id, $nombreTorneo, $organizador, $patrocinadores, $sede, $categoria, $premio1, $premio2, $premio3, $otroPremio, $usuario, $contrasena)
    {
        $statement = $this->PDO->prepare(
            "UPDATE torneos SET 
            nombreTorneo = :nombreTorneo,
            organizador = :organizador,
            patrocinadores = :patrocinadores,
            sede = :sede,
            categoria = :categoria,
            premio1 = :premio1,
            premio2 = :premio2,
            premio3 = :premio3,
            otroPremio = :otroPremio,
            usuario = :usuario,
            contrasena = :contrasena
            WHERE id = :id"
        );

        $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

        $statement->bindParam(":id", $id);
        $statement->bindParam(":nombreTorneo", $nombreTorneo);
        $statement->bindParam(":organizador", $organizador);
        $statement->bindParam(":patrocinadores", $patrocinadores);
        $statement->bindParam(":sede", $sede);
        $statement->bindParam(":categoria", $categoria);
        $statement->bindParam(":premio1", $premio1);
        $statement->bindParam(":premio2", $premio2);
        $statement->bindParam(":premio3", $premio3);
        $statement->bindParam(":otroPremio", $otroPremio);
        $statement->bindParam(":usuario", $usuario);
        $statement->bindParam(":contrasena", $contrasena);

        return ($statement->execute()) ? $id : false;
    }

    public function delete($id)
    {
        $statement = $this->PDO->prepare("DELETE FROM torneos WHERE id = :id");
        $statement->bindParam(":id", $id);

        return ($statement->execute()) ? $id : false;
    }
}