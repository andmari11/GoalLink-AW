<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;

class FormularioRegistro extends FormularioUsuarioNuevo
{

    public function __construct() {
        parent::__construct();
    }
    
   protected function accionSecundaria($usuario){
        $app = Aplicacion::getInstance();
        $app->login($usuario);
    }


}