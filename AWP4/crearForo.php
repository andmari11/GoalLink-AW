<?php
require_once __DIR__.'/includes/config.php';

$formForo = new \es\ucm\fdi\aw\foros\FormularioForo();
$formForoHTML = $formForo->gestiona();

$titulo = 'Crear Foro';
$contenido = '';
if ($app->usuarioLogueado() && ($app->esAdmin() || $app->esModerador())) {
    $contenido = <<<EOF
        <h2>Crear Foro</h2>
        $formForoHTML
EOF;
}

$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto2.php', $params);
?>