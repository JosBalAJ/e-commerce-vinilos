<?php
// 1. Iniciar y validar la sesión antes de CUALQUIER otra cosa
require 'controlSesion.php';

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit(); // Detiene la ejecución para asegurar la redirección
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="stylesCarrito.css">
    <title>Vinilos Josue - Carrito</title>
    <script src="https://www.paypal.com/sdk/js?client-id=AQfMSnMCqTRIh3Dgc9-3NkG984jjKhOtKeREJnGqn-K1WST9dxLGglpXPtDzcR1LIISNV43Q-2MuutrH&currency=MXN"></script>
</head>

<body>
    <header>
        <img class="logo" src="img/Vinilo Logo.jpg" alt="Vinilo Logo">
        <h1>Carrito</h1>
        <img class="logo" src="img/Vinilo Logo.jpg" alt="Vinilo Logo">
    </header>
    <main id="mainResumen">
        <h1>Resumen de Pedido</h1>
        <div id="descripcionResumen">
            <span>PORTADA</span>
            <span>ÁLBUM</span>
            <span>PRECIO UNITARIO</span>
            <span>CANTIDAD</span>
            <span>SUBTOTAL</span>
        </div>

        <?php
        require('conexion.php');
        $email = $_SESSION['email'];
        $sql = "SELECT * FROM discos_carrito WHERE email = '$email'";
        $pedidos_discos = $conexion->query($sql);
        $total = 0;

        if ($pedidos_discos->num_rows > 0) {
            while ($fila = $pedidos_discos->fetch_assoc()) {
                $id_disco = $fila['id_disco'];
                $sql_disco = "SELECT album, imagen FROM discos WHERE id_disco = '$id_disco'";
                $resultado_disco = $conexion->query($sql_disco);
                $disco = $resultado_disco->fetch_assoc();
                $imagen_disco = $disco['imagen'];
                $album = $disco['album'];
                $precio_unitario = (float) $fila['precio_unitario'];
                $cantidad = (int) $fila['cantidad'];
                $subtotal = $precio_unitario * $cantidad;
                $total += $subtotal;

                echo '<div class="contenedorArticulo">
                        <img src="' . $imagen_disco . '" alt="Disco">
                        <span>' . $album . '</span>
                        <span>$' . $precio_unitario . ' MXN</span>
                    <div>
                    <div class="botonesCantidad" data-cantidad="' . $cantidad . '" data-id_disco="' . $id_disco . '" data-precio_unitario="' . $precio_unitario . '">
                        <span class="btnDisminuir">-</span>
                        <span class="btnCantidad">' . $cantidad . '</span>
                        <span class="btnAumentar">+</span>
                    </div>
                    <div class="botonEliminar" data-eliminar_id_disco="' . $id_disco . '">
                        <span class="boton btnEliminarDisco">Eliminar</span>
                    </div>
                </div>
                <span>$' . ($fila['precio_unitario'] * $fila['cantidad']) . ' MXN</span>
            </div>';
            }
        }

        echo '<span id="totalNumero"><span id="totalTexto">Total: </span> $' . $total . '</span>';
        ?>

        <div id="botonesResumen">
            <span class="boton" id="btnVolver">Volver</span>
            <span class="boton" id="btnRecibo">Imprimir Recibo</span>
        </div>
        <div id="paypal-button-container"></div>
        <script>
            paypal.Buttons({
                style: {
                    layout: 'horizontal',
                    color: 'gold',
                    shape: 'pill',
                    label: 'paypal',
                    tagline: false
                },
                createOrder: function (data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: <?php echo $total ?>
                            }
                        }]
                    });
                },

                onApprove: function (data, actions) {
                    return actions.order.capture().then(function (details) {
                        alert('Pago completado por ' + details.payer.name.given_name);
                        window.location.href = "pedidoPaypal.php";
                    });
                },
                onRender: function () {
                    console.log("PayPal button rendered");
                    const paypalButton = document.querySelector("#paypal-button-container");
                    if (paypalButton) {
                        paypalButton.style.display = "none";
                        setTimeout(() => {
                            paypalButton.style.display = "block";
                        }, 1500);
                    }
                }
            }).render('#paypal-button-container');
        </script>
    </main>
    <footer>
        <p>&copy; 2025 Vinilos Josue. Todos los derechos reservados.</p>
    </footer>
</body>

<script src="jsCarrito.js"></script>

</html>