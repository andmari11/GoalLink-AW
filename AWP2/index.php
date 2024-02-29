<?php

session_start();

$titulo = 'Index';

$contenido = <<<EOS
<h1>Página principal</h1>
<p> Aquí está el contenido público, visible para todos los usuarios. </p>
EOS;

require __DIR__.'/includes/Vistas/esqueleto.php';
