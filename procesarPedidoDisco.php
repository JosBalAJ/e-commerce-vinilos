<?php
require 'controlSesion.php';
require 'conexion.php';

if (isset($_SESSION['email'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id_disco = $_POST['id_disco'];
        $precio_unitario = $_POST['precio_unitario'];
        $email = $_POST['email'];
        $cantidad = 1;
        $subtotal = $precio_unitario * $cantidad;

        $verificar = "SELECT * FROM discos_carrito WHERE id_disco = '$id_disco'";
        $resultado = $conexion->query($verificar);
        if ($resultado->num_rows > 0) {
            echo 'Ese disco ya está en el carrito';
        } else {
            $sql = "INSERT INTO discos_carrito (email, id_disco, cantidad, precio_unitario, subtotal) VALUES ('$email', '$id_disco', '$cantidad', '$precio_unitario', '$subtotal')";

            if (mysqli_query($conexion, $sql)) {
                echo 'index.php';
            } else {
                echo "Error al Agregar: " . mysqli_error($conexion);
            }
        }

        mysqli_close($conexion);
    }
} else{
    echo 'index.php';
}


?>