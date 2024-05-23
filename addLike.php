<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

include('./connection.php');

// Comprueba si se han recibido los datos necesarios
if (!isset($_POST['id_usuario']) || !isset($_POST['id_publicacion'])) {
  $response = ['success' => false, 'message' => 'Debes pasar id_usuario e id_publicacion'];
} else {
  // Obtiene los datos enviados desde el formulario
  $id_usuario = $_POST['id_usuario'];
  $id_publicacion = $_POST['id_publicacion'];

  // Consulta preparada para evitar inyección SQL
  $stmt = $connect->prepare("INSERT INTO likes (id_usuario, id_publicacion) VALUES ('$id_usuario', '$id_publicacion')");
  $stmt->bind_param("ii", $id_usuario, $id_publicacion);
  $result = $stmt->execute();

  if ($result) {
    $response = ['success' => true, 'message' => 'Like añadido correctamente'];
  } else {
    $response = ['success' => false, 'message' => 'Error al añadir el like'];
  }

  $stmt->close();
}

echo json_encode($response);
?>
