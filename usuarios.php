<?php
require 'controlSesion.php';
require 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="stylesBitacora.css">
    <title>Vinilos Josue</title>
</head>

<body>
    <header>
        <img class="logo" src="img/Vinilo Logo.jpg" alt="Vinilo Logo">
        <h1>Control de Usuarios</h1>
        <img class="logo" src="img/Vinilo Logo.jpg" alt="Vinilo Logo">
    </header>
    <main>
        <h1>Usuarios</h1>
        <div class="tabla">
            <div class="column1 columnas">
                <?php
                $sql = "SELECT * FROM usuarios";
                $datos = $conexion->query($sql);
                $registros = [];
                if ($datos->num_rows > 0) {
                    while ($fila = $datos->fetch_assoc()) {
                        $registros[] = $fila;
                    }
                }
                ?>
                <div class="primeraFila esquinaIzquierda">
                    <span>Email</span>
                </div>
                <?php
                foreach ($registros as $fila) {
                    echo '<div class="fila bold alto">
                            <span>' . $fila['email'] . '</span>
                        </div>';
                }
                ?>
            </div>
            <div class="column2 columnas">
                <div class="primeraFila">
                    <span>Nombre(s)</span>
                </div>
                <?php
                foreach ($registros as $fila) {
                    echo '<div class="fila bold alto">
                            <span>' . $fila['name'] . '</span>
                        </div>';
                }
                ?>
            </div>
            <div class="column3 columnas">
                <div class="primeraFila">
                    <span>Apellidos</span>
                </div>
                <?php
                foreach ($registros as $fila) {
                    echo '<div class="fila bold alto">
                            <span>' . $fila['lastname'] . '</span>
                        </div>';
                }
                ?>
            </div>
            <div class="column4 columnas">
                <div class="primeraFila">
                    <span>Calle y Número de Casa</span>
                </div>
                <?php
                foreach ($registros as $fila) {
                    echo '<div class="fila bold alto">
                            <span>' . $fila['calle_numero'] . '</span>
                        </div>';
                }
                ?>
            </div>
            <div class="column5 columnas">
                <div class="primeraFila">
                    <span>Colonia</span>
                </div>
                <?php
                foreach ($registros as $fila) {
                    echo '<div class="fila bold alto">
                            <span>' . $fila['colonia'] . '</span>
                        </div>';
                }
                ?>
            </div>
            <div class="column6 columnas">
                <div class="primeraFila esquinaDerecha">
                    <span>Municipio</span>
                </div>
                <?php
                foreach ($registros as $fila) {
                    echo '<div class="fila bold alto">
                            <span>' . $fila['municipio'] . '</span>
                        </div>';
                }
                ?>
            </div>
        </div>
        <div id="botonesAccionesUsuarios">
            <span class="boton" id="btnEliminarUsuario">Eliminar</span>
            <section class="modalEliminarUsuario">
                <div id="contenedorEliminarUsuario">
                    <h1>Eliminar Usuario</h1>
                    <form id="formularioEliminarUsuario">
                        <span>Email del Usuario:</span>
                        <input type="text" name="eliminarUsuarioEmail" id="eliminarUsuarioEmail">
                    </form>
                    <span class="boton" id="btnFormEliminarUsuario">Eliminar Usuario</span>
                    <span class="btnCerrarModal boton">Cerrar</span>
                </div>
            </section>
            <span class="boton" id="btnModificarUsuario">Modificar</span>
            <section class="modalModificarUsuario">
                <div id="contenedorModificarUsuario">
                    <h1>Modificar Información del Usuario</h1>
                    <span class="aclaracion">Sólo ingresa la información en los campos que quieras modificar. Si un
                        campo se debe quedar igual, no ingreses nada</span>
                    <form id="formularioModificarUsuario">
                        <span>Email:</span>
                        <input type="email" name="modificarUsuarioEmail" id="modificarUsuarioEmail">
                        <span>Nombre(s):</span>
                        <input type="text" name="modificarUsuarioNombre" id="modificarUsuarioNombre">
                        <span>Apellidos:</span>
                        <input type="text" name="modificarUsuarioApellido" id="modificarUsuarioApellido">
                        <span>Calle y Número:</span>
                        <input type="text" name="modificarUsuarioCalleNumero" id="modificarUsuarioCalleNumero">
                        <span>Colonia:</span>
                        <input type="text" name="modificarUsuarioColonia" id="modificarUsuarioColonia">
                        <span>Municipio:</span>
                        <input type="text" name="modificarUsuarioMunicipio" id="modificarUsuarioMunicipio">
                        <span title="Mayúscula, Minúscula, Número, Símbolo, Ocho caracteres">Contraseña: ?</span>
                        <input type="password" name="modificarUsuarioPassword" id="modificarUsuarioPassword">
                    </form>
                    <span class="boton" id="btnFormModificarUsuario">Modificar Usuario</span>
                    <span class="btnCerrarModal boton">Cerrar</span>
                </div>
            </section>
            <span class="boton" id="btnAgregarUsuario">Agregar</span>
            <section class="modalAgregarUsuario">
                <div id="contenedorAgregarUsuario">
                    <h1>Agregar Usuario</h1>
                    <form id="formularioAgregarUsuario">
                        <span>Email:</span>
                        <input type="email" name="agregarUsuarioEmail" id="agregarUsuarioEmail">
                        <span>Nombre(s):</span>
                        <input type="text" name="agregarUsuarioNombre" id="agregarUsuarioNombre">
                        <span>Apellidos:</span>
                        <input type="text" name="agregarUsuarioApellido" id="agregarUsuarioApellido">
                        <span>Calle y Número:</span>
                        <input type="text" name="agregarUsuarioCalleNumero" id="agregarUsuarioCalleNumero">
                        <span>Colonia:</span>
                        <input type="text" name="agregarUsuarioColonia" id="agregarUsuarioColonia">
                        <span>Municipio:</span>
                        <input type="text" name="agregarUsuarioMunicipio" id="agregarUsuarioMunicipio">
                        <span title="Mayúscula, Minúscula, Número, Símbolo, Ocho caracteres">Contraseña: ?</span>
                        <input type="password" name="agregarUsuarioPassword" id="agregarUsuarioPassword">
                    </form>
                    <span class="boton" id="btnFormAgregarUsuario">Agregar Usuario</span>
                    <span class="btnCerrarModal boton">Cerrar</span>
                </div>
            </section>
        </div>
        <span class="boton btnBitacora" onclick="window.location.href='bitacoraUsuarios.php'">Bitácora de Usuarios</span>
        <span class="boton" id="btnVolver">Volver</span>
    </main>
    <footer>
        <p>&copy; 2025 Vinilos Josue. Todos los derechos reservados.</p>
    </footer>
</body>

<script src="jsUsuarios.js"></script>

</html>