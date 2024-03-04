<?php

session_start();

$titulo = 'Index';
$barraIzq = <<<EOS
<ul>
<li><a href="index.php">Inicio</a></li>
<li><a href="contenido.php">Ver contenido</a></li>
<li><a href="admin.php">Admini</a></li>
</ul>
EOS;
$contenido = <<<EOS
<h1>Página principal</h1>
<p> Aquí está el contenido público, visible para todos los usuarios. </p>
EOS;

require __DIR__.'/includes/Vistas/esqueleto.php';
