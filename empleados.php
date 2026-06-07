<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="stylesEmpleados.css">
    <title>Vinilos Josue - Empleados</title>
</head>

<body>
    <header>
        <img class="logo" src="img/Vinilo Logo.jpg" alt="Vinilo Logo">
        <h1>Empleados Vinilos Josue</h1>
        <img class="logo" src="img/Vinilo Logo.jpg" alt="Vinilo Logo">
    </header>
    <main>
        <div class="formularioEmpleado">
            <h2>Iniciar Sesión de Empleado</h2>
            <form id="formEmplIniciarSesion">
                <span>Email:</span>
                <input type="email" name="empleadoEmailIniSes" id="empleadoEmailIniSes">
                <span>Contraseña:</span>
                <input type="password" name="empleadoPasswordIniSes" id="empleadoPasswordIniSes">
                <span class="boton" id="btnEmplIniciarSesion">Iniciar Sesión</span>
            </form>
        </div>
        <div class="formularioEmpleado">
            <h2>Registrarse Como Nuevo Empleado</h2>
            <form id="formEmplRegistrarse">
                <span>Nombre(s):</span>
                <input type="text" name="empleadoNombre" id="empleadoNombre">
                <span>Apellidos:</span>
                <input type="text" name="empleadoApellidos" id="empleadoApellidos">
                <span>Email:</span>
                <input type="email" name="empleadoEmail" id="empleadoEmail">
                <span>Contraseña:</span>
                <input type="password" name="empleadoPassword" id="empleadoPassword">
                <span>Tienda:</span>
                <select name="empleadoTienda" id="empleadoTienda">
                    <option value="">Seleccionar</option>
                    <option value="1">Catedral</option>
                    <option value="2">Rotonda</option>
                    <option value="3">Normal</option>
                </select>
                <span class="boton" id="btnEmplRegistrarse">Registrarse</span>
            </form>
        </div>
        <span class="boton" onclick="window.location.href='index.php'">Volver</span>
    </main>
    <footer>
        <p>&copy; 2025 Vinilos Josue. Todos los derechos reservados.</p>
    </footer>
</body>

<script src="jsEmpleados.js"></script>

</html>