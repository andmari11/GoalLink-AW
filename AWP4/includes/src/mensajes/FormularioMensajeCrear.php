<?php
namespace es\ucm\fdi\aw\mensajes;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\mensajes\Mensaje;


class FormularioMensajeCrear extends Formulario {

    private $id_foro;

    public function __construct($id_foro) {
        parent::__construct('formMensajeCrear', ['urlRedireccion' => $_SERVER['REQUEST_URI'], 'method'=>'POST', 'enctype'=>'multipart/form-data']);
        $this->id_foro=$id_foro;
    }

    protected function generaCamposFormulario(&$datos)
    {
        $app = Aplicacion::getInstance();

        if ($app->usuarioLogueado()) {
            $usuarioId=$app->getUsuarioID();
            
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['texto', 'imagen'], $this->errores, 'span', array('class' => 'error'));
    
            $html = <<<EOS
            $htmlErroresGlobales
            <div class="formulario">
                <input type="hidden" id="id_autor" name="id_autor" value="{$usuarioId}">
                <input type="hidden" id="id_foro" name="id_foro" value="{$this->id_foro}">
                <label for="contenido">Contenido:</label><br>
                <textarea id="contenido" name="contenido" rows="4" cols="50"></textarea><br><br>       
                <input type="submit" value="Enviar">

            </div>
            EOS;
        }
        else{

            $html = <<<EOS

            ACESSO DENEGADO
            EOS;

        }
        return $html;
    }
    

    protected function procesaFormulario(&$datos)
    {
        $foro_id = $datos['id_foro'];
        $usuario_id = $datos['id_autor'];
        $text = $datos['contenido'];


        if (count($this->errores) === 0) {

            Mensaje::insertarMensaje($foro_id, $usuario_id, $text, date('Y-m-d'), date('H:i:s', time()), 0);

        }

    }
}
