<?php
session_start();

require 'conexion.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $email = mysqli_real_escape_string($conexion, $_POST['emailIniciarSesion']);
    $contrasena = mysqli_real_escape_string($conexion, $_POST['passwordIniciarSesion']);

    $usuarioExiste = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = $conexion->query($usuarioExiste);
    if($resultado->num_rows > 0){
        $fila = $resultado->fetch_assoc();
        $contrasenaHash = $fila['password'];
        if(password_verify($contrasena, $contrasenaHash)){
            $nombre = $fila['name'];
            $apellido = $fila['lastname'];
            $calle_numero = $fila['calle_numero'];
            $colonia = $fila['colonia'];
            $municipio = $fila['municipio'];
            $_SESSION['nombre'] = $nombre;
            $_SESSION['apellido'] = $apellido;
            $_SESSION['calle_numero'] = $calle_numero;
            $_SESSION['colonia'] = $colonia;
            $_SESSION['municipio'] = $municipio;
            $_SESSION['email'] = $email;
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