<?php
    require "includes/model/usuarioModel.php";

    session_start();
    $username= htmlspecialchars(trim(strip_tags($_REQUEST["usuario"])));
    $titulo = 'ProcesarDelete';

  
    if(($_SESSION["rol"])=='a'){

    if(Usuario::eliminarUsuario($username)){

        $contenido = <<<EOS
        <h2>Usuario eliminado: {$username} </h2>
        <b>Volver al <a href="admin.php">panel de administración</a>
        EOS;
    }
    else {
        $contenido = <<<EOS
        <h2>Usuario no eliminado: {$username} </h2>
        <b>Volver al <a href="admin.php">panel de administración</a></b>
        EOS;
    }

    }
    else{
        $contenido = <<<EOS
        <h2>Acceso denegado </h2>
        EOS;

    }

    require __DIR__.'/includes/Vistas/esqueleto.php';

