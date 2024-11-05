<?php
include "config.php";

$input = file_get_contents("php://input");
$decode = json_decode($input, true);

$id = isset($decode['id']) ? (int)$decode['id'] : null;

// Validar que el ID no sea nulo
if ($id === null) {
    echo json_encode(["success" => false, "message" => "El ID es obligatorio."]);
    exit;
}

// Prepared statement
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "USUARIO ELIMINADO CON ÉXITO"]);
} else {
    echo json_encode(["success" => false, "message" => "PROBLEMA DEL SERVIDOR"]);
}

$stmt->close();
$conn->close();
?>
