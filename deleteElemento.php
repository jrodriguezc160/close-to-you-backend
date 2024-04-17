<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

if (!isset($_POST['id_api'])) {
  $response = ['success' => false, 'message' => 'id_api is required'];
} else {
  $id_api = $_POST['id_api'];

  $query = "DELETE from elementos where id_api='$id_api'";
  $result = mysqli_query($connect, $query);

  if ($result) {
    $response = ['success' => true, 'message' => 'Elemento deleted successfully'];
  } else {
    $response = ['success' => false, 'message' => 'Something went wrong while deleting the publicación'];
  }
}

echo json_encode($response);
?>
