<?php
namespace es\ucm\fdi\aw\foros;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioForoEliminar extends Formulario
{
    private $foroId;

    public function __construct($foroId) {
        parent::__construct('formForoEliminar', [
            'urlRedireccion' => Aplicacion::getInstance()->resuelve('/admin.php')
        ]);
        $this->foroId = $foroId;
    }

    protected function generaCamposFormulario(&$datos)
    {
        $camposFormulario = <<<EOS
        <input type="hidden" name="foro_id" value="$this->foroId">
        <button class="enlace" type="submit"> 🗑️</button>
        EOS;
        return $camposFormulario;
    }

    protected function procesaFormulario(&$datos)
    {
        $app = Aplicacion::getInstance();

        if ($app->usuarioLogueado() && ($app->esAdmin() || $app->esModerador())) {
            $foroId = htmlspecialchars(trim(strip_tags($datos["foro_id"])));

            if (Foro::eliminarForo($foroId)) {
                echo <<<EOS
                <h2>Foro eliminado: {$foroId}</h2>
                <b>Volver al <a href="admin.php">panel de administración</a></b>
                EOS;
                return true;
            } else {
                echo <<<EOS
                <h2>Error: Foro no eliminado</h2>
                <b>Volver al <a href="admin.php">panel de administración</a></b>
                EOS;
            }
        } else {
            echo <<<EOS
            <h2>Acceso denegado</h2>
            EOS;
        }
    }
}
?>