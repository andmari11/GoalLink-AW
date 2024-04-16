<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\ligas\Liga;

class FormularioUsuarioNuevo extends Formulario
{
    public function __construct() {
        parent::__construct('formRegistro', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php'),'method'=>'POST', 'enctype'=>'multipart/form-data']);
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
        $nombreUsuario = $datos['nombreUsuario'] ?? '';
        $nombre = $datos['nombre'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreUsuario', 'nombre', 'email', 'password', 'password2', 'liga'], $this->errores, 'span', array('class' => 'error'));
        $ligas=self::obtenerOpcionesLigas();
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset class="formulario">
            <legend>Datos para el registro</legend>
            <div>
                <label for="nombreUsuario">Nombre de usuario:</label>
                <input id="nombreUsuario" type="text" name="nombreUsuario" value="$nombreUsuario">
                {$erroresCampos['nombreUsuario']}
            </div>
            <div>
                <label for="nombre">Nombre:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre">
                {$erroresCampos['nombre']}
            </div>
            <div>
            <label for="email">Email:</label>
            <input id="email" type="text" name="email">
            {$erroresCampos['email']}
            </div>
            <div>
                <label for="password">Password:</label>
                <input id="password" type="password" name="password">
                {$erroresCampos['password']}
            </div>
            <div>
                <label for="password2">Reintroduce el password:</label>
                <input id="password2" type="password" name="password2">
                {$erroresCampos['password2']}
            </div>
            <div>
                <label for="imagen">Imagen:</label><br>
                <input type="file" id="imagen" name="imagen" required><br><br>
                {$erroresCampos['file']}
            </div>
            <div>
                <label>Elija su liga favorita:</label>
                <select name="liga" required>
                {$ligas}
                {$erroresCampos['liga']}
                </select>
            </div>
            <div>
                <button type="submit" name="registro">Registrar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }
    protected function accionSecundaria($usuario){


    }


    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
        $nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $nombreUsuario || mb_strlen($nombreUsuario) < 5) {
            $this->errores['nombreUsuario'] = 'El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.';
        }

        $email = trim($datos['email'] ?? '');
        $email = filter_var($email, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $email) {
            $this->errores['nombre'] = 'El Email no puede estar vacio.';
        }

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password || mb_strlen($password) < 5 ) {
            $this->errores['password'] = 'El password tiene que tener una longitud de al menos 5 caracteres.';
        }

        $password2 = trim($datos['password2'] ?? '');
        $password2 = filter_var($password2, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( ! $password2 || $password != $password2 ) {
            $this->errores['password2'] = 'Los passwords deben coincidir';
        }

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
            $usuario = Usuario::buscaUsuario($nombreUsuario);
	
            if ($usuario) {
                $this->errores[] = "El usuario ya existe";
            } else {
                $usuario = new Usuario($nombreUsuario, $email, $password, 'u', 'LaLiga');
                if (Usuario::insertaUsuario($usuario, $imagen)) {
                    $this->accionSecundaria($usuario);
                } else {
                    $this->errores[] = "Error al insertar el usuario";
                }
            }
        }
    }
}