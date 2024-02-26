<aside id="sidebarDer">
    <h3>Foros destacados</h3>
    <ul>
        <?php
            // Conexión a la base de datos
            $conn = new mysqli("localhost", "usuario", "contraseña", "basededatos");
            if ($conn->connect_error){
                die("La conexión ha fallado" . $conn->connect_error);
            }

            // Cargar resultados
            $result = $conn->query("SELECT id, titulo, descripcion, likes FROM foro");

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

            // Cerrar conexión
            $conn->close();
        ?>
    </ul>
</aside>
