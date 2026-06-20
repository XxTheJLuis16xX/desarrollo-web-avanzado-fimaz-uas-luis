<?php

class Usuario
{
    private string $nombre;
    private string $correo;

    public function __construct(string $nombre, string $correo)
    {
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
}