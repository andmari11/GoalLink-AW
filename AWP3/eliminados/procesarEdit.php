<?php
    require "includes/model/usuarioModel.php";
    session_start();
    
    $nombreAntiguo=htmlspecialchars(trim(strip_tags($_REQUEST["nombreAntiguo"])));
    #en un futuro vamos a permitir cambiar el noombre de usuario pero actualemtne al ser pk no es posible
    $usernameNuevo= htmlspecialchars(trim(strip_tags($_REQUEST["nombre"])));
    $email= htmlspecialchars(trim(strip_tags($_REQUEST["email"])));
    $rol = ($_REQUEST["rol"]);

    $titulo = 'ProcesarEdit';
    
    
    if(($_SESSION["rol"])=='a'){


        if(Usuario::actualizaUsuario($usernameNuevo, $email, $rol, $nombreAntiguo)) {

            $contenido = <<<EOS
            <h2>Usuario editado {$usernameNuevo} </h2>
            <p>Vuelta al panel de  <a href='admin.php'>administración</a></p>
            EOS;
            
        
        }else{
            
            $contenido = <<<EOS
                <h2>Error</h2>
                <p>No ha sido posible editar la información del usuario. <a href='admin.php'>Inténtalo de nuevo</a></p>
            EOS;
    
    
        }
    }
    else{

        $contenido = <<<EOS
        <h2>Error</h2>
        <p>Acceso denegado.</p>
        EOS;
    }
    
    


    require __DIR__.'/includes/Vistas/esqueleto.php';

