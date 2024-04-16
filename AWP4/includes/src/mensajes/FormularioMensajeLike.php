<?php

namespace es\ucm\fdi\aw\mensajes;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioMensajeLike extends Formulario
{
    private $mensaje;

    public function __construct($mensaje, $url) {
        $this->mensaje = $mensaje;
        parent::__construct('formMensajeLike', ['urlRedireccion' => $url]);
    }
    

    protected function generaCamposFormulario(&$datos)
    {
        $likes= $this->mensaje->getLikes() . " ♥";
        $id=$this->mensaje->getId();
        $camposFormulario = <<<EOS
            <input type="hidden" id="mensaje" name="mensaje" value="{$id}">
            <button class="enlace" type="submit">{$likes}</button>
        EOS;
        return $camposFormulario;
    }

    /**
     * Procesa los datos del formulario.
     */
    protected function procesaFormulario(&$datos)
    {

        $id_mensaje = $datos['mensaje'];
        $mensaje=Mensaje::getMensajeById($id_mensaje);
        return $mensaje->setLike(1);
        
    }
}