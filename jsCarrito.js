document.addEventListener("DOMContentLoaded", function () {
    const contenedorContenedores = document.getElementById("mainResumen");
    contenedorContenedores.addEventListener("click", function (event) {
        if (event.target.classList.contains("btnAumentar")) {
            const botonesCantidad = event.target.closest(".botonesCantidad");
            const cantidad = parseInt(botonesCantidad.dataset.cantidad) + 1;
            const id_disco = botonesCantidad.dataset.id_disco;
            const precio_unitario = botonesCantidad.dataset.precio_unitario;

            const datosCantidad = new FormData();
            datosCantidad.append("cantidad", cantidad);
            datosCantidad.append("id_disco", id_disco);
            datosCantidad.append("precio_unitario", precio_unitario);

            fetch("cambiarCantidad.php", {
                method: "POST",
                body: datosCantidad
            })
                .then(response => response.text())
                .then(data => {
                    if (data == "carrito.php") {
                        window.location.href = data;
                    } else {
                        alert(data);
                    }
                })
                .catch(error => console.error("Error: ", error));
        }
        if (event.target.classList.contains("btnDisminuir")) {
            const botonesCantidad = event.target.closest(".botonesCantidad");
            const cantidad = parseInt(botonesCantidad.dataset.cantidad) - 1;
            const id_disco = botonesCantidad.dataset.id_disco;
            const precio_unitario = botonesCantidad.dataset.precio_unitario;

            const datosCantidad = new FormData();
            datosCantidad.append("cantidad", cantidad);
            datosCantidad.append("id_disco", id_disco);
            datosCantidad.append("precio_unitario", precio_unitario);

            fetch("cambiarCantidad.php", {
                method: "POST",
                body: datosCantidad
            })
                .then(response => response.text())
                .then(data => {
                    if (data == "carrito.php") {
                        window.location.href = data;
                    } else {
                        alert(data);
                    }
                })
                .catch(error => console.error("Error: ", error));
        }
        if (event.target.classList.contains("btnEliminarDisco")) {
            const contenedorEliminar = event.target.closest(".botonEliminar");
            const id_disco = contenedorEliminar.dataset.eliminar_id_disco;

            const datosEliminar = new FormData();
            datosEliminar.append("id_disco", id_disco);

            fetch("eliminarPedidoDisco.php", {
                method: "POST",
                body: datosEliminar
            })
                .then(response => response.text())
                .then(data => {
                    if (data == "carrito.php") {
                        window.location.href = data;
                    } else {
                        alert(data);
                    }
                })
                .catch(error => console.error("Error: ", error));
        }
    })
})

const btnVolver = document.getElementById("btnVolver");
btnVolver.addEventListener("click", () => {
    window.location.href = "index.php";
})

const btnRecibo = document.getElementById("btnRecibo");
btnRecibo.addEventListener("click", () => {
    fetch("pedido.php")
        .then(response => response.text())
        .then(data => {
            if (data == "carrito.php") {
                alert("Exito! Confirmación enviada por correo");
                window.location.href = data;
            } else if (data == "") {
                alert ("Vacío");
            } else {
                alert(data);
                window.location.href = "carrito.php";
            }
        })
        .catch(error => console.error("Error: ", error));
})