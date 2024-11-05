<?php

include "config.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Validar que el ID sea numérico
    if (!is_numeric($id)) {
        echo json_encode(["error" => "ID inválido"]);
        exit();
    }

    // Preparar la consulta SQL para evitar inyección de SQL
    $sql = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $sql->bind_param("i", $id); // 'i' indica que el parámetro es un entero

    $sql->execute();
    $result = $sql->get_result();
    $output = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $output[] = $row;
        }
    } else {
        $output["empty"] = "empty";
    }

    echo json_encode($output);

    // Cerrar la consulta y la conexión
    $sql->close();
    $conn->close();
} else {
    echo json_encode(["error" => "ID no especificado"]);
}
?>
