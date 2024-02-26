<?php
	session_start();
    
	$titulo = <<<EOS
		<h2>Página principal</h2>
	EOS;

	$titulo = <<<EOS
		<p>Aquí está el contenido público, visible para todos los usuarios.</p>
	EOS;
	
    require "esqueleto.php";