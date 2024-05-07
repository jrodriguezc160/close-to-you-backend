<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

if (!isset($_POST['id_usuario'])
    || !isset($_POST['id_coleccion'])
    || !isset($_POST['titulo'])
    || !isset($_POST['autor'])
    || !isset($_POST['imagen'])
    || !isset($_POST['id_api'])
    || !isset($_POST['favorito'])) {
  $response = ['success' => false, 'message' => 'id_coleccion, id_usuario, titulo, autor, imagen and id_api are required'];
} else {
  $id_usuario = $_POST['id_usuario'];
  $id_coleccion = $_POST['id_coleccion'];
  $titulo = $_POST['titulo'];
  $autor = $_POST['autor'];
  $imagen = $_POST['imagen'];
  $id_api = $_POST['id_api'];
  $favorito = $_POST['favorito'];

  $query = "INSERT INTO elementos (id_coleccion, titulo, autor, imagen, id_api) VALUES ('$id_coleccion', '$titulo', '$autor', '$imagen', '$id_api')";
  $result = mysqli_query($connect, $query);

  if ($result) {
    // Obtener el último ID insertado en la tabla elementos
    $elemento_id = mysqli_insert_id($connect);

    // Consulta para insertar el elemento en la tabla elementos_usuario
    $insert_elemento_usuario_query = "INSERT INTO elementos_usuario (id_elemento, id_usuario, favorito) VALUES ('$elemento_id', '$id_usuario', '$favorito')";
    $result_elemento_usuario = mysqli_query($connect, $insert_elemento_usuario_query);

    if ($result_elemento_usuario) {
      $response = ['success' => true, 'message' => 'Elemento added successfully'];
    } else {
      $response = ['success' => false, 'message' => 'Failed to add elemento_usuario'];
    }
  } else {
    $response = ['success' => false, 'message' => 'Something went wrong while adding the publicación'];
  }
}

echo json_encode($response);
?>
