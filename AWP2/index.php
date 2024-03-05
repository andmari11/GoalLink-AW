<?php

session_start();

$titulo = 'Index';

if(($_SESSION["rol"])=='a'){
    $barraIzq = <<<EOS
    <ul>
    <li><a href="index.php">Inicio</a></li>
    <li><a href="contenido.php">Ver contenido</a></li>
    <li><a href="foro.php">Foro</a></li>
    <li><a href="admin.php">Administrar</a></li>
    </ul>
    EOS;
}else {
    $barraIzq = <<<EOS
    <ul>
    <li><a href="index.php">Inicio</a></li>
    <li><a href="contenido.php">Ver contenido</a></li>
    <li><a href="foro.php">Foro</a></li>
    </ul>
    EOS;
}

$contenido = '';
if($_SESSION["rol"] == 'a'){
    $contenido .= <<<EOS
    <h1>HOME</h1>
    <p> Noticias destacadas y foros destacados. </p>
    <button type="button">Editar</button>
EOS;
}
else{
    $contenido .= <<<EOS
    <h1>HOME</h1>
    <p> Noticias destacadas y foros destacados. </p>
EOS;

}


require __DIR__.'/includes/Vistas/esqueleto.php';
