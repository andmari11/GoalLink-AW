<?php
    define('BD_HOST', 'localhost');
    define('BD_USER', 'root');
    define('BD_PASS', '');
    define('BD_NAME', 'goallink_1');
            // Conexión a la base de datos
            $conn = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME);
            if ($conn->connect_error){
                die("La conexión ha fallado" . $conn->connect_error);
            }

?>
