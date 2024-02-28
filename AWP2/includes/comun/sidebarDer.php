<aside id="sidebarDer">
    <h1>Foros destacados</h1>
    <ul>
        <?php
            //include "includes/mysql/conexion.php";
            // Cargar foros
            $result = $conn->query("SELECT titulo, descripcion, likes FROM foro WHERE destacado=1");

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li>";
                    echo "<h4>" . $row["titulo"] . "</h4>";
                    echo "<p>" . $row["descripcion"] . "</p>";
                    echo "<p>" . $row["likes"] . " <span style='color: red;'>&#10084;&#65039;</span></p>";
                    echo "</li>";
                }
                $result->free();
            } else {
                echo "<li>No se encontraron foros.</li>";
            }


            // Cargar noticias
            $result2 = $conn->query("SELECT titulo, autor, likes FROM noticia WHERE destacado=1");
        ?>
    </ul> 
    <h3>Noticias destacadas</h3>   
    <php> 
    <ul>
        <?php
            if ($result2->num_rows > 0) {
                while ($row = $result2->fetch_assoc()) {
                    echo "<li>";
                    echo "<h4>" . $row["titulo"] . "</h4>";
                    echo "<p>" . $row["autor"] . "</p>";
                    echo "<p>" . $row["likes"] . " <span style='color: red;'>&#10084;&#65039;</span></p>";
                    echo "</li>";
                }
                $result2->free();
            } else {
                echo "<li>No se encontraron noticias.</li>";
            }


            // Cerrar conexión
            $conn->close();
        ?>
    </ul>
</aside>
