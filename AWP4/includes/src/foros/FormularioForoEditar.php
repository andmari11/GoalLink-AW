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
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['titulo', 'contenido', 'file', 'descripcion'], $this->errores, 'span', array('class' => 'error'));
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
                <label for="imagen">Imagen:</label><br>
                <input type="file" id="imagen" name="imagen"><br><br>
                {$erroresCampos['file']}
                <label for="destacado">Destacado</label>
                <input type="checkbox" id="destacado" name="destacado" {$destacado}>

                </div>

                <div>
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

        $imagen = null;
        if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
            $imagen = $_FILES['imagen'];
            if ($imagen['size'] > 10485760) {
                $this->errores['file'] = 'El tamaño del archivo excede el límite permitido.';
            }
            $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));
            $extensionesPermitidas = array("jpg", "jpeg", "png", "gif");
            if (!in_array($extension, $extensionesPermitidas)) {
                $this->errores['file'] = 'El archivo debe ser una imagen (JPEG, PNG, GIF).';
            } 
        } 

        if (empty($titulo) || empty($descripcion) || empty($idForo)) {
            $errores[] = 'Por favor, completa todos los campos.';
        } 
        
        if (count($this->errores) === 0) {
            $result = Foro::updateForo($idForo, $titulo, $descripcion, $destacado, $imagen);
        }

        return $result;
    }
}