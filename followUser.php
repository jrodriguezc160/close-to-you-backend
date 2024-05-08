<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

if (!isset($_POST['follower_id']) || !isset($_POST['followed_id'])) {
  $response = ['success' => false, 'message' => 'id_usuario and contenido are required'];
} else {
  $id_usuario = $_POST['id_usuario'];
  $contenido = $_POST['contenido'];

  $query = "INSERT INTO publicaciones (id_usuario, contenido) VALUES ('$id_usuario', '$contenido')";
  $result = mysqli_query($connect, $query);

  if ($result) {
    $response = ['success' => true, 'message' => 'Publicacion added successfully'];
  } else {
    $response = ['success' => false, 'message' => 'Something went wrong while adding the publicación'];
  }
}

echo json_encode($response);
?>
