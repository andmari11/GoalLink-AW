<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios\FormularioLogout;
use es\ucm\fdi\aw\usuarios\Usuario;

function mostrarSaludo()
{
    $html = '';
    $app = Aplicacion::getInstance();
    if ($app->usuarioLogueado()) {
        $nombreUsuario = $app->nombreUsuario();

        $formLogout = new FormularioLogout();
        $htmlLogout = $formLogout->gestiona();
        
        $imagen=Usuario::getFotoPerfil($app->getUsuarioID());
        $imagenhtml="";
        if($imagen!=null){
            $imagenhtml = '<img class="imagen-usuario-din" src="data:image/jpeg;base64,' . base64_encode($imagen) . '" alt="usuariodin">';
        }
            $html = "<a href='usuarioDinamico.php?id=". urlencode($app->getUsuarioID()) ."'> $nombreUsuario </a>" . $imagenhtml. $htmlLogout;

        
        
    } else {
        $loginUrl = $app->resuelve('/login.php');
        $registroUrl = $app->resuelve('/registro.php');
        $html = <<<EOS
        Usuario desconocido  <a href="{$loginUrl}">Login </a><a href="{$registroUrl}">Registro </a>
      EOS;
    }

    echo $html;
}

?>

<header>
    
    <div class ="Logo">
        <img src="img/logo.png" alt="logo">
        <h1>GoalLink</h1>
    </div>
    
    <div class="saludo">
        <?php
        mostrarSaludo();
        ?>
    </div>
</header>
