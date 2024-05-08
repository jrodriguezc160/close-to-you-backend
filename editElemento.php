<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

if (!isset($_POST['id_usuario'])
    || !isset($_POST['id_api'])
    || !isset($_POST['id_coleccion'])
    || !isset($_POST['favorito'])) {
  $response = ['success' => false, 'message' => 'id_usuario, id_api, id_coleccion and favorito are required'];
} else {
  $id_usuario = $_POST['id_usuario'];
  $id_api = $_POST['id_api'];
  $id_coleccion = $_POST['id_coleccion'];
  $favorito = $_POST['favorito'];

  // Consulta para obtener el ID del elemento
  $query = "SELECT id FROM elementos WHERE id_api='$id_api' AND id_coleccion='$id_coleccion'";
  $result = mysqli_query($connect, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $elemento_id = $row['id'];

    // Consulta para crear la conexión del usuario con el elemento en la tabla elementos_usuario
    $insert_elemento_usuario_query = "UPDATE elementos_usuario SET favorito='$favorito' WHERE id_elemento='$elemento_id' AND id_usuario='$id_usuario'";
    $result_elemento_usuario = mysqli_query($connect, $insert_elemento_usuario_query);

    if ($result_elemento_usuario) {
      $response = ['success' => true, 'message' => 'Elemento edited successfully'];
    } else {
      $response = ['success' => false, 'message' => 'Failed to edit elemento_usuario'];
    }
  } else {
    $response = ['success' => false, 'message' => 'Element with given id_api not found'];
  }
}

echo json_encode($response);
?>
