<?php
require_once "models/User.php";
require_once "config/database.php";
require_once "Response.php";

$database = new Database();
$db = $database->getConnection();

try {
    if (isset($_GET['id'])) {
        // Buscar usuario específico
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
                $row['sexo']
            );
            $userData = [
                'id' => $user->getId(),
                'nombre' => $user->getNombre(),
                'apellidos' => $user->getApellidos(),
                'telefono' => $user->getTelefono(),
                'email' => $user->getEmail(),
                'sexo' => $user->getSexo()
            ];
            Response::json(true, "Alumno encontrado", $userData);
        } else {
            Response::json(false, "Alumno no encontrado", null);
        }
    } else {
        // Buscar todos los usuarios
        $stmt = $db->query("SELECT * FROM alumno");
        $usuarios = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new User(
                $row['id'],
                $row['nombre'],
                $row['apellidos'],
                $row['password'],
                $row['telefono'],
                $row['email'],
                $row['sexo']
            );
            $userData = [
                'id' => $user->getId(),
                'nombre' => $user->getNombre(),
                'apellidos' => $user->getApellidos(),
                'telefono' => $user->getTelefono(),
                'email' => $user->getEmail(),
                'sexo' => $user->getSexo()
            ];
            $usuarios[] = $userData;
        }
        Response::json(true, "Lista de alumnos", $usuarios);
    }
} catch (PDOException $e) {
    Response::json(false, "Error: " . $e->getMessage(), null);
}
