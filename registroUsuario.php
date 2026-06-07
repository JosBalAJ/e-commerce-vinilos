<?php
session_start();

require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombreRegistrarse']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['apellidosRegistrarse']);
    $calle_numero = mysqli_real_escape_string($conexion, $_POST['calleRegistrarse']);
    $colonia = mysqli_real_escape_string($conexion, $_POST['coloniaRegistrarse']);
    $municipio = mysqli_real_escape_string($conexion, $_POST['municipioRegistrarse']);
    $email = mysqli_real_escape_string($conexion, $_POST['emailRegistrarse']);
    $contrasena = password_hash($_POST['passwordRegistrarse'], PASSWORD_BCRYPT);

    $verificar = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = $conexion->query($verificar);
    if ($resultado->num_rows > 0) {
        echo 'Ese correo ya está en uso';
    } else {
        $sql = "INSERT INTO usuarios (email, name, lastname, password, calle_numero, colonia, municipio) VALUES ('$email', '$nombre', '$apellido', '$contrasena', '$calle_numero',  '$colonia', '$municipio')";

        if (mysqli_query($conexion, $sql)) {
            $_SESSION['nombre'] = $nombre;
            $_SESSION['email'] = $email;
            $_SESSION['apellido'] = $apellido;
            $_SESSION['calle_numero'] = $calle_numero;
            $_SESSION['colonia'] = $colonia;
            $_SESSION['municipio'] = $municipio;
            echo 'index.php';
        } else {
            echo "Error al Registrar: " . mysqli_error($conexion);
        }
    }

    mysqli_close($conexion);
}

?>