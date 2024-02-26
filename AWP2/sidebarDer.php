<aside id="sidebarDer">
	<h3>Foros destacados</h3>

	<?php
    <ul>

	//conexion	
	$conn = new mysqli("localhost", "usuario", "contraseña", "basededatos");
	if ($conn->connect_error){
		die("La conexión ha fallado" . $conn->connect_error);
	}

	//cargar en result
	$result = $conn->query("SELECT id, titulo, descripcion, likes FROM foro");

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			echo "<li>";
			echo "<h4>" . $row["titulo"] . "</h4>";
			echo "<p>" . $row["descripcion"] . "</p>";
			echo "<p>" . $row["likes"] . " ❤️</p>";
			echo "</li>";
		}
		$result->free();
	} 
	else {
		echo "No se encontraron foros.";
	}

	$conn->close();
	</ul>

	?>
</aside>

