<?php

session_start();
require "usuario.php";

$titulo = "Administración";
if (($_SESSION["rol"])=='a') {
    $contenido = <<<EOS
    <h1>Panel de Administración</h1>
    <h3>Usuarios</h3>
EOS;
    $usuarios=Usuario::listaUsuario();
    if ($usuarios !== NULL) {
        $contenido .= "<table border='1'>";
        $contenido .= "<tr><th>Nombre</th><th>Email</th><th>Rol</th><th>✏️ </th><th> 🗑️ </th></tr>";
        foreach ($usuarios as $usuario) {
            $contenido .= "<tr>";
            $contenido .= "<td>" . $usuario->getNombre() . "</td>";
            $contenido .= "<td>" . $usuario->getEmail() . "</td>";
            $contenido .= "<td>" . $usuario->getRol() . "</td>";
            $contenido .= "<td>" ." Editar ". "</td>";
            $contenido .= "<td>" ." Eliminar ". "</td>";
            $contenido .= "</tr>";

        }
        $contenido .= "</table>";
    } else {
        $contenido .= "<p>No se encontraron usuarios.</p>";
    }

} else {
    $contenido = <<<EOS
    <h1>Panel de Administración  </h1>
    <p> ACCESO DENEGADO. </p>
EOS;

}



require __DIR__ . '/includes/Vistas/esqueleto.php';







