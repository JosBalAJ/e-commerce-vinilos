<?php
session_start();

$tiempoInactividad = 900;

if (isset($_SESSION['ultimoAcceso'])) {
    $tiempoTranscurrido = time() - $_SESSION['ultimoAcceso'];

    if ($tiempoTranscurrido > $tiempoInactividad) {
        session_unset();
        session_destroy();
    }
}

$_SESSION['ultimoAcceso'] = time();

?>