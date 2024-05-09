<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

if (!isset($_POST['follower_id']) || !isset($_POST['followed_id'])) {
  $response = ['success' => false, 'message' => 'follower_id and followed_id are required'];
} else {
  $follower_id = $_POST['follower_id'];
  $followed_id = $_POST['followed_id'];

  $query = "DELETE FROM siguiendo WHERE usuario_seguido = '$followed_id' AND seguidor = '$follower_id'";
  $result = mysqli_query($connect, $query);

  if ($result) {
    $response = ['success' => true, 'message' => 'User unfollowed successfully'];
  } else {
    $response = ['success' => false, 'message' => 'Something went wrong while unfollowing the user'];
  }
}

echo json_encode($response);

?>
