<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

if (!isset($_POST['id']) || !isset($_POST['contenido'])) {
  $response = ['success' => false, 'message' => 'id and contenido are required'];
} else {
  
  $id = $_POST['id'];

  $contenido = $_POST['contenido'];

  $query = "UPDATE publicaciones set contenido = '$contenido' where id='$id'";
  $result = mysqli_query($connect, $query);

  if ($result) {
    $response = ['success' => true, 'message' => 'Publicacion updated successfully'];
  } else {
    $response = ['success' => false, 'message' => 'Something went wrong while adding the publicación'];
  }
}

echo json_encode($response);
?>
