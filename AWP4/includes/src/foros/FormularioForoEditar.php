<?php
namespace es\ucm\fdi\aw\foros;
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioForoEditar extends Formulario
{
    private $id;
    public function __construct()
    {
        $this->id=$_REQUEST["foro"];
        parent::__construct('formForoEditar', ['urlRedireccion' => "foroDinamico.php?id= $this->id", 'method'=>'POST', 'enctype'=>'multipart/form-data']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $app = Aplicacion::getInstance();

        if($app->esAdmin() or $app->esModerador()){
            // Obtener información del foro
            $foro = Foro::getForoById($this->id);

            if (!$foro) {
                return "Foro no encontrado.";
            }

            $titulo = $foro->getTitulo();
            $descripcion = $foro->getDescripcion();
            $destacado = $foro->getDestacado() ? 'checked' : '';

            // Generar campos de formulario prellenados con la información actual
            $html = <<<EOS
            <div class="formulario">
                <label for="titulo">Título:</label><br>
                <input type="text" id="titulo" name="titulo" value="{$titulo}" required><br><br>
    
                <label for="descripcion">Descripción:</label><br>
                <textarea id="descripcion" name="descripcion" rows="4" cols="50">{$descripcion}</textarea><br><br>
    
                <input type="checkbox" id="destacado" name="destacado" {$destacado}>
                <label for="destacado">Destacado</label><br><br>
    
                <input type="hidden" name="id" value="$this->id">
                <input type="submit" value="Guardar Cambios">
            </div>
            EOS;
        }
        else{
            $html = <<<EOS
            ACCESO DENEGADO
            EOS;
        }
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $errores = [];

        // Obtener datos del formulario
        $idForo = $datos['id'] ?? null;
        $titulo = $datos['titulo'] ?? null;
        $descripcion = $datos['descripcion'] ?? null;
        $destacado = isset($datos["destacado"]) ? 1 : 0;

        // Validar los datos del formulario
        if (empty($titulo) || empty($descripcion) || empty($idForo)) {
            $errores[] = 'Por favor, completa todos los campos.';
        } else {
            // Actualizar el foro en la base de datos
            $result = Foro::updateForo($idForo, $titulo, $descripcion, $destacado);

            if (!$result) {
                $errores[] = 'Error al actualizar el foro.';
            }
        }

        return $errores;
    }
}