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
    private $ruta_imagen1;
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
        $this->ruta_imagen1=$imagen1;

        if ($imagen1 !== NULL) {
            $this->imagen1 = file_get_contents($imagen1);
            if ($this->imagen1 === FALSE) {
                die("Error al leer el archivo de imagen.". $imagen1);
            }
        }            
        $this->liga=$liga;
    }
    public static function compararFechas($a, $b) {
        $aFecha=strtotime($a->getFecha());
        $bFecha=strtotime($b->getFecha());

        if ($bFecha==$aFecha) {
            return 0;
        }
        return ($aFecha > $bFecha) ? -1 : 1;
    }
    public static function listaDestacados($n) {

        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error){
            die("La conexión ha fallado" . $conn->connect_error);
        }

        $result = $conn->query("SELECT * FROM noticia WHERE destacado>=$n");
        if($result && $result->num_rows>0){

            while($array=$result->fetch_assoc()){

                $noticia= new Noticia($array["id"], $array["id_autor"], $array["titulo"], $array["contenido"], $array["fecha"], $array["likes"], $array["destacado"], $array["liga"],$array["imagen1"] );
                $lista[]=$noticia;
            }

            usort($lista, array('es\ucm\fdi\aw\noticias\Noticia', 'compararFechas'));
            
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

            usort($lista, array('es\ucm\fdi\aw\noticias\Noticia', 'compararFechas'));
            
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

        $ruta_destino = "img/noticias/" . basename($imagen1["name"]);

        if(!move_uploaded_file($imagen1["tmp_name"], $ruta_destino)){
            die(error_get_last()['message']);
        }

        $titulo = $conn->real_escape_string($titulo);
        $contenido = $conn->real_escape_string($contenido);
        $id_autor = $conn->real_escape_string($id_autor);
        $fecha = $conn->real_escape_string($fecha);
        $destacado = $destacado ? 1 : 0; // Convertir a valor entero
        if ($conn->query("INSERT INTO noticia (titulo, id_autor, contenido, fecha, destacado, imagen1, liga) 
                        VALUES ('$titulo', '$id_autor', '$contenido', '$fecha', '$destacado', '$ruta_destino', '$ligas')")) 
        {
            echo "Noticia creada exitosamente.";
        } else {
            echo "Error al crear la noticia: " . $conn->error;
        }

    }



    public static function updateNoticia($id_noticia, $titulo, $contenido, $imagen1, $destacado, $ligas){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();        
        if ($conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $conn->connect_error);
        }

        $titulo = $conn->real_escape_string($titulo);
        $contenido = $conn->real_escape_string($contenido);
        $destacado = $destacado ? 1 : 0; // Convertir a valor entero
        $id_noticia = $conn->real_escape_string($id_noticia);

        $noticia=self::getNoticiaById($id_noticia);

        if($imagen1["tmp_name"]!=NULL){
            if (file_exists($noticia->getRutaImg())) {
                unlink($noticia->getRutaImg());
            }

            $ruta_destino = "img/noticias/" . basename($imagen1["name"]);
            if(!move_uploaded_file($imagen1["tmp_name"], $ruta_destino)){
                die(error_get_last()['message']);
            }
            if ($conn->query("UPDATE noticia 
            SET titulo = '$titulo', 
                contenido = '$contenido', 
                destacado = '$destacado', 
                imagen1 = '$ruta_destino', 
                liga = '$ligas'
            WHERE id = '$id_noticia'")){
                return true;
            }
        }
        else{
            if ($conn->query("UPDATE noticia 
            SET titulo = '$titulo', 
                contenido = '$contenido', 
                destacado = '$destacado', 
                liga = '$ligas'
            WHERE id = '$id_noticia'")){
                return true;
            }
        }
 
        return false;
    }

    public static function eliminarNoticia($id){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();

        $query = sprintf("DELETE FROM `noticia` WHERE `id` = '%s'", $conn->real_escape_string($id));

        $noticia=self::getNoticiaById($id);

        if(!$noticia){
            return false;
        }


        if (file_exists($noticia->ruta_imagen1)) {
            unlink($noticia->ruta_imagen1);
        }

        if(!$conn->query($query) or $conn->affected_rows != 1){
            die("Noticia no eliminado ". $id . $conn->connect_error);
        }

        return true;
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

    public function getLiga()
    {
        return $this->liga;
    }
    public function getRutaImg()
    {
        return $this->ruta_imagen1;
    }



    public function setLike($n){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();        
        if ($conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $conn->connect_error);
        }

        $result = $conn->query("SELECT * FROM likes WHERE usuario_id = {$app->getUsuarioID()} AND noticia_id = $this->id");

        if ($result && $result->num_rows > 0) {
            $this->likes -= $n;
            $conn->query("DELETE FROM likes WHERE usuario_id = {$app->getUsuarioID()} AND noticia_id = $this->id");

        } else {
            $this->likes+=$n;
            $conn->query("INSERT INTO likes (usuario_id, noticia_id) VALUES ({$app->getUsuarioID()}, $this->id)");
        }


        $result=($conn->query("UPDATE noticia SET likes='$this->likes' WHERE id = '$this->id'"));
        return $result;
    }

    public function getDestacado()
    {
        return $this->destacado;
    }

}


