<?php

session_start();
require "includes/model/usuarioModel.php";

$titulo = "Administración";


    if(($_SESSION["rol"])=='a'){
    $contenido = <<<EOS
    <h2>Panel de Administración</h2>
    <h3>Usuarios</h3>
    EOS;
    $usuarios=Usuario::listaUsuario();
    if ($usuarios !== NULL) {
        $contenido .= "<table>";
        $contenido .= "<tr><th>Nombre</th><th>Email</th><th>Rol</th><th>✏️ </th><th> 🗑️ </th></tr>";
        foreach ($usuarios as $usuario) {
            $contenido .= "<tr>";
            $contenido .= "<td>" . $usuario->getNombre() . "</td>";
            $contenido .= "<td>" . $usuario->getEmail() . "</td>";
            $contenido .= "<td>" . $usuario->getRol() . "</td>";

            if($usuario->getRol()!="a") {
                $contenido .= "<td>" ." <a href='edit.php?usuario=" . urlencode($usuario->getNombre()) . "'>Editar</a>". "</td>";
                $contenido .= "<td>" ." <a href='procesarDelete.php?usuario=" . urlencode($usuario->getNombre()) . "'>Eliminar</a> ". "</td>";
            }
            else{
                $contenido .= "<td>"."". "</td>";
                $contenido .= "<td>"."". "</td>";
            }

            $contenido .= "</tr>";

        }
        $contenido .= "</table>";
    } else {
        $contenido .= "<p>No se encontraron usuarios.</p>";
    }
    $contenido .= <<<EOS
    <ul>
    <li><a href="index.php">Editar home</a></li>
    <li><a href="contenido.php">Editar contenido</a></li>
    <li><a href="foro.php"> Editar foro</a></li>
    </ul>
    EOS;

} else {
    $contenido = <<<EOS
    <h1>Panel de Administración  </h1>
    <p> ACCESO DENEGADO. </p>
EOS;

}



require __DIR__ . '/includes/Vistas/esqueleto2.php';
