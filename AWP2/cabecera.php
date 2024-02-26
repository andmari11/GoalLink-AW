<?php
    function saludar(){
        if(isset($_SESSION["login"])){
            return "Bienvenido " . $_SESSION["nombre"] . " <a href='logout.php'> Logout</a>";
        }
        else{
            return "Inicie sesión " . "<a href='login.php'>aquí</a>";
        }
    }

    $saludo = saludar();

    $cabecera = <<<EOS
    <header>
        <h1><img src="img/logo.png" alt="logo" width="50" height="50">oalLink</h1>
        <div class="saludo">
            $saludo
        </div>
    </header>
   EOS;
