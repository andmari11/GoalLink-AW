<?php
session_start();
$titulo = 'Contenido';
$contenido = '';
if (isset($_SESSION["login"])) {
    $contenido .= <<<EOS
                <h1>Contenido</h1>
                
                <h2>Citroën SM</h2>

                <p>El Citroën SM es un automóvil de lujo y deportivo que fue producido por el fabricante francés Citroën entre 1970 y 1975. Es conocido por su diseño distintivo, su tecnología innovadora y su desempeño deportivo.</p>
                
                <p>Una de las características más destacadas del Citroën SM es su sistema de suspensión hidroneumática, que permitía un viaje suave y cómodo, así como un manejo excepcionalmente ágil. Esta suspensión ajustable también le permitía al conductor variar la altura del vehículo para adaptarse a diferentes condiciones de conducción.</p>
                
                <img src ='images.jpeg'>


                <p>Además de su avanzada suspensión, el SM contaba con una dirección asistida hidráulica, frenos de disco en las cuatro ruedas y neumáticos radiales, todos ellos características de vanguardia en su época.</p>

                

                EOS;
} else {
    $contenido .= <<<EOS
                <h1>Contenido</h1>
                Inicie sesión para visualizar contenido exclusivo: <a href='login.php'>Login</a>
                EOS;
}

require __DIR__.'/includes/Vistas/esqueleto.php';