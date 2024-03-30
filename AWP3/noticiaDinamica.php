<?php

require_once __DIR__.'/includes/config.php';

$id_noticia = $_GET['id'];

// Valida y sanea el ID de la noticia
$id_noticia = filter_var($id_noticia, FILTER_SANITIZE_NUMBER_INT);
$id_noticia = filter_var($id_noticia, FILTER_VALIDATE_INT);

if ($id_noticia === false) {
    echo 'El ID de la noticia no es válido.';
    exit;
}

require "includes/model/noticiaModel.php";
$noticia = Noticia::getNoticiaById($id_noticia);

if ($noticia === null) {
    echo 'No se encontró la noticia.';
    exit;
}

$titulo = $noticia->getTitulo();
$contenido .= "<h1>" . $titulo . "</h1>";

if ($noticia->getImagen1() !== NULL) {
    $contenido .= '<img src="data:image/jpeg;base64,'.base64_encode($noticia->getImagen1()).'" style="max-width: 300px; max-height: 300px;" />';
}

$contenido .= "<p>" .$noticia->getContenido()."</p>";

$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto2.php', $params);
