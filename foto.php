<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['foto'])) {
        $foto = $_FILES['foto'];
        
        // Verificar si el archivo es una imagen
        if (getimagesize($foto['tmp_name'])) {
            // Generar un nombre único con la extensión correcta
            $nombreImagen = uniqid() . '.' . pathinfo($foto['name'], PATHINFO_EXTENSION);
            
            // Mover el archivo a la carpeta de destino
            if (move_uploaded_file($foto['tmp_name'], 'imagenes/' . $nombreImagen)) {
                // Actualizar la base de datos con el nuevo nombre de la imagen
                $sql = "UPDATE usuario SET foto = '$nombreImagen' WHERE id = " . $_POST['id'];
                $conn->query($sql);

                if ($conn->affected_rows > 0) {
                    $respuesta = ['estado' => 'ok', 'nombreImagen' => 'imagenes/' . $nombreImagen];
                } else {
                    $respuesta = ['estado' => 'error', 'mensaje' => 'Error al actualizar la foto en la base de datos'];
                }
            } else {
                $respuesta = ['estado' => 'error', 'mensaje' => 'Error al mover la imagen'];
            }
        } else {
            $respuesta = ['estado' => 'error', 'mensaje' => 'El archivo no es una imagen válida'];
        }
    } else {
        $respuesta = ['estado' => 'error', 'mensaje' => 'No se ha recibido ninguna imagen'];
    }
} else {
    $respuesta = ['estado' => 'error', 'mensaje' => 'Método no permitido'];
}

echo json_encode($respuesta);
?>
