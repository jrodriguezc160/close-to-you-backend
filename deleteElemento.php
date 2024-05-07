<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

if (!isset($_POST['id_usuario']) || !isset($_POST['id_api'])) {
  $response = ['success' => false, 'message' => 'id_usuario and id_api are required'];
} else {
  $id_usuario = $_POST['id_usuario'];
  $id_api = $_POST['id_api'];

  $query = "DELETE FROM elementos_usuario WHERE id_usuario='$id_usuario' AND id_elemento IN (SELECT id FROM elementos WHERE id_api='$id_api')";
  $result = mysqli_query($connect, $query);

  if ($result) {
    $response = ['success' => true, 'message' => 'Elemento deleted successfully for the user'];
  } else {
    $response = ['success' => false, 'message' => 'Something went wrong while deleting the elemento_usuario relationship'];
  }
}

echo json_encode($response);
?>
