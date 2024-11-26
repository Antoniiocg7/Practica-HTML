<?php
require_once "models/User.php";
require_once "config/database.php";
require_once "Response.php";

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::json(false, "Método no permitido", null);
    exit;
}

// Obtener el JSON del body y convertirlo a array
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

try {
    $stmt = $db->prepare("INSERT INTO alumno (nombre, apellidos, PASSWORD, telefono, email, sexo, fecha_nacimiento) 
                         VALUES (:nombre, :apellidos, :password, :telefono, :email, :sexo, :fecha_nacimiento)");

    $stmt->bindParam(":nombre", $data['nombre']);
    $stmt->bindParam(":apellidos", $data['apellidos']);
    $stmt->bindParam(":password", $data['contraseña']);
    $stmt->bindParam(":telefono", $data['telefono']);
    $stmt->bindParam(":email", $data['email']);
    $stmt->bindParam(":sexo", $data['sexo']);
    $stmt->bindParam(":fecha_nacimiento", $data['fecha_nacimiento']);

    if ($stmt->execute()) {
        $id = $db->lastInsertId();
        $user = new User(
            $id,
            $data['nombre'],
            $data['apellidos'],
            $data['contraseña'],
            $data['telefono'],
            $data['email'],
            $data['sexo']
        );
        // Convertir el usuario a array para la respuesta
        $userData = [
            'id' => $id,
            'nombre' => $data['nombre'],
            'apellidos' => $data['apellidos'],
            'telefono' => $data['telefono'],
            'email' => $data['email'],
            'sexo' => $data['sexo']
        ];
        Response::json(true, "Usuario creado correctamente", $userData);
    } else {
        Response::json(false, "Error al crear usuario", null);
    }
} catch (PDOException $e) {
    Response::json(false, "Error: " . $e->getMessage(), null);
}
