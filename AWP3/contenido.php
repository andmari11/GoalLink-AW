<?php

require_once __DIR__.'/includes/config.php';
require "includes/src/noticias/noticiaModel.php";
require "includes/src/usuarios/Usuario.php";
require "includes/src/ligas/ligasModel.php";

use \es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\ligas\Liga;
$titulo = 'Contenido';

$contenido = '';
if ($app->usuarioLogueado()) {
    if($app->esAdmin() || $app->esEditor()){
        $noticiasDestacadas = \es\ucm\fdi\aw\noticias\Noticia::listaLigas(Usuario::getLigaDeUsuarioId($app->getUsuarioID()));
        $contenido.='<div class="contenido-con-imagen">';
        $contenido .= '<img class="logo-liga-din" src="data:image/jpeg;base64,'.base64_encode(Liga::LogoLiga(Usuario::getLigaDeUsuarioId($app->getUsuarioID()))).'" />';

        $contenido .= '<button type="button"><i class="fas fa-user-cog"></i><a href="admin.php">Editar</button></h2></a></div>';
    }
    else{
        $contenido .= <<<EOS
        <h2>Contenido</h2>

        EOS;
    
    }



    if ($noticiasDestacadas != NULL) {

        foreach ($noticiasDestacadas as $noticia) {
            $contenido .= '<div class="noticia">'; // Agregar contenedor de noticia
            $contenido .= '<h3><a href="noticiaDinamica.php?id=' . $noticia->getId() . '">' . $noticia->getTitulo() . '</a></h3>';
            $contenido .= "<p>" . substr($noticia->getContenido(), 0, 100) . "..."."</p>";
            $contenido .= "<p>" . $noticia->getLikes() . " <span style='color: red;'>&#10084;&#65039;</span></p>";
    
            if($noticia->getImagen1()!=NULL){
                $contenido .= '<img src="data:image/jpeg;base64,'.base64_encode($noticia->getImagen1()).'"width = 300px height=180px" />';
            }
            $contenido .= '</div>'; // Cerrar contenedor de noticia
        }
    } else {
        $contenido .= "<p>No se encontraron noticias de la liga.</p>";
    }

    

} else {
    $contenido .= <<<EOS
                <h2>Contenido</h2>
                Inicie sesión para visualizar contenido exclusivo: <a href='login.php'>Login</a>
                EOS;
}

$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto.php', $params);