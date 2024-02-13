<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Login</title>
</head>

<body>

<div id="contenedor"> <!-- Inicio del contenedor -->

	<?php
        session_start();
        require("cabecera.php");
        require("sidebarIzq.php");
    ?>

	<main>
	  <article>
		<h1>Log in</h1>
        <form action="procesarLogin.php" method="post">
            <fieldset>
                <legend>Introduzca sus datos </legend>
                <label>Usuario:</label><input type="text" name="usuario"> 
                <label>Contraseña:</label><input type="password" name="contraseña"> 
                <button type="submit">Siguiente</button>
            </fieldset>
	  </article>
	</main>



	<?php
		require("sidebarDer.php");
		require("pie.php");
	?>

</div> <!-- Fin del contenedor -->

</body>
</html>