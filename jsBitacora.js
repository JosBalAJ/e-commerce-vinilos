function hayScrollbar(){
    const filas = document.querySelectorAll(".fila");

    filas.forEach(fila =>{
        if (fila.scrollHeight > fila.clientHeight){
            fila.classList.add("scrollbar");
        } else {
            fila.classList.remove("scrollbar");
        }
    })
}

window.addEventListener("load", hayScrollbar());
window.addEventListener("resize", hayScrollbar());

const btnVolver = document.getElementById("btnVolver");
btnVolver.addEventListener("click", ()=>{
    window.location.href = "index.php";
})