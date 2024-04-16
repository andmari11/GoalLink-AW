<?php

require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\foros\FormularioForoFavorito;
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\mensajes\FormularioMensajeLike;
use es\ucm\fdi\aw\mensajes\FormularioMensajeEliminar;

use es\ucm\fdi\aw\usuarios\Usuario;



$id_foro = $_GET['id'];
$id_foro = filter_var($id_foro, FILTER_SANITIZE_NUMBER_INT);
$id_foro = filter_var($id_foro, FILTER_VALIDATE_INT);
$app = Aplicacion::getInstance();

if ($id_foro === false) {
    $contenido.= 'El ID del foro no es válido.';
    exit;
}

$foro = es\ucm\fdi\aw\foros\Foro::getForoById($id_foro);

if ($foro === null) {
    $contenido.= 'No se encontró la foro.';
    exit;
}
$contenido = '';

$titulo = $foro->getTitulo();
$contenido .= "<h2 class='titulo-foro'>" . $titulo . "</h2>";

#$contenido .= '<div class="foro-imagenes-din">'; 
#$contenido .= '<img class="logo-liga-din" src="data:image/jpeg;base64,'.base64_encode(es\ucm\fdi\aw\ligas\Liga::LogoLiga($noticia->getLiga())).'" alt = "logoliga">';
#$contenido .= '</div>';

if($app->usuarioLogueado()){    
    $url="foroDinamico.php?id=' . $id_foro . '";
    $form = new FormularioForoFavorito($foro, $url);
    $contenido .= $form->gestiona();
    

}

if($app->usuarioLogueado()){    
    $contenido .= "<h3>Introducir mensaje:</h3>";
    $form = new \es\ucm\fdi\aw\mensajes\FormularioMensajeCrear($id_foro);
    $contenido.= $form->gestiona();

    if(($app->esModerador() or $app->esAdmin())){

        #$contenido .= " <a href='editForos.php?foro=" . urlencode($foro->getId()) . "'>Editar</a>";
    }
  
} 
$resultado = $foro->getMensajes();
$contenido.= "<div id ='forosdinamicos'>";
foreach ($resultado as $mensaje) {
    $contenido.= "<div class ='forodin'>";
    $contenido.= "<div class ='usfeho'>";
    $contenido.= "<p class ='usermsg'> " . Usuario::getNombreAutor($mensaje->getUsuarioId()) . "</p>";
    $contenido.= "<p class ='fechamsg'> Fecha: " . $mensaje->getFecha() . "</p>";
    $contenido.= "<p class ='horamsg'>" . $mensaje->getHora() . "</p>";
    $contenido.= "</div>";
   
    $contenido.= "<div class ='mensaje'>";
    $contenido.= "<p>" . $mensaje->getText() . "</p>";
    $contenido.= "</div>";

    if($app->usuarioLogueado()){    
        $url = "foroDinamico.php?id=" . $id_foro;
        $form = new FormularioMensajeLike($mensaje, $url);
        $contenido .= $form->gestiona();

        if($app->esAdmin() or $app->esModerador()){
            $formEliminar = new FormularioMensajeEliminar($mensaje, $url);
            $contenido .= $formEliminar->gestiona();
        }
    }
    else{
        $contenido.= "<p class= 'likemsg'>" . $mensaje->getLikes() . " <span style='color: red;'>&#10084;&#65039;</span></p>";
    }
    $contenido.= "</div>";
}
$contenido.= "</div>";



$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto.php', $params);

