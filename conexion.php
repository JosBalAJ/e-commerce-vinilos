<?php
// Render inyectará estos datos automáticamente desde su panel de control
$servidor = getenv('DB_HOST') ?: "127.0.0.1";
$usuario = getenv('DB_USER') ?: "root";
$contrasena = getenv('DB_PASSWORD') ?: "password";
$baseDeDatos = getenv('DB_NAME') ?: "defaultdb";
$puerto = getenv('DB_PORT') ?: 3307;

$conexion = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos, $puerto);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>