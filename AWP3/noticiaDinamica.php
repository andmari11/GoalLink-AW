<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\noticias\FormularioNoticiaLike;

$id_noticia = $_GET['id'];

// Valida y sanea el ID de la noticia
$id_noticia = filter_var($id_noticia, FILTER_SANITIZE_NUMBER_INT);
$id_noticia = filter_var($id_noticia, FILTER_VALIDATE_INT);

if ($id_noticia === false) {
    echo 'El ID de la noticia no es válido.';
    exit;
}

require "includes/src/noticias/noticiaModel.php";
$noticia = es\ucm\fdi\aw\noticias\Noticia::getNoticiaById($id_noticia);

if ($noticia === null) {
    echo 'No se encontró la noticia.';
    exit;
}

$titulo = $noticia->getTitulo();
$contenido .= "<h1>" . $titulo . "</h1>";

if($app->usuarioLogueado()){
    $url="noticiaDinamica.php?id=' . $id_noticia . '";
    $formLogout = new FormularioNoticiaLike($noticia, $url);
    $contenido .= $formLogout->gestiona();
}

if ($noticia->getImagen1() !== null) {
    $contenido .= '<img src="data:image/jpeg;base64,'.base64_encode($noticia->getImagen1()).'" style="max-width: 900px; max-height: 900px;" />';
}

$contenido .= "<p>" .$noticia->getContenido()."</p>";


$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto2.php', $params);

?>

