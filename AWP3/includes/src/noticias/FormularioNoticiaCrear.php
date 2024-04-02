<?php
namespace es\ucm\fdi\aw\noticias;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\FormularioArchivos;
require "includes/src/noticias/noticiaModel.php";

class FormularioNoticiaCrear extends FormularioArchivos {

    public function __construct() {
        parent::__construct('formNoticiaCrear', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/admin.php')]);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $app = Aplicacion::getInstance();


        if($app->esAdmin()){
            $fecha=$datos['fecha'] ?? date('Y-m-d');
            $usuarioId=$app->getUsuarioID();
            $html = <<<EOS
            <div class="formulario-noticia">
            <form action="crearNoticia.php" method="POST" enctype="multipart/form-data">
                <label for="titulo">Título:</label><br>
                <input type="text" id="titulo" name="titulo" required><br><br>
                
                <input type="hidden" id="id_autor" name="id_autor" value="{$usuarioId}">
                
                <label for="contenido">Contenido:</label><br>
                <textarea id="contenido" name="contenido" rows="4" cols="50"></textarea><br><br>
        
                <label for="fecha">Fecha:</label><br>
                <input type="date" id="fecha" name="fecha" value="{$fecha}"><br><br>
                
                <label for="imagen1">Imagen:</label><br>
                <input type="file" id="imagen1" name="imagen1"><br><br>
                
                <input type="checkbox" id="destacado" name="destacado" value="1">
                <label for="destacado">Destacado</label><br><br>
                
                <input type="submit" value="Crear Noticia">
            </form>
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
    

    protected function procesaFormulario(&$datos, &$archivos)
    {
        $titulo = $datos['titulo'] ?? null;
        $contenido = $datos['contenido'] ?? null;
        $id_autor = $datos['id_autor']; // Considerando que el ID del autor es siempre 1 por ahora
        $fecha = $datos['fecha'];
        $destacado = isset($datos["destacado"]) ? 1 : 0;
        $imagen1 = null;


        if(isset($archivos["imagen1"]) && $archivos["imagen1"]["error"] == 0) {
            die("aaa");
            $imagen1= addslashes(file_get_contents($archivos['imagen1']['tmp_name']));
        } 


        // Insertar la noticia utilizando el modelo de Noticia
        Noticia::insertarNoticia($titulo, $contenido, $id_autor, $fecha, $imagen1, $destacado);
    }
}
?>