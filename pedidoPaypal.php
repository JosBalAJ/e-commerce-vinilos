<?php
session_start();
include 'controlSesion.php';
require 'conexion.php';

$email = $_SESSION['email'];
$usuario = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$calle_numero = $_SESSION['calle_numero'];
$colonia = $_SESSION['colonia'];
$municipio = $_SESSION['municipio'];

$sql_disco = "SELECT * FROM discos_carrito WHERE email = '$email'";
$resultado_disco = $conexion->query($sql_disco);
if ($resultado_disco->num_rows > 0) {

    $sql = "INSERT INTO pedidos (email, fecha_pedido, total) VALUES ('$email', NOW(), 0)";
    if (mysqli_query($conexion, $sql)) {
        $sql_pedido = "SELECT MAX(id_pedido) AS ultimo_id FROM pedidos WHERE email = '$email'";
        $resultado_pedido = $conexion->query($sql_pedido);
        $fila = $resultado_pedido->fetch_assoc();
        $ultimo_id = $fila['ultimo_id'];

        $total = 0;
        while ($fila = $resultado_disco->fetch_assoc()) {
            $cantidad = $fila['cantidad'];
            $precio_unitario = $fila['precio_unitario'];
            $subtotal = (float) $fila['subtotal'];
            $id_disco = $fila['id_disco'];
            $total += $subtotal;

            $sql_album = "SELECT album, artista, stock FROM discos WHERE id_disco = '$id_disco'";
            $resultado_album = $conexion->query($sql_album);
            $fila_album = $resultado_album->fetch_assoc();
            $album = $fila_album['album'];
            $artista = $fila_album['artista'];
            $stock = $fila_album['stock'];

            $sql_detalle = "INSERT INTO detalles_pedidos (id_pedido, album, artista, cantidad, precio_unitario, subtotal, email) 
                            VALUES ('$ultimo_id', '$album', '$artista', '$cantidad', '$precio_unitario', '$subtotal', '$email')";
            $conexion->query($sql_detalle);

            $nueva_cantidad = $stock - $cantidad;
            if ($nueva_cantidad > 0) {
                $sql_nuevo_stock = "UPDATE discos SET stock = '$nueva_cantidad' WHERE id_disco = '$id_disco'";
            } else {
                $sql_nuevo_stock = "DELETE FROM discos WHERE id_disco = '$id_disco'";
            }
            $conexion->query($sql_nuevo_stock);
        }
        $sql = "UPDATE pedidos SET total = '$total' WHERE id_pedido = '$ultimo_id'";
        $conexion->query($sql);

        $sql_borrar = "DELETE FROM discos_carrito WHERE email = '$email'";
        $conexion->query($sql_borrar);
        echo '¡Exito!';
        header("Location: index.php");
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
} else {
    echo 'No hay nada en el carrito';
}

mysqli_close($conexion);

?>