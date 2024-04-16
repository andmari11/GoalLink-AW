<?php

namespace es\ucm\fdi\aw\foros;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioForoFavorito extends Formulario
{
    private $foro;

    public function __construct($foro, $url) {
        $this->foro=$foro;
        parent::__construct('formLike', [
            'urlRedireccion' => ($url)]);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $favoritos= $this->foro->getfavoritos() . " ⭐";
        $camposFormulario = <<<EOS
            <button class="enlace" type="submit">{$favoritos}</button>
        EOS;
        return $camposFormulario;
    }

    /**
     * Procesa los datos del formulario.
     */
    protected function procesaFormulario(&$datos)
    {
        $app = Aplicacion::getInstance();
        $app->getUsuarioID();
        return $this->foro->setFavorito($app->getUsuarioID());
        
    }
}