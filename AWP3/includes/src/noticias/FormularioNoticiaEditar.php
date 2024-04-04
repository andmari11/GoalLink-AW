<?php
namespace es\ucm\fdi\aw\noticias;
require("includes/src/ligas/ligasModel.php");

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\ligas\Liga;

class FormularioNoticiaEdit extends Formulario
{
    public function __construct() {
        $app = Aplicacion::getInstance();
        if($app->esAdmin())
            parent::__construct('formRegistro', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/admin.php')]);
        else
            parent::__construct('formRegistro', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);

    }
    

}
    