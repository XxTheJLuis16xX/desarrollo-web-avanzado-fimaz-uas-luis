<?php

class DataBase
{
    private $host = "localhost";
    private $db = "proyecto";
    private $user = "root";
    private $password = "";

    public function connect()
    {
        try {
            $PDO = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db,
                $this->user,
                $this->password
            );

            $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $PDO;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}