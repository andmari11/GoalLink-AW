<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios\FormularioLogout;

function mostrarSaludo()
{
    $html = '';
    $app = Aplicacion::getInstance();
    if ($app->usuarioLogueado()) {
        $nombreUsuario = $app->nombreUsuario();

        $formLogout = new FormularioLogout();
        $htmlLogout = $formLogout->gestiona();
        $html = "Bienvenido, <a href='edit.php?usuario=" . urlencode($nombreUsuario) . "'>" . $nombreUsuario . "</a> . " . $htmlLogout;
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
