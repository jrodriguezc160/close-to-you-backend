<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

if (!isset($_POST['id_api']) || !isset($_POST['favorito'])) {
  $response = ['success' => false, 'message' => 'id_api and favorito are required'];
} else {
  
  $id_api = $_POST['id_api'];

  $favorito = $_POST['favorito'];

  $query = "UPDATE elementos set favorito = '$favorito' where id_api='$id_api'";
  $result = mysqli_query($connect, $query);

  if ($result) {
    $response = ['success' => true, 'message' => 'Elemento updated successfully'];
  } else {
    $response = ['success' => false, 'message' => 'Something went wrong while adding the elemento'];
  }
}

echo json_encode($response);
?>
