<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Portada</title>
</head>

<body>

<div id="contenedor"> <!-- Inicio del contenedor -->

    <?php
	    session_start();
        require("cabecera.php");
        echo $cabecera;
        require("sidebarIzq.php");
    ?>

	<main>
        <?php
            echo $titulo . $contenido
        ?>
	</main>


	<?php
		require("sidebarDer.php");
		require("pie.php");
	?>

</div> <!-- Fin del contenedor -->

</body>
</html>