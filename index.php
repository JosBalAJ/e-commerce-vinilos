<?php
require 'controlSesion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Vinilos Josue</title>
</head>

<body>
    <?php
    $loginMode = 0; //No Loggeado->0 / Loggeado como Usuario->1 / Loggeado como Empleado->2
    if (isset($_SESSION['nombre']) && isset($_SESSION['email'])) {
        $usuario = $_SESSION['nombre'];
        $email = $_SESSION['email'];
        $loginMode = 1;
    } elseif (isset($_SESSION['nombre_empleado']) && isset($_SESSION['email_empleado'])) {
        $usuario = $_SESSION['nombre_empleado'];
        $email = $_SESSION['email_empleado'];
        $loginMode = 2;
    }

    ?>
    <header>
        <img class="logo" src="img/Vinilo Logo.jpg" alt="Logo">
        <h1>Vinilos Josue</h1>
        <?php
        if ($loginMode == 0) {
            echo '<div id="botonesHeader">
            <div id="botonesUsuario">
                <span class="boton btnIniciarSesion">Iniciar Sesión</span>
                <section class="modalIniciarSesion">
                    <div id="contenedorIniciarSesion">
                        <h1>Iniciar Sesión</h1>
                        <form id="formularioIniciarSesion">
                            <span>Email:</span>
                            <input type="email" name="emailIniciarSesion" id="emailIniciarSesion" required>
                            <span>Contraseña:</span>
                            <input type="password" name="passwordIniciarSesion" id="passwordIniciarSesion" required>
                            <span class="boton" id="btnIngresar">Ingresar</span>
                        </form>
                        <span class="boton btnCerrarModal">Cerrar</span>
                    </div>
                </section>
                <span id="btnRegistrarse" class="boton">Registrarse</span>
                <section class="modalRegistrarse">
                    <div id="contenedorRegistrarse">
                        <h1>Registrarse</h1>
                        <form id="formularioRegistrarse">
                            <span>Nombre(s):</span>
                            <input type="text" name="nombreRegistrarse" id="nombreRegistrarse" required>
                            <span>Apellidos:</span>
                            <input type="text" name="apellidosRegistrarse" id="apellidosRegistrarse" required>
                            <span>Calle y Número:</span>
                            <input type="text" name="calleRegistrarse" id="calleRegistrarse" required>
                            <span>Colonia:</span>
                            <input type="text" name="coloniaRegistrarse" id="coloniaRegistrarse">
                            <span>Municipio:</span>
                            <input type="text" name="municipioRegistrarse" id="municipioRegistrarse">
                            <span>Email:</span>
                            <input type="email" name="emailRegistrarse" id="emailRegistrarse" required>
                            <span title="Mayúscula, Minúscula, Número, Símbolo, Ocho caracteres">Contraseña: ?</span>
                            <input type="password" name="passwordRegistrarse" id="passwordRegistrarse" required>
                            <span class="boton" id="btnFormularioRegistrarse">Registrarse</span>
                        </form>
                        <span class="btnCerrarModal boton">Cerrar</span>
                    </div>
                </section>
            </div>
            <div>
                <a href="empleados.php">¿Eres un empleado?</a>
            </div>
            
        </div>';
        } else {
            echo '<div>
                    <h1 id="saludo">' . $usuario . '</h1>
                    <span class="boton" id="btnCerrarSesion" onclick="window.location.href=' . "'cerrarSesion.php'" . '">Cerrar Sesión</span>
                  </div>';
        }
        ?>
    </header>
    <main>
        <h1 id="slogan">MÚSICA MODERNA AL MODO CLÁSICO</h1>
        <?php
        if ($loginMode == 0) {
            echo '<div id="misionVision">
                    <section class="card">
                        <p>Ofrecer una selección única de discos de vinilo de artistas nuevos, que combine
                            la nostalgia de lo analógico con la emoción de descubrir música fresca y de calidad.</p>
                        <div class="tituloCard">
                            <h2>Misión</h2>
                        </div>
                    </section>
                    <section class="card">
                        <p>Ser la tienda online líder en vinilos, brindando a los amantes de la música una
                            experiencia auténtica de coleccionismo, con envíos rápidos y atención al cliente personalizada.</p>
                        <div class="tituloCard">
                            <h2>Visión</h2>
                        </div>
                    </section>
                </div>

                <h2>!Ponte en contacto con nosotros!</h2>
                <section id="contacto">
                    <div id="infoContacto">
                        <p><strong>Háblanos</strong></p>
                        <p><strong>Dirección: </strong>Av. Fray Antonio Alcalde 10, Zona Centro, 44100 Guadalajara, Jal.</p>
                        <p><strong>Correo electrónico: </strong><a href="mailto:a23310162@ceti.mx">a23310162@ceti.mx</a></p>
                        <p><strong>Teléfono: </strong>33 3552 6989</p>
                    </div>
                    <div id="mapa">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3732.8111625469405!2d-103.3453497505735!3d20.67726026330869!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8428b1faa928f63f%3A0x25dcb2cdab10691a!2sCatedral%20de%20Guadalajara%20(Catedral%20Bas%C3%ADlica%20de%20la%20Asunci%C3%B3n%20de%20Mar%C3%ADa%20Sant%C3%ADsima)!5e0!3m2!1ses!2smx!4v1739379100858!5m2!1ses!2smx"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </section>
                <span id="btnVamosComprar" class="btnIniciarSesion">¡Vamos a comprar!</span>';
        } else {

            echo '<div id="filas">';
            require 'conexion.php';

            $sql = "SELECT * FROM discos";
            $discos = $conexion->query($sql);

            if ($discos->num_rows > 0) {
                while ($fila = $discos->fetch_assoc()) {
                    echo '<div class="contenedorDiscos" data-id_disco="' . $fila['id_disco'] . '" data-precio_unitario="' . $fila['precio'] . '" data-email="' . $email . '">
                            <img title="' . $fila['descripcion'] . '" src="' . $fila['imagen'] . '" alt="' . $fila['album'] . '">
                            <h2 class="discoAlbum">' . $fila['album'] . '</h2>
                            <h3 class="discoArtista">' . $fila['artista'] . '</h3>
                            <div class="discoGeneroContenedor">';
                    $generos = explode(',', $fila['genero']);
                    foreach ($generos as $genero) {
                        echo '<h5 class="discoGenero">' . trim($genero) . '</h5>';
                    }
                    echo '</div>
                            <h2 class="discoPrecio">$' . $fila['precio'] . ' MXN</h2>';
                    if ($loginMode == 1) {
                        echo '<span class="btnAlCarrito boton">Añadir al Carrito</span>';
                    }
                    if ($loginMode == 2) {
                        echo '<h4>ID del Disco: ' . $fila['id_disco'] . '</h3>
                                    <h4>Stock: ' . $fila['stock'] . '</h3>';
                    }
                    echo '</div>';
                }
            }
            if ($loginMode == 2) {
                echo '<div class="contenedorDiscos" id="btnAgregarDisco">
                            <img src="img/agregar.png">
                            <h3>Agregar Disco</h3>
                        </div>
                        <section class="modalAgregarDisco">
                            <div id="contenedorAgregarDiscco">
                                <h1>Agregar Disco</h1>
                                <form id="formularioAgregarDisco">
                                    <span>Album:</span>
                                    <input type="text" name="agregarAlbum" id="agregarAlbum">
                                    <span>Artista:</span>
                                    <input type="text" name="agregarArtista" id="agregarArtista">
                                    <span>Precio:</span>
                                    <input type="number" name="agregarPrecio" id="agregarPrecio">
                                    <span>Descripción:</span>
                                    <input type="text" name="agregarDescripcion" id="agregarDescripcion">
                                    <span>Imagen:</span>
                                    <input type="file" name="agregarImagen" id="agregarImagen" accept="image/*">
                                    <span>Cantidad en Stock:</span>
                                    <input type="number" name="agregarStock" id="agregarStock">
                                    <span class="spanGenero" id="spanGenAgregar">Géneros:</span>
                                    <div class="contenedorGeneros" id="contGenAgregar">
                                        <input type="checkbox" id="opc1" class="inputCheckbox agregarGenero" value="Hip Hop">
                                        <label for="opc1" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Hip Hop</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opc2" class="inputCheckbox agregarGenero" value="Rap">
                                        <label for="opc2" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Rap</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opc3" class="inputCheckbox agregarGenero" value="Jazz">
                                        <label for="opc3" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Jazz</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opc4" class="inputCheckbox agregarGenero" value="Soul">
                                        <label for="opc4" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Soul</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opc5" class="inputCheckbox agregarGenero" value="Musical">
                                        <label for="opc5" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Musical</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opc6" class="inputCheckbox agregarGenero" value="R&B">
                                        <label for="opc6" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">R&B</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opc7" class="inputCheckbox agregarGenero" value="Rock Alternativo">
                                        <label for="opc7" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Rock Alternativo</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opc8" class="inputCheckbox agregarGenero" value="Experimental">
                                        <label for="opc8" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Experimental</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opc9" class="inputCheckbox agregarGenero" value="Pop Alternativo">
                                        <label for="opc9" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Pop Alternativo</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opc10" class="inputCheckbox agregarGenero" value="Electropop">
                                        <label for="opc10" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Electropop</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opc11" class="inputCheckbox agregarGenero" value="Dream Pop">
                                        <label for="opc11" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Dream Pop</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opc12" class="inputCheckbox agregarGenero" value="Indie Rock">
                                        <label for="opc12" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Indie Rock</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opc13" class="inputCheckbox agregarGenero" value="Electrónica">
                                        <label for="opc13" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Electrónica</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opc14" class="inputCheckbox agregarGenero" value="Clásica">
                                        <label for="opc14" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Clásica</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opc15" class="inputCheckbox agregarGenero" value="Rock">
                                        <label for="opc15" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Rock</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opc16" class="inputCheckbox agregarGenero" value="Regional">
                                        <label for="opc16" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Regional</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opc17" class="inputCheckbox agregarGenero" value="Pop">
                                        <label for="opc17" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Pop</div>
                                            </div>
                                        </label>
                                    </div>
                                </form>
                                <span class="boton" id="btnFormAgregarDisco">Agregar Disco</span>
                                <span class="btnCerrarModal boton">Cerrar</span>
                            </div>
                        </section>
                        <div class="contenedorDiscos" id="btnEliminarDisco">
                            <img src="img/borrar.png">
                            <h3>Eliminar Disco</h3>
                        </div>
                        <section class="modalEliminarDisco">
                            <div id="contenedorEliminarDiscco">
                                <h1>Eliminar Disco</h1>
                                <form id="formularioEliminarDisco">
                                    <span>ID del Disco:</span>
                                    <input type="number" name="eliminarID" id="eliminarID">
                                </form>
                                <span class="boton" id="btnFormEliminarDisco">Eliminar Disco</span>
                                <span class="btnCerrarModal boton">Cerrar</span>
                            </div>
                        </section>
                        <div class="contenedorDiscos" id="btnModificarDisco">
                            <img src="img/editar.png">
                            <h3>Modificar Disco</h3>
                        </div>
                        <section class="modalModificarDisco">
                            <div id="contenedorModificarDiscco">
                                <h1>Modificar Información del Disco</h1>
                                <span class="aclaracion">Sólo ingresa la información en los campos que quieras modificar. Si un campo se debe quedar igual, no ingreses nada</span>
                                <form id="formularioModificarDisco">
                                    <span>ID del Disco:</span>
                                    <input type="number" name="modificarID" id="modificarID">
                                    <span>Album:</span>
                                    <input type="text" name="modificarAlbum" id="modificarAlbum">
                                    <span>Artista:</span>
                                    <input type="text" name="modificarArtista" id="modificarArtista">
                                    <span>Precio:</span>
                                    <input type="number" name="modificarPrecio" id="modificarPrecio">
                                    <span>Descripción:</span>
                                    <input type="text" name="modificarDescripcion" id="modificarDescripcion">
                                    <span>Imagen:</span>
                                    <input type="file" name="modificarImagen" id="modificarImagen" accept="image/*">
                                    <span>Cantidad en Stock:</span>
                                    <input type="number" name="modificarStock" id="modificarStock">
                                    <span class="spanGenero" id="spanGenModificar">Géneros:</span>
                                    <div class="contenedorGeneros" id="contGenModificar">
                                        <input type="checkbox" id="opcion1" class="inputCheckbox modificarGenero" value="Hip Hop">
                                        <label for="opcion1" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Hip Hop</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opcion2" class="inputCheckbox modificarGenero" value="Rap">
                                        <label for="opcion2" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Rap</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opcion3" class="inputCheckbox modificarGenero" value="Jazz">
                                        <label for="opcion3" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Jazz</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opcion4" class="inputCheckbox modificarGenero" value="Soul">
                                        <label for="opcion4" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Soul</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opcion5" class="inputCheckbox modificarGenero" value="Musical">
                                        <label for="opcion5" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Musical</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opcion6" class="inputCheckbox modificarGenero" value="R&B">
                                        <label for="opcion6" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">R&B</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opcion7" class="inputCheckbox modificarGenero" value="Rock Alternativo">
                                        <label for="opcion7" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Rock Alternativo</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opcion8" class="inputCheckbox modificarGenero" value="Experimental">
                                        <label for="opcion8" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Experimental</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opcion9" class="inputCheckbox modificarGenero" value="Pop Alternativo">
                                        <label for="opcion9" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Pop Alternativo</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opcion10" class="inputCheckbox modificarGenero" value="Electropop">
                                        <label for="opcion10" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Electropop</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opcion11" class="inputCheckbox modificarGenero" value="Dream Pop">
                                        <label for="opcion11" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Dream Pop</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opcion12" class="inputCheckbox modificarGenero" value="Indie Rock">
                                        <label for="opcion12" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Indie Rock</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opcion13" class="inputCheckbox modificarGenero" value="Electrónica">
                                        <label for="opcion13" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Electrónica</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opcion14" class="inputCheckbox modificarGenero" value="Clásica">
                                        <label for="opcion14" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Clásica</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opcion15" class="inputCheckbox modificarGenero" value="Rock">
                                        <label for="opcion15" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Rock</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opcion16" class="inputCheckbox modificarGenero" value="Regional">
                                        <label for="opcion16" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Regional</div>
                                            </div>
                                        </label>
                                        <input type="checkbox" id="opcion17" class="inputCheckbox modificarGenero" value="Pop">
                                        <label for="opcion17" class="contenedorCheckbox">
                                            <div class="checkbox">
                                                <div class="textoGenero">Pop</div>
                                            </div>
                                        </label>
                                    </div>
                                </form>
                                <span class="boton" id="btnFormModificarDisco">Modificar Disco</span>
                                <span class="btnCerrarModal boton">Cerrar</span>
                            </div>
                        </section>
                    </div>
                    <div class="extras">
                        <span class="boton btnBitacora" onclick="window.location.href=\'bitacoraDiscos.php\';">Bitácora de Discos</span>
                    </div>
                    <div class="extras">
                        <span class="boton btnUsuarios" onclick="window.location.href=\'usuarios.php\';">Usuarios</span>
                    </div>
                ';
            }
            echo '</main>';
        }

        if ($loginMode == 1) {
            echo '<div id="carrito" onclick="window.location.href=\'carrito.php\';">
                    <img src="img/carrito.png" alt="Carrito">
                </div>';
        }

        ?>

        <footer>
            <p>&copy; 2025 Vinilos Josue. Todos los derechos reservados.</p>
        </footer>
</body>

<script src="javascript.js"></script>
<script src="jsEmpleado.js"></script>

</html>