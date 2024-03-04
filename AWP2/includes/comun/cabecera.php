<?php
function mostrarSaludo()
{
    if (isset($_SESSION["login"])) {
        echo "<p>Bienvenido " . $_SESSION["nombre"] . " " . "<a href ='logout.php'>(Logout)</a></p>";
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
