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

    // Escapar y sanitizar los datos para evitar inyección de SQL
    $id = mysqli_real_escape_string($conn, $decode['id']);
    $name = mysqli_real_escape_string($conn, $decode['name']);
    $age = (int) $decode['age']; // Convertir a entero para mayor seguridad
    $country = mysqli_real_escape_string($conn, $decode['country']);

    // Preparar la consulta de actualización
    $sql = "UPDATE users SET user_name='$name', user_age=$age, user_country='$country' WHERE id='$id'";
    $run_sql = mysqli_query($conn, $sql);

    if ($run_sql) {
        echo json_encode(["success" => true, "message" => "USUARIO ACTUALIZADO CON ÉXITO"]);
    } else {
        echo json_encode(["success" => false, "message" => "PROBLEMA DEL SERVIDOR"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "DATOS INVÁLIDOS O INCOMPLETOS"]);
}

// Cerrar la conexión
$conn->close();
?>
