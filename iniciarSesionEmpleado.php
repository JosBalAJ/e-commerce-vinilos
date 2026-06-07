<?php
session_start();

require 'conexion.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $email = mysqli_real_escape_string($conexion, $_POST['empleadoEmailIniSes']);
    $contrasena = mysqli_real_escape_string($conexion, $_POST['empleadoPasswordIniSes']);

    $empleadoExiste = "SELECT * FROM administradores WHERE email_admin = '$email'";
    $resultado = $conexion->query($empleadoExiste);
    if($resultado->num_rows > 0){
        $fila = $resultado->fetch_assoc();
        $contrasenaHash = $fila['password_admin'];
        if(password_verify($contrasena, $contrasenaHash)){
            $nombre = $fila['name_admin'];
            $_SESSION['nombre_empleado'] = $nombre;
            $_SESSION['email_empleado'] = $email;
            echo 'index.php';
        } else {
            echo 'Contraseña Incorrecta';
        }
    } else {
        echo 'Información no Encontrada';
    }

    mysqli_close($conexion);
}

?>