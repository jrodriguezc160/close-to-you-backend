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
    $query = "SELECT e.id, e.id_coleccion, e.titulo, e.autor, e.imagen, e.id_api, eu.favorito FROM elementos AS e INNER JOIN elementos_usuario AS eu ON e.id = eu.id_elemento WHERE eu.id_usuario='$id_usuario' AND e.id_coleccion='$id_coleccion' AND eu.favorito='$favorito'";
  } else {
    $query = "SELECT e.id, e.id_coleccion, e.titulo, e.autor, e.imagen, e.id_api, eu.favorito FROM elementos AS e INNER JOIN elementos_usuario AS eu ON e.id = eu.id_elemento WHERE eu.id_usuario='$id_usuario' AND e.id_coleccion='$id_coleccion'";
  }

  $result = mysqli_query($connect, $query);
  
  $elementos = array();
  
  while ($row = mysqli_fetch_array($result)) {
    $elementos[] = array (
    'id' => $row['id'],
    'id_coleccion' => $row['id_coleccion'],
    'titulo' => $row['titulo'],
    'autor' => $row['autor'],
    'imagen' => $row['imagen'],
    'id_api' => $row['id_api'],
    'favorito' => $row['favorito']
    );
  }
  
  $response = ['success' => true, 'data' => $elementos];
}

echo json_encode($response);
exit();
?>
