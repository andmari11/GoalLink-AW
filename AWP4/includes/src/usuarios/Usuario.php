<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;

class Usuario
{

    private $id;
    private $nombre;
    private $email;
    private $password_hash;
    private $rol;
    private $liga_fav;
    private $imagen;

    public function __construct($nombre, $email, $password, $rol, $liga_fav,  $imagen=null, $id=null)
    {
        $this->id=$id;
        $this->nombre = $nombre;
        $this->email=$email;
        $this->rol = $rol;
        $this->liga_fav=$liga_fav;
        $this->imagen=$imagen;
        // Almacena la contraseña como un hash
        $this->password_hash=$password;
    }

    public static function login($nombre, $pass){
        $user = self::buscaUsuario($nombre);
        if ($user && $user->compruebaPassword($pass)) {
            return $user;
        }
        
        return false;
    }

    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function compruebaPassword($password)
    {
        return password_verify($password, $this->password_hash);
    }
    
    public static function buscaUsuario($nombre){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();

        $result = $conn->query("SELECT * FROM usuario WHERE usuario.nombre='$nombre'");
        if($result){

            if($result->num_rows>0){
                $array=$result->fetch_assoc();
                $user= new Usuario($array['nombre'], $array['email'], ($array['password']), $array['rol'], $array['liga_fav'], $array['imagen'],$array['id']);
                return $user;
            }
            else{
                return NULL;
            }
        }

    }

    public static function insertaUsuario($usuario, $imagen) {

        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $ruta_destino="";

        if (Usuario::buscaUsuario($usuario->nombre) == NULL) {
            if($imagen!=null){
                $ruta_destino = "img/usuarios/" . basename($imagen["name"]);
                if(!move_uploaded_file($imagen["tmp_name"], $ruta_destino)){
                    die(error_get_last()['message']);
                }
            }

            $query = sprintf("INSERT INTO `usuario` (`nombre`, `email`, `password`, `rol`, `liga_fav`, `imagen`) VALUES('%s', '%s', '%s', '%s', '%s', '%s')",
                $conn->real_escape_string($usuario->nombre),
                $conn->real_escape_string($usuario->email),
                $conn->real_escape_string(self::hashPassword($usuario->password_hash)), // Utiliza el hash almacenado
                $conn->real_escape_string($usuario->rol),
                $conn->real_escape_string($usuario->liga_fav),
                ($ruta_destino));
    
            if (!$conn->query($query)) {
                die("Error: " . $query . "<br>" . $conn->error);
            }
    
            return true;
        } else {
            return false;
        }
    }
    

    public static function actualizaUsuario($username, $email, $rol, $nombreAntiguo, $ligas, $password){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();

        $nombreAntiguo = $conn->real_escape_string($nombreAntiguo);
        $username = $conn->real_escape_string($username);
        $email = $conn->real_escape_string($email);
        $rol = $conn->real_escape_string($rol);
        $ligas = $conn->real_escape_string($ligas);
        $password=$conn->real_escape_string($password);
        
        // Si se proporciona una nueva contraseña, hasheala
        if($password != "") {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE `usuario` SET nombre='$username', email='$email', rol='$rol', liga_fav='$ligas', password='$password_hash' WHERE nombre='$nombreAntiguo'";
        } else {
            $query = "UPDATE `usuario` SET nombre='$username', email='$email', rol='$rol', liga_fav='$ligas' WHERE nombre='$nombreAntiguo'";
        }
        
        if (!$conn->query($query) || $conn->affected_rows != 1) {
            return false;
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
                    $user= new Usuario($array['nombre'], $array['email'],($array['password']),$array['rol'], $array['liga_fav'],$array['imagen'],$array['id']);
                    $lista[]=$user;
                }
                return $lista;
            }
            else{
                return NULL;
            }
        }
    }

    public static function getLigaDeUsuarioId($id) {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        $result = $conn->query("SELECT liga_fav FROM usuario WHERE usuario.id='$id'");
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $liga_fav = $row['liga_fav'];
            $result->free();
            return $liga_fav;
        } else {
            return null;
        }
    }

    public static function getNombreAutor($idautor)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $conn->connect_error);
        }

        $result = $conn->query("SELECT nombre FROM usuario WHERE id = '$idautor'");

        if ($result->num_rows > 0) {
            // Si hay resultados, devolvemos el logo de la liga
            $row = $result->fetch_assoc();
            return $row['nombre'];
        } else {
            // Si no hay resultados, devolvemos null o algún valor por defecto
            return null;
        }
    }
    

    public function getId()
    {
        return $this->id;
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

    public function getLigaFav(){
        
        return $this->liga_fav;
    }

    public function getImagen(){

        return $this->imagen;
    }
}