<?php

session_start();
$titulo = 'Foro';


$contenido = '';
if (isset($_SESSION["login"])) {
    if($_SESSION["rol"] == 'a' || $_SESSION["rol"] == 'm' ){
        $contenido .= <<<EOS
        <h2>FORO <button type="button">Editar</button></h2>
        <p>Todos los foros</p>
        EOS;
    }
    else{
        $contenido .= <<<EOS
        <h2>FORO</h2>
        <p>Foros suscritos y foros destacados.</p>
        EOS;
    
    }
} else {
    $contenido .= <<<EOS
                <h2>FORO</h2>
                <p>Inicie sesión para visualizar contenido exclusivo del foro: <a href='login.php'>Login</a></p>
                EOS;
}

require __DIR__.'/includes/Vistas/esqueleto.php';