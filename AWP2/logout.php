<?php
session_start();
unset($_SESSION["nombre"]);
unset($_SESSION["login"]);
unset($_SESSION["email"]);
unset($_SESSION["rol"]);

session_destroy();

$titulo = 'LogOut';



$contenido = <<<EOS
<h2>Sesión cerrada</h2>
		<p>Gracias por visitar nuestra web. ¡Hasta pronto!</p>
EOS;

require __DIR__ . '/includes/Vistas/esqueleto2.php';









