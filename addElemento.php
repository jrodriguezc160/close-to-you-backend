<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

if (!isset($_POST['id_coleccion'])
    || !isset($_POST['id_usuario'])
    || !isset($_POST['titulo'])
    || !isset($_POST['autor'])
    || !isset($_POST['imagen'])
    || !isset($_POST['id_api'])
    || !isset($_POST['favorito'])) {
  $response = ['success' => false, 'message' => 'id_coleccion, id_usuario, titulo, autor, imagen and id_api are required'];
} else {
  $id_coleccion = $_POST['id_coleccion'];
  $id_usuario = $_POST['id_usuario'];
  $titulo = $_POST['titulo'];
  $autor = $_POST['autor'];
  $imagen = $_POST['imagen'];
  $id_api = $_POST['id_api'];
  $favorito = $_POST['favorito'];

  $query = "INSERT INTO elementos (id_coleccion, id_usuario, titulo, autor, imagen, id_api, favorito) VALUES ('$id_coleccion', '$id_usuario', '$titulo', '$autor', '$imagen', '$id_api', '$favorito')";
  $result = mysqli_query($connect, $query);

  if ($result) {
    $response = ['success' => true, 'message' => 'Elemento added successfully'];
  } else {
    $response = ['success' => false, 'message' => 'Something went wrong while adding the publicación'];
  }
}

echo json_encode($response);
?>
