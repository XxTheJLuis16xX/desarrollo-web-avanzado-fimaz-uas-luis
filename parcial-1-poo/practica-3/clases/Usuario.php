<?php

class Usuario
{
    protected string $nombre;
    protected string $correo;

    public function __construct(string $nombre, string $correo)
    {
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El correo '$correo' no tiene un formato válido.");
        }

        $this->nombre = $nombre;
        $this->correo = $correo;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getCorreo(): string
    {
        return $this->correo;
    }

    public function getRol(): string
    {
        return "Usuario";
    }
}