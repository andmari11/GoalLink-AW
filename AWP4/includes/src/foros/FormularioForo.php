<?php
namespace es\ucm\fdi\aw\foros;
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioForo extends Formulario
{
    public function __construct()
    {
        parent::__construct('formForoCrear', [
            'urlRedireccion' => Aplicacion::getInstance()->resuelve('/admin.php'), 'method'=>'POST', 'enctype'=>'multipart/form-data'
        ]);    }

    protected function generaCamposFormulario(&$datos)
    {
        $app = Aplicacion::getInstance();

        if($app->esAdmin() or $app->esModerador()){
            $titulo = $datos['titulo'] ?? '';
            $descripcion = $datos['descripcion'] ?? '';
            $fecha = $datos['fecha'] ?? date('Y-m-d');
            $destacado = isset($datos["destacado"]) ? 'checked' : '';
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['titulo', 'descripcion'], $this->errores, 'span', array('class' => 'error'));
    
            $html = <<<EOS
            $htmlErroresGlobales
            <div class="formulario">
                <label for="titulo">Título:</label><br>
                <input type="text" id="titulo" name="titulo" value="{$titulo}" required><br><br>
    
                <label for="descripcion">Descripción:</label><br>
                <textarea id="descripcion" name="descripcion" rows="4" cols="50">{$descripcion}</textarea><br><br>
                <div>
                <label for="imagen">Imagen:</label><br>
                <input type="file" id="imagen" name="imagen"><br><br>
                </div>    
                <label for="fecha">Fecha de subida:</label><br>
                <input type="date" id="fecha" name="fecha" value="{$fecha}"><br><br>
                <label for="destacado">Destacado</label>
                <input type="checkbox" id="destacado" name="destacado" {$destacado}>
    
                <input type="submit" value="Crear Foro">
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

    $titulo = $datos['titulo'] ?? null;
    $descripcion = $datos['descripcion'] ?? null;
    $fecha = $datos['fecha'] ?? null;
    $destacado = isset($datos["destacado"]) ? 1 : 0;

    if (empty($titulo) || empty($descripcion) || empty($fecha)) {
        $errores[] = 'Por favor, completa todos los campos.';
    } 
    
    $imagen=null;
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
    if (count($this->errores) === 0) {
       
        Foro::insertarForo($titulo, $descripcion, $fecha , 0, $destacado, $imagen);
    }

    return $errores;
    }
}
?>