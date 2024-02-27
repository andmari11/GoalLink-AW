<?php

session_start();

$titulo = 'Administrar';
if (isset($_SESSION["esAdmin"])) {


    $contenido = <<<EOS
    <h1>Panel de Administración</h1>
    <p> Bienvenido. </p>
EOS;
} else {
    $contenido = <<<EOS
    <h1>Panel de Administración</h1>
    <p> ACCESO DENEGADO. </p>
EOS;

}



require __DIR__ . '/includes/Vistas/esqueleto.php';







