<?php

require_once __DIR__.'/includes/config.php';
$formRegistro = new \es\ucm\fdi\aw\usuarios\FormularioRegistro();
$formRegistro = $formRegistro->gestiona();


$tituloPagina = 'Registro';
$contenidoPrincipal=<<<EOF
  	<h2>Registro de usuario</h2>
    $formRegistro
EOF;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/esqueleto.php', $params);