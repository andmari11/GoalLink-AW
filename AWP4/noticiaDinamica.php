<?php

require_once __DIR__.'/includes/config.php';


use es\ucm\fdi\aw\noticias\FormularioNoticiaLike;
use es\ucm\fdi\aw\usuarios\Usuario;

$id_noticia = $_GET['id'];

// Valida y sanea el ID de la noticia
$id_noticia = filter_var($id_noticia, FILTER_SANITIZE_NUMBER_INT);
$id_noticia = filter_var($id_noticia, FILTER_VALIDATE_INT);

if ($id_noticia === false) {
    echo 'El ID de la noticia no es válido.';
    exit;
}

$noticia = es\ucm\fdi\aw\noticias\Noticia::getNoticiaById($id_noticia);

if ($noticia === null) {
    echo 'No se encontró la noticia.';
    exit;
}
$contenido = '';

$titulo = $noticia->getTitulo();
$contenido .= "<h2 class='titulo-noticia'>" . $titulo . "</h2>";

$contenido .= '<div class="noticia-imagenes-din">';
if ($noticia->getImagen1() !== null) {
    $contenido .= '<img class="imagen-noticia-din" src="data:image/jpeg;base64,'.base64_encode($noticia->getImagen1()).'" alt="noticiadin">';
}
$contenido .= '<img class="logo-liga-din" src="data:image/jpeg;base64,'.base64_encode(es\ucm\fdi\aw\ligas\Liga::LogoLiga($noticia->getLiga())).'" alt = "logoliga">';
$contenido .= '</div>';

$contenido .= "<p class ='contenido'>" .$noticia->getContenido()."</p>";
$usuarioNombre=Usuario::getNombreAutor($noticia->getIdAutor());

$contenido .= "<p><a class='usermsg' href='usuarioDinamico.php?id=" . urlencode($noticia->getIdAutor()) . "'>$usuarioNombre</a>" ."    (". $noticia->getFecha() . ")</p>";



if($app->usuarioLogueado()){    
    $url="noticiaDinamica.php?id=' . $id_noticia . '";
    $formLogout = new FormularioNoticiaLike($noticia, $url);
    $contenido .= $formLogout->gestiona();
    

}
if($app->usuarioLogueado() and($app->esEditor() or $app->esAdmin())){    
    $contenido .= "<br>";
    $contenido .= " <a href='editNoticias.php?noticia=" . urlencode($noticia->getId()) . "'>Editar</a>";
  
} 



$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto2.php', $params);

?>

