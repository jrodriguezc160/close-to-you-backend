<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

$response = [];

if (!isset($_GET['id_usuario']) || !isset($_GET['id_publicacion'])) {
    $response = ['success' => false, 'message' => 'id_usuario e id_publicacion son requeridos'];
} else {
    $id_usuario = $_GET['id_usuario'];
    $id_publicacion = $_GET['id_publicacion'];

    $query = "SELECT COUNT(*) as count
              FROM likes
              WHERE id_usuario=? AND id_publicacion=?";
    
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $id_usuario, $id_publicacion);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($result);
    $hasLiked = $row['count'] > 0;

    $response = ['success' => true, 'hasLiked' => $hasLiked];
}

echo json_encode($response);
exit();
?>
