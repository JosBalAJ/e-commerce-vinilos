<?php
require 'controlSesion.php';
require 'conexion.php';

if (isset($_SESSION['email_empleado'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_album = mysqli_real_escape_string($conexion, $_POST['eliminarID']);

        $verificar = "SELECT * FROM discos WHERE id_disco = '$id_album'";
        $resultado = $conexion->query($verificar);
        if ($resultado->num_rows > 0) {
            $email_empleado = $_SESSION['email_empleado'];
            $sql = "DELETE FROM discos WHERE id_disco = '$id_album'";
            $datos = $resultado->fetch_assoc();

            $album = mysqli_real_escape_string($conexion, $datos['album']);
            $artista = mysqli_real_escape_string($conexion, $datos['artista']);
            $genero = mysqli_real_escape_string($conexion, $datos['genero']);
            $precio = mysqli_real_escape_string($conexion, $datos['precio']);
            $descripcion = mysqli_real_escape_string($conexion, $datos['descripcion']);
            $imagen = mysqli_real_escape_string($conexion, $datos['imagen']);
            $stock = (int) $datos['stock'];

            $contrasentencia = "INSERT INTO discos (album, artista, genero, precio, descripcion, imagen, stock)
                VALUES ('$album', '$artista', '$genero', '$precio', '$descripcion', '$imagen', '$stock')";

            $sql_escaped = mysqli_real_escape_string($conexion, $sql);
            $contrasentencia_escaped = mysqli_real_escape_string($conexion, $contrasentencia);

            $sql_bitacora = "INSERT INTO bitacora_discos (accion_disco, fecha_cambio_disco, email_admin, id_disco, sentencia_disco, contrasentencia_disco)
                VALUES ('Eliminación', NOW(), '$email_empleado', '$id_album', '$sql_escaped', '$contrasentencia_escaped')";

            if (mysqli_query($conexion, $sql) && mysqli_query($conexion, $sql_bitacora)) {
                if(file_exists($imagen)){
                    unlink($imagen);
                }
                echo 'index.php';
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