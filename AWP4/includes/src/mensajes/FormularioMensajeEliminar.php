<?php

namespace es\ucm\fdi\aw\mensajes;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioMensajeEliminar extends Formulario
{
    private $mensaje;

    public function __construct($mensaje, $url) {
        $this->mensaje = $mensaje;
        parent::__construct('formMensajeEliminar', ['urlRedireccion' => $url]);
    }
    

    protected function generaCamposFormulario(&$datos)
    {
        $id=$this->mensaje->getId();
        $camposFormulario = <<<EOS
            <input type="hidden" id="mensaje" name="mensaje" value="{$id}">
            <button class="enlace" type="submit">🗑️</button>
        EOS;
        return $camposFormulario;
    }

    /**
     * Procesa los datos del formulario.
     */
    protected function procesaFormulario(&$datos)
    {
        $id_mensaje = $datos['mensaje'];
        return Mensaje::eliminarMensaje($id_mensaje);        
    }
}