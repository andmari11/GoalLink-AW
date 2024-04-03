<?php
namespace es\ucm\fdi\aw\noticias;
use es\ucm\fdi\aw\Aplicacion;
class Noticia
{
    private $id;
    private $id_autor;
    private $titulo;
    private $contenido;
    private $fecha;
    private $likes;
    private $destacado;
    private $imagen1;
    private $liga;

    public function __construct($id, $id_autor, $titulo, $contenido, $fecha, $likes, $destacado, $liga,  $imagen1=NULL)
    {
        $this->id = $id;
        $this->id_autor = $id_autor;
        $this->titulo = $titulo;
        $this->contenido = $contenido;
        $this->fecha = $fecha;
        $this->likes = $likes;
        $this->destacado = $destacado;
        $this->imagen1=$imagen1;
        $this->liga=$liga;
    }

    public static function listaDestacados() {

        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error){
            die("La conexión ha fallado" . $conn->connect_error);
        }

        $result = $conn->query("SELECT * FROM noticia WHERE destacado=1");
        if($result && $result->num_rows>0){

            while($array=$result->fetch_assoc()){

                $noticia= new Noticia($array["id"], $array["id_autor"], $array["titulo"], $array["contenido"], $array["fecha"], $array["likes"], $array["destacado"], $array["liga"],$array["imagen1"] );
                $lista[]=$noticia;
            }

            return $lista;
            
            
        }
        return NULL;
    }

    public static function listaLigas($ligas) {

        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error){
            die("La conexión ha fallado" . $conn->connect_error);
        }
        $result = $conn->query("SELECT * FROM noticia WHERE liga='$ligas'");
        if($result && $result->num_rows>0){

            while($array=$result->fetch_assoc()){

                $noticia= new Noticia($array["id"], $array["id_autor"], $array["titulo"], $array["contenido"], $array["fecha"], $array["likes"], $array["destacado"], $array["liga"],$array["imagen1"] );
                $lista[]=$noticia;
            }

            return $lista;
            
            
        }
        
        return NULL;
    }


    public static function getNoticiaById($id) {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error){
            die("La conexión ha fallado" . $conn->connect_error);
        }
    
        // Prepara la consulta SQL para evitar inyecciones SQL
        $stmt = $conn->prepare("SELECT * FROM noticia WHERE id = ?");
        $stmt->bind_param("i", $id); // "i" indica que $id es un entero
    
        // Ejecuta la consulta
        $stmt->execute();
    
        // Obtiene los resultados
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $array = $result->fetch_assoc();
            $noticia = new Noticia($array["id"], $array["id_autor"], $array["titulo"], $array["contenido"], $array["fecha"], $array["likes"], $array["destacado"],$array["liga"] ,$array["imagen1"]);
            return $noticia;
        } else {
            return NULL;
        }
    }

    public static function insertarNoticia($titulo, $contenido, $id_autor, $fecha, $imagen1 ,$destacado, $ligas){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();        
        if ($conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $conn->connect_error);
        }

        $titulo = $conn->real_escape_string($titulo);
        $contenido = $conn->real_escape_string($contenido);
        $id_autor = $conn->real_escape_string($id_autor);
        $fecha = $conn->real_escape_string($fecha);
        $destacado = $destacado ? 1 : 0; // Convertir a valor entero
        if ($conn->query("INSERT INTO noticia (titulo, id_autor, contenido, fecha, destacado, imagen1, liga) 
                        VALUES ('$titulo', '$id_autor', '$contenido', '$fecha', '$destacado', '$imagen1', '$ligas')")) 
        {
            echo "Noticia creada exitosamente.";
        } else {
            echo "Error al crear la noticia: " . $conn->error;
        }

    }



    public static function updateNoticia($id_noticia, $titulo, $contenido, $id_autor, $fecha, $imagen1, $destacado, $ligas, $likes){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();        
        if ($conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $conn->connect_error);
        }
        $titulo = $conn->real_escape_string($titulo);
        $contenido = $conn->real_escape_string($contenido);
        $id_autor = $conn->real_escape_string($id_autor);
        $fecha = $conn->real_escape_string($fecha);
        $destacado = $destacado ? 1 : 0; // Convertir a valor entero
        $id_noticia = $conn->real_escape_string($id_noticia);
        
        if ($conn->query("UPDATE noticia 
                          SET titulo = '$titulo', 
                              id_autor = '$id_autor', 
                              contenido = '$contenido', 
                              fecha = '$fecha', 
                              destacado = '$destacado', 
                              imagen1 = '$imagen1', 
                              liga = '$ligas', 
                              likes='$likes'
                          WHERE id = '$id_noticia'")) 
        {
            echo "Noticia actualizada exitosamente.";
        } else {
            echo "Error al actualizar la noticia: " . $conn->error;
        }
    }
    

    public function getId()
    {
        return $this->id;
    }

    public function getImagen1(){

        return $this->imagen1;
    }

    public function getIdAutor()
    {
        return $this->id_autor;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }
    public function getContenido()
    {
        return $this->contenido;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function getLikes()
    {
        return $this->likes;
    }

    public function setLike($n){

        $this->likes+=$n;

        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();        
        if ($conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $conn->connect_error);
        }
        $result=($conn->query("UPDATE noticia SET likes='$this->likes' WHERE id = '$this->id'"));
        return $result;
    }

    public function getDestacado()
    {
        return $this->destacado;
    }
}


