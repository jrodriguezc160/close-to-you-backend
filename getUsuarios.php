<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

$query = 'SELECT * FROM usuarios';
$result = mysqli_query($connect, $query);

$usuarios = array();

while ($row = mysqli_fetch_array($result)) {
  $usuarios[] = array (
    'id' => $row['id'],
    'nombre_mostrado' => $row['nombre_mostrado'],
    'usuario' => $row['usuario'],
    'email' => $row['email'],
    'nombre' => $row['nombre'],
    'apellido1' => $row['apellido1'],
    'apellido2' => $row['apellido2'],
    'fecha_nacimiento' => $row['fecha_nacimiento'],
    'foto_perfil' => $row['foto_perfil'],
    'banner' => $row['banner'],
    'descripcion' => $row['descripcion']
  );
}

$response = ['success' => true, 'data' => $usuarios];

echo json_encode($response);
exit();
