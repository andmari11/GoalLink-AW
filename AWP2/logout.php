<?php
session_start();
unset($_SESSION["nombre"]);
unset($_SESSION["login"]);
unset($_SESSION["email"]);
unset($_SESSION["rol"]);

session_destroy();

$titulo = 'LogOut';



$contenido = <<<EOS
<h1>Sesión cerrada</h1>
		<p>Gracias por visitar nuestra web. ¡Hasta pronto!</p>
EOS;

require __DIR__ . '/includes/Vistas/esqueleto.php';









