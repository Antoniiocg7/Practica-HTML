<?php
require_once(__DIR__ . '/models/User.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger datos del formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $contraseña = $_POST['contraseña'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $sexo = $_POST['sexo'];

    // Instacia de Usuario
    $usuario = new User($nombre, $apellidos, $contraseña, $telefono, $email, $sexo);

    // Guardar la información en un archivo
    $datos = $usuario->toJson() . "\n";
    file_put_contents('usuarios.txt', $datos, FILE_APPEND);

    // Mostrar información en formato JSON
    header('Content-Type: application/json');
    echo $usuario->toJson();
}
