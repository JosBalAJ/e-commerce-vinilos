const btnVolver = document.getElementById("btnVolver");
btnVolver.addEventListener("click", () => {
    window.location.href = "index.php";
})

const btnEliminarUsuario = document.getElementById("btnEliminarUsuario");
const modalEliminarUsuario = document.querySelector(".modalEliminarUsuario");
const btnModificarUsuario = document.getElementById("btnModificarUsuario");
const modalModificarUsuario = document.querySelector(".modalModificarUsuario");
const btnAgregarUsuario = document.getElementById("btnAgregarUsuario");
const modalAgregarUsuario = document.querySelector(".modalAgregarUsuario");
const btnCerrarModal = document.querySelectorAll(".btnCerrarModal");

btnEliminarUsuario.addEventListener("click", () => {
    modalEliminarUsuario.classList.add("mostrarModal");
})
btnModificarUsuario.addEventListener("click", () => {
    modalModificarUsuario.classList.add("mostrarModal");
})
btnAgregarUsuario.addEventListener("click", () => {
    modalAgregarUsuario.classList.add("mostrarModal");
})
btnCerrarModal.forEach(boton => {
    boton.addEventListener("click", () => {
        modalEliminarUsuario.classList.remove("mostrarModal");
        modalModificarUsuario.classList.remove("mostrarModal");
        modalAgregarUsuario.classList.remove("mostrarModal");
    })
});

const btnFormAgregarUsuario = document.getElementById("btnFormAgregarUsuario");
btnFormAgregarUsuario.addEventListener("click", () => {
    const formularioAgregarUsuario = document.getElementById("formularioAgregarUsuario");
    const email = document.getElementById("agregarUsuarioEmail").value.trim();
    const nombre = document.getElementById("agregarUsuarioNombre").value.trim();
    const apellido = document.getElementById("agregarUsuarioApellido").value.trim();
    const calleNumero = document.getElementById("agregarUsuarioCalleNumero").value.trim();
    const colonia = document.getElementById("agregarUsuarioColonia").value.trim();
    const municipio = document.getElementById("agregarUsuarioMunicipio").value.trim();
    const password = document.getElementById("agregarUsuarioPassword").value.trim();

    document.body.style.cursor = "wait";

    if (nombre == "" || apellido == "" || email == "" || password == "" || calleNumero == "" || colonia == "" || municipio == "") {
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

    const datosformularioAgregarUsuario = new FormData(formularioAgregarUsuario);

    fetch("registroUsuarioAdmin.php", {
        method: "POST",
        body: datosformularioAgregarUsuario
    })
        .then(response => response.text())
        .then(data => {
            document.body.style.cursor = "default";
            if (data == "usuarios.php" || data == "index.php") {
                setTimeout(function () {
                    window.location.href = data;
                }, 500);
            } else {
                alert(data);
            }
        })
        .catch(error => console.error("Error: ", error));
})

const btnFormModificarUsuario = document.getElementById("btnFormModificarUsuario");
btnFormModificarUsuario.addEventListener("click", () => {
    const formularioModificarUsuario = document.getElementById("formularioModificarUsuario");
    const email = document.getElementById("modificarUsuarioEmail").value.trim();
    const nombre = document.getElementById("modificarUsuarioNombre").value.trim();
    const apellido = document.getElementById("modificarUsuarioApellido").value.trim();
    const calleNumero = document.getElementById("modificarUsuarioCalleNumero").value.trim();
    const colonia = document.getElementById("modificarUsuarioColonia").value.trim();
    const municipio = document.getElementById("modificarUsuarioMunicipio").value.trim();
    const password = document.getElementById("modificarUsuarioPassword").value.trim();

    document.body.style.cursor = "wait";

    if (email == "") {
        alert("Ingresa un Email");
        document.body.style.cursor = "default";
        return;
    }

    if (password != "") {
        const testPassword = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&.,/#])[A-Za-z\d@$!%*?&.,/#]{8,}$/;
        if (!testPassword.test(password)) {
            alert("La contraseña no cumple con los requisitos");
            document.body.style.cursor = "default";
            return;
        }
    }

    const datosformularioModificarUsuario = new FormData(formularioModificarUsuario);

    fetch("modificarUsuarioAdmin.php", {
        method: "POST",
        body: datosformularioModificarUsuario
    })
        .then(response => response.text())
        .then(data => {
            document.body.style.cursor = "default";
            if (data == "usuarios.php" || data == "index.php") {
                setTimeout(function () {
                    window.location.href = data;
                }, 500);
            } else {
                alert(data);
            }
        })
        .catch(error => console.error("Error: ", error));
})

const btnFormEliminarUsuario = document.getElementById("btnFormEliminarUsuario");
btnFormEliminarUsuario.addEventListener("click", () => {
    const formularioEliminarUsuario = document.getElementById("formularioEliminarUsuario");
    const email = document.getElementById("eliminarUsuarioEmail").value.trim();

    document.body.style.cursor = "wait";

    if (email == "") {
        alert("Debes ingresar un Email");
        document.body.style.cursor = "default";
        return;
    }

    const datosformularioEliminarUsuario = new FormData(formularioEliminarUsuario);

    fetch("eliminarUsuarioAdmin.php", {
        method: "POST",
        body: datosformularioEliminarUsuario
    })
        .then(response => response.text())
        .then(data => {
            document.body.style.cursor = "default";
            if (data == "usuarios.php" || data == "index.php") {
                setTimeout(function () {
                    window.location.href = data;
                }, 500);
            } else {
                alert(data);
            }
        })
        .catch(error => console.error("Error: ", error));
})