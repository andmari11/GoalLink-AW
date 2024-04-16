<?php
namespace es\ucm\fdi\aw\foros;
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioForo extends Formulario
{
    public function __construct()
    {
        parent::__construct('crear_foro');
    }

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
    
                <label for="fecha">Fecha de subida:</label><br>
                <input type="date" id="fecha" name="fecha" value="{$fecha}"><br><br>
    
                <input type="checkbox" id="destacado" name="destacado" {$destacado}>
                <label for="destacado">Destacado</label><br><br>
    
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
    } else {
       
         Foro::insertarForo($titulo, $descripcion, $fecha , 0, $destacado);
    }

    return $errores;
    }
}
?>