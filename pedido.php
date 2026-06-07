<?php
require 'controlSesion.php';
require 'conexion.php';
require_once 'librerias/TCPDF-main/tcpdf.php';
require_once 'librerias/PHPMailer-master/src/PHPMailer.php';
require_once 'librerias/PHPMailer-master/src/SMTP.php';
require_once 'librerias/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION['email'])) {
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

            $pdf = new TCPDF();

            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Vinilos Josue');
            $pdf->SetTitle('Recibo de Compra');
            $pdf->SetSubject('Detalles del Pedido');
            $pdf->SetKeywords('PDF, recibo, compra, pedido');

            $pdf->AddPage();

            $pdf->Image('img/Vinilo Logo.jpg', 10, 10, 50);
            $pdf->setY(60);

            $html = '
                    <h1>Recibo de Compra</h1>
                    <p><strong>Nombre:</strong>' . $usuario . '</p>
                    <p><strong>Apellido:</strong>' . $apellido . '</p>
                    <p><strong>ID del Pedido:</strong>' . $ultimo_id . '</p>
                    <p><strong>Fecha del pedido:</strong> ' . date("Y-m-d H:i:s") . '</p>
                    <p><strong>Email:</strong> ' . $email . '</p>
                    <table border="1" cellpadding="5">
                        <thead>
                            <tr>
                                <th>Album</th>
                                <th>Artista</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                    <tbody>';

            $sql_detalle_pdf = "SELECT * FROM detalles_pedidos WHERE id_pedido = '$ultimo_id'";
            $resultado_detalle = $conexion->query($sql_detalle_pdf);
            while ($fila = $resultado_detalle->fetch_assoc()) {
                $album = $fila['album'];
                $artista = $fila['artista'];
                $cantidad = $fila['cantidad'];
                $precio_unitario = $fila['precio_unitario'];
                $subtotal = $fila['subtotal'];

                $html .= '
                            <tr>
                                <td>' . $album . '</td>
                                <td>' . $artista . '</td>
                                <td>' . $cantidad . '</td>
                                <td>$' . $precio_unitario . '</td>
                                <td>$' . $subtotal . '</td>
                            </tr>';
            }

            $html .= '
                       </tbody>
                    </table>
                    <p><strong>Total de la compra:</strong> $' . $total . '</p>
                    <br><br><br><br>
                    <p><strong>Se enviará a la siguiente dirección:</strong> ' . $calle_numero . ', ' . $colonia . ', ' . $municipio . ', Jal.</p>
                    <br><br><br><br><br><br><br><br><br><br>
                    <p><strong>Dudas o aclaraciones:</strong> a23310162@ceti.mx - 33 3552 6989</p>
                    ';

            $pdf->writeHTML($html, true, false, true, false, '');

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'a23310162@ceti.mx';
                $mail->Password = 'AyudaVitorugo12';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('a23310162@ceti.mx', 'Vinilos Josue');
                $mail->addAddress($email, $usuario);
                $mail->Subject = 'Tu recibo de compra';

                $pdfContenido = $pdf->Output('', 'S');
                $mail->addStringAttachment($pdfContenido, 'reciboDeCompra.pdf');

                $mail->isHTML(true);
                $mail->Body = "Hola '$usuario'.<br>Muchas gracias por ser un Usuario de Vinilos Josue.<br>Adjuntamos tu recibo de compra en PDF.<br><br>¡Gracias por tu compra!";

                $mail->send();
                echo 'carrito.php';

            } catch (Exception $e) {
                echo "Error al enviar el correo: {$mail->ErrorInfo}";
            }

        } else {
            echo "Error: " . mysqli_error($conexion);
        }
    } else {
        echo 'No hay nada en el carrito';
    }

    mysqli_close($conexion);
} else {
    echo 'carrito.php';
}

?>