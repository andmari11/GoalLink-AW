<?php

session_start();

$titulo = "Administración";
if (($_SESSION["rol"])=='a') {

    $contenido = <<<EOS
    <h1>Panel de Administración</h1>
    <p> Bienvenido. </p>
EOS;
} else {
    echo "El valor de 'rol' en la sesión es: " . $_SESSION["rol"];

    $contenido = <<<EOS
    <h1>Panel de Administración  </h1>
    <p> ACCESO DENEGADO. </p>
EOS;

}



require __DIR__ . '/includes/Vistas/esqueleto.php';







