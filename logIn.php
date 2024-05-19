<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

include('./connection.php');

$response = [];

if (!isset($_GET['usuario']) || !isset($_GET['passwd'])) {
  $response = ['success' => false, 'message' => 'Usuario and password are required'];
} else {
  $usuario = $_GET['usuario'];
  $passwd = $_GET['passwd'];

  // Consulta preparada para verificar usuario y contraseña
  $query = "SELECT id FROM usuarios WHERE usuario = ? AND passwd = ?";
  $stmt = mysqli_prepare($connect, $query);
  mysqli_stmt_bind_param($stmt, 'ss', $usuario, $passwd);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($result) {
    if ($row = mysqli_fetch_assoc($result)) {
      // Devuelve el ID de usuario junto con el éxito de inicio de sesión
      $userId = $row['id'];
      $response = ['success' => true, 'message' => 'Logged in successfully', 'userId' => $userId];
    } else {
      $response = ['success' => false, 'message' => 'Incorrect username or password'];
    }
  } else {
    $response = ['success' => false, 'message' => 'Something went wrong'];
  }

  mysqli_stmt_close($stmt);
}

mysqli_close($connect);

echo json_encode($response);
?>
