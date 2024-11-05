<?php

include 'config.php';

$input = file_get_contents("php://input");
$decode = json_decode($input, true);

// Validar y sanitizar datos
$name = isset($decode["name"]) ? trim($decode["name"]) : null;
$age = isset($decode["age"]) ? (int)$decode["age"] : null; // Asegúrate de que sea un número
$country = isset($decode["country"]) ? trim($decode["country"]) : null;

// Validar que no estén vacíos y que la edad sea un número
if (empty($name) || empty($country) || $age === null) {
    echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios y la edad debe ser un número."]);
    exit;
}

// Usar prepared statements
$stmt = $conn->prepare("INSERT INTO users (user_name, user_age, user_country) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $name, $age, $country); // s = string, i = integer

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "USUARIO AGREGADO CON ÉXITO"]);
} else {
    echo json_encode(["success" => false, "message" => "PROBLEMA DEL SERVIDOR"]);
}

$stmt->close();
$conn->close();
?>
