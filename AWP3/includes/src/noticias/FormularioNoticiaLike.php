<?php

namespace es\ucm\fdi\aw\noticias;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioNoticiaLike extends Formulario
{
    private $noticia;

    public function __construct($noticia, $url) {
        $this->noticia=$noticia;
        parent::__construct('formLike', [
            'urlRedireccion' => Aplicacion::getInstance()->resuelve($url)]);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $likes= $this->noticia->getLikes() . " ♥";
        $camposFormulario = <<<EOS
            <button class="enlace" type="submit">{$likes}</button>
        EOS;
        return $camposFormulario;
    }

    /**
     * Procesa los datos del formulario.
     */
    protected function procesaFormulario(&$datos)
    {
        
        return $this->noticia->setLike(1);
        
    }
}