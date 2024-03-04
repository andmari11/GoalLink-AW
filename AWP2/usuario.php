<?php

class Usuario
{

    private $nombre;
    private $email;
    private $password;
    private $rol;

    public function __construct($nombre, $email, $password, $rol)
    {
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

        $conn = new mysqli('localhost', 'root', '', 'goallink_1');
        if ($conn->connect_error){
            die("La conexión ha fallado" . $conn->connect_error);
        }

        $result = $conn->query("SELECT * FROM usuario WHERE usuario.nombre='$nombre'");
        if($result){

            if($result->num_rows>0){
                $array=$result->fetch_assoc();
                $user= new Usuario($array['nombre'], $array['email'],$array['password'],$array['rol']);
                return $user;
            }
            else{
                
                return NULL;
            }
        }

    }

    public static function insertaUsuario($usuario){

        $conn = new mysqli('localhost', 'root', '', 'goallink_1');
        if ($conn->connect_error){
            die("La conexión ha fallado" . $conn->connect_error);
        }

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

    public static function actualizaUsuario($usuario){

        $conn = new mysqli('localhost', 'root', '', 'goallink_1');
        if ($conn->connect_error){
            die("La conexión ha fallado" . $conn->connect_error);
        }

        $usuario=Usuario::buscaUsuario($nombre);
        if(!$usuario || $usuario->getRol()=="a"){

            return false;
        }
        
        $query=sprintf("UPDATE `usuario` SET nombre='%s', email='%s', password='%s', rol='%s' WHERE usuario.nombre='%s')"
        , $conn->real_escape_string($usuario->nombre)
        , $conn->real_escape_string($usuario->email)
        , $conn->real_escape_string($usuario->password)
        , $conn->real_escape_string($usuario->rol)
        , $conn->real_escape_string($usuario->nombre));

        if(!$conn->query($query) or $conn->affected_rows != 1){

            die("No se ha podido actualizar el usuario: " . $usuario->id . $conn->connect_error);
        }

        return $usuario;
    }

    public static function eliminarUsuario($nombre){

        $conn = new mysqli('localhost', 'root', '', 'goallink_1');
        if ($conn->connect_error){
            die("La conexión ha fallado" . $conn->connect_error);
        }    
        

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

        $conn = new mysqli('localhost', 'root', '', 'goallink_1');
        if ($conn->connect_error){
            die("La conexión ha fallado" . $conn->connect_error);
        }

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

?>