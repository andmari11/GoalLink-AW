<?php
    namespace es\ucm\fdi\aw\usuarios;

    require_once __DIR__.'/includes/config.php';

    $username= htmlspecialchars(trim(strip_tags($_REQUEST["usuario"])));
    $titulo = 'ProcesarDelete';

  
    if(($app->usuarioLogueado()) && ($app->esAdmin())){

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

    $params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
    $app->generaVista('/esqueleto.php', $params);
