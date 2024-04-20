<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

if (!isset($_GET['id_usuario']) || !isset($_GET['id_coleccion'])) {
  $response = ['success' => false, 'message' => 'id_usuario and id_coleccion are required'];
} else {

  $id_usuario = $_GET['id_usuario'];
  $id_coleccion = $_GET['id_coleccion'];

  // Construir la consulta SQL sin el campo 'favorito' si no se pasa en la URL
  if (isset($_GET['favorito'])) {
    $favorito = $_GET['favorito'];
    $query = "SELECT * FROM elementos WHERE id_usuario='$id_usuario' and id_coleccion='$id_coleccion' and favorito='$favorito'";
  } else {
    $query = "SELECT * FROM elementos WHERE id_usuario='$id_usuario' and id_coleccion='$id_coleccion'";
  }

  $result = mysqli_query($connect, $query);
  
  $publicaciones = array();
  
  while ($row = mysqli_fetch_array($result)) {
    $publicaciones[] = array (
    'id' => $row['id'],
    'id_usuario' => $row['id_usuario'],
    'id_coleccion' => $row['id_coleccion'],
    'titulo' => $row['titulo'],
    'autor' => $row['autor'],
    'imagen' => $row['imagen'],
    'id_api' => $row['id_api'],
    'favorito' => $row['favorito']
    );
  }
  
  $response = ['success' => true, 'data' => $publicaciones];
}

echo json_encode($response);
exit();
