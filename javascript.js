const btnIiniciarSesion = document.querySelectorAll(".btnIniciarSesion");
const modalIiciarSesion = document.querySelector(".modalIniciarSesion");
const btnRegistrarse = document.querySelector("#btnRegistrarse");
const modalRegistrarse = document.querySelector(".modalRegistrarse");
const btnCerrarModal = document.querySelectorAll(".btnCerrarModal");

document.addEventListener("DOMContentLoaded", function () {
    // AGREGAR AL CARRITO
    const contenedorContenedores = document.getElementById("filas");
    contenedorContenedores.addEventListener("click", function (event) {
        if (event.target.classList.contains("btnAlCarrito")) {
            const disco = event.target.closest(".contenedorDiscos");
            const id_disco = disco.dataset.id_disco;
            const precio_unitario = disco.dataset.precio_unitario;
            const email = disco.dataset.email;

            const datosProductoPedido = new FormData();
            datosProductoPedido.append("id_disco", id_disco);
            datosProductoPedido.append("precio_unitario", precio_unitario);
            datosProductoPedido.append("email", email);

            fetch("procesarPedidoDisco.php", {
                method: "POST",
                body: datosProductoPedido
            })
                .then(response => response.text())
                .then(data => {
                    if (data == "index.php") {
                        window.location.href = data;
                    } else {
                        alert(data);
                    }
                })
                .catch(error => console.error("Error: ", error));
        }
    })

    const btnAgregarDisco = document.getElementById("btnAgregarDisco");
    const btnEliminarDisco = document.getElementById("btnEliminarDisco");
    const btnModificarDisco = document.getElementById("btnModificarDisco");
    const modalAgregarDisco = document.querySelector(".modalAgregarDisco");
    const modalEliminarDisco = document.querySelector(".modalEliminarDisco");
    const modalModificarDisco = document.querySelector(".modalModificarDisco");
    const btnCerrarModal = document.querySelectorAll(".btnCerrarModal");

    btnAgregarDisco.addEventListener("click", () => {
        modalAgregarDisco.classList.add("mostrarModal");
    })
    btnEliminarDisco.addEventListener("click", () => {
        modalEliminarDisco.classList.add("mostrarModal");
    })
    btnModificarDisco.addEventListener("click", () => {
        modalModificarDisco.classList.add("mostrarModal");
    })
    btnCerrarModal.forEach(boton => {
        boton.addEventListener("click", () => {
            modalAgregarDisco.classList.remove("mostrarModal");
            modalEliminarDisco.classList.remove("mostrarModal");
            modalModificarDisco.classList.remove("mostrarModal");
        })
    })

    // AGREGAR DISCO
    const btnFormAgregarDisco = document.getElementById("btnFormAgregarDisco");
    btnFormAgregarDisco.addEventListener("click", () => {
        const formularioAgregarDisco = document.getElementById("formularioAgregarDisco");
        const album = document.getElementById("agregarAlbum").value.trim();
        const artista = document.getElementById("agregarArtista").value.trim();
        let generosMarcados = document.querySelectorAll('.agregarGenero:checked');
        let generosSeleccionados = Array.from(generosMarcados).map(checkbox => checkbox.value);
        const precio = document.getElementById("agregarPrecio").value.trim();
        const descripion = document.getElementById("agregarDescripcion").value.trim();
        const imagen = document.getElementById("agregarImagen").files[0];
        const stock = document.getElementById("agregarStock").value.trim();

        document.body.style.cursor = "wait";

        if (album == "" || artista == "" || precio == "" || precio < 1 || descripion == "" || !imagen || stock == "" || stock < 1 || generosSeleccionados.length === 0) {
            alert("Parece que hay un valor no válido...");
            document.body.style.cursor = "default";
            return;
        }

        const datosformularioAgregarDisco = new FormData(formularioAgregarDisco);

        generosSeleccionados.forEach(genero => {
            datosformularioAgregarDisco.append("generos[]", genero);
        })

        datosformularioAgregarDisco.append("imagen", imagen);

        fetch("registroDisco.php", {
            method: "POST",
            body: datosformularioAgregarDisco
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
                    console.log(data);
                }
            })
            .catch(error => console.error("Error: ", error));
    })

    // ELIMINAR DISCO
    const btnFormEliminarDisco = document.getElementById("btnFormEliminarDisco");
    btnFormEliminarDisco.addEventListener("click", () => {
        const formularioEliminarDisco = document.getElementById("formularioEliminarDisco");
        const id_disco = document.getElementById("eliminarID").value.trim();

        document.body.style.cursor = "wait";

        if (id_disco == "") {
            alert("Debes ingresar un ID");
            document.body.style.cursor = "default";
            return;
        }

        const datosformularioEliminarDisco = new FormData(formularioEliminarDisco);

        fetch("eliminarDisco.php", {
            method: "POST",
            body: datosformularioEliminarDisco
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

    // MODIFICAR DISCO
    const btnFormModificarDisco = document.getElementById("btnFormModificarDisco");
    btnFormModificarDisco.addEventListener("click", () => {
        const formularioModificarDisco = document.getElementById("formularioModificarDisco");
        const id_disco = document.getElementById("modificarID").value.trim();
        const album = document.getElementById("agregarAlbum").value.trim();
        const artista = document.getElementById("agregarArtista").value.trim();
        let generosMarcados = document.querySelectorAll('.modificarGenero:checked');
        let generosSeleccionados = Array.from(generosMarcados).map(checkbox => checkbox.value);
        const precio = document.getElementById("agregarPrecio").value.trim();
        const descripion = document.getElementById("agregarDescripcion").value.trim();
        const imagen = document.getElementById("modificarImagen").files[0];
        const stock = document.getElementById("agregarStock").value.trim();

        document.body.style.cursor = "wait";

        if (id_disco == "") {
            alert("Ingresa un ID");
            document.body.style.cursor = "default";
            return;
        }

        const datosformularioModificarDisco = new FormData(formularioModificarDisco);

        if (generosMarcados.length != 0) {
            generosSeleccionados.forEach(genero => {
                datosformularioModificarDisco.append("generos[]", genero);
            })
        }

        datosformularioModificarDisco.append("imagen", imagen);

        fetch("modificarDisco.php", {
            method: "POST",
            body: datosformularioModificarDisco
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
})
btnIiniciarSesion.forEach(boton => {
    boton.addEventListener("click", () => {
        modalIiciarSesion.classList.add("mostrarModal");
    })
})
btnRegistrarse.addEventListener("click", () => {
    modalRegistrarse.classList.add("mostrarModal");
})
btnCerrarModal.forEach(boton => {
    boton.addEventListener("click", () => {
        modalIiciarSesion.classList.remove("mostrarModal");
        modalRegistrarse.classList.remove("mostrarModal");
    })
})

// REGISTRARSE
const btnFormularioRegistrarse = document.getElementById("btnFormularioRegistrarse");
btnFormularioRegistrarse.addEventListener("click", () => {
    const formularioRegistrarse = document.getElementById("formularioRegistrarse");
    const nombre = document.getElementById("nombreRegistrarse").value.trim();
    const apellido = document.getElementById("apellidosRegistrarse").value.trim();
    const calleNumero = document.getElementById("calleRegistrarse").value.trim();
    const colonia = document.getElementById("coloniaRegistrarse").value.trim();
    const municipio = document.getElementById("municipioRegistrarse").value.trim();
    const email = document.getElementById("emailRegistrarse").value.trim();
    const password = document.getElementById("passwordRegistrarse").value.trim();

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

    const datosFormularioRegistrarse = new FormData(formularioRegistrarse);

    fetch("registroUsuario.php", {
        method: "POST",
        body: datosFormularioRegistrarse
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

//INICIAR SESIÓN
const btnIngresar = document.getElementById("btnIngresar");
btnIngresar.addEventListener("click", () => {
    const formularioIngresar = document.getElementById("formularioIniciarSesion");
    const email = document.getElementById("emailIniciarSesion").value.trim();
    const password = document.getElementById("passwordIniciarSesion").value.trim();

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

    const datosFormularioIngresar = new FormData(formularioIngresar);

    fetch("iniciarSesion.php", {
        method: "POST",
        body: datosFormularioIngresar
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