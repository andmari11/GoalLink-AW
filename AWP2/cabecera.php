<header>
        <h1><img src="img/logo.png" alt="logo" width="50" height="50">oalLink</h1>
		<div class="saludo">
        <?php
        saludar();
        ?>
        </div>
</header>


<?php

    function saludar(){

        if(isset($_SESSION["login"])){

            echo "Bienvenido " . $_SESSION["nombre"] . " <a href='logout.php'> Logout</a>";
        }
        else{

            echo "Inicie sesión " . "<a href='login.php'>Login</a>";

        }
    }
?>
