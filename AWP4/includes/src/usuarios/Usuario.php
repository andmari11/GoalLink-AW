<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
define("PIMIENTA", 'goallink');

class Usuario
{

    private $id;
    private $nombre;
    private $email;
    private $password_hash;
    private $rol;
    private $liga_fav;
    private $imagen;
    private $ruta_imagen;
    private $salt;



    public function __construct($nombre, $email, $password, $rol, $liga_fav, $imagen=null, $id=null, $salt=null)
    {
        $this->id=$id;
        $this->nombre = $nombre;
        $this->email=$email;
        $this->rol = $rol;
        $this->liga_fav=$liga_fav;
        $this->ruta_imagen=$imagen;

        if ($imagen == null) {
            $imagen="img/usuarios/default.png";
        }

        if(file_exists($imagen)){

            $this->imagen = file_get_contents($imagen);   
        }     
        $this->password_hash=$password;
        $this->salt=$salt;
    }

    public static function login($nombre, $pass){
        $user = self::buscaUsuarioPorNombre($nombre);
        if ($user && $user->compruebaPassword($pass,$user->salt)) {
            return $user;
        }
        
        return false;
    }

    private static function hashPassword($password,$salt)
    {
        return password_hash($password . $salt . PIMIENTA , PASSWORD_DEFAULT);
    }

    public function compruebaPassword($password, $salt)
    {
        return password_verify($password. $salt. PIMIENTA , $this->password_hash);
    }
    
    public static function buscaUsuarioPorNombre($nombre){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();

        $result = $conn->query("SELECT * FROM usuario WHERE usuario.nombre='$nombre'");
        if($result){

            if($result->num_rows>0){
                $array=$result->fetch_assoc();
                $user= new Usuario($array['nombre'], $array['email'], ($array['password']), $array['rol'], $array['liga_fav'], $array['imagen'],$array['id'],$array['salt'] );
                return $user;
            }
            else{
                return NULL;
            }
        }

    }
    public static function buscaUsuarioPorId($id){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
    
        $result = $conn->query("SELECT * FROM usuario WHERE usuario.id='$id'");
        if($result){
    
            if($result->num_rows>0){
                $array=$result->fetch_assoc();
                $user= new Usuario($array['nombre'], $array['email'], ($array['password']), $array['rol'], $array['liga_fav'], $array['imagen'],$array['id'],$array['salt']);
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

        if (Usuario::buscaUsuarioPorNombre($usuario->nombre) == NULL) {
            $salt=rand();
            if($imagen!=null){
                $ruta_destino = "img/usuarios/" . basename($imagen["name"]);
                if(!move_uploaded_file($imagen["tmp_name"], $ruta_destino)){
                    die(error_get_last()['message']);
                }

                $query = sprintf("INSERT INTO `usuario` (`nombre`, `email`, `password`, `rol`, `liga_fav`, `imagen`, `salt`) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%n')",
                $conn->real_escape_string($usuario->nombre),
                $conn->real_escape_string($usuario->email),
                $conn->real_escape_string(self::hashPassword($usuario->password_hash, $salt)), // Utiliza el hash almacenado
                $conn->real_escape_string($usuario->rol),
                $conn->real_escape_string($usuario->liga_fav),
                ($ruta_destino),
                $salt);
            }
            else{
                $query = sprintf("INSERT INTO `usuario` (`nombre`, `email`, `password`, `rol`, `liga_fav`, `salt`) VALUES('%s', '%s', '%s', '%s', '%s', '%s')",
                $conn->real_escape_string($usuario->nombre),
                $conn->real_escape_string($usuario->email),
                $conn->real_escape_string(self::hashPassword($usuario->password_hash, $salt)), // Utiliza el hash almacenado
                $conn->real_escape_string($usuario->rol),
                $conn->real_escape_string($usuario->liga_fav),
                $salt);

            }

    
            if (!$conn->query($query)) {
                die("Error: " . $query . "<br>" . $conn->error);
            }

            return true;
        } else {
            return false;
        }
    }
    
    public static function actualizaUsuario($username, $email, $rol, $nombreAntiguo, $ligas, $password, $imagen) {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();

        $nombreAntiguo = $conn->real_escape_string($nombreAntiguo);
        $username = $conn->real_escape_string($username);
        $email = $conn->real_escape_string($email);
        $rol = $conn->real_escape_string($rol);
        $ligas = $conn->real_escape_string($ligas);
        $password = $conn->real_escape_string($password);
        // Si se proporciona una nueva contraseña, hasheala
        if ($password != "") {
            $salt=rand();
            $password_hash = self::hashPassword($password,$salt);
            $query = "UPDATE `usuario` SET nombre='$username', email='$email', rol='$rol', liga_fav='$ligas', password='$password_hash', salt='$salt' WHERE nombre='$nombreAntiguo'";
        } else {
            $query = "UPDATE `usuario` SET nombre='$username', email='$email', rol='$rol', liga_fav='$ligas' WHERE nombre='$nombreAntiguo'";
        }
    
        $conn->query($query);
        // Comprobar si se debe actualizar la imagen
        if ($imagen["tmp_name"] != NULL) {
            // Eliminar la imagen anterior si existe
            $queryDeleteImage = "SELECT imagen FROM usuario WHERE nombre='$nombreAntiguo'";
            $resultDeleteImage = $conn->query($queryDeleteImage);
            if ($resultDeleteImage && $resultDeleteImage->num_rows > 0) {
                $row = $resultDeleteImage->fetch_assoc();
                $rutaImagenAntigua = $row["imagen"];
                if ($rutaImagenAntigua!="img/usuarios/default.png" and file_exists($rutaImagenAntigua)) {
                    unlink($rutaImagenAntigua);
                }
            }
    
            // Mover la nueva imagen y actualizar la ruta en la base de datos
            $ruta_destino = "img/usuarios/" . basename($imagen["name"]);
            if (!move_uploaded_file($imagen["tmp_name"], $ruta_destino)) {
                die(error_get_last()['message']);
            }
            $queryUpdateImage = "UPDATE usuario SET imagen = '$ruta_destino' WHERE nombre='$username'";
            if (!$conn->query($queryUpdateImage) || $conn->affected_rows != 1) {
                return false;
            }
        }
        return true;
    }
    

    public static function eliminarUsuario($nombre){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();

        $query = sprintf("DELETE FROM `usuario` WHERE `nombre` = '%s'", $conn->real_escape_string($nombre));

        $usuario=Usuario::buscaUsuarioPorNombre($nombre);
        if(!$usuario || $usuario->getRol()=="a"){
            return false;
        }

        if ($usuario->ruta_imagen!="img/usuarios/default.png" and file_exists($usuario->ruta_imagen)) {
            unlink($usuario->ruta_imagen);
        }

        $result=$conn->query($query);
        if(!$result or $conn->affected_rows != 1){
            die("Usuario no eliminado ". $nombre . $conn->connect_error);
        }

        return true;
    }

    public static function getFotoPerfil($id){

        $usuario=self::buscaUsuarioPorId($id);

        if($usuario){

            return $usuario->getImagen();
        }
        return null;

    }

    public static function listaUsuario() {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();

        $result = $conn->query("SELECT * FROM usuario");
        if($result){
            if($result->num_rows>0){
                while($array=$result->fetch_assoc()){
                    $user= new Usuario($array['nombre'], $array['email'],($array['password']),$array['rol'], $array['liga_fav'],$array['imagen'],$array['id'],$array['salt']);
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

    public static function getRolAutor($idautor)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $conn->connect_error);
        }

        $result = $conn->query("SELECT rol FROM usuario WHERE id = '$idautor'");

        if ($result->num_rows > 0) {
            // Si hay resultados, devolvemos el logo de la liga
            $row = $result->fetch_assoc();
            return $row['rol'];
        } else {
            // Si no hay resultados, devolvemos null o algún valor por defecto
            return null;
        }
    }

    public static function bloquearUsuario($id){

        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $conn->connect_error);
        }
        $usuario = self::buscaUsuarioPorId($id);

        if($usuario and $usuario->getRol()!='a' and $usuario->getRol()!='m'){
    
            $consulta_existencia = sprintf("SELECT COUNT(*) AS existe FROM `bloqueados` WHERE `id_usuario` = '%s'",
                $conn->real_escape_string($usuario->id));
            $resultado = $conn->query($consulta_existencia);
            if (!$resultado) {
                die("Error al verificar la existencia del usuario en la lista de bloqueados: " . $conn->error);
            }
            $fila = $resultado->fetch_assoc();
            $existe = $fila['existe'];
    
            if($existe) {
                $query = sprintf("DELETE FROM `bloqueados` WHERE `id_usuario` = '%s'",
                    $conn->real_escape_string($usuario->id));
                if (!$conn->query($query)) {
                    die("Error al desbloquear al usuario: " . $conn->error);
                }
                return true;
            } else {
                $query = sprintf("INSERT INTO `bloqueados` (`id_usuario`) VALUES('%s')",
                    $conn->real_escape_string($usuario->id));
                if (!$conn->query($query)) {
                    die("Error al bloquear al usuario: " . $conn->error);
                }
                return true;
            }

        }
        return false;
    }
    

    public static function consultarBloqueo($id){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $conn->connect_error);
        }
        
        $query = sprintf("SELECT COUNT(*) AS count FROM `bloqueados` WHERE `id_usuario` = '%s'",
            $conn->real_escape_string($id));
        
        $result = $conn->query($query);
        if (!$result) {
            die("Error al consultar el bloqueo: " . $conn->error);
        }
        
        $row = $result->fetch_assoc();
        $count = $row['count'];
        
        return $count > 0;
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
    public function getRutaImagen(){
       
        return $this->ruta_imagen;
    }
}