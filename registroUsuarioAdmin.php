<?php
require 'controlSesion.php';
require 'conexion.php';

if (isset($_SESSION['email_empleado'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email_empleado = $_SESSION['email_empleado'];
        $email = mysqli_real_escape_string($conexion, $_POST['agregarUsuarioEmail']);
        $nombre = mysqli_real_escape_string($conexion, $_POST['agregarUsuarioNombre']);
        $apellido = mysqli_real_escape_string($conexion, $_POST['agregarUsuarioApellido']);
        $calle_numero = mysqli_real_escape_string($conexion, $_POST['agregarUsuarioCalleNumero']);
        $colonia = mysqli_real_escape_string($conexion, $_POST['agregarUsuarioColonia']);
        $municipio = mysqli_real_escape_string($conexion, $_POST['agregarUsuarioMunicipio']);
        $contrasena = password_hash($_POST['agregarUsuarioPassword'], PASSWORD_BCRYPT);

        $verificar = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado = $conexion->query($verificar);
        if ($resultado->num_rows > 0) {
            echo 'Ese correo ya está en uso';
        } else {
            $sql = "INSERT INTO usuarios (email, name, lastname, password, calle_numero, colonia, municipio) VALUES ('$email', '$nombre', '$apellido', '$contrasena', '$calle_numero',  '$colonia', '$municipio')";

            $contrasentencia = "DELETE FROM usuarios WHERE email = '$email'";
            $sql_escaped = mysqli_real_escape_string($conexion, $sql);
            $contrasentencia_escaped = mysqli_real_escape_string($conexion, $contrasentencia);

            $sql_bitacora = "INSERT INTO bitacora_usuarios (accion_usuario, fecha_cambio_usuario, email_admin, email, sentencia_usuario, contrasentencia_usuario)
                VALUES ('Agregado', NOW(), '$email_empleado', '$email', '$sql_escaped', '$contrasentencia_escaped')";

            if (mysqli_query($conexion, $sql) && mysqli_query($conexion, $sql_bitacora)) {
                echo 'usuarios.php';
            } else {
                echo "Error al Registrar: " . mysqli_error($conexion);
            }
        }

        mysqli_close($conexion);
    }
} else {
    echo 'index.php';
}

?>