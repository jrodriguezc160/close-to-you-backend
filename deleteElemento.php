<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

if (!isset($_POST['id'])) {
  $response = ['success' => false, 'message' => 'id is required'];
} else {
  $id = $_POST['id'];

  $query = "DELETE from elementos where id='$id'";
  $result = mysqli_query($connect, $query);

  if ($result) {
    $response = ['success' => true, 'message' => 'Elemento deleted successfully'];
  } else {
    $response = ['success' => false, 'message' => 'Something went wrong while deleting the publicación'];
  }
}

echo json_encode($response);
?>
