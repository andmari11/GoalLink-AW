<?php

namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioUsuarioBloquear extends Formulario
{
    public function __construct($usuario, $url) {
        parent::__construct('formUsuarioBloquear', [
            'urlRedireccion' =>$url]);
        $this->usuario=$usuario;
    }
    private $usuario;

    protected function generaCamposFormulario(&$datos)
    {
        $icono = Usuario::consultarBloqueo($this->usuario) ? "Bloqueado 🚫" : "Desbloqueado ✅";
        $camposFormulario = <<<EOS
        
        <input type="hidden" name="id" value="$this->usuario">

            <button class="enlace" type="submit">$icono</button>
        EOS;
        return $camposFormulario;
    }

    /**
     * Procesa los datos del formulario.
     */
    protected function procesaFormulario(&$datos)
    {
        $app = Aplicacion::getInstance();

        $id= htmlspecialchars(trim(strip_tags($datos['id'])));
        if(($app->usuarioLogueado()) && ($app->esAdmin() or $app->esModerador())){


            if(Usuario::bloquearUsuario($id)){

                echo <<<EOS
                <h2>Usuario eliminado: {$id} </h2>
                <b>Volver al <a href="admin.php">panel de administración</a>
                EOS;

                return true;
            }
            else {
        
                echo <<<EOS
                <h2>Usuario no eliminado: {$id} </h2>
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

