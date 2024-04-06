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

require "includes/src/noticias/noticiaModel.php";
$noticiasDestacadas = \es\ucm\fdi\aw\noticias\Noticia::listaDestacados(1);

if ($noticiasDestacadas != NULL) {
    foreach ($noticiasDestacadas as $noticia) {
        $contenido .= '<div class="noticia">'; // Agregar contenedor de noticia
        $contenido .= '<h3><a href="noticiaDinamica.php?id=' . $noticia->getId() . '">' . $noticia->getTitulo() . '</a></h3>';
        $contenido .= "<p>" . substr($noticia->getContenido(), 0, 100) . "..."."</p>";
        $contenido .= "<p>" . $noticia->getLikes() . " <span style='color: red;'>&#10084;&#65039;</span></p>";

        if($noticia->getImagen1()!=NULL){
            $contenido .= '<figure class="noticia-imagen">'; //contenedor de figura
            $contenido .= '<img src="data:image/jpeg;base64,'.base64_encode($noticia->getImagen1()).'"width = 300px height=180px" />';
            $contenido .= '</figure>'; // Cerrar contenedor de figura
                }
                $contenido .= "<p class = 'autorfechahome'>" . es\ucm\fdi\aw\usuarios\Usuario::getNombreAutor($noticia->getIdAutor()). " " .$noticia->getFecha()."</p>";
        $contenido .= '</div>'; // Cerrar contenedor de noticia
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
$forosDestacados = Foro::listaDestacados(1);

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
