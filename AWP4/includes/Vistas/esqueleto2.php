<?php
$params['app']->doInclude('/Vistas/helpers/plantilla.php');
$mensajes = mensajesPeticionAnterior();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" type="text/css" href="./CSS/estilo.css">
<link rel="stylesheet" type="text/css" href="./CSS/formularios.css">
<link rel="stylesheet" type="text/css" href="./CSS/noticia.css">
<link rel="stylesheet" type="text/css" href="./CSS/foro.css">
<link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $params['tituloPagina'] ?></title>
</head>

<body>
<?= $mensajes ?>
<div id="contenedor"> <!-- Inicio del contenedor -->

	<?php
	 
	 $params['app']->doInclude('/comun/cabecera.php');
	 $params['app']->doInclude('/comun/sidebarIzq.php');
    ?>

	<main class = "main-esqueleto2">
	  <article>
		<?=  $params['contenidoPrincipal'] ?>
	  </article>
	</main>



	<?php
		$params['app']->doInclude('/comun/pie.php');
	?>

</div> <!-- Fin del contenedor -->

</body>
</html>