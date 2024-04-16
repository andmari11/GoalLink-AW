<aside id="sidebarDer">
    <h3>Noticias destacadas</h3>
    <ul>
        <?php
            use \es\ucm\fdi\aw\noticias\Noticia;

            // Obtener la lista de noticias destacadas
            $noticiasDestacadas = Noticia::listaDestacados(1);

            // Mostrar las noticias destacadas
            if ($noticiasDestacadas != NULL) {
                foreach ($noticiasDestacadas as $noticia) {
                    echo "<li>";
                    echo "<h4 class='titulo-noticia-BarraLateral'><a href='noticiaDinamica.php?id=" . $noticia->getId() . "'>" . $noticia->getTitulo() . "</a></h4>";
                    echo "<p>" . substr($noticia->getContenido(), 0, 25) . "..."."</p>";
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
            use \es\ucm\fdi\aw\foros\Foro;

            // Obtener la lista de foros destacados
            $forosDestacados = Foro::listaDestacados(1);
            
            // Mostrar los foros destacados
            if ($forosDestacados != NULL) {
                foreach ($forosDestacados as $foro) {
                    echo "<li>";
                    echo "<h4 class='titulo-foro-BarraLateral'><a href='foroDinamico.php?id=" . $foro->getId() . "'>" . $foro->getTitulo() . "</a></h4>";
                    echo "<p>" . $foro->getDescripcion() . "</p>";
                    echo "<p>" . $foro->getfavoritos() . " <span style=>&#11088;&#65039;</span>";
                    echo "</li>";
                }
            } else {
                echo "<li>No se encontraron foros destacados.</li>";
            }
            
        ?>
    </ul>
</aside>
