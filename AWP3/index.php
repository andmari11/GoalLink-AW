<?php

require_once __DIR__.'/includes/config.php';
$titulo = 'Index';
$contenido = '';
if (($app->usuarioLogueado()) && ($app->esAdmin())){

    $contenido .= <<<EOS
    <h2>HOME <button type="button">Editar</button></h2>
    <p> Noticias destacadas y foros destacados. </p>
EOS;
}
else{
    $contenido .= <<<EOS
    <h2>HOME</h2>
    <p> Noticias destacadas y foros destacados. </p>
EOS;

}


$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto.php', $params);
