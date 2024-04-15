<?php

require_once __DIR__.'/includes/config.php';

use es\ucm\fdi\aw\foros\Foro;


$id_foro = $_GET['id'];

// Valida y sanea el ID de la noticia
$id_foro = filter_var($id_foro, FILTER_SANITIZE_NUMBER_INT);
$id_foro = filter_var($id_foro, FILTER_VALIDATE_INT);

if ($id_foro === false) {
    echo 'El ID del foro no es válido.';
    exit;
}

$foro = es\ucm\fdi\aw\foros\Foro::getForoById($id_foro);

if ($foro === null) {
    echo 'No se encontró la foro.';
    exit;
}
$contenido = '';

$titulo = $foro->getTitulo();
$contenido .= "<h2 class='titulo-foro'>" . $titulo . "</h2>";

$contenido .= '<div class="foro-imagenes-din">';

#$contenido .= '<img class="logo-liga-din" src="data:image/jpeg;base64,'.base64_encode(es\ucm\fdi\aw\ligas\Liga::LogoLiga($noticia->getLiga())).'" alt = "logoliga">';
$contenido .= '</div>';



if($app->usuarioLogueado() and($app->esEditor() or $app->esAdmin())){    
    $contenido .= "<br>";
    #$contenido .= " <a href='editForos.php?foro=" . urlencode($foro->getId()) . "'>Editar</a>";
  
} 



$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto2.php', $params);

?>

