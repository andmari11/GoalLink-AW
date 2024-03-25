<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;

class Usuario
{

    private $id;
    private $nombre;
    private $email;
    private $password;
    private $rol;

    public function __construct($nombre, $email, $password, $rol, $id=null)
    {
        $this->id=$id;
        $this->nombre = $nombre;
        $this->password = $password;
        $this->rol = $rol;
        $this->email=$email;
    }

    public static function login($nombre, $pass)
    {
        $user = self::buscaUsuario($nombre);
        if ($user!= NULL && $user->checkPassword($pass)) {
            return $user;
        }
        
        return false;
    }

    public static function buscaUsuario($nombre){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();

        $result = $conn->query("SELECT * FROM usuario WHERE usuario.nombre='$nombre'");
        if($result){

            if($result->num_rows>0){
                $array=$result->fetch_assoc();
                $user= new Usuario( $array['nombre'], $array['email'],$array['password'],$array['rol']);
                return $user;
            }
            else{
                
                return NULL;
            }
        }

    }

    public static function insertaUsuario($usuario){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();

        if(Usuario::buscaUsuario($usuario->nombre) == NULL){
            $query=sprintf("INSERT INTO `usuario` (`nombre`, `email`, `password`, `rol`) VALUES('%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->email)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->rol));
            
            if (!$conn->query($query)) {
                echo "Error: " . $query . "<br>" . $conn->error;
            }
            return true;
        }else{
            return false;
        }
    }

    public static function actualizaUsuario($username, $email, $rol, $nombreAntiguo){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();

        $nombreAntiguo = $conn->real_escape_string($nombreAntiguo);
        $username = $conn->real_escape_string($username);
        $email = $conn->real_escape_string($email);
        $rol = $conn->real_escape_string($rol);
        
        $query = "UPDATE `usuario` SET nombre='$username', email='$email', rol='$rol' WHERE nombre='$nombreAntiguo'";
        
        if (!$conn->query($query) || $conn->affected_rows != 1) {
            die("No se ha producido ningún cambio " . $conn->error. $nombreAntiguo);
        }
        return true;
    }

    public static function eliminarUsuario($nombre){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();

        $query = sprintf("DELETE FROM `usuario` WHERE `nombre` = '%s'", $conn->real_escape_string($nombre));

        $usuario=Usuario::buscaUsuario($nombre);
        if(!$usuario || $usuario->getRol()=="a"){
            return false;
        }

        if(!$conn->query($query) or $conn->affected_rows != 1){
            die("Usuario no eliminado ". $nombre . $conn->connect_error);
        }

        return true;
    }

    public static function listaUsuario() {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();

        $result = $conn->query("SELECT * FROM usuario");
        if($result){
            if($result->num_rows>0){
                while($array=$result->fetch_assoc()){
                    $user= new Usuario($array['nombre'], $array['email'],$array['password'],$array['rol']);
                    $lista[]=$user;
                }
                return $lista;
            }
            else{
                return NULL;
            }
        }
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function checkPassword($password)
    {
        return ($password==$this->password);
    }
}
