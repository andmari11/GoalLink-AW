<?php

session_start();

$titulo = 'Index';



$contenido = '';
if (isset($_SESSION["login"]) && $_SESSION["rol"] == 'a'){

    $contenido .= <<<EOS
    <h2>HOME <button type="button">Editar</button></h2>
    <p> Noticias destacadas y foros destacados. </p>
EOS;
}
else{
    $contenido .= <<<EOS
    <h2>HOME</h2>
    <p> Noticias destacadas y foros destacados. </p>
EOS;

}


require __DIR__.'/includes/Vistas/esqueleto.php';
