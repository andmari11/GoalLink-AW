<?php
namespace es\ucm\fdi\aw\ligas;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioLigaCrear extends Formulario {

    public function __construct() {
        parent::__construct('formNoticiaCrear', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/admin.php'), 'method'=>'POST', 'enctype'=>'multipart/form-data']);
    }
    protected function generaCamposFormulario(&$datos)
    {
        $html="";

        $app = Aplicacion::getInstance();
        if($app->esAdmin() or $app->esEditor()){

            $html = <<<EOS
            <div class="formulario">
            
                <label for="titulo">Nombre de la liga:</label><br>
                <input type="text" id="titulo" name="titulo" required><br><br>
                
                <label for="imagen1">Imagen:</label><br>
                <input type="file" id="imagen1" name="imagen1" required><br><br>

                
                <button type="submit" name="crearliga">Crear Liga</button>
            
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
    protected function procesaFormulario(&$datos){

        $titulo = $datos['titulo'] ?? null;
        $imagen1 = null;

        if(isset($_FILES["imagen1"]) && $_FILES["imagen1"]["error"] == 0) {
            $imagen1= ($_FILES['imagen1']);
        } 
        Liga::add($titulo, $imagen1);
    }

}