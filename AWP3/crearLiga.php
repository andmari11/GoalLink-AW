<?php
require_once __DIR__.'/includes/config.php';

$form = new \es\ucm\fdi\aw\ligas\FormularioLigaCrear();
$form = $form->gestiona();

$titulo = 'Crear Liga';
if (($app->usuarioLogueado()) && ($app->esAdmin() || $app->esEditor())) {
    $contenido = <<<EOF
        <h2>Crear Liga</h2>
        $form
        
    EOF;
}

$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto2.php', $params);