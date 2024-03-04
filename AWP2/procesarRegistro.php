<?php
    require "usuario.php";
    session_start();

    $username= htmlspecialchars(trim(strip_tags($_REQUEST["usuario"])));
    $email= htmlspecialchars(trim(strip_tags($_REQUEST["email"])));
    $password= htmlspecialchars(trim(strip_tags($_REQUEST["contraseña"])));
    $password_repetida= htmlspecialchars(trim(strip_tags($_REQUEST["contraseña2"])));
    $rol = 'u';

    $titulo = 'ProcesarLogin';

    if($password != $password_repetida){

        $contenido = <<<EOS
        <h1>Error</h1>
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
                <h1>Registradooooo {$_SESSION['nombre']} </h1>
                <p>Descubre contenido exclusivo <a href='contenido.php'>aquí.</a></p>
                EOS;
            }
        
        }else{
            
            $contenido = <<<EOS
                <h1>Error</h1>
                <p>El nombre de usuario ya existe. <a href='registro.php'>Inténtalo de nuevo</a></p>
            EOS;
    
    
        }
    }
    
    


    require __DIR__.'/includes/Vistas/esqueleto.php';

?>