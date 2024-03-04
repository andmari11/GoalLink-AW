<?php
require "usuario.php";

session_start();

$titulo = 'Editar';

if ($_SESSION["rol"] == 'a') {
    $barraIzq = <<<EOS
    <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="contenido.php">Ver contenido</a></li>
        <li><a href="foro.php">Foro</a></li>
        <li><a href="admin.php">Administrar</a></li>
    </ul>
EOS;
} else {
    $barraIzq = <<<EOS
    <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="contenido.php">Ver contenido</a></li>
        <li><a href="foro.php">Foro</a></li>
    </ul>
EOS;
}

if ($_SESSION["rol"] == 'a') {
    $contenido = <<<EOS
    <h1>Editar usuario</h1>
    <form action="procesarEdit.php" method="post"> 
        <fieldset>
            <legend>Editar datos:</legend>
            <label>Nombre:</label><input type="text" name="usuario"> 
            <label>Email:</label><input type="text" name="email"> 
            <label>Rol:</label> 
            <select name="rol">
                <option value="e">Editor</option>
                <option value="m">Moderador</option>
                <option value="b">Usuario</option>
            </select>
            <button type="Confirmar">Siguiente</button>
        </fieldset>
    </form>
    </article>
    </main>
EOS;
} else {
    $contenido = <<<EOS
    <h1>Acceso denegado</h1>
EOS;
}

require __DIR__.'/includes/Vistas/esqueleto.php';
?>
