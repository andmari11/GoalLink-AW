<?php

session_start();

$titulo = 'Login';


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
EOS;

require __DIR__.'/includes/Vistas/esqueleto.php';

	


	