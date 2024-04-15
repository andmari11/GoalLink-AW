<?php
use es\ucm\fdi\aw\Aplicacion;

function mostrarLista()
{
    $app = Aplicacion::getInstance();
    if(($app->usuarioLogueado()) && ($app->esAdmin() or $app->esModerador() or $app->esEditor())){
        
        echo "<ul>";
        echo "<li><a href='index.php'><i class='fa-solid fa-house'></i>Inicio</a></li>";
        echo "<li><a href='contenido.php'><i class='fas fa-bullhorn'></i>Contenido</a></li>";
        echo "<li><a href='foro.php'><i class='fas fa-comment'></i>Foro</a></li>";
        echo "<li><a href='admin.php'><i class='fas fa-user-cog'></i>Administrar</a></li>";
        echo "</ul>";
        
    }else {
        
        echo "<ul>";
        echo "<li><a href='index.php'><i class='fa-solid fa-house'></i>Inicio</a></li>";
        echo "<li><a href='contenido.php'><i class='fas fa-bullhorn'></i>Contenido</a></li>";
        echo "<li><a href='foro.php'><i class='fas fa-comment'></i>Foro</a></li>";
        echo "</ul>";
        
    }
}
?>
<nav id="sidebarIzq">
    <h3>Navegación</h3>
    <?php 
    mostrarLista();
    ?>
    
</nav>