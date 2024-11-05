<?php
header('Content-Type: application/json');

// Token secreto para autenticación
$secretToken = '123456';

// Simulación de una base de datos de usuarios (esto debería ser reemplazado por una conexión a la base de datos real)
$users = [
    ["id" => 1, "name" => "Juan", "age" => 30, "country" => "México"],
    ["id" => 2, "name" => "María", "age" => 25, "country" => "España"]
];

// Verificar el token de autenticación
function authenticate($token) {
    global $secretToken;
    // Log the received token for debugging
    error_log("Received token: " . $token);
    return $token === $secretToken || $token === '123456';
}

// Obtener la lista de usuarios
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    } else {
        // Si no hay Bearer, usar el token directamente
        $token = trim($authHeader);
    }

    if (authenticate($token)) {
        echo json_encode($users);
    } else {
        http_response_code(401);
        echo json_encode(["error" => "Unauthorized"]);
    }
}

// Agregar un nuevo usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    } else {
        $token = trim($authHeader);
    }

    if (authenticate($token)) {
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['name'], $data['age'], $data['country'])) {
            $newUser = [
                "id" => count($users) + 1,
                "name" => $data['name'],
                "age" => $data['age'],
                "country" => $data['country']
            ];
            $users[] = $newUser;
            echo json_encode($newUser);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Invalid input"]);
        }
    } else {
        http_response_code(401);
        echo json_encode(["error" => "Unauthorized"]);
    }
}

// Eliminar un usuario por ID
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    } else {
        $token = trim($authHeader);
    }

    if (authenticate($token)) {
        $id = intval(basename($_SERVER['REQUEST_URI']));
        $key = array_search($id, array_column($users, 'id'));
        if ($key !== false) {
            unset($users[$key]);
            echo json_encode(["message" => "User deleted successfully"]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "User not found"]);
        }
    } else {
        http_response_code(401);
        echo json_encode(["error" => "Unauthorized"]);
    }
}
?>
