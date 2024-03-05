<?php

session_start();

$titulo = 'Index';



$contenido = '';
if($_SESSION["rol"] == 'a'){
    $contenido .= <<<EOS
    <h1>HOME <button type="button">Editar</button></h1>
    <p> Noticias destacadas y foros destacados. </p>
EOS;
}
else{
    $contenido .= <<<EOS
    <h1>HOME</h1>
    <p> Noticias destacadas y foros destacados. </p>
EOS;

}


require __DIR__.'/includes/Vistas/esqueleto.php';
