<?php

require_once __DIR__.'/includes/config.php';


use \es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\ligas\Liga;
$titulo = 'Contenido';

$contenido = '';
$noticiasDestacadas = null;


$contenido.='<div class="contenido-con-imagen">';

if(!empty($_REQUEST["id_liga"])){
    $id_noticia=htmlspecialchars(trim(strip_tags($_REQUEST["id_liga"])));
    $contenido .= '<p class="liga-favorita">Otras ligas</p>';

}
else if (!$app->usuarioLogueado()){

    $contenido .= <<<EOS
    <h2>Contenido</h2>
    Inicie sesión para visualizar contenido exclusivo: <a href='login.php'>Login</a>
    EOS;
}
else{

    $id_noticia=Usuario::getLigaDeUsuarioId($app->getUsuarioID());
    $contenido.='<div class="contenido-con-imagen">';
    $contenido .= '<p class="liga-favorita">Liga favorita</p>';
}

$contenido .= '<img class="logo-liga-din" src="data:image/jpeg;base64,'.base64_encode(Liga::LogoLiga($id_noticia)).'" alt = "logoliga">';

    $noticiasDestacadas = \es\ucm\fdi\aw\noticias\Noticia::listaLigas($id_noticia);

    if($noticiasDestacadas!=null){

        if($app->esAdmin() || $app->esEditor()){

            $contenido .= '<br>';
            $contenido .= '<a href="admin.php"><i class="fas fa-user-cog"></i>Editar</a></div>';
        }
        else{
            $contenido .= <<<EOS
            <h2>Contenido</h2>

            EOS;
        
        }
    }



    if ($noticiasDestacadas == NULL) {
        $contenido .= '<p>No hay noticias de tu liga favorita</p>'; // Cerrar contenedor de noticia

    }
    else{

            foreach ($noticiasDestacadas as $noticia) {
                $contenido .= '<div class="noticia">'; // Agregar contenedor de noticia
                $contenido .= '<h3><a href="noticiaDinamica.php?id=' . $noticia->getId() . '">' . $noticia->getTitulo() . '</a></h3>';
                $contenido .= "<p>" . substr($noticia->getContenido(), 0, 300) . "..."."</p>";
                $contenido .= "<p>" . $noticia->getLikes() . " <span style='color: red;'>&#10084;&#65039;</span></p>";
        
                if($noticia->getImagen1()!=NULL){
                    $contenido .= '<div class="imagen-noticia-container">';
                    $contenido .= '<img class="imagen-noticia" src="data:image/jpeg;base64,'.base64_encode($noticia->getImagen1()).'" alt="noticiadinamica">';
                    $contenido .= '</div>'; // Cerrar div imagen-noticia-container
                }
                $contenido .= '</div>'; // Cerrar contenedor de noticia
            }
    }
    $ligas = Liga::listaLigas();
    $contenido .= '<div id= "lista-ligas">';
    if ($ligas) {
        foreach ($ligas as $liga) {
            $contenido .= '<div class= "lista-ligas-unica">';
            $contenido .= '<a href=noticiasContenido.php?id_liga='.urldecode($liga->getNombre()).'>';
            $contenido .= '<img class="logo-liga-din" src="data:image/jpeg;base64,'.base64_encode($liga->getLogo()).'" alt="logoliga">';
            $contenido .= '</a>';
            $contenido .= '</div>';
        }
    }
    $contenido .= '</div>';

$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto.php', $params);