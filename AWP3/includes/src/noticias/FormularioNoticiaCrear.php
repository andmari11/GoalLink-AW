<?php
namespace es\ucm\fdi\aw\noticias;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\ligas\Liga;
require("includes/src/ligas/ligasModel.php");
require "includes/src/noticias/noticiaModel.php";

class FormularioNoticiaCrear extends Formulario {

    public function __construct() {
        parent::__construct('formNoticiaCrear', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/admin.php')]);
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
    protected function generaCamposFormulario(&$datos)
    {
        $app = Aplicacion::getInstance();

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
        if($app->esAdmin()){
            $fecha=$datos['fecha'] ?? date('Y-m-d');
            $usuarioId=$app->getUsuarioID();
            $ligas=self::obtenerOpcionesLigas();

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
                <div>
                <label>Elija la liga relacionada:</label>
                <select name="liga">
                {$ligas}
                </select>
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
        $id_autor = 1; 
        $fecha = $datos['fecha'];
        $destacado = isset($datos["destacado"]) ? 1 : 0;
        $ligas= $_REQUEST['liga'];
        $imagen1 = null;


        if(isset($_FILES["imagen1"]) && $_FILES["imagen1"]["error"] == 0) {
            $imagen1= addslashes(file_get_contents($_FILES['imagen1']['tmp_name']));
        } 

        // Insertar la noticia utilizando el modelo de Noticia
        Noticia::insertarNoticia($titulo, $contenido, $id_autor, $fecha, $imagen1, $destacado, $ligas);
    }
}
?>