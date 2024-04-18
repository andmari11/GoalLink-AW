<?php

namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioUsuarioEliminar extends Formulario
{
    public function __construct($usuario) {
        parent::__construct('formUsuarioEliminar', [
            'urlRedireccion' => Aplicacion::getInstance()->resuelve('/admin.php')]);
        $this->usuario=$usuario;
    }
    private $usuario;

    protected function generaCamposFormulario(&$datos)
    {
        $camposFormulario = <<<EOS
        
        <input type="hidden" name="id" value="$this->usuario">

            <button class="enlace" type="submit">🗑️</button>
        EOS;
        return $camposFormulario;
    }

    /**
     * Procesa los datos del formulario.
     */
    protected function procesaFormulario(&$datos)
    {
        $app = Aplicacion::getInstance();

        $username= htmlspecialchars(trim(strip_tags($datos['id'])));
        if(($app->usuarioLogueado()) && ($app->esAdmin())){


            if(Usuario::eliminarUsuario($username)){

                echo <<<EOS
                <h2>Usuario eliminado: {$username} </h2>
                <b>Volver al <a href="admin.php">panel de administración</a>
                EOS;

                return true;
            }
            else {
        
                echo <<<EOS
                <h2>Usuario no eliminado: {$username} </h2>
                <b>Volver al <a href="admin.php">panel de administración</a></b>
                EOS;
            }
        
        }
        else{
        
                
            echo <<<EOS
            <h2>Acceso denegado </h2>
            EOS;
        
        }
    }
}

