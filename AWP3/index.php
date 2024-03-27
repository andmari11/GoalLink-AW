<?php

require_once __DIR__.'/includes/config.php';

$titulo = 'Index';
$contenido = '';
if (($app->usuarioLogueado()) && ($app->esAdmin())){

    $contenido .= <<<EOS
    <h2>HOME <button type="button">Editar</button></h2>


EOS;
}
else{
    $contenido .= <<<EOS
    <h2>HOME</h2> 
EOS;

}
$contenido .= <<<EOS
    <div id='container'>
        <div id='nots'>
        <h2>Noticias destacadas</h2>
            <div class='notscontent'>
            <h3>Titulo noticia 1</h3>
            <p>Contenido noticia 1</p>
            <p>10<span style='color: red;'>&#10084;&#65039;</span></p>
    
            </div>
            <br>
            <div class='notscontent'>
            <h3>Titulo noticia 2</h3>
            <p>Contenido noticia 2</p>
            <p>20<span style='color: red;'>&#10084;&#65039;</span></p>
    
            </div>
    
        </div>
        <div id='foros'>
        <h2>Foros destacados</h2>
            <div class='foroscontent'>
            <h3>Titulo foro 1</h3>
            <p>Descripcion foro 1</p>
            <p>10<span style='color: red;'>&#10084;&#65039;</span></p>
            
            </div>
            <br>
            <div class='foroscontent'>
            <h3>Titulo foro 2</h3>
            <p>Descripcion foro 2</p>
            <p>20<span style='color: red;'>&#10084;&#65039;</span></p>
    
            </div>
    
        </div>
    
    </div>


    
EOS;


$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto.php', $params);
