<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

if (!isset($_GET['id_usuario']) || !isset($_GET['coleccion'])) {
  $response = ['success' => false, 'message' => 'id_usuario and coleccion are required'];
} else {

  $id_usuario = $_GET['id_usuario'];
  $coleccion = $_GET['coleccion'];
  $id_coleccion = 0;

  switch ($coleccion) {
    case 'Libros':
      $id_coleccion = 1;
      break;
    
    case 'Libros favoritos':
      $id_coleccion = 2;
      break;
    
    case 'Películas':
      $id_coleccion = 3;
      break;
    
    case 'Películas favoritas':
      $id_coleccion = 4;
      break;
    
    default:
      $id_coleccion = 0;
      break;
  }

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
