<?php

require_once __DIR__.'/includes/config.php';
$titulo = 'Foro';


$contenido = '';
if ($app->usuarioLogueado()) {
    if($app->esAdmin() || $app->esModerador()){
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

$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto.php', $params);