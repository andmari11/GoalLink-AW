<?php
require_once __DIR__.'/includes/config.php';

	use es\ucm\fdi\aw\usuarios\Usuario;
    
        $nom = Usuario::buscaUsuarioPorNombre($_REQUEST["user"]);

        if($nom == NULL){

            echo 'disponible';
        }
        else{
            echo 'existe';
        }
        
        
?>