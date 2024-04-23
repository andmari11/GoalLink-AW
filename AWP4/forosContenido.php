<?php

require_once __DIR__.'/includes/config.php';
use es\ucm\fdi\aw\foros;
use es\ucm\fdi\aw\Aplicacion;

$titulo = 'Foro';




$contenido = '';

if ($app->usuarioLogueado()) {
    if($app->esAdmin() || $app->esModerador()){
        $contenido .= <<<EOS
        <h2>FORO <button type="button">Editar</button></h2>
        <p>Todos los foros</p>
        EOS;
    }
    else{
        $contenido .= <<<EOS
        <h2>FORO</h2>
        <p>Foros suscritos y foros destacados.</p>
        EOS;
        
        $forosFavoritos = es\ucm\fdi\aw\foros\Foro::listaFavoritos($app->getUsuarioID());
        if ($forosDestacados != NULL) {
            foreach ($forosDestacados as $foro) {
                $contenido .= '<div class="foro">';
                $contenido .= '<h3><a href="foroDinamico.php?id=' . $foro->getId() . '">' . $foro->getTitulo() . '</a></h3>';
                if($foro->getImagen()!=null){
        
                    $contenido .= '<div class="foro-imagen">'; 
                    $contenido .= '<img class="foro-imagen" src="data:image/jpeg;base64,'.base64_encode($foro->getImagen()).'" alt = "foro-imagen">';
                    $contenido .= '</div>';
                }
                $contenido .= "<p>" . $foro->getDescripcion() . "</p>";
                $contenido .= "<p>" . $foro->getfavoritos() . "<span style='color: red;'>&#11088;&#65039;</span>" .$foro->getMensajesNum() .  "<span style='color: red;'>&#128172;</span></p>";
                $contenido .= '</div>';
            } 
     
        }
    }

} else {
    $contenido .= <<<EOS
                <h2>FORO</h2>
                <p>Inicie sesión para visualizar contenido exclusivo del foro: <a href='login.php'>Login</a></p>
                EOS;
}

$params = ['tituloPagina' => $titulo, 'contenidoPrincipal' => $contenido];
$app->generaVista('/esqueleto.php', $params);