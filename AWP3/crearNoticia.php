<?php
require_once __DIR__.'/includes/config.php';

$formNoticia = new \es\ucm\fdi\aw\noticias\FormularioNoticiaCrear();
$formNoticia = $formNoticia->gestiona();

$titulo = 'Crear Noticia';
if (($app->usuarioLogueado()) && ($app->esAdmin() || $app->esEditor())) {
    $contenido = <<<EOF
        <h2>Crear Noticia</h2>
        $formNoticia
    EOF;
}

$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto2.php', $params);