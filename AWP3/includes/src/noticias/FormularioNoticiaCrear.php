<?php
namespace es\ucm\fdi\aw\noticias;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\ligas\Liga;

class FormularioNoticiaCrear extends Formulario {

    public function __construct() {
        parent::__construct('formNoticiaCrear', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/admin.php'), 'method'=>'POST', 'enctype'=>'multipart/form-data']);
    }
    function obtenerOpcionesLigas() {
        $opciones = '<option value="">Selecciona una liga...</option>';
        $ligas = Liga::listaLigas();

        if ($ligas) {
            foreach ($ligas as $liga) {
                $opciones .= "<option value='" . $liga->getNombre() . "'>" . $liga->getNombre() . "</option>";
            }
        }
        return $opciones;
    }
    protected function generaCamposFormulario(&$datos)
    {
        $app = Aplicacion::getInstance();

        if($app->esAdmin() or $app->esEditor()){
            $fecha=$datos['fecha'] ?? date('Y-m-d');
            $usuarioId=$app->getUsuarioID();
            $ligas=self::obtenerOpcionesLigas();
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['ligas', 'file'], $this->errores, 'span', array('class' => 'error'));
    
            $html = <<<EOS
            <div class="formulario">
            <form action="crearNoticia.php" method="POST">
                <label for="titulo">Título:</label><br>
                <input type="text" id="titulo" name="titulo" required><br><br>
                
                <input type="hidden" id="id_autor" name="id_autor" value="{$usuarioId}">
                
                <label for="contenido">Contenido:</label><br>
                <textarea id="contenido" name="contenido" rows="4" cols="50"></textarea><br><br>
        
                <label for="fecha">Fecha:</label><br>
                <input type="date" id="fecha" name="fecha" value="{$fecha}"><br><br>
                
                <label for="imagen1">Imagen:</label><br>
                <input type="file" id="imagen1" name="imagen1" required><br><br>
                {$erroresCampos['file']}
                <div>
                <label>Elija la liga relacionada:</label>
                <select name="liga" required>
                {$ligas}
                </select>
                {$erroresCampos['ligas']}
                </div>
                <br><br><br>
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
    

    protected function procesaFormulario(&$datos)
    {
        $titulo = $datos['titulo'] ?? null;
        $contenido = $datos['contenido'] ?? null;
        $id_autor = $datos['id_autor']; 
        $fecha = $datos['fecha'];
        $destacado = isset($datos["destacado"]) ? 1 : 0;
        $ligas= $_REQUEST['liga'];
        $imagen1 = null;


        if(isset($_FILES["imagen1"]) && $_FILES["imagen1"]["error"] == 0) {
            $imagen1 = $_FILES["imagen1"];
        } 

        Noticia::insertarNoticia($titulo, $contenido, $id_autor, $fecha, $imagen1, $destacado, $ligas);
    }
}
