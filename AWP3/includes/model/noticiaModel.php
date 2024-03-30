<?php

class Noticia
{
    private $id;
    private $id_autor;
    private $titulo;
    private $contenido;
    private $fecha;
    private $likes;
    private $destacado;
    public $imagen1;


    public function __construct($id, $id_autor, $titulo, $contenido, $fecha, $likes, $destacado, $imagen1=NULL)
    {
        $this->id = $id;
        $this->id_autor = $id_autor;
        $this->titulo = $titulo;
        $this->contenido = $contenido;
        $this->fecha = $fecha;
        $this->likes = $likes;
        $this->destacado = $destacado;
        $this->imagen1=$imagen1;
    }

    public static function listaDestacados() {

        $conn = new mysqli('localhost', 'root', '', 'goallink_1');
        if ($conn->connect_error){
            die("La conexión ha fallado" . $conn->connect_error);
        }

        $result = $conn->query("SELECT * FROM noticia WHERE destacado=1");
        if($result && $result->num_rows>0){

            while($array=$result->fetch_assoc()){

                $noticia= new Noticia($array["id"], $array["id_autor"], $array["titulo"], $array["contenido"], $array["fecha"], $array["likes"], $array["destacado"], $array["imagen1"]);
                $lista[]=$noticia;
            }
            $conn->close();

            return $lista;
            
            
        }
        $conn->close();
        return NULL;
    }

    public static function getNoticiaById($id) {
        $conn = new mysqli('localhost', 'root', '', 'goallink_1');
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
            $noticia = new Noticia($array["id"], $array["id_autor"], $array["titulo"], $array["contenido"], $array["fecha"], $array["likes"], $array["destacado"], $array["imagen1"]);
            $conn->close();
            return $noticia;
        } else {
            $conn->close();
            return NULL;
        }
    }

    public static function InsertarNoticia($titulo, $contenido, $id_autor, $fecha, $imagen1 ,$destacado){
        $conn = new mysqli('localhost', 'root', '', 'goallink_1');
        
        if ($conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $conn->connect_error);
        }

        $titulo = $conn->real_escape_string($titulo);
        $contenido = $conn->real_escape_string($contenido);
        $id_autor = $conn->real_escape_string($id_autor);
        $fecha = $conn->real_escape_string($fecha);
        $destacado = $destacado ? 1 : 0; // Convertir a valor entero

        $sql = "INSERT INTO noticia (titulo, id_autor, contenido, fecha, destacado, imagen1) 
                VALUES ('$titulo', '$id_autor', '$contenido', '$fecha', '$destacado', ?)";
        
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("b", $imagen1);

        if ($stmt->execute()) {
            echo "Noticia creada exitosamente.";
        } else {
            echo "Error al crear la noticia: " . $conn->error;
        }

        $conn->close();
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

    public function getDestacado()
    {
        return $this->destacado;
    }
}


