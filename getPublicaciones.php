<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

$query = 'SELECT * FROM publicaciones';
$result = mysqli_query($connect, $query);

$publicaciones = array();

while ($row = mysqli_fetch_array($result)) {
  $publicaciones[] = array (
    'id' => $row['id'],
    'id_usuario' => $row['id_usuario'],
    'contenido' => $row['contenido'],
    'fecha' => $row['fecha'],
    'likes' => $row['likes']
  );
}

$response = ['success' => true, 'data' => $publicaciones];

echo json_encode($response);
exit();
