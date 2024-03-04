<?php
    require "usuario.php";

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
        
        if(($_SESSION["rol"])=='a'){
            $barraIzq = <<<EOS
            <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="contenido.php">Ver contenido</a></li>
            <li><a href="contenido.php">Foro</a></li>
            <li><a href="admin.php">Administrar</a></li>
            </ul>
            
            EOS;
        }else {
            $barraIzq = <<<EOS
            <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="contenido.php">Ver contenido</a></li>
            <li><a href="admin.php">Foro</a></li>
            </ul>
            EOS;
        }
        
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

?>