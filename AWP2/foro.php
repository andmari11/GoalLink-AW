<?php

session_start();
$titulo = 'Foro';
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
if (isset($_SESSION["login"])) {
    $contenido .= <<<EOS
                <h1>FORO</h1>
                
            EOS;
} else {
    $contenido .= <<<EOS
                <h1>FORO</h1>
                Inicie sesión para visualizar contenido exclusivo del foro: <a href='login.php'>Login</a>
                EOS;
}

require __DIR__.'/includes/Vistas/esqueleto.php';