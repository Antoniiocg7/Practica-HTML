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

try {
    // Obtener usuario antes de eliminar
    $stmt = $db->prepare("SELECT * FROM alumno WHERE id = :id");
    $stmt->bindParam(":id", $_GET['id']);
    $stmt->execute();

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user = new User(
            $row['id'],
            $row['nombre'],
            $row['apellidos'],
            $row['password'],
            $row['telefono'],
            $row['email'],
            $row['sexo'],
            $row['fecha_nacimiento']
        );

        // Eliminar usuario
        $stmt = $db->prepare("DELETE FROM alumno WHERE id = :id");
        $stmt->bindParam(":id", $_GET['id']);

        if ($stmt->execute()) {
            // Convertir usuario a array para la respuesta
            $userData = [
                'id' => $row['id'],
                'nombre' => $row['nombre'],
                'apellidos' => $row['apellidos'],
                'telefono' => $row['telefono'],
                'email' => $row['email'],
                'sexo' => $row['sexo'],
                'fecha_nacimiento' => $row['fecha_nacimiento']
            ];
            Response::json(true, "Alumno eliminado correctamente", $userData);
        } else {
            Response::json(false, "Error al eliminar alumno", null);
        }
    } else {
        Response::json(false, "Alumno no encontrado", null);
    }
} catch (PDOException $e) {
    Response::json(false, "Error: " . $e->getMessage(), null);
}
