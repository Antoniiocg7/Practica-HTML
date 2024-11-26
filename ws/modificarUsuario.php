<?php
require_once "models/User.php";
require_once "config/database.php";
require_once "Response.php";

$database = new Database();
$db = $database->getConnection();

if (!isset($_GET['id'])) {
    Response::json(false, "ID no proporcionado", null);
    exit;
}

// Obtener JSON del body
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

try {
    // Verificar si el alumno existe
    $stmt = $db->prepare("SELECT * FROM alumno WHERE id = :id");
    $stmt->bindParam(":id", $_GET['id']);
    $stmt->execute();

    if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
        Response::json(false, "Alumno no encontrado", null);
        exit;
    }

    // Construir query de actualización
    $updates = [];
    $params = [];

    if (!empty($data['nombre'])) {
        $updates[] = "nombre = :nombre";
        $params[':nombre'] = $data['nombre'];
    }
    if (!empty($data['apellidos'])) {
        $updates[] = "apellidos = :apellidos";
        $params[':apellidos'] = $data['apellidos'];
    }
    if (!empty($data['contraseña'])) {
        $updates[] = "PASSWORD = :password";
        $params[':password'] = $data['contraseña'];
    }
    if (!empty($data['telefono'])) {
        $updates[] = "telefono = :telefono";
        $params[':telefono'] = $data['telefono'];
    }
    if (!empty($data['email'])) {
        $updates[] = "email = :email";
        $params[':email'] = $data['email'];
    }
    if (!empty($data['sexo'])) {
        $updates[] = "sexo = :sexo";
        $params[':sexo'] = $data['sexo'];
    }
    if (!empty($data['fecha_nacimiento'])) {
        $updates[] = "fecha_nacimiento = :fecha_nacimiento";
        $params[':fecha_nacimiento'] = $data['fecha_nacimiento'];
    }

    if (empty($updates)) {
        Response::json(false, "No hay datos para actualizar", null);
        exit;
    }

    $query = "UPDATE alumno SET " . implode(", ", $updates) . " WHERE id = :id";
    $params[':id'] = $_GET['id'];

    $stmt = $db->prepare($query);
    if ($stmt->execute($params)) {
        // Obtener alumno actualizado
        $stmt = $db->prepare("SELECT * FROM alumno WHERE id = :id");
        $stmt->bindParam(":id", $_GET['id']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $userData = [
            'id' => $row['id'],
            'nombre' => $row['nombre'],
            'apellidos' => $row['apellidos'],
            'telefono' => $row['telefono'],
            'email' => $row['email'],
            'sexo' => $row['sexo'],
            'fecha_nacimiento' => $row['fecha_nacimiento']
        ];
        Response::json(true, "Alumno actualizado correctamente", $userData);
    } else {
        Response::json(false, "Error al actualizar alumno", null);
    }
} catch (PDOException $e) {
    Response::json(false, "Error: " . $e->getMessage(), null);
}
