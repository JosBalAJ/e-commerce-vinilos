<?php
require 'controlSesion.php';
require 'conexion.php';

if (!isset($_SESSION['email_empleado'])) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitácora Usuarios - Vinilos Josue</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="stylesBitacora.css">
</head>

<body>
    <header>
        <img class="logo" src="img/Vinilo Logo.jpg" alt="Vinilo Logo">
        <h1>Bitácora de Usuarios</h1>
        <img class="logo" src="img/Vinilo Logo.jpg" alt="Vinilo Logo">
    </header>
    <main>
        <h1>Historial de Acciones en Usuarios</h1>
        <div class="tabla">
            <div class="columna1 columnas">
                <?php
                $sql = "SELECT * FROM bitacora_usuarios";
                $datos = $conexion->query($sql);
                $registros = [];
                if ($datos->num_rows > 0) {
                    while ($fila = $datos->fetch_assoc()) {
                        $registros[] = $fila;
                    }
                }
                ?>
                <div class="primeraFila esquinaIzquierda">
                    <span>ID</span>
                </div>
                <?php
                foreach ($registros as $fila) {
                    echo '<div class="fila bold">
                            <span>' . $fila['id_cambio_usuario'] . '</span>
                        </div>';
                }
                ?>
            </div>
            <div class="columna2 columnas">
                <div class="primeraFila">
                    <span>Acción Realizada</span>
                </div>
                <?php
                foreach ($registros as $fila) {
                    echo '<div class="fila bold">
                            <span>' . $fila['accion_usuario'] . '</span>
                        </div>';
                }
                ?>
            </div>
            <div class="columna3 columnas">
                <div class="primeraFila">
                    <span>Fecha y Hora</span>
                </div>
                <?php
                foreach ($registros as $fila) {
                    echo '<div class="fila bold">
                            <span>' . $fila['fecha_cambio_usuario'] . '</span>
                        </div>';
                }
                ?>
            </div>
            <div class="columna4 columnas">
                <div class="primeraFila">
                    <span>Email de quien lo Realizó</span>
                </div>
                <?php
                foreach ($registros as $fila) {
                    echo '<div class="fila bold">
                            <span>' . $fila['email_admin'] . '</span>
                        </div>';
                }
                ?>
            </div>
            <div class="columna5 columnas">
                <div class="primeraFila">
                    <span>Sentencia Usada</span>
                </div>
                <?php
                foreach ($registros as $fila) {
                    echo '<div class="fila largos">
                            <span>' . $fila['sentencia_usuario'] . '</span>
                        </div>';
                }
                ?>
            </div>
            <div class="columna6 columnas">
                <div class="primeraFila esquinaDerecha">
                    <span>Sentencia para Deshacer</span>
                </div>
                <?php
                foreach ($registros as $fila) {
                    echo '<div class="fila largos">
                            <span>' . $fila['contrasentencia_usuario'] . '</span>
                        </div>';
                }
                ?>
            </div>
        </div>
        <span class="boton" onclick="window.location.href='usuarios.php'">Volver</span>
    </main>
    <footer>
        <p>&copy; 2025 Vinilos Josue. Todos los derechos reservados.</p>
    </footer>
</body>

<script src="jsBitacora.js"></script>

</html>