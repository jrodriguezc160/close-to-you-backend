<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

if (!isset($_GET['id_usuario'])) {
  $response = ['success' => false, 'message' => 'id_usuario is required'];
} else {

  $id_usuario = $_GET['id_usuario'];

  $query = "SELECT * FROM publicaciones WHERE id_usuario='$id_usuario'";
  $result = mysqli_query($connect, $query);
  
  $publicaciones = array();
  
  while ($row = mysqli_fetch_array($result)) {
    $publicaciones[] = array (
    'id' => $row['id'],
    'id_usuario' => $row['id_usuario'],
    'contenido' => $row['contenido'],
    'likes' => $row['likes'],
    'reposts' => $row['reposts']
    );
  }
  
  $response = ['success' => true, 'data' => $publicaciones];
}

echo json_encode($response);
exit();
