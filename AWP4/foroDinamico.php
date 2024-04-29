<?php

require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\foros\FormularioForoFavorito;
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\mensajes\FormularioMensajeLike;
use es\ucm\fdi\aw\mensajes\FormularioMensajeEliminar;
use es\ucm\fdi\aw\usuarios\FormularioUsuarioBloquear;
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

if($app->usuarioLogueado() and($app->esModerador() or $app->esAdmin())){    
    $contenido .= "<br>";
    $contenido .= "<a href='editarForo.php?foro=" . urlencode($foro->getId()) . "'><i class='fas fa-user-cog'></i>Editar foro</a>";
  
}

$titulo = $foro->getTitulo();
$contenido .= "<h2 class='titulo-foro'>" . $titulo . "</h2>";
$contenido .= "<p>" . $foro->getDescripcion() . "</p>";

$contenido .= '<div class="foro-imagenes-din">';
if($foro->getImagen()!=null){

    $contenido .= '<div class="foro-imagen-dinamico">';
    $contenido .= '<img class="foro-imagen-din" src="data:image/jpeg;base64,'.base64_encode($foro->getImagen()).'" alt = "foro-imagen">';
    $contenido .= '</div>';
}
$contenido .= '<div class="foro-form">';
if($app->usuarioLogueado() and !Usuario::consultarBloqueo($app->getUsuarioID())){    
    $form = new \es\ucm\fdi\aw\mensajes\FormularioMensajeCrear($id_foro);
    $contenido.= $form->gestiona();

    if(($app->esModerador() or $app->esAdmin())){

        #$contenido .= " <a href='editForos.php?foro=" . urlencode($foro->getId()) . "'>Editar</a>";
    }
  
} 
else{

    $contenido.="<h4> No tienes permisos para participar</h4>";
}
$contenido .= '</div>';
$contenido .= '</div>';
if($app->usuarioLogueado() ){    
    $url="foroDinamico.php?id=' . $id_foro . '";
    $form = new FormularioForoFavorito($foro, $url);
    $contenido .= $form->gestiona();
    

}




$resultado = $foro->getMensajes($app->esAdmin() or $app->esModerador());
$contenido.= "<div id ='forosdinamicos'>";
if($resultado!=null){

    foreach ($resultado as $mensaje) {
        $contenido.= "<div class ='forodin'>";
        $contenido.= "<div class ='usfeho'>";
        $fotoperfil=Usuario::getFotoPerfil($mensaje->getUsuarioId());
        if($fotoperfil!=null){

            $imagen = '<img class="imagen-usuario-din" src="data:image/jpeg;base64,' . base64_encode( $fotoperfil) . '" alt="usuariodin">';
            $contenido.= "<p> " . $imagen . "</p>";
        }
        $usuarioNombre=Usuario::getNombreAutor($mensaje->getUsuarioId());
        $usuarioRol=Usuario::getRolAutor($mensaje->getUsuarioId());
        if($usuarioRol == 'a' || $usuarioRol == 'm'){
            $contenido.= "<a class='usermsg-admin' href='usuarioDinamico.php?id=". urlencode($mensaje->getUsuarioId()) ."'> $usuarioNombre</a>";
        }
        elseif($mensaje->getUsuarioId()==-1){
            $contenido.= "<a class='usermsg'> UsuarioBloqueado</a>";
        }
        else{
            $contenido.= "<a class='usermsg' href='usuarioDinamico.php?id=". urlencode($mensaje->getUsuarioId()) ."'> $usuarioNombre</a>";
        }
        $contenido.= "<p class ='fechamsg'> Fecha: " . $mensaje->getFecha() . "</p>";
        $contenido.= "<p class ='horamsg'>" . $mensaje->getHora() . "</p>";
        $contenido.= "</div>";
       
        $contenido.= "<div class ='mensaje'>";
        $contenido.= "<p>" . $mensaje->getText() . "</p>";
        if ($mensaje->getImagen() !== null) {
            $contenido .= '<img class="imagen-mensaje-din" src="data:image/jpeg;base64,'.base64_encode($mensaje->getImagen()).'" alt="mensajedin">';
        }
        $contenido.= "</div>";
    
        if($app->usuarioLogueado()){    
            $url = "foroDinamico.php?id=" . $id_foro;
            $form = new FormularioMensajeLike($mensaje, $url);
            $contenido .= "<div class ='bot-msg'>" . $form->gestiona();
    
            if($app->esAdmin() or $app->esModerador()){
                $formEliminar = new FormularioMensajeEliminar($mensaje, $url);
                $contenido .= $formEliminar->gestiona();
                
                
                $formBloquear = new FormularioUsuarioBloquear($mensaje->getUsuarioId(), $url);
                $contenido .= $formBloquear->gestiona();
            }
            $contenido .= "</div>";
        
        }
        else{
            $contenido.= "<p class= 'likemsg'>" . $mensaje->getLikes() . " <span style='color: red;'>&#10084;&#65039;</span></p>";
        }
        $contenido.= "</div>";
    }
    $contenido.= "</div>";
}


 

$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto.php', $params);

