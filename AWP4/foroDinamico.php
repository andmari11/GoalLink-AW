<?php

require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\foros\Foro;
use es\ucm\fdi\aw\usuarios\Usuario;



$id_foro = $_GET['id'];
$id_foro = filter_var($id_foro, FILTER_SANITIZE_NUMBER_INT);
$id_foro = filter_var($id_foro, FILTER_VALIDATE_INT);

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
    $contenido .= "<h3>Introducir mensaje:</h3>";
    $form = new \es\ucm\fdi\aw\mensajes\FormularioMensajeCrear($id_foro);
    $contenido.= $form->gestiona();

    if(($app->esModerador() or $app->esAdmin())){

        #$contenido .= " <a href='editForos.php?foro=" . urlencode($foro->getId()) . "'>Editar</a>";
    }
  
} 
$resultado = $foro->getMensajes();

foreach ($resultado as $mensaje) {
    $contenido.= "<div>";
    $contenido.= "<p>Usuario: " . Usuario::getNombreAutor($mensaje->getUsuarioId()) . "</p>";
    $contenido.= "<p>Texto: " . $mensaje->getText() . "</p>";
    $contenido.= "<p>Fecha: " . $mensaje->getFecha() . "</p>";
    $contenido.= "<p>Hora: " . $mensaje->getHora() . "</p>";
    $contenido.= "<p>Likes: " . $mensaje->getLikes() . "</p>";
    $contenido.= "</div>";
}




$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto2.php', $params);

