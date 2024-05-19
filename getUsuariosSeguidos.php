<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include('./connection.php');

$response = [];

if (!isset($_GET['id_usuario'])) {
    $response = ['success' => false, 'message' => 'id_usuario is required'];
} else {
    $id_usuario = $_GET['id_usuario'];

    $query = "SELECT usuarios.id, usuarios.nombre_mostrado, usuarios.usuario, usuarios.descripcion, usuarios.foto_perfil
              FROM siguiendo
              INNER JOIN usuarios ON siguiendo.usuario_seguido = usuarios.id
              WHERE siguiendo.seguidor=?";
    
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, 's', $id_usuario);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $usuariosSeguidos = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $usuariosSeguidos[] = [
            'id' => $row['id'],
            'nombre_mostrado' => $row['nombre_mostrado'],
            'usuario' => $row['usuario'],
            'descripcion' => $row['descripcion'],
            'foto_perfil' => $row['foto_perfil']
        ];
    }

    $response = ['success' => true, 'data' => $usuariosSeguidos];
}

echo json_encode($response);
exit();
?>
