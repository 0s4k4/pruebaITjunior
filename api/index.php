<?php
require 'db.php';
header('Content-Type: application/json');

// Autenticación básica
function checkAuth() {
    $validUser = 'admin';
    $validPass = 'admin123';

    if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] !== $validUser || $_SERVER['PHP_AUTH_PW'] !== $validPass) {
        header('WWW-Authenticate: Basic realm="API"');
        http_response_code(401);
        echo json_encode(['error' => 'Autenticación requerida']);
        exit;
    }
}

// Llama a la función `checkAuth()` para proteger los endpoints
checkAuth();

$method = $_SERVER['REQUEST_METHOD'];
$path = explode('/', trim($_SERVER['PATH_INFO'] ?? '', '/'));

switch ($method) {
    case 'GET':
        if ($path[0] === 'users') {
            $result = $conn->query('SELECT * FROM users');
            $users = [];

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $users[] = $row;
                }
                echo json_encode($users);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al obtener usuarios']);
            }
        }
        break;

    case 'POST':
        if ($path[0] === 'users') {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!isset($data['user_name']) || !isset($data['user_age']) || !isset($data['user_country'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Faltan campos obligatorios']);
                exit;
            }

            $stmt = $conn->prepare('INSERT INTO users (user_name, user_age, user_country) VALUES (?, ?, ?)');
            $stmt->bind_param('sss', $data['user_name'], $data['user_age'], $data['user_country']);

            if ($stmt->execute()) {
                http_response_code(201);
                echo json_encode(['message' => 'Usuario agregado exitosamente', 'id' => $stmt->insert_id]);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al agregar usuario']);
            }
        }
        break;

    case 'DELETE':
        if ($path[0] === 'users' && isset($path[1])) {
            $userId = (int) $path[1];
            $stmt = $conn->prepare('DELETE FROM users WHERE id = ?');
            $stmt->bind_param('i', $userId);

            if ($stmt->execute() && $stmt->affected_rows > 0) {
                echo json_encode(['message' => 'Usuario eliminado exitosamente']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Usuario no encontrado']);
            }
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}

// Cierra la conexión a la base de datos
$conn->close();
?>
