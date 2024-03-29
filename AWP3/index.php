<?php

require_once __DIR__.'/includes/config.php';

$titulo = 'Index';
$contenido = '';

if (($app->usuarioLogueado()) && ($app->esAdmin())) {
    $contenido .= <<<EOS
    <h2>HOME <button type="button">Editar</button></h2>
EOS;
} else {
    $contenido .= <<<EOS
    <h2>HOME</h2> 
EOS;
}

$contenido .= <<<EOS
    <div id='container'>
        <div id='nots'>
            <h2>Noticias destacadas</h2>
            <div class='notscontent'>
EOS;

require "includes/model/noticiaModel.php";
$noticiasDestacadas = Noticia::listaDestacados();

if ($noticiasDestacadas != NULL) {
    foreach ($noticiasDestacadas as $noticia) {
        $contenido .= "<h3>" . $noticia->getTitulo() . "</h3>";
        //$contenido .= "<p>" . $noticia->getContenido() . "</p>";
        $contenido .= "<p>" . $noticia->getLikes() . " <span style='color: red;'>&#10084;&#65039;</span></p>";

        if($noticia->getImagen1()!=NULL){
            $contenido .= '<img src="data:image/jpeg;base64,'.base64_encode($noticia->getImagen1()).'" style="max-width: 300px; max-height: 300px;" />';
        }
    }
} else {
    $contenido .= "<p>No se encontraron noticias destacadas.</p>";
}

$contenido .= <<<EOS
            </div>
        </div>
        <div id='foros'>
            <h2>Foros destacados</h2>
            <div class='foroscontent'>
EOS;

require "includes/model/foroModel.php";
$forosDestacados = Foro::listaDestacados();

if ($forosDestacados != NULL) {
    foreach ($forosDestacados as $foro) {
        $contenido .= "<h3>" . $foro->getTitulo() . "</h3>";
        $contenido .= "<p>" . $foro->getDescripcion() . "</p>";
        $contenido .= "<p>" . $foro->getLikes() . " <span style='color: red;'>&#10084;&#65039;</span></p>";
    }
} else {
    $contenido .= "<p>No se encontraron foros destacados.</p>";
}

$contenido .= <<<EOS
            </div>
        </div>
    </div>
EOS;

$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto2.php', $params);
?>
