<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

include('./connection.php');

// Comprueba si se han recibido los datos necesarios
if (!isset($_POST['id_usuario']) || !isset($_POST['contenido'])) {
  $response = ['success' => false, 'message' => 'Debes pasar id_usuario y contenido'];
} else {
  // Obtiene los datos enviados desde el formulario
  $id_usuario = $_POST['id_usuario'];
  $contenido = $_POST['contenido'];

  // Consulta preparada para evitar inyección SQL
  $stmt = $connect->prepare("INSERT INTO publicaciones (id_usuario, contenido, likes, reposts) VALUES (?, ?, 0, 0)");
  $stmt->bind_param("is", $id_usuario, $contenido);
  $result = $stmt->execute();

  if ($result) {
    $response = ['success' => true, 'message' => 'Publicación añadida correctamente'];
  } else {
    $response = ['success' => false, 'message' => 'Error al añadir la publicación'];
  }

  $stmt->close();
}

echo json_encode($response);
?>
