<?php
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Leer y decodificar la solicitud JSON
$input = file_get_contents("php://input");
$decode = json_decode($input, true);

// Verificar si los datos necesarios están presentes
if (isset($decode["name"], $decode["age"], $decode["country"])) {
    $name = trim($decode["name"]);
    $age = (int) $decode["age"]; // Convertir a entero para evitar inyecciones
    $country = trim($decode["country"]);

    // Validar que los campos no estén vacíos y tengan el formato adecuado
    if (empty($name) || !is_numeric($age) || empty($country)) {
        echo json_encode(["success" => false, "message" => "Datos inválidos"]);
        exit;
    }

    // Usar consultas preparadas para evitar inyecciones de SQL
    $stmt = $conn->prepare("INSERT INTO users (user_name, user_age, user_country) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sis", $name, $age, $country);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(["success" => true, "message" => "USUARIO AGREGADO CON ÉXITO"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al agregar el usuario"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Error en la preparación de la consulta"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
}

// Cerrar la conexión
$conn->close();
?>
