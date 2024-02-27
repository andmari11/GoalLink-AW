<?php
    
    session_start();
    $username= htmlspecialchars(trim(strip_tags($_REQUEST["usuario"])));
    $password= htmlspecialchars(trim(strip_tags($_REQUEST["contraseña"])));

    if($username == "user" && $password == "userpass"){

        $_SESSION["login"]=true;
        $_SESSION["nombre"]="Usuario";
    }
    else if ($username == "admin" && $password == "adminpass"){
        
        $_SESSION["login"]=true;
        $_SESSION["nombre"]="Administrador";
        $_SESSION["esAdmin"]=true;
    }

    $titulo = 'ProcesarLogin';


    if(isset($_SESSION["login"])){
        $contenido = <<<EOS
        <h1>Bienvenido {$_SESSION['nombre']} </h1>
        <p>Descubre contenido exclusivo <a href='contenido.php'>aquí.</a></p>
        EOS;
    }
    else{
        $contenido = <<<EOS
        <h1>ERROR</h1>
        <p>Usuario y/o contraseña invalidos, <a href='login.php'>inténtelo de nuevo</a></p>
        EOS;
    }

    require __DIR__.'/includes/Vistas/esqueleto.php';

