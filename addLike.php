<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

$id_usuario = $_POST['id_usuario'];
$id_publicacion = $_POST['id_publicacion'];

// Insert the like into the likes table
$query = "INSERT INTO likes (id_usuario, id_publicacion) VALUES ('$id_usuario', '$id_publicacion')";
$result = mysqli_query($connect, $query);

if ($result) {
  // Update the likes count in the publicaciones table
  $updateQuery = "UPDATE publicaciones SET likes = likes + 1 WHERE id = '$id_publicacion'";
  mysqli_query($connect, $updateQuery);

  $response = ['success' => true, 'message' => 'Like added successfully'];
} else {
  $response = ['success' => false, 'message' => 'Error adding like'];
}

echo json_encode($response);
exit();
?>
