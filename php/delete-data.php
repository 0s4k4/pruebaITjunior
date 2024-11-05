<?php
include "config.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Obtener el cuerpo de la solicitud
$data = json_decode(file_get_contents("php://input"));

// Validar que el ID esté presente y sea numérico
if (!isset($data->id) || !is_numeric($data->id)) {
    echo json_encode(["success" => false, "message" => "ID inválido"]);
    exit();
}

$id = (int)$data->id; // Convertir a entero para mayor seguridad

// Preparar la consulta SQL para evitar inyección de SQL
$sql = $conn->prepare("DELETE FROM users WHERE id = ?");
$sql->bind_param("i", $id);

// Ejecutar la consulta y verificar el resultado
if ($sql->execute()) {
    if ($sql->affected_rows > 0) {
        echo json_encode(["success" => true, "message" => "USUARIO ELIMINADO CON ÉXITO"]);
    } else {
        echo json_encode(["success" => false, "message" => "No se encontró el usuario o ya fue eliminado"]);
    }
} else {
    // Registro del error en un archivo de log (buena práctica)
    error_log("Error en la consulta: " . $conn->error);
    echo json_encode(["success" => false, "message" => "PROBLEMA DEL SERVIDOR"]);
}

$sql->close();
$conn->close();
?>
