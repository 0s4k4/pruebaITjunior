<?php

$localhost="192.168.100.37";
$username="admin";
$password="admin123";
$database="pruebaIT";

$conn = new mysqli($localhost, $username, $password, $database);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

?>