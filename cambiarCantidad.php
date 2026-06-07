<?php
require 'controlSesion.php';
require 'conexion.php';


if (isset($_SESSION['email'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cantidad = $_POST['cantidad'];
        $id_disco = $_POST['id_disco'];
        $precio_unitario = $_POST['precio_unitario'];
        $subtotal = $precio_unitario * $cantidad;

        if ($cantidad < 1) {
            echo 'carrito.php';
        } else {
            $sql_stock = "SELECT stock FROM discos WHERE id_disco = '$id_disco'";
            $resultado_stock = $conexion->query($sql_stock);
            if ($resultado_stock->num_rows > 0) {
                $fila_stock = $resultado_stock->fetch_assoc();
                $stock = (int) $fila_stock['stock'];
                if ($stock < $cantidad) {
                    echo 'carrito.php';
                } else {
                    $verificar = "SELECT * FROM discos_carrito WHERE id_disco = '$id_disco'";
                    $resultado = $conexion->query($verificar);
                    if ($resultado->num_rows > 0) {
                        $sql = "UPDATE discos_carrito SET cantidad = '$cantidad', subtotal = '$subtotal' WHERE id_disco = '$id_disco'";

                        if (mysqli_query($conexion, $sql)) {
                            echo 'carrito.php';
                        } else {
                            echo "Error al Agregar: " . mysqli_error($conexion);
                        }
                    } else {
                        echo 'No se encontró';
                    }
                }
            }
        }

        mysqli_close($conexion);
    }
} else {
    echo 'carrito.php';
}

?>