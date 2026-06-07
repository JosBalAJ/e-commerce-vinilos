<?php
require 'controlSesion.php';
require 'conexion.php';

if (isset($_SESSION['email'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_disco = $_POST['id_disco'];

        $verificar = "SELECT * FROM discos_carrito WHERE id_disco = '$id_disco'";
        $resultado = $conexion->query($verificar);
        if ($resultado->num_rows > 0) {
            $sql = "DELETE FROM discos_carrito WHERE id_disco = '$id_disco'";

            if (mysqli_query($conexion, $sql)) {
                echo 'carrito.php';
            } else {
                echo "Error al Eliminar: " . mysqli_error($conexion);
            }
        } else {
            echo 'No se encontró';
        }

        mysqli_close($conexion);
    }
} else {
    echo 'carrito.php';
}

?>