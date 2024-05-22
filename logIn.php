<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

// Incluye el autoload de Composer
require 'vendor/autoload.php';

use Firebase\JWT\JWT;

include('./connection.php');

$response = [];

try {
    // Comprueba si la solicitud es POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    // Obtiene los datos enviados en el cuerpo de la solicitud
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['usuario']) || !isset($data['passwd'])) {
        throw new Exception('Usuario y contraseña son requeridos');
    }

    $usuario = $data['usuario'];
    $passwd = $data['passwd'];

    // Consulta preparada para verificar usuario y contraseña
    $query = "SELECT id FROM usuarios WHERE usuario = ? AND passwd = ?";
    $stmt = mysqli_prepare($connect, $query);

    if (!$stmt) {
        throw new Exception('Error en la preparación de la consulta: ' . mysqli_error($connect));
    }

    mysqli_stmt_bind_param($stmt, 'ss', $usuario, $passwd);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if ($row = mysqli_fetch_assoc($result)) {
            // Generar token JWT
            $userId = $row['id'];
            $key = 'your_secret_key'; // Cambia esto por tu clave secreta
            $payload = [
                'userId' => $userId,
                'iat' => time(),
                'exp' => time() + (60 * 60) // Token expira en 1 hora
            ];
            $token = JWT::encode($payload, $key);

            // Devolver el token junto con el éxito de inicio de sesión
            $response = ['success' => true, 'message' => 'Inicio de sesión exitoso', 'token' => $token];
        } else {
            $response = ['success' => false, 'message' => 'Usuario o contraseña incorrectos'];
        }
    } else {
        throw new Exception('Error en la ejecución de la consulta: ' . mysqli_error($connect));
    }

    mysqli_stmt_close($stmt);

} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage()];
}

mysqli_close($connect);

echo json_encode($response);

?>
