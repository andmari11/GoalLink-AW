<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioNoticia extends Formulario {
    protected function generaCamposFormulario(&$datos)
    {
        $html = <<<EOS
        <label for="titulo">Título:</label><br>
        <input type="text" id="titulo" name="titulo" required value="{$datos['titulo'] ? $datos['titulo'] : ''}"><br><br>
        
        <input type="hidden" id="id_autor" name="id_autor" value="1"><br><br>
        
        <label for="contenido">Contenido:</label><br>
        <textarea id="contenido" name="contenido" rows="4" cols="50">{$datos['contenido'] ? $datos['contenido'] : ''}</textarea><br><br>
        
        <label for="fecha">Fecha:</label><br>
        <input type="date" id="fecha" name="fecha" value="{$datos['fecha'] ? $datos['fecha'] : date('Y-m-d')}"><br><br>
        
        <label for="imagen1">Imagen:</label><br>
        <input type="file" id="imagen1" name="imagen1"><br><br>
        
        <input type="checkbox" id="destacado" name="destacado" value="1">
        <label for="destacado">Destacado</label><br><br>
        EOS;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $titulo = $datos['titulo'] ?? null;
        $contenido = $datos['contenido'] ?? null;
        $id_autor = 1; // Considerando que el ID del autor es siempre 1 por ahora
        $fecha = $datos['fecha'] ?? date('Y-m-d');
        $imagen1 = isset($_FILES["imagen1"]) && $_FILES["imagen1"]["error"] == 0 ? addslashes(file_get_contents($_FILES['imagen1']['tmp_name'])) : null;
        $destacado = isset($datos["destacado"]) ? 1 : 0;

        // Insertar la noticia utilizando el modelo de Noticia
        NoticiaModel::InsertarNoticia($titulo, $contenido, $id_autor, $fecha, $imagen1, $destacado);
    }
}
?>