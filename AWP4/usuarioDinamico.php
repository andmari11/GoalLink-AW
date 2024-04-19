<?php

require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\mensajes\Mensaje;
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\mensajes\FormularioMensajeLike;
use es\ucm\fdi\aw\mensajes\FormularioMensajeEliminar;
use es\ucm\fdi\aw\usuarios\FormularioUsuarioBloquear;
use es\ucm\fdi\aw\usuarios\Usuario;



$id_usuario = $_GET['id'];

$app = Aplicacion::getInstance();



$usuario = es\ucm\fdi\aw\usuarios\Usuario::buscaUsuarioPorId($id_usuario);
$contenido = '';

if ($usuario === null) {
    $contenido.= 'No se encontró el usuario.';
    exit;
}

$titulo = $usuario->getNombre();
$contenido .= "<h2 class='titulo-usuario'> Mensajes de " . $titulo . ":</h2>";
if($app->getUsuarioID()==$id_usuario or $app->esAdmin()){

    $contenido.= "<a href='editUsuarios.php?usuario=" . urlencode($usuario->getNombre()) . "'>" . "Editar" . "</a> ";

}

if($usuario->getImagen()!=null){

    $contenido .= '<div class="usuario-imagenes-din">'; 
    #$contenido .= '<img class="usuario-imagen-din" src="data:image/jpeg;base64,'.base64_encode($usuario->getImagen()).'" alt = "usuario-imagen">';
    $contenido .= '</div>';
}


$resultado = Mensaje::getMensajesUsuario($id_usuario, $app->esAdmin() or $app->esModerador());
$contenido.= "<div id ='usuariosdinamicos'>";
if($resultado!=null){

    foreach ($resultado as $mensaje) {
        $contenido.= "<div class ='usuariodin'>";
        $contenido.= "<div class ='usfeho'>";
        $imagen = '<img class="imagen-usuario-din" src="data:image/jpeg;base64,' . base64_encode( Usuario::getFotoPerfil($mensaje->getUsuarioId())) . '" alt="usuariodin">';
        $contenido.= "<p> " . $imagen . "</p>";
        $contenido.= "<p class ='usermsg'> " . Usuario::getNombreAutor($mensaje->getUsuarioId()) . "</p>";
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
            $url = "usuarioDinamico.php?id=" . $id_usuario;
            $form = new FormularioMensajeLike($mensaje, $url);
            $contenido .= $form->gestiona();
    
            if($app->esAdmin() or $app->esModerador()){
                $formEliminar = new FormularioMensajeEliminar($mensaje, $url);
                $contenido .= $formEliminar->gestiona();
                
                
                $formBloquear = new FormularioUsuarioBloquear($mensaje->getUsuarioId(), $url);
                $contenido .= $formBloquear->gestiona();
            }
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

