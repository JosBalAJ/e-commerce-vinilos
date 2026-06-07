<?php
require 'controlSesion.php';
require 'conexion.php';

if (isset($_SESSION['email_empleado'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email_empleado = $_SESSION['email_empleado'];
        $album = mysqli_real_escape_string($conexion, $_POST['agregarAlbum']);
        $artista = mysqli_real_escape_string($conexion, $_POST['agregarArtista']);
        $array_generos = $_POST['generos'];
        $generos = "";
        foreach ($array_generos as $genero) {
            $generos .= $genero . ",";
        }
        $generos = rtrim($generos, ",");
        $precio = mysqli_real_escape_string($conexion, $_POST['agregarPrecio']);
        $descripcion = mysqli_real_escape_string($conexion, $_POST['agregarDescripcion']);
        $stock = mysqli_real_escape_string($conexion, $_POST['agregarStock']);

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $imagen_tmp = $_FILES['imagen']['tmp_name'];
            $imagen_nombre = $_FILES['imagen']['name'];
            $imagen_extension = pathinfo($imagen_nombre, PATHINFO_EXTENSION);
            $extensiones_validas = ['jpg', 'jpeg', 'png'];
            if (in_array(strtolower($imagen_extension), $extensiones_validas)) {
                $directorio_destino = 'img/discos/';
                $imagen_ruta = $directorio_destino . $imagen_nombre;
                if (file_exists($imagen_ruta)) {
                    echo 'Esa imagen de disco ya existe. No se agregó...';
                    exit;
                } else {
                    if (move_uploaded_file($imagen_tmp, $imagen_ruta)) {
                        $imagen = mysqli_real_escape_string($conexion, $imagen_ruta);
                    } else {
                        echo 'Error al subir la imagen al servidor';
                        exit;
                    }
                }
            } else {
                echo 'No se ha subido ninguna imagen';
                exit;
            }
        }

        $verificar = "SELECT * FROM discos WHERE album = '$album' AND artista = '$artista'";
        $resultado = $conexion->query($verificar);
        if ($resultado->num_rows > 0) {
            echo 'Ese disco ya está registrado';
        } else {
            $sql = "INSERT INTO discos (album, artista, genero, precio, descripcion, imagen, stock) VALUES ('$album', '$artista', '$generos', '$precio', '$descripcion', '$imagen', '$stock')";
            if (mysqli_query($conexion, $sql)) {
                $id_disco = mysqli_insert_id($conexion);

                $contrasentencia = "DELETE FROM discos WHERE id_disco = '$id_disco'";
                $sql_escaped = mysqli_real_escape_string($conexion, $sql);
                $contrasentencia_escaped = mysqli_real_escape_string($conexion, $contrasentencia);

                $sql_bitacora = "INSERT INTO bitacora_discos (accion_disco, fecha_cambio_disco, email_admin, id_disco, sentencia_disco, contrasentencia_disco)
                    VALUES ('Agregado', NOW(), '$email_empleado', '$id_disco', '$sql_escaped', '$contrasentencia_escaped')";

                if (mysqli_query($conexion, $sql_bitacora)) {
                    echo 'index.php';
                } else {
                    echo "Error al Registrar en la bitácora" . mysqli_error($conexion);
                }
            } else {
                echo "Error al Registrar el Disco: " . mysqli_error($conexion);
            }
        }

        mysqli_close($conexion);
    }
} else {
    echo 'index.php';
}


?>