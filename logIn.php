<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

if (!isset($_GET['usuario']) || !isset($_GET['passwd'])) {
  $response = ['success' => false, 'message' => 'Usuario and password are required'];
} else {
  $usuario = $_GET['usuario'];
  $passwd = $_GET['passwd'];

  // Consulta preparada para evitar inyección SQL
  $query = "SELECT id, passwd FROM usuarios WHERE usuario=?";
  $stmt = mysqli_prepare($connect, $query);
  mysqli_stmt_bind_param($stmt, 's', $usuario);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($result) {
    if ($row = mysqli_fetch_assoc($result)) {
      $storedPassword = $row['passwd'];
      
      // Comparación segura de contraseñas
      if ($passwd === $storedPassword) {
        // Devuelve el ID de usuario junto con el éxito de inicio de sesión
        $userId = $row['id'];
        $response = ['success' => true, 'message' => 'Logged in successfully', 'userId' => $userId];
      } else {
        $response = ['success' => false, 'message' => 'Incorrect password'];
      }
    } else {
      $response = ['success' => false, 'message' => 'User not found'];
    }
  } else {
    $response = ['success' => false, 'message' => 'Something went wrong'];
  }
}

echo json_encode($response);
?>
