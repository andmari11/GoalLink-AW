<?php
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\ligas\Liga;

function obtenerOpcionesLigas() {
    $opciones = '<option value="">Selecciona una liga...</option>';
    $ligas = Liga::listaLigas();

    if ($ligas) {
        foreach ($ligas as $liga) {
            $opciones .= "<option value='" . $liga->getNombre() . "'>" . $liga->getNombre() . "</option>";
        }
    }
    return $opciones;
}

function mostrarLista()
{
    $app = Aplicacion::getInstance();
    echo "<ul>";
    echo "<li><a href='index.php'><i class='fa-solid fa-house'></i>Inicio</a></li>";
    echo "<li><a href='noticiasContenido.php'><i class='fas fa-bullhorn'></i>Contenido</a></li>";
    echo "<li><a href='forosContenido.php'><i class='fas fa-comment'></i>Foro</a></li>";
    if(($app->usuarioLogueado()) && ($app->esAdmin() or $app->esModerador() or $app->esEditor())){
        
        echo "<li><a href='admin.php'><i class='fas fa-user-cog'></i>Administrar</a></li>";
    }
    echo "</ul>";

}
?>
<nav id="sidebarIzq">
    <h3>Navegación</h3>
    <?php 
    mostrarLista();
    ?>
    
</nav>