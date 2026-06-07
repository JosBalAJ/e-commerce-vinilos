<?php
require 'controlSesion.php';
require 'conexion.php';

if (isset($_SESSION['email_empleado'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = mysqli_real_escape_string($conexion, $_POST['eliminarUsuarioEmail']);

        $verificar = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado = $conexion->query($verificar);
        if ($resultado->num_rows > 0) {
            $email_empleado = $_SESSION['email_empleado'];
            $sql = "DELETE FROM usuarios WHERE email = '$email'";
            $datos = $resultado->fetch_assoc();

            $nombre = mysqli_real_escape_string($conexion, $datos['name']);
            $apellido = mysqli_real_escape_string($conexion, $datos['lastname']);
            $contrasena = mysqli_real_escape_string($conexion, $datos['password']);
            $calle_numero = mysqli_real_escape_string($conexion, $datos['calle_numero']);
            $colonia = mysqli_real_escape_string($conexion, $datos['colonia']);
            $municipio = mysqli_real_escape_string($conexion, $datos['municipio']);

            $contrasentencia = "INSERT INTO usuarios (email, name, lastname, password, calle_numero, colonia, municipio)
                VALUES ('$email', '$nombre', '$apellido', '$contrasena', '$calle_numero', '$colonia', '$municipio')";

            $sql_escaped = mysqli_real_escape_string($conexion, $sql);
            $contrasentencia_escaped = mysqli_real_escape_string($conexion, $contrasentencia);

            $sql_bitacora = "INSERT INTO bitacora_usuarios (accion_usuario, fecha_cambio_usuario, email_admin, email, sentencia_usuario, contrasentencia_usuario)
                VALUES ('Eliminación', NOW(), '$email_empleado', '$email', '$sql_escaped', '$contrasentencia_escaped')";

            if (mysqli_query($conexion, $sql) && mysqli_query($conexion, $sql_bitacora)) {
                echo 'usuarios.php';
            } else {
                echo "Error al Eliminar: " . mysqli_error($conexion);
            }
        } else {
            echo 'No se encontró';
        }

        mysqli_close($conexion);
    }
} else {
    echo 'index.php';
}

?>