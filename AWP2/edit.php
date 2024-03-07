<?php
require "includes/model/usuarioModel.php";

session_start();
$titulo = 'Editar';


if (isset($_SESSION["login"]) && $_SESSION["rol"] == 'a') {

    $username= htmlspecialchars(trim(strip_tags($_REQUEST["usuario"])));

    $usuario=Usuario::buscaUsuario($username);
    $nombre=$usuario->getNombre();
    $email=$usuario->getEmail();   
     
    $contenido = <<<EOS
    <h2>Editar usuario</h2>
    <form action="procesarEdit.php" method="post"> 
        <fieldset>
            <legend>Editar datos:</legend>
            <h3>{$nombre}</h3> 
            <label>Email:</label><input type="text" name="email" value="{$email}" required> 
            <label>Rol:</label> 
            <select name="rol">
                <option value="e">Editor</option>
                <option value="m">Moderador</option>
                <option value="b">Usuario</option>
            </select>
            <button type="submit">Siguiente</button>
            <input type="hidden" name="nombreAntiguo" value="{$username}">
        </fieldset>
    </form>
    
EOS;
} else {
    $contenido = <<<EOS
    <h2>Acceso denegado</h2>
EOS;
}

require __DIR__.'/includes/Vistas/esqueleto.php';

