
<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" type="text/css" href="./CSS/Style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?= $titulo ?></title>
</head>

<body> <!-- No tiene sidebarDer -->

<div id="contenedor"> <!-- Inicio del contenedor -->

	<?php
	 
		require_once("mysql/conexion.php");
        require("includes/comun/cabecera.php");
        require("includes/comun/sidebarIzq.php");
    ?>

	<main>
        <article>
		     <?= $contenido ?>
	    </article>
	</main>



	<?php
		
        require("includes/comun/pie.php");
	?>

</div> <!-- Fin del contenedor -->

</body>
</html>