<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

require 'vendor/autoload.php';
include('./connection.php');

$response = [];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['nombreMostrado']) || !isset($data['usuario']) || !isset($data['passwd']) || !isset($data['email']) || !isset($data['nombre']) || !isset($data['ap1']) || !isset($data['ap2'])) {
        throw new Exception('Todos los campos son requeridos');
    }

    $nombreMostrado = $data['nombreMostrado'];
    $usuario = $data['usuario'];
    $passwd = $data['passwd'];
    $email = $data['email'];
    $nombre = $data['nombre'];
    $ap1 = $data['ap1'];
    $ap2 = $data['ap2'];
    $fotoPerfil = isset($data['fotoPerfil']) ? $data['fotoPerfil'] : '';

    // Verifica si el usuario ya existe
    $query = "SELECT id FROM usuarios WHERE usuario = ? OR email = ?";
    $stmt = mysqli_prepare($connect, $query);

    if (!$stmt) {
        throw new Exception('Error en la preparación de la consulta: ' . mysqli_error($connect));
    }

    mysqli_stmt_bind_param($stmt, 'ss', $usuario, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        throw new Exception('El usuario o el correo electrónico ya están registrados');
    }

    mysqli_stmt_close($stmt);

    // Inserta el nuevo usuario en la base de datos
    $query = "INSERT INTO usuarios (nombreMostrado, usuario, passwd, email, nombre, ap1, ap2, fotoPerfil) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connect, $query);

    if (!$stmt) {
        throw new Exception('Error en la preparación de la consulta: ' . mysqli_error($connect));
    }

    mysqli_stmt_bind_param($stmt, 'ssssssss', $nombreMostrado, $usuario, $passwd, $email, $nombre, $ap1, $ap2, $fotoPerfil);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $response = ['success' => true, 'message' => 'Usuario registrado correctamente'];
    } else {
        throw new Exception('Error al registrar el usuario');
    }

    mysqli_stmt_close($stmt);

} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage()];
}

mysqli_close($connect);

echo json_encode($response);

?>
