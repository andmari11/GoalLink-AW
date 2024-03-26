<?php

require_once __DIR__.'/includes/config.php';

$form = new \es\ucm\fdi\aw\usuarios\FormularioUsuarioNuevo();
$form = $form->gestiona();


$tituloPagina = 'Registro';
$contenidoPrincipal=<<<EOF
  	<h1>Registro de usuario</h1>
    $form
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/esqueleto.php', $params);