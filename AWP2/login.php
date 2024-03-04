<?php

session_start();

$titulo = 'Login';
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
<h1>Iniciar sesión</h1>
        <form action="procesarLogin.php" method="post"> 
            <fieldset>
                <legend>Introduzca sus datos </legend>
                <label>Usuario:</label><input type="text" name="usuario"> 
                <label>Contraseña:</label><input type="password" name="contraseña"> 
                <button type="submit">Siguiente</button>
            </fieldset>
        </form>
        <p><a href='registro.php'>Registrar</a></p>
	  </article>
	</main>
EOS;

require __DIR__.'/includes/Vistas/esqueleto.php';

	


	