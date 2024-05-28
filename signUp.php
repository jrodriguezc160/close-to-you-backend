<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

if (!isset($_GET['nombreMostrado']) || !isset($_GET['usuario']) || !isset($_GET['passwd']) || !isset($_GET['email']) || !isset($_GET['nombre']) || !isset($_GET['ap1'])) {
  $response = ['success' => false, 'message' => 'Usuario, contraseña, nombre mostrado y correo electrónico son requeridos'];
} else {
  $nombreMostrado = $_GET['nombreMostrado'];
  $usuario = $_GET['usuario'];
  $email = $_GET['email'];
  $passwd = $_GET['passwd'];
  $nombre = $_GET['nombre'];
  $ap1 = $_GET['ap1'];
  $ap2 = $_GET['ap2'];
  $fotoPerfil = $_GET['fotoPerfil'];

  // Consulta preparada para evitar inyección SQL
  $query = "INSERT INTO usuarios (nombre_mostrado, usuario, passwd, email, nombre, apellido1, apellido2, foto_perfil) VALUES ('$nombreMostrado', '$usuario', '$passwd', '$email', '$nombre', '$ap1', '$ap2', '$fotoPerfil')";
  $result = mysqli_query($connect, $query);

  if ($result) {
    $response = ['success' => true, 'message' => 'Usuario registrado correctamente'];
  } else {
    $response = ['success' => false, 'message' => 'Error al registrar el usuario'];
  }
}

echo json_encode($response);
?>
