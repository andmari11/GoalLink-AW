<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\usuarios\Usuario;


class FormularioRegistro extends FormularioUsuarioNuevo
{

    public function __construct() {
        parent::__construct();
    }
    
   protected function accionSecundaria($usuario){
        $app = Aplicacion::getInstance();
        $usuario=Usuario::buscaUsuarioPorNombre($usuario->getNombre());

        $app->login($usuario);
    }


}