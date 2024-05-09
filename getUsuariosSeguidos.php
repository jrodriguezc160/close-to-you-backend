<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

if (!isset($_GET['id_usuario'])) {
  $response = ['success' => false, 'message' => 'id_usuario is required'];
} else {
  $id_usuario = $_GET['id_usuario'];

  $query = "SELECT usuarios.id, usuarios.nombre_mostrado, usuarios.usuario, usuarios.descripcion, usuarios.foto_perfil
            FROM siguiendo
            INNER JOIN usuarios ON siguiendo.usuario_seguido = usuarios.id
            WHERE siguiendo.seguidor='$id_usuario'";
  $result = mysqli_query($connect, $query);
  
  $usuariosSeguidos = array();
  
  while ($row = mysqli_fetch_array($result)) {
    $usuariosSeguidos[] = array (
    'id' => $row['id'],
    'nombre_mostrado' => $row['nombre_mostrado'],
    'usuario' => $row['usuario'],
    'descripcion' => $row['descripcion'],
    'foto_perfil' => $row['foto_perfil']
    );
  }
  
  $response = ['success' => true, 'data' => $usuariosSeguidos];
}

echo json_encode($response);
exit();
?>
