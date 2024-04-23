<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

if (!isset($_POST['id']) || !isset($_POST['banner'])) {
  $response = ['success' => false, 'message' => 'id and banner are required'];
} else {
  
  $id = $_POST['id'];

  $banner = $_POST['banner'];

  $query = "UPDATE usuarios set banner = '$banner' where id='$id'";
  $result = mysqli_query($connect, $query);

  if ($result) {
    $response = ['success' => true, 'message' => 'Banner updated successfully'];
  } else {
    $response = ['success' => false, 'message' => 'Something went wrong while adding the banner'];
  }
}

echo json_encode($response);
?>
