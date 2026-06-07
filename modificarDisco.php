<?php
require 'controlSesion.php';
require 'conexion.php';

if (isset($_SESSION['email_empleado'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_album = mysqli_real_escape_string($conexion, $_POST['modificarID']);
        $verificar = "SELECT * FROM discos WHERE id_disco = '$id_album'";
        $resultado = $conexion->query($verificar);
        if ($resultado->num_rows > 0) {
            $camposModificar = [];
            $email_empleado = $_SESSION['email_empleado'];

            if (!empty($_POST['modificarAlbum'])) {
                $album = mysqli_real_escape_string($conexion, $_POST['modificarAlbum']);
                $camposModificar[] = "album = '$album'";
            }
            if (!empty($_POST['modificarArtista'])) {
                $artista = mysqli_real_escape_string($conexion, $_POST['modificarArtista']);
                $camposModificar[] = "artista = '$artista'";
            }
            if (!empty($_POST['generos'])) {
                $array_generos = $_POST['generos'];
                $generos = "";
                foreach ($array_generos as $genero) {
                    $generos .= $genero . ",";
                }
                $generos = rtrim($generos, ",");
                $camposModificar[] = "genero = '$generos'";
            }
            if (!empty($_POST['modificarPrecio'])) {
                $precio = mysqli_real_escape_string($conexion, $_POST['modificarPrecio']);
                $camposModificar[] = "precio = '$precio'";
            }
            if (!empty($_POST['modificarDescripcion'])) {
                $descripcion = mysqli_real_escape_string($conexion, $_POST['modificarDescripcion']);
                $camposModificar[] = "descripcion = '$descripcion'";
            }
            if (!empty($_FILES['modificarImagen']['name'])) {
                $imagen_tmp = $_FILES['modificarImagen']['tmp_name'];
                $imagen_nombre = $_FILES['modificarImagen']['name'];
                $imagen_extension = pathinfo($imagen_nombre, PATHINFO_EXTENSION);
                $directorio_destino = 'img/discos/';
                $imagen_ruta = $directorio_destino . $imagen_nombre;
                if(file_exists($imagen_ruta)){
                    echo 'Ya hay un disco con esa imagen. No se subirá.';
                    exit;
                } else {
                    if(move_uploaded_file($imagen_tmp, $imagen_ruta)){
                        $imagen = $imagen_ruta;
                        $camposModificar[] = "imagen = '$imagen'";
                    } else {
                        echo 'Error al subir';
                        exit;
                    }
                }
            }
            if (!empty($_POST['modificarStock'])) {
                $stock = mysqli_real_escape_string($conexion, $_POST['modificarStock']);
                $camposModificar[] = "stock = '$stock'";
            }

            if (!empty($camposModificar)) {
                $sql = "UPDATE discos SET " . implode(", ", $camposModificar) . " WHERE id_disco = '$id_album'";

                $sql_datos_actuales = "SELECT * FROM discos WHERE id_disco = '$id_album'";
                $resultado_datos_actuales = $conexion->query($sql_datos_actuales);
                $datos = $resultado_datos_actuales->fetch_assoc();

                $album = mysqli_real_escape_string($conexion, $datos['album']);
                $artista = mysqli_real_escape_string($conexion, $datos['artista']);
                $genero = mysqli_real_escape_string($conexion, $datos['genero']);
                $precio = mysqli_real_escape_string($conexion, $datos['precio']);
                $descripcion = mysqli_real_escape_string($conexion, $datos['descripcion']);
                $imagen = mysqli_real_escape_string($conexion, $datos['imagen']);
                $stock = (int) $datos['stock'];

                $contrasentencia = "UPDATE discos SET album = '$album', artista = '$artista', genero = '$genero', 
                        precio = '$precio', descripcion = '$descripcion', imagen = '$imagen', 
                        stock = $stock WHERE id_disco = '$id_album'";

                $sql_escaped = mysqli_real_escape_string($conexion, $sql);
                $contrasentencia_escaped = mysqli_real_escape_string($conexion, $contrasentencia);

                $sql_bitacora = "INSERT INTO bitacora_discos (accion_disco, fecha_cambio_disco, email_admin, id_disco, sentencia_disco, contrasentencia_disco) 
                     VALUES ('Modificación', NOW(), '$email_empleado', '$id_album', '$sql_escaped', '$contrasentencia_escaped')";

                if (mysqli_query($conexion, $sql) && mysqli_query($conexion, $sql_bitacora)) {
                    echo 'index.php';
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