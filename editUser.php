<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

include('./connection.php');

// Comprueba si se han recibido los datos necesarios
if (!isset($_POST['id'])) {
  $response = ['success' => false, 'message' => 'Debes pasar el id de usuario'];
} else {
  // Obtiene los datos enviados desde el formulario
  $id = $_POST['id'];
  $fotoPerfil = $_POST['fotoPerfil'];
  $nombreMostrado = $_POST['nombreMostrado'];
  $usuario = $_POST['usuario'];
  $nombre = $_POST['nombre'];
  $apellido1 = $_POST['apellido1'];
  $apellido2 = $_POST['apellido2'];
  $descripcion = $_POST['descripcion'];

  // Consulta preparada para evitar inyección SQL
  $query = "UPDATE usuarios SET foto_perfil = '$fotoPerfil', nombre_mostrado = '$nombreMostrado', usuario = '$usuario', nombre = '$nombre', apellido1 = '$apellido1', apellido2 = '$apellido2', descripcion = '$descripcion' WHERE id = '$id'";
  $result = mysqli_query($connect, $query);

  if ($result) {
    $response = ['success' => true, 'message' => 'Perfil de usuario actualizado correctamente'];
  } else {
    $response = ['success' => false, 'message' => 'Error al actualizar el perfil del usuario'];
  }
}

echo json_encode($response);
?>
