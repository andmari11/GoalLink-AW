<?php

namespace es\ucm\fdi\aw\ligas;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioLigaEliminar extends Formulario
{
    private $liga;
    public function __construct($liga) {
        parent::__construct('formligaEliminar', [
            'urlRedireccion' => Aplicacion::getInstance()->resuelve('/admin.php')]);
        $this->liga=$liga;
    }

    protected function generaCamposFormulario(&$datos)
    {
        $camposFormulario = <<<EOS
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
        die($this->liga);

        if(($app->usuarioLogueado()) && ($app->esAdmin() or $app->esEditor())){

            if(!Liga::delete($this->liga)){
                die("liga no valida" . $this->liga);
            }
        
        }
        else{
        
                
            echo <<<EOS
            <h2>Acceso denegado </h2>
            EOS;
        
        }
    }
}

