<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

// Verificar que los parámetros requeridos están presentes
if (!isset($_GET['nombreMostrado']) || !isset($_GET['usuario']) || !isset($_GET['passwd']) || !isset($_GET['email']) || !isset($_GET['nombre']) || !isset($_GET['ap1'])) {
  $response = ['success' => false, 'message' => 'Usuario, contraseña, nombre mostrado y correo electrónico son requeridos'];
} else {
  // Asignar valores a las variables y manejar los opcionales
  $nombreMostrado = $_GET['nombreMostrado'];
  $usuario = $_GET['usuario'];
  $email = $_GET['email'];
  $passwd = $_GET['passwd'];
  $nombre = $_GET['nombre'];
  $ap1 = $_GET['ap1'];
  $ap2 = isset($_GET['ap2']) ? $_GET['ap2'] : ''; // Valor por defecto para ap2
  $fotoPerfil = isset($_GET['fotoPerfil']) ? $_GET['fotoPerfil'] : ''; // Valor por defecto para fotoPerfil

  // Consulta preparada para evitar inyección SQL
  $query = "INSERT INTO usuarios (nombre_mostrado, usuario, passwd, email, nombre, apellido1, apellido2, foto_perfil) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($connect, $query);

  // Verificar si la preparación de la consulta fue exitosa
  if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'ssssssss', $nombreMostrado, $usuario, $passwd, $email, $nombre, $ap1, $ap2, $fotoPerfil);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
      $response = ['success' => true, 'message' => 'Usuario registrado correctamente'];
    } else {
      $response = ['success' => false, 'message' => 'Error al registrar el usuario'];
    }
    mysqli_stmt_close($stmt);
  } else {
    $response = ['success' => false, 'message' => 'Error en la preparación de la consulta'];
  }
}

echo json_encode($response);
?>
