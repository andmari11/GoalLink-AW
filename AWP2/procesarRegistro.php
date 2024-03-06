<?php
    require "includes/model/usuarioModel.php";
    session_start();

    $username= htmlspecialchars(trim(strip_tags($_REQUEST["usuario"])));
    $email= htmlspecialchars(trim(strip_tags($_REQUEST["email"])));
    $password= htmlspecialchars(trim(strip_tags($_REQUEST["contraseña"])));
    $password_repetida= htmlspecialchars(trim(strip_tags($_REQUEST["contraseña2"])));
    $rol = 'u';

    $titulo = 'ProcesarRegistro';
    
    

    if($password != $password_repetida){

        $contenido = <<<EOS
        <h2>Error</h2>
        <p>Las contraseñas no coinciden. <a href='registro.php'>Inténtalo de nuevo</a></p>
    EOS;
    
    
    }else{

        if(Usuario::insertaUsuario(new Usuario($username, $email, $password, $rol))) {

            $usuario = Usuario::buscaUsuario($username);
            
            if($usuario){
                $_SESSION["login"]=true;
                $_SESSION["nombre"]=$usuario->getNombre();
                $_SESSION["email"]=$usuario->getEmail();
                $_SESSION["rol"]=$usuario->getRol();
        
                $contenido = <<<EOS
                <h2>Registrado {$_SESSION['nombre']} </h2>
                <p>Descubre contenido exclusivo <a href='contenido.php'>aquí.</a></p>
                EOS;
            }
        
        }else{
            
            $contenido = <<<EOS
                <h2>Error</h2>
                <p>El nombre de usuario ya existe. <a href='registro.php'>Inténtalo de nuevo</a></p>
            EOS;
    
    
        }
    }
    
    


    require __DIR__.'/includes/Vistas/esqueleto.php';

