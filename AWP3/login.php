<?php

require_once __DIR__.'/includes/config.php';

$formLogin = new \es\ucm\fdi\aw\usuarios\FormularioLogin();
$formLogin = $formLogin->gestiona();


$titulo = 'Login';
$contenido=<<<EOF
  	<h1>Acceso al sistema</h1>
    $formLogin
EOF;

$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto2.php', $params);




	


	