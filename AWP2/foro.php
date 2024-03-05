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
    if($_SESSION["rol"] == 'a' || $_SESSION["rol"] == 'm' ){
        $contenido .= <<<EOS
        <h1>FORO <button type="button">Editar</button></h1>
        <p>Todos los foros </p<
        EOS;
    }
    else{
        $contenido .= <<<EOS
        <h1>FORO</h1>
        <p>Foros suscritos y foros destacados. </p<
        EOS;
    
    }
} else {
    $contenido .= <<<EOS
                <h1>FORO</h1>
                Inicie sesión para visualizar contenido exclusivo del foro: <a href='login.php'>Login</a>
                EOS;
}

require __DIR__.'/includes/Vistas/esqueleto.php';