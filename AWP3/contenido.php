<?php

require_once __DIR__.'/includes/config.php';
$titulo = 'Contenido';

$contenido = '';
if ($app->usuarioLogueado()) {
    if($app->esAdmin() || $app->esEditor()){
        $contenido .= <<<EOS
        <h2>Contenido <button type="button">Editar</button></h2>
        EOS;
    }
    else{
        $contenido .= <<<EOS
        <h2>Contenido</h2>

        EOS;
    
    }

    $contenido .= <<<EOS
    <h3>Kane en la cima de Europa</h3>

    <p>El delantero inglés del Bayern, Bota de Oro y máximo goleador de la Bundesliga con 27 tantos, suma seis dianas en la Champions como Kylian y firma ya su tercera mejor temporada realizadora (33)</p>

    <img src ="./img/kane.png" alt = "kane" width = "200" height = "220">

    
    EOS;

} else {
    $contenido .= <<<EOS
                <h2>Contenido</h2>
                Inicie sesión para visualizar contenido exclusivo: <a href='login.php'>Login</a>
                EOS;
}

$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto.php', $params);