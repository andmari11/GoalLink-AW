<?php
namespace es\ucm\fdi\aw\usuarios;
require("includes/src/ligas/ligasModel.php");

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;
use es\ucm\fdi\aw\ligas\Liga;

class FormularioUsuarioEdit extends Formulario
{
    public function __construct() {
        $app = Aplicacion::getInstance();
        if($app->esAdmin())
            parent::__construct('formRegistro', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/admin.php')]);
        else
            parent::__construct('formRegistro', ['urlRedireccion' => Aplicacion::getInstance()->resuelve('/index.php')]);

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
        $username= htmlspecialchars(trim(strip_tags($_REQUEST["usuario"])));

        $usuario=Usuario::buscaUsuario($username);
        $nombre=$usuario->getNombre();
        $email=$usuario->getEmail(); 
        $ligas=self::obtenerOpcionesLigas();

        if($nombre!='admin'){
            // Se generan los mensajes de error si existen.
            $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
            $erroresCampos = self::generaErroresCampos(['nombreUsuario', 'email', 'password', 'password2'], $this->errores, 'span', array('class' => 'error'));

            $html = <<<EOF
            $htmlErroresGlobales
            <h2>Editar usuario</h2>
            <form action="procesareditUsuarios.php" method="post"> 
                <fieldset class="formulario">
                    <legend>Editar datos:</legend>
                    <div>
                    <label>Nombre:</label><input type="text" name="nombre" value="{$nombre}" required> 
                    {$erroresCampos['nombreUsuario']}
                    </div>
                    <div>
                    <label>Email:</label><input type="text" name="email" value="{$email}" required> 
                    {$erroresCampos['email']}
                    </div>
            EOF;
            if( Aplicacion::getInstance()->esAdmin()){
                $html.=<<<EOF
                        <div>
                        <label>Rol:</label> 
                        <select name="rol">
                            <option value="e">Editor</option>
                            <option value="m">Moderador</option>
                            <option value="u">Usuario</option>
                            {$erroresCampos['rol']}
                        </select>
                        </div>
                EOF;
            }
            $html.=<<<EOF
                    <div>
                    <label for="password">Password:</label>
                    <input id="password" type="password" name="password" />
                    {$erroresCampos['password']}
                    </div>
                    <div>
                    <label for="password2">Reintroduce el password:</label>
                    <input id="password2" type="password" name="password2" />
                    {$erroresCampos['password2']}
                    </div>
                    <div>
                    <label>Elija su liga favorita:</label>
                    <select name="liga">
                    {$ligas}
                    {$erroresCampos['liga']}
                    </select>
                </div>
                    <button type="submit">Siguiente</button>
                    <input type="hidden" name="nombreAntiguo" value="{$username}">
                </fieldset>
            </form>
            </div>
            EOF;
        }
        else{

            $html = "<h2>No es posible editar admin</h2>";
        }
        return $html;

    }

    protected function procesaFormulario(&$datos){

        $nombreAntiguo=htmlspecialchars(trim(strip_tags($_REQUEST["nombreAntiguo"])));
        $usernameNuevo= htmlspecialchars(trim(strip_tags($_REQUEST["nombre"])));
        $email= htmlspecialchars(trim(strip_tags($_REQUEST["email"])));
        $rol = ($_REQUEST["rol"]);
        $ligas= $_REQUEST["liga"];


        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        $password2 = trim($datos['password2'] ?? '');
        $password2 = filter_var($password2, FILTER_SANITIZE_FULL_SPECIAL_CHARS);



        $contenido="";
        
        if(count($this->errores) === 0 && Usuario::actualizaUsuario($usernameNuevo, $email, $rol, $nombreAntiguo, $ligas, $password)) {

            $contenido = <<<EOS
            <h2>Usuario editado {$usernameNuevo} </h2>
            <p>Vuelta al panel de  <a href='admin.php'>administración</a></p>
            EOS;
            
        
        }else{
            
            $contenido = <<<EOS
                <h2>Error</h2>
                <p>No ha sido posible editar la información del usuario. <a href='admin.php'>Inténtalo de nuevo</a></p>
            EOS;
    
    
        }

        return $contenido;
    }

}
    