<?php
session_start();

require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conexion, $_POST['empleadoNombre']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['empleadoApellidos']);
    $email = mysqli_real_escape_string($conexion, $_POST['empleadoEmail']);
    $contrasena = password_hash($_POST['empleadoPassword'], PASSWORD_BCRYPT);
    $tienda = mysqli_real_escape_string($conexion, $_POST['empleadoTienda']);

    $verificar = "SELECT * FROM administradores WHERE email_admin = '$email'";
    $resultado = $conexion->query($verificar);
    if ($resultado->num_rows > 0) {
        echo 'Ese correo ya está en uso';
    } else {
        $sql = "INSERT INTO administradores (email_admin, name_admin, lastname_admin, password_admin, id_tienda) VALUES ('$email', '$nombre', '$apellido', '$contrasena', '$tienda')";

        if (mysqli_query($conexion, $sql)) {
            $_SESSION['nombre_empleado'] = $nombre;
            $_SESSION['email_empleado'] = $email;
            echo 'index.php';
        } else {
            echo "Error al Registrar: " . mysqli_error($conexion);
        }
    }

    mysqli_close($conexion);
}

?>