<?php
function mostrarSaludo()
{
    if (isset($_SESSION["login"])) {
        echo "<p>Bienvenido " . $_SESSION["nombre"] . "<a href = \"logout.php\">(Logout)</a></p>";
    } else {
        echo "<p>Usuario desconocido. <a href='login.php'>Login</a></p>";
    }
}
?>

<header>
    <h1><img src="img/logo.png" alt="logo" width="50" height="50">oalLink</h1>
    <div class="saludo">
        <?php
        mostrarSaludo();
        ?>
    </div>
</header>
