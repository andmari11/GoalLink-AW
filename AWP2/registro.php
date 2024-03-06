<?php


$titulo = 'Login';


$contenido = <<<EOS
<h1>Registrar</h1>
        <form action="procesarRegistro.php" method="post"> 
            <fieldset>
                <legend>Introduzca sus datos </legend>
                <label>Nombre de usuario:</label><input type="text" name="usuario" required> 
                <label>Email:</label><input type="text" name="email" required> 
                <label>Contraseña:</label><input type="password" name="contraseña" required> 
                <label>Repite contraseña:</label><input type="password" name="contraseña2" required> 
                <button type="Registrar">Siguiente</button>
            </fieldset>
        </form>
	  </article>
	</main>
EOS;

require __DIR__.'/includes/Vistas/esqueleto.php';