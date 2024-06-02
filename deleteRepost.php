<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

$id_usuario = $_POST['id_usuario'];
$id_publicacion = $_POST['id_publicacion'];

// Delete the repost from the reposts table
$query = "DELETE FROM reposts WHERE id_usuario = '$id_usuario' AND id_publicacion = '$id_publicacion'";
$result = mysqli_query($connect, $query);

if ($result) {
  // Update the reposts count in the publicaciones table
  $updateQuery = "UPDATE publicaciones SET reposts = reposts - 1 WHERE id = '$id_publicacion'";
  mysqli_query($connect, $updateQuery);

  $response = ['success' => true, 'message' => 'Repost removed successfully'];
} else {
  $response = ['success' => false, 'message' => 'Error removing repost'];
}

echo json_encode($response);
exit();
?>
