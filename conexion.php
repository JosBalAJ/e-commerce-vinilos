<?php
$servidor = "127.0.0.1";
$usuario = "root";
$contrasena = "password";
$baseDeDatos = "vinilosdb";

$conexion = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos, 3307);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error() . " (Código: " . mysqli_connect_errno() . ")");
}

?>