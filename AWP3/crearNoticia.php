<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Noticia</title>
</head>
<body>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $titulo = $_POST["titulo"];
        $id_autor = $_POST["id_autor"];
        $contenido = $_POST["contenido"];
        $fecha = $_POST["fecha"];
        $destacado = isset($_POST["destacado"]) ? 1 : 0;

        if(isset($_FILES["imagen1"]) && $_FILES["imagen1"]["error"] == 0) {
            $imagen1= addslashes(file_get_contents($_FILES['imagen1']['tmp_name']));
        } else {
            $imagen1 = null;
        }

        $conn = new mysqli('localhost', 'root', '', 'goallink_1');

        if ($conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $conn->connect_error);
        }

        // Preparar la consulta SQL con parámetros seguros
        $stmt = $conn->query("INSERT INTO noticia (titulo, id_autor, contenido, fecha, destacado, imagen1) VALUES ('$titulo', '$id_autor', '$contenido', '$fecha', '$destacado', '$imagen1')");


        // Ejecutar la consulta
        if ($stmt) {
            echo "Noticia creada exitosamente.";
        } else {
            echo "Error al crear la noticia: " . $conn->error;
        }

        $conn->close();
    }
?>


    <h2>Crear Noticia</h2>
    <form action="crearNoticia.php" method="POST" enctype="multipart/form-data">
        <label for="titulo">Título:</label><br>
        <input type="text" id="titulo" name="titulo" required><br><br>
        
        <input type="hidden" id="id_autor" name="id_autor" value="1">
        
        <label for="contenido">Contenido:</label><br>
        <textarea id="contenido" name="contenido" rows="4" cols="50"></textarea><br><br>

        <label for="fecha">Fecha:</label><br>
        <input type="date" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>"><br><br>
        
        <label for="imagen1">Imagen:</label><br>
        <input type="file" id="imagen1" name="imagen1"><br><br>
        
        <input type="checkbox" id="destacado" name="destacado" value="1">
        <label for="destacado">Destacado</label><br><br>
        
        <input type="submit" value="Crear Noticia">
    </form>
</body>
</html>
