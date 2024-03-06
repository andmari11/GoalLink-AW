<?php
    require "includes/model/usuarioModel.php";
    session_start();
    
    $nombreAntiguo=htmlspecialchars(trim(strip_tags($_REQUEST["nombreAntiguo"])));
    $username= htmlspecialchars(trim(strip_tags($_REQUEST["usuario"])));
    $email= htmlspecialchars(trim(strip_tags($_REQUEST["email"])));
    $rol = ($_REQUEST["rol"]);

    $titulo = 'ProcesarEdit';
    
    
    if(($_SESSION["rol"])=='a'){


        if(Usuario::actualizaUsuario($username, $email, $password, $rol, $nombreAntiguo)) {

            $contenido = <<<EOS
            <h1>Usuario editado {$username} </h1>
            <p>Vuelta al panel de  <a href='admin.php'>administración</a></p>
            EOS;
            
        
        }else{
            
            $contenido = <<<EOS
                <h1>Error</h1>
                <p>No ha sido posible editar la información del usuario. <a href='admin.php'>Inténtalo de nuevo</a></p>
            EOS;
    
    
        }
    }
    else{

        $contenido = <<<EOS
        <h1>Error</h1>
        <p>Acceso denegado.</p>
        EOS;
    }
    
    


    require __DIR__.'/includes/Vistas/esqueleto.php';

