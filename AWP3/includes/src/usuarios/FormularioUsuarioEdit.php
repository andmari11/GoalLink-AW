<?php
namespace es\ucm\fdi\aw\usuarios;
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularioUsuarioEdit extends Formulario
{
    public function __construct() {
        parent::__construct('formRegistro', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $username= htmlspecialchars(trim(strip_tags($_REQUEST["usuario"])));

        $usuario=Usuario::buscaUsuario($username);
        $nombre=$usuario->getNombre();
        $email=$usuario->getEmail(); 

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreUsuario', 'email', 'rol'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <h2>Editar usuario</h2>
        <form action="procesarEdit.php" method="post"> 
            <fieldset>
                <legend>Editar datos:</legend>
                <div>
                <label>Nombre:</label><input type="text" name="nombre" value="{$nombre}" required> 
                {$erroresCampos['nombreUsuario']}
                </div>
                <div>
                <label>Email:</label><input type="text" name="email" value="{$email}" required> 
                {$erroresCampos['email']}
                </div>
                <div>
                <label>Rol:</label> 
                <select name="rol">
                    <option value="e">Editor</option>
                    <option value="m">Moderador</option>
                    <option value="b">Usuario</option>
                    {$erroresCampos['rol']}
                </select>
                </div>
                <button type="submit">Siguiente</button>
                <input type="hidden" name="nombreAntiguo" value="{$username}">
            </fieldset>
        </form>
        EOF;
        return $html;

    }

    protected function procesaFormulario(&$datos){


    }

}
    