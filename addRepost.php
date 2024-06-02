<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

$id_usuario = $_POST['id_usuario'];
$id_publicacion = $_POST['id_publicacion'];

// Insert the repost into the reposts table
$query = "INSERT INTO reposts (id_usuario, id_publicacion) VALUES ('$id_usuario', '$id_publicacion')";
$result = mysqli_query($connect, $query);

if ($result) {
  // Update the reposts count in the publicaciones table
  $updateQuery = "UPDATE publicaciones SET reposts = reposts + 1 WHERE id = '$id_publicacion'";
  mysqli_query($connect, $updateQuery);

  $response = ['success' => true, 'message' => 'Repost added successfully'];
} else {
  $response = ['success' => false, 'message' => 'Error adding repost'];
}

echo json_encode($response);
exit();
?>
