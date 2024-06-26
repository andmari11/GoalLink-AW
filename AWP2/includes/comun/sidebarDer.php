<aside id="sidebarDer">
    <h3>Noticias destacadas</h3>
    <ul>
        <?php
            require "includes/model/noticiaModel.php";

            // Obtener la lista de noticias destacadas
            $noticiasDestacadas = Noticia::listaDestacados();

            // Mostrar las noticias destacadas
            if ($noticiasDestacadas != NULL) {
                foreach ($noticiasDestacadas as $noticia) {
                    echo "<li>";
                    echo "<h4>" . $noticia->getTitulo() . "</h4>";
                    echo "<p>" . $noticia->getContenido() . "</p>";
                    echo "<p>" . $noticia->getLikes() . " <span style='color: red;'>&#10084;&#65039;</span></p>";
                    echo "</li>";
                }
            } 
            else {
                echo "<li>No se encontraron noticias destacadas.</li>";
            }

        ?>
    </ul>

    <h3>Foros destacados</h3>
    <ul>
        <?php
            require "includes/model/foroModel.php";

            // Obtener la lista de foros destacados
            $forosDestacados = Foro::listaDestacados();
            
            // Mostrar los foros destacados
            if ($forosDestacados != NULL) {
                foreach ($forosDestacados as $foro) {
                    echo "<li>";
                    echo "<h4>" . $foro->getTitulo() . "</h4>";
                    echo "<p>" . $foro->getDescripcion() . "</p>";
                    echo "<p>" . $foro->getLikes() . " <span style='color: red;'>&#10084;&#65039;</span></p>";
                    echo "</li>";
                }
            } else {
                echo "<li>No se encontraron foros destacados.</li>";
            }
            
        ?>
    </ul>
</aside>
