<?php

class Noticia
{
    private $id;
    private $autor;
    private $titulo;
    private $contenido;
    private $fecha;
    private $likes;
    private $destacado;

    public function __construct($id, $autor, $titulo, $contenido, $fecha, $likes, $destacado)
    {
        $this->id = $id;
        $this->autor = $autor;
        $this->titulo = $titulo;
        $this->contenido = $contenido;
        $this->fecha = $fecha;
        $this->likes = $likes;
        $this->destacado = $destacado;
    }

    public static function listaDestacados() {

        $conn = new mysqli('localhost', 'root', '', 'goallink_1');
        if ($conn->connect_error){
            die("La conexión ha fallado" . $conn->connect_error);
        }

        $result = $conn->query("SELECT * FROM noticia WHERE destacado=1");
        if($result && $result->num_rows>0){

            while($array=$result->fetch_assoc()){

                $noticia= new Noticia($array["id"], $array["autor"], $array["titulo"], $array["contenido"], $array["fecha"], $array["likes"], $array["destacado"]);
                $lista[]=$noticia;
            }
            $conn->close();

            return $lista;
            
            
        }
        $conn->close();
        return NULL;
    }

    public function getId()
    {
        return $this->id;
    }


    public function getAutor()
    {
        return $this->autor;
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
        return $this->id;
    }

    public function getDestacado()
    {
        return $this->destacado;
    }
}


