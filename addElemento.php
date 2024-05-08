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

  // Verificar si ya existe un elemento con el mismo id_api
  $check_query = "SELECT * FROM elementos WHERE id_api = '$id_api' AND id_coleccion = '$id_coleccion'";
  $check_result = mysqli_query($connect, $check_query);
  
  if(mysqli_num_rows($check_result) > 0) {
    // Si el elemento ya existe, actualizar la fila correspondiente en la tabla elementos_usuario

    // Obtener el ID del elemento
    $row = mysqli_fetch_assoc($check_result);
    $elemento_id = $row['id'];

    // Consulta para actualizar la conexión del usuario con el elemento en la tabla elementos_usuario
    $update_elemento_usuario_query = "INSERT INTO elementos_usuario (id_elemento, id_usuario, favorito) VALUES ('$elemento_id', '$id_usuario', '$favorito')";
    $result_update_elemento_usuario = mysqli_query($connect, $update_elemento_usuario_query);

    if ($result_update_elemento_usuario) {
      $response = ['success' => true, 'message' => 'Elemento edited successfully'];
    } else {
      $response = ['success' => false, 'message' => 'Failed to edit elemento_usuario'];
    }
  } else {
    // Si no existe, insertar el nuevo elemento
    $insert_elemento_query = "INSERT INTO elementos (id_coleccion, titulo, autor, imagen, id_api) VALUES ('$id_coleccion', '$titulo', '$autor', '$imagen', '$id_api')";
    $result_insert_elemento = mysqli_query($connect, $insert_elemento_query);

    if ($result_insert_elemento) {
      // Obtener el último ID insertado en la tabla elementos
      $elemento_id = mysqli_insert_id($connect);

      // Consulta para insertar el elemento en la tabla elementos_usuario
      $insert_elemento_usuario_query = "INSERT INTO elementos_usuario (id_elemento, id_usuario, favorito) VALUES ('$elemento_id', '$id_usuario', '$favorito')";
      $result_insert_elemento_usuario = mysqli_query($connect, $insert_elemento_usuario_query);

      if ($result_insert_elemento_usuario) {
        $response = ['success' => true, 'message' => 'Elemento added successfully'];
      } else {
        $response = ['success' => false, 'message' => 'Failed to add elemento_usuario'];
      }
    } else {
      $response = ['success' => false, 'message' => 'Something went wrong while adding the publicación'];
    }
  }
}

echo json_encode($response);
?>
