<?php
session_start();
unset($_SESSION["nombre"]);
unset($_SESSION["login"]);
unset($_SESSION["email"]);
unset($_SESSION["rol"]);

session_destroy();

$titulo = 'LogOut';
if(($_SESSION["rol"])=='a'){
    $barraIzq = <<<EOS
    <ul>
    <li><a href="index.php">Inicio</a></li>
    <li><a href="contenido.php">Ver contenido</a></li>
    <li><a href="contenido.php">Foro</a></li>
    <li><a href="admin.php">Administrar</a></li>
    </ul>
    EOS;
}else {
    $barraIzq = <<<EOS
    <ul>
    <li><a href="index.php">Inicio</a></li>
    <li><a href="contenido.php">Ver contenido</a></li>
    <li><a href="admin.php">Foro</a></li>
    </ul>
    EOS;
}


$contenido = <<<EOS
<h1>Sesión cerrada</h1>
		<p>Gracias por visitar nuestra web. ¡Hasta pronto!</p>
EOS;

require __DIR__ . '/includes/Vistas/esqueleto.php';









