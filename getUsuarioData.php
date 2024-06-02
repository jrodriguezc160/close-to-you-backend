<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

if (!isset($_GET['id'])) {
  $response = ['success' => false, 'message' => 'id is required'];
} else {

  $id = $_GET['id'];

  $query = "SELECT * FROM usuarios WHERE id='$id'";
  $result = mysqli_query($connect, $query);
  
  $usuarios = array();
  
  while ($row = mysqli_fetch_array($result)) {
    $usuarios[] = array (
      'id' => $row['id'],
      'nombre_mostrado' => $row['nombre_mostrado'],
      'usuario' => $row['usuario'],
      'email' => $row['email'],
      'nombre' => $row['nombre'],
      'apellido1' => $row['apellido1'],
      'apellido2' => $row['apellido2'],
      'fecha_nacimiento' => $row['fecha_nacimiento'],
      'foto_perfil' => $row['foto_perfil'],
      'descripcion' => $row['descripcion'],
      'admin' => $row['admin']
    );
  }
  
  $response = ['success' => true, 'data' => $usuarios];
}

echo json_encode($response);
exit();
