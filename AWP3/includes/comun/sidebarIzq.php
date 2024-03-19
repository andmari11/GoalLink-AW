<?php
function mostrarLista()
{
    
    if(( isset($_SESSION["login"]) && ($_SESSION["rol"])=='a')){
        
        echo "<ul>";
        echo "<li><a href='index.php'>Inicio</a></li>";
        echo "<li><a href='contenido.php'>Ver contenido</a></li>";
        echo "<li><a href='foro.php'>Foro</a></li>";
        echo "<li><a href='admin.php'>Administrar</a></li>";
        echo "</ul>";
        
    }else {
        
        echo "<ul>";
        echo "<li><a href='index.php'>Inicio</a></li>";
        echo "<li><a href='contenido.php'>Ver contenido</a></li>";
        echo "<li><a href='foro.php'>Foro</a></li>";
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