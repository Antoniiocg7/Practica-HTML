<?php
require_once(__DIR__ . '/../interfaces/IToJson.php');

class User implements IToJson
{
    private $nombre;
    private $apellidos;
    private $contraseña;
    private $telefono;
    private $email;
    private $sexo;

    public function __construct($nombre, $apellidos, $contraseña, $telefono, $email, $sexo)
    {
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->contraseña = $contraseña;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->sexo = $sexo;
    }

    // Getters
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getApellidos()
    {
        return $this->apellidos;
    }
    public function getContraseña()
    {
        return $this->contraseña;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getSexo()
    {
        return $this->sexo;
    }

    // Setters
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }
    public function setContraseña($contraseña)
    {
        $this->contraseña = $contraseña;
    }
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    public function toJson()
    {
        return json_encode([
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'contraseña' => $this->contraseña,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'sexo' => $this->sexo
        ]);
    }
}
