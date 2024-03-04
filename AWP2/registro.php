<?php


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
<h1>Registrar</h1>
        <form action="procesarRegistro.php" method="post"> 
            <fieldset>
                <legend>Introduzca sus datos </legend>
                <label>Nombre de usuario:</label><input type="text" name="usuario"> 
                <label>Email:</label><input type="text" name="email"> 
                <label>Contraseña:</label><input type="password" name="contraseña"> 
                <label>Repite contraseña:</label><input type="password" name="contraseña2"> 
                <button type="Registrar">Siguiente</button>
            </fieldset>
        </form>
	  </article>
	</main>
EOS;

require __DIR__.'/includes/Vistas/esqueleto.php';