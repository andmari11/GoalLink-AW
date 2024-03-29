<?php

namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioUsuarioEliminar extends Formulario
{
    public function __construct() {
        parent::__construct('formUsuarioEliminar', [
            'urlRedireccion' => Aplicacion::getInstance()->resuelve('/admin.php')]);
    }

    /**
     * Procesa los datos del formulario.
     */
    protected function procesaFormulario(&$datos)
    {
        $app = Aplicacion::getInstance();

        $username= htmlspecialchars(trim(strip_tags($_REQUEST["usuario"])));
        if(($app->usuarioLogueado()) && ($app->esAdmin())){


            if(Usuario::eliminarUsuario($username)){

                $contenido = <<<EOS
                <h2>Usuario eliminado: {$username} </h2>
                <b>Volver al <a href="admin.php">panel de administración</a>
                EOS;

                return true;
            }
            else {
        
                $contenido = <<<EOS
                <h2>Usuario no eliminado: {$username} </h2>
                <b>Volver al <a href="admin.php">panel de administración</a></b>
                EOS;
            }
        
        }
        else{
        
                
            $contenido = <<<EOS
            <h2>Acceso denegado </h2>
            EOS;
        
        }
    }
}

