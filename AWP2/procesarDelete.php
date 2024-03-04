<?php
    require "usuario.php";

    session_start();
    $username= htmlspecialchars(trim(strip_tags($_REQUEST["usuario"])));
    $titulo = 'ProcesarDelete';

    if(($_SESSION["rol"])=='a'){
        $barraIzq = <<<EOS
        <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="contenido.php">Ver contenido</a></li>
        <li><a href="contenido.php">Foro</a></li>
        <li><a href="admin.php">Administrar</a></li>
        </ul>
        EOS;
    }else {
        $barraIzq = <<<EOS
        <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="contenido.php">Ver contenido</a></li>
        <li><a href="admin.php">Foro</a></li>
        </ul>
        EOS;
    }
    
    if(Usuario::eliminarUsuario($username)){

        $contenido = <<<EOS
        <h1>Usuario eliminado: {$username} </h1>
        <b>Volver al <a href="admin.php">panel de administración</a>
        EOS;
    }
    else {
        $contenido = <<<EOS
        <h1>Usuario no eliminado: {$username} </h1>
        <b>Volver al <a href="admin.php">panel de administración</a>
        EOS;
    }



    require __DIR__.'/includes/Vistas/esqueleto.php';

?>