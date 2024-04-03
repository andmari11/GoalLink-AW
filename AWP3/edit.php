<?php
require_once __DIR__.'/includes/config.php';

$formEditar = new \es\ucm\fdi\aw\usuarios\FormularioUsuarioEdit();
$formEditar = $formEditar->gestiona();
$titulo = 'Editar';


if (($app->usuarioLogueado())) {

    $contenido=<<<EOF
    <h1>Acceso al sistema</h1>
    $formEditar    
    EOF;
} else {
    $contenido = <<<EOS
    <h2>Acceso denegado</h2>
EOS;
}

$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto2.php', $params);
