<?php

include "config.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$output = [];

$sql = "SELECT * FROM users ORDER BY id DESC";
$run_sql = mysqli_query($conn, $sql);

if ($run_sql) {
    if (mysqli_num_rows($run_sql) > 0) {
        while ($row = mysqli_fetch_assoc($run_sql)) {
            // Opcionalmente, puedes limpiar los datos antes de devolverlos
            $output[] = array_map('htmlspecialchars', $row);
        }
    } else {
        $output = ["empty" => "empty"];
    }

    // Enviar la respuesta como JSON
    echo json_encode($output);
} else {
    // Manejo de errores en la consulta
    echo json_encode(["error" => "Error en la consulta"]);
}

// Cerrar la conexión
$conn->close();
?>
