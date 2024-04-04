<?php
namespace es\ucm\fdi\aw\noticias;
require("includes/src/ligas/ligasModel.php");
require "includes/src/noticias/noticiaModel.php";

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\ligas\Liga;

class FormularioNoticiaEditar extends Formulario
{
    public function __construct() {
        parent::__construct('formNoticiaEditar', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/admin.php'), 'method'=>'POST', 'enctype'=>'multipart/form-data']);

    }
    function obtenerOpcionesLigas() {
        $opciones = '';
        $ligas = Liga::listaLigas();

        if ($ligas) {
            foreach ($ligas as $liga) {
                $opciones .= "<option value='" . $liga->getNombre() . "'>" . $liga->getNombre() . "</option>";
            }
        }
        return $opciones;
    }
    protected function generaCamposFormulario(&$datos){
        $id= htmlspecialchars(trim(strip_tags($_REQUEST["noticia"])));
        $noticia=Noticia::getNoticiaById($id);
        if(!$noticia) {
            return "<p>La noticia no existe.</p>";
        }
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['titulo', 'contenido', 'imagen', 'liga'], $this->errores, 'span', array('class' => 'error'));

        $ligas=self::obtenerOpcionesLigas();
        $titulo = htmlspecialchars($noticia->getTitulo());
        $contenido = htmlspecialchars($noticia->getContenido());

        $html="";

        $html .= <<<EOF
        <h2>Editar Noticia</h2>
        <form action="procesarEditNoticia.php" method="post"> 
            <fieldset class="formulario">
                <legend>Editar datos:</legend>
                <div>
                    <label>Título:</label>
                    <input type="text" name="titulo" value="$titulo" required>
                </div>
                <div>
                    <label>Contenido:</label>
                    <textarea name="contenido" rows="4" cols="50" required>$contenido</textarea>
                </div>
                <label for="imagen1">Imagen:</label><br>
                <input type="file" id="imagen1" name="imagen1"><br><br>
                <div>
                    <label>Elija la liga relacionada:</label>
                    <select name="liga">
                    {$ligas}
                    </select>
                </div>
                <label >Destacado</label>
                <input type="checkbox" id="destacado" name="destacado" value="1">
                <button type="submit">Guardar Cambios</button>
                <input type="hidden" name="id_noticia" value="$id">
            </fieldset>
        </form>
    EOF;
        return $html;
    }
    protected function procesaFormulario(&$datos){
        $id=$datos['id_noticia'];
        $titulo = $datos['titulo'] ?? null;
        $contenido = $datos['contenido'] ?? null;
        $destacado = isset($datos["destacado"]) ? 1 : 0;
        $ligas= $_REQUEST['liga'];
        $imagen1 = null;

        if(isset($_FILES["imagen1"]) && $_FILES["imagen1"]["error"] == 0) {
            $imagen1= addslashes(file_get_contents($_FILES['imagen1']['tmp_name']));
        }
        Noticia::updateNoticia($id, $titulo, $contenido, $imagen1, $destacado, $ligas);


    }
}
    