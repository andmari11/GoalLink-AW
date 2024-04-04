<?php
require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\ligas\FormularioLigaEliminar;
use es\ucm\fdi\aw\usuarios\FormularioUsuarioEliminar;
use es\ucm\fdi\aw\noticias\FormularioNoticiaEliminar;



$titulo = "Administración";

    $contenido="<h2>Panel de Administración</h2>";

    if($app->esAdmin()){

        $contenido .= <<<EOS
        <h3>Usuarios<a href='anadirUsuario.php'><button type="button">Añadir nuevo usuario</button></a></h3>
        EOS;
        $usuarios=es\ucm\fdi\aw\usuarios\Usuario::listaUsuario();
        if ($usuarios !== NULL) {
            $contenido .= "<table>";
            $contenido .= "<tr><th>Id</th><th>Nombre</th><th>Email</th><th>Rol</th><th>LigaFav</th><th>Editar </th><th> Eliminar </th></tr>";
            foreach ($usuarios as $usuario) {
                $contenido .= "<tr>";
                $contenido .= "<td>" . $usuario->getId() . "</td>";
                $contenido .= "<td>" . $usuario->getNombre() . "</td>";
                $contenido .= "<td>" . $usuario->getEmail() . "</td>";
                $contenido .= "<td>" . $usuario->getRol() . "</td>";
                $contenido .= "<td>" . $usuario->getLigaFav() . "</td>";


                if($usuario->getRol()!="a") {
                    $contenido .= "<td>" ." <a href='editUsuarios.php?usuario=" . urlencode($usuario->getNombre()) . "'>✏️</a>". "</td>";
                    $formDelete = new FormularioUsuarioEliminar($usuario->getNombre());
                    $contenido .= "<td>" . $formDelete->gestiona(). "</td>";
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


    }
    if($app->esEditor() || $app->esAdmin()){
        $contenido .= <<<EOS
            <h3>Noticias
            <a href="crearNoticia.php"><button type="button"> Crear noticia</button></a></h3>
        EOS;
        require "includes/src/noticias/noticiaModel.php";
        $noticias = \es\ucm\fdi\aw\noticias\Noticia::listaDestacados(0);

        if ($noticias !== NULL) {
            $contenido .= "<table>";
            $contenido .= "<tr><th>Id</th><th>Título</th><th>IdAutor</th><th>Fecha</th><th>Ligas</th><th>Likes</th><th>Editar</th><th>Eliminar</th></tr>";
            foreach ($noticias as $noticia) {
                $contenido .= "<tr>";
                $contenido .= "<td>" . $noticia->getId() . "</td>";
                if(!$noticia->getDestacado()){
                    $contenido .= "<td>" . $noticia->getTitulo() . "</td>";
                }
                else{
                    $contenido .= "<td><b>" . $noticia->getTitulo() . "</b></td>";
                }                $contenido .= "<td>" . $noticia->getIdAutor() . "</td>";
                $contenido .= "<td>" . $noticia->getFecha() . "</td>";
                $contenido .= "<td>" . $noticia->getLiga() . "</td>";
                $contenido .= "<td>" . $noticia->getLikes() . "</td>";
                $contenido .= "<td>" ." <a href='editNoticias.php?noticia=" . urlencode($noticia->getId()) . "'>✏️</a>". "</td>";

                $formDelete = new FormularioNoticiaEliminar($noticia->getId());
                $contenido .= "<td>" . $formDelete->gestiona(). "</td>";

                $contenido .= "</tr>";
            }
            $contenido .= "</table>";
        }
    }
     else {
        $contenido .= "<p>No se encontraron noticias destacadas.</p>";
    }




    if($app->esEditor() || $app->esAdmin()){
        $contenido .= <<<EOS
            <h3>Ligas
            <a href="crearLiga.php"><button type="button"> Crear liga</button></a></h3>

        EOS;
        require "includes/src/ligas/ligasModel.php";
        $ligas = \es\ucm\fdi\aw\ligas\Liga::listaLigas();
        if ($ligas !== NULL) {
            $contenido .= "<table>";
            $contenido .= "<tr><th>Título</th><th>Eliminar</th></tr>";
            foreach ($ligas as $liga) {
                $contenido .= "<tr>";
                $contenido .= "<td>" . $liga->getNombre() . "</td>";
                $contenido .= "<td>" . (new FormularioLigaEliminar($liga->getNombre()))->gestiona(). "</td>";
                $contenido .= "</tr>";
            }
            $contenido .= "</table>";
        }
    }
     else {
        $contenido .= "<p>No se encontraron ligas .</p>";
    }

    

    if(!$app->esAdmin() and !$app->esEditor() and !$app->esModerador()) {
        $contenido = <<<EOS
        <h1>Panel de Administración  </h1>
        <p> ACCESO DENEGADO. </p>
        EOS;

    }  



$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto.php', $params);
