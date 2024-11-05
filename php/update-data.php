<?php
include "config.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Obtener los datos del cuerpo de la solicitud
$input = file_get_contents("php://input");
$decode = json_decode($input, true);

// Validar si los datos necesarios están presentes y no están vacíos
if (isset($decode['id'], $decode['name'], $decode['age'], $decode['country']) &&
    !empty($decode['id']) && !empty($decode['name']) && !empty($decode['age']) && !empty($decode['country'])) {

    // Convertir el ID a entero y validar que sea un número
    $id = (int) $decode['id'];
    if ($id <= 0) {
        echo json_encode(["success" => false, "message" => "ID inválido."]);
        exit;
    }

    // Sanitizar el nombre y el país
    $name = trim($decode['name']);
    $country = trim($decode['country']);
    
    // Validar que la edad sea un número entero
    $age = (int) $decode['age'];
    if ($age <= 0) {
        echo json_encode(["success" => false, "message" => "La edad debe ser un número positivo."]);
        exit;
    }

    // Preparar la consulta de actualización utilizando prepared statements
    $stmt = $conn->prepare("UPDATE users SET user_name = ?, user_age = ?, user_country = ? WHERE id = ?");
    $stmt->bind_param("sisi", $name, $age, $country, $id); // s = string, i = integer

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "USUARIO ACTUALIZADO CON ÉXITO"]);
    } else {
        echo json_encode(["success" => false, "message" => "PROBLEMA DEL SERVIDOR"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "DATOS INVÁLIDOS O INCOMPLETOS"]);
}

// Cerrar la conexión
$conn->close();
?>
