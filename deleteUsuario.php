<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

include('./connection.php');

// Comprueba si se han recibido los datos necesarios
if (!isset($_POST['id'])) {
  $response = ['success' => false, 'message' => 'Debes pasar el id de usuario'];
} else {
  // Obtiene el id enviado desde el formulario
  $id = $_POST['id'];

  // Consulta preparada para evitar inyección SQL
  $query = "DELETE FROM usuarios WHERE id = ?";
  $stmt = mysqli_prepare($connect, $query);

  if ($stmt) {
    // Vincula el parámetro id
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
      $response = ['success' => true, 'message' => 'Usuario eliminado correctamente'];
    } else {
      $response = ['success' => false, 'message' => 'No se encontró ningún usuario con ese id'];
    }

    // Cierra la declaración
    mysqli_stmt_close($stmt);
  } else {
    $response = ['success' => false, 'message' => 'Error en la preparación de la consulta'];
  }
}

// Cierra la conexión
mysqli_close($connect);

echo json_encode($response);
?>
