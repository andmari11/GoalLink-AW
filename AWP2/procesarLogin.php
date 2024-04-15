<?php
    require "includes/model/usuarioModel.php";

    session_start();
    $username= htmlspecialchars(trim(strip_tags($_REQUEST["usuario"])));
    $password= htmlspecialchars(trim(strip_tags($_REQUEST["contraseña"])));
    $titulo = 'ProcesarLogin';
    

    $usuario=Usuario::login($username, $password);

   
    
    if($usuario){

        $_SESSION["login"]=true;
        $_SESSION["nombre"]=$usuario->getNombre();
        $_SESSION["email"]=$usuario->getEmail();
        $_SESSION["rol"]=$usuario->getRol();
    }

    if(isset($_SESSION["login"])){
        
        
        $contenido = <<<EOS
        <h2>Bienvenido {$_SESSION['nombre']} </h2>
        <p>Descubre contenido exclusivo <a href='noticiasContenido.php'>aquí.</a></p>
        EOS;
    }
    else{
        $contenido = <<<EOS
        <h2>ERROR</h2>
        <p>Usuario y/o contraseña invalidos, <a href='login.php'>inténtelo de nuevo</a></p>
        EOS;

        
    }

    require __DIR__.'/includes/Vistas/esqueleto.php';

