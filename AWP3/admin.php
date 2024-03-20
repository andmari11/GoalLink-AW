<?php
require_once __DIR__.'/includes/config.php';


$titulo = "Administración";


    if($app->esAdmin()){
    $contenido = <<<EOS
    <h2>Panel de Administración</h2>
    <h3>Usuarios<button type="button">Añadir nuevo usuario</button></h3>
    EOS;
    $usuarios=es\ucm\fdi\aw\usuarios\Usuario::listaUsuario();
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



$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto.php', $params);
