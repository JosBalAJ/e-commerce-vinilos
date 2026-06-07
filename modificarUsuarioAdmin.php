<?php
require 'controlSesion.php';
require 'conexion.php';

if (isset($_SESSION['email_empleado'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = mysqli_real_escape_string($conexion, $_POST['modificarUsuarioEmail']);
        $verificar = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado = $conexion->query($verificar);
        if ($resultado->num_rows > 0) {
            $camposModificar = [];
            $email_empleado = $_SESSION['email_empleado'];

            if (!empty($_POST['modificarUsuarioNombre'])) {
                $nombre = mysqli_real_escape_string($conexion, $_POST['modificarUsuarioNombre']);
                $camposModificar[] = "name = '$nombre'";
            }
            if (!empty($_POST['modificarUsuarioApellido'])) {
                $apellido = mysqli_real_escape_string($conexion, $_POST['modificarUsuarioApellido']);
                $camposModificar[] = "lastname = '$apellido'";
            }
            if (!empty($_POST['modificarUsuarioPassword'])) {
                $contrasena = password_hash($_POST['modificarUsuarioPassword'], PASSWORD_BCRYPT);
                $camposModificar[] = "password = '$contrasena'";
            }
            if (!empty($_POST['modificarUsuarioCalleNumero'])) {
                $calle_numero = mysqli_real_escape_string($conexion, $_POST['modificarUsuarioCalleNumero']);
                $camposModificar[] = "calle_numero = '$calle_numero'";
            }
            if (!empty($_POST['modificarUsuarioColonia'])) {
                $colonia = mysqli_real_escape_string($conexion, $_POST['modificarUsuarioColonia']);
                $camposModificar[] = "colonia = '$colonia'";
            }
            if (!empty($_POST['modificarUsuarioMunicipio'])) {
                $municipio = mysqli_real_escape_string($conexion, $_POST['modificarUsuarioMunicipio']);
                $camposModificar[] = "municipio = '$municipio'";
            }

            if (!empty($camposModificar)) {
                $sql = "UPDATE usuarios SET " . implode(", ", $camposModificar) . " WHERE email = '$email'";

                $sql_datos_actuales = "SELECT * FROM usuarios WHERE email = '$email'";
                $resultado_datos_actuales = $conexion->query($sql_datos_actuales);
                $datos = $resultado_datos_actuales->fetch_assoc();

                $nombre = mysqli_real_escape_string($conexion, $datos['name']);
                $apellido = mysqli_real_escape_string($conexion, $datos['lastname']);
                $contrasena = mysqli_real_escape_string($conexion, $datos['password']);
                $calle_numero = mysqli_real_escape_string($conexion, $datos['calle_numero']);
                $colonia = mysqli_real_escape_string($conexion, $datos['colonia']);
                $municipio = mysqli_real_escape_string($conexion, $datos['municipio']);

                $contrasentencia = "UPDATE usuarios SET name = '$nombre', lastname = '$apellido', password = '$contrasena', 
                        calle_numero = '$calle_numero', colonia = '$colonia', municipio = '$municipio' WHERE email = '$email'";

                $sql_escaped = mysqli_real_escape_string($conexion, $sql);
                $contrasentencia_escaped = mysqli_real_escape_string($conexion, $contrasentencia);

                $sql_bitacora = "INSERT INTO bitacora_usuarios (accion_usuario, fecha_cambio_usuario, email_admin, email, sentencia_usuario, contrasentencia_usuario) 
                        VALUES ('Modificación', NOW(), '$email_empleado', '$email', '$sql_escaped', '$contrasentencia_escaped')";

                if (mysqli_query($conexion, $sql) && mysqli_query($conexion, $sql_bitacora)) {
                    echo 'usuarios.php';
                } else {
                    echo "Error al Modificar: " . mysqli_error($conexion);
                }
            } else {
                echo 'Debes modificar al menos un campo';
            }
        } else {
            echo 'No se encontró...';
        }

        mysqli_close($conexion);
    }
} else {
    echo 'index.php';
}

?>