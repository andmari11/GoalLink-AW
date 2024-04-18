<?php
require_once __DIR__.'/includes/config.php';

$formulario = new \es\ucm\fdi\aw\foros\FormularioForoEditar();
$formulario = $formulario->gestiona();
$titulo = 'Editar';


if (($app->usuarioLogueado())) {

    $contenido=<<<EOF
    <h2>Acceso al sistema</h2>
    $formulario    
    EOF;
} else {
    $contenido = <<<EOS
    <h2>Acceso denegado</h2>
    EOS;
}

$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto2.php', $params);