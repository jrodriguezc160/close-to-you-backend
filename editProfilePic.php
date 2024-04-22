<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

if (!isset($_POST['id']) || !isset($_POST['foto_perfil'])) {
  $response = ['success' => false, 'message' => 'id and foto_perfil are required'];
} else {
  
  $id = $_POST['id'];

  $foto_perfil = $_POST['foto_perfil'];

  $query = "UPDATE usuarios set foto_perfil = '$foto_perfil' where id='$id'";
  $result = mysqli_query($connect, $query);

  if ($result) {
    $response = ['success' => true, 'message' => 'Foto de perfil updated successfully'];
  } else {
    $response = ['success' => false, 'message' => 'Something went wrong while adding the foto de perfil'];
  }
}

echo json_encode($response);
?>
