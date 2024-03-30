<?php
require_once __DIR__.'/includes/config.php';

$formNoticia = new \es\ucm\fdi\aw\usuarios\FormularioNoticia();
$formNoticia = $formNoticia->gestiona();

$titulo = 'Crear Noticia';
$contenido = <<<EOF
    <h2>Crear Noticia</h2>
    $formNoticia
EOF;

$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto2.php', $params);