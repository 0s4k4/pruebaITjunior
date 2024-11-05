<?php
include "config.php";

// Usar COUNT(*) para obtener el número total de filas
$sql = "SELECT COUNT(*) as total_count FROM users";
$run_sql = mysqli_query($conn, $sql);

if ($run_sql) {
    $row = mysqli_fetch_assoc($run_sql);
    $result = $row['total_count'];

    echo json_encode(["total_count" => $result]);
} else {
    echo json_encode(["error" => "Error en la consulta"]);
}

// Cerrar la conexión
$conn->close();
?>
