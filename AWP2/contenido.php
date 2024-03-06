<?php

session_start();
$titulo = 'Contenido';

$contenido = '';
if (isset($_SESSION["login"])) {
    if($_SESSION["rol"] == 'a' || $_SESSION["rol"] == 'e' ){
        $contenido .= <<<EOS
        <h2>Contenido <button type="button">Editar</button></h2>
        EOS;
    }
    else{
        $contenido .= <<<EOS
        <h2>Contenido</h2>

        EOS;
    
    }

    $contenido .= <<<EOS
    <h3>Kane en la cima de Europa</h3>

    <p>El delantero inglés del Bayern, Bota de Oro y máximo goleador de la Bundesliga con 27 tantos, suma seis dianas en la Champions como Kylian y firma ya su tercera mejor temporada realizadora (33)</p>

    <img src ="./img/kane.png" alt = "kane" width = "200" height = "220">

    
    EOS;

} else {
    $contenido .= <<<EOS
                <h2>Contenido</h2>
                Inicie sesión para visualizar contenido exclusivo: <a href='login.php'>Login</a>
                EOS;
}

require __DIR__.'/includes/Vistas/esqueleto.php';