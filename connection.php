<?php

// $host = 'fdb1034.awardspace.net';  // Host de la base de datos proporcionado por tu proveedor
// $user = '4472287_closetoyou';      // Usuario de la base de datos proporcionado
// $password = 'Camavinga12!';  // Sustituye 'your_password_here' por tu contraseña real
// $db = '4472287_closetoyou';        // Nombre de la base de datos proporcionado

$host = 'localhost';
$user = 'root';
$password = '';
$db = 'close-to-you';

$connect = new mysqli($host, $user, $password, $db);

// Comprobar conexión
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// No imprimir nada en caso de éxito
?>
