<?php


$titulo = 'Registro';


$contenido = <<<EOS
<h2>Registrar</h2>
        <form action="procesarRegistro.php" method="post"> 
            <fieldset>
                <legend>Introduzca sus datos </legend>
                <label>Nombre de usuario:</label><input type="text" name="usuario" required> 
                <label>Email:</label><input type="text" name="email" required> 
                <label>Contraseña:</label><input type="password" name="contraseña" required> 
                <label>Repite contraseña:</label><input type="password" name="contraseña2" required> 
                <button type="submit">Siguiente</button>
            </fieldset>
        </form>
	
EOS;

require __DIR__.'/includes/Vistas/esqueleto.php';