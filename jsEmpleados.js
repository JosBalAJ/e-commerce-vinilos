// REGISTRAR EMPLEADO
const btnEmplRegistrarse = document.querySelector("#btnEmplRegistrarse");
btnEmplRegistrarse.addEventListener("click", () => {
    const formEmplRegistrarse = document.getElementById("formEmplRegistrarse");
    const nombre = document.getElementById("empleadoNombre").value.trim();
    const apellido = document.getElementById("empleadoApellidos").value.trim();
    const email = document.getElementById("empleadoEmail").value.trim();
    const password = document.getElementById("empleadoPassword").value.trim();
    const select = document.getElementById("empleadoTienda");
    const tienda = select.value;

    document.body.style.cursor = "wait";

    if (nombre == "" || apellido == "" || email == "" || password == "" || tienda == "") {
        alert("Parece que hay un campo vacío...");
        document.body.style.cursor = "default";
        return;
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        alert("Parece que el correo es incorrecto...");
        document.body.style.cursor = "default";
        return;
    }
    const testPassword = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&.,/#])[A-Za-z\d@$!%*?&.,/#]{8,}$/;
    if (!testPassword.test(password)) {
        alert("La contraseña no cumple con los requisitos");
        document.body.style.cursor = "default";
        return;
    }

    const datosFormularioEmpleadosRegistrarse = new FormData(formEmplRegistrarse);

    fetch("registroEmpleado.php", {
        method: "POST",
        body: datosFormularioEmpleadosRegistrarse
    })
        .then(response => response.text())
        .then(data => {
            document.body.style.cursor = "default";
            if (data == "index.php") {
                setTimeout(function () {
                    window.location.href = data;
                }, 500);
            } else {
                alert(data);
            }
        })
        .catch(error => console.error("Error: ", error));
})

// INICIAR SESION EMPLEADO
const btnEmplIniciarSesion = document.getElementById("btnEmplIniciarSesion");
btnEmplIniciarSesion.addEventListener("click", () => {
    const formEmplIniciarSesion = document.getElementById("formEmplIniciarSesion");
    const email = document.getElementById("empleadoEmailIniSes").value.trim();
    const password = document.getElementById("empleadoPasswordIniSes").value.trim();

    document.body.style.cursor = "wait";

    if (email == "" || password == "") {
        alert("Parece que hay un campo vacío...");
        document.body.style.cursor = "default";
        return;
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        alert("Parece que el correo es incorrecto...");
        document.body.style.cursor = "default";
        return;
    }

    const datosFormularioEmpleadosIniciarSesion = new FormData(formEmplIniciarSesion);

    fetch("iniciarSesionEmpleado.php", {
        method: "POST",
        body: datosFormularioEmpleadosIniciarSesion
    })
        .then(response => response.text())
        .then(data => {
            document.body.style.cursor = "default";
            if (data == "index.php") {
                setTimeout(function () {
                    window.location.href = data;
                }, 500);
            } else {
                alert(data);
            }
        })
        .catch(error => console.error("Error: ", error));
})
