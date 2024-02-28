<?php

class Usuario
{

    private $nombre;
    private $email;
    private $password;
    private $rol;

    private function __construct($nombre, $email, $password, $rol)
    {
        $this->nombre = $nombre;
        $this->password = $password;
        $this->rol = $rol;
        $this->email=$email;
    }

    public static function login($nombre, $pass)
    {
        $user = self::buscaUsuario($nombre);

        if ($user!=NULL && $user->checkPassword($pass)) {
            return true;
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
        else{
            die("La conexión ha fallado" . $conn->connect_error);
            return -1;
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
        return $user->password==$pass;
    }
}

?>