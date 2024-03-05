<?php
function mostrarSaludo()
{
    if(isset($_SESSION["rol"])){
        if($_SESSION["rol"] =='a' || $_SESSION["rol"] =='u' ){
            echo "<p>Bienvenido " . $_SESSION["nombre"] . " " . "<a href ='logout.php'>(Logout)</a></p>";
        }
        else if ($_SESSION["rol"] =='e') {
            echo "<p>Bienvenido " . $_SESSION["nombre"] . " (E) " . "<a href ='logout.php'>(Logout)</a></p>";
        }
        else if ($_SESSION["rol"] =='m'){
            echo "<p>Bienvenido " . $_SESSION["nombre"] . " (M) " . "<a href ='logout.php'>(Logout)</a></p>";
        } 
    } else {
        echo "<p>Usuario desconocido. <a href='login.php'>Login</a></p>";
    }
}
?>

<header>
    
    <div class ="Logo">
        <img src="img/logo.png" alt="logo">
        <h1>GoalLink</h1>
    </div>
    
    <div class="saludo">
        <?php
        mostrarSaludo();
        ?>
    </div>
</header>
