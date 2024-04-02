<?php

class Foro
{
    private $id;
    private $titulo;
    private $descripcion;
    private $fecha;
    private $likes;
    private $destacado;

    public function __construct($id, $titulo, $descripcion, $fecha, $likes, $destacado)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->fecha = $fecha;
        $this->likes = $likes;
        $this->destacado = $destacado;
    }

    public static function listaDestacados() {

        $conn = new mysqli('localhost', 'root', '', 'goallink_1');
        if ($conn->connect_error){
            die("La conexión ha fallado" . $conn->connect_error);
        }

        $result = $conn->query("SELECT * FROM foro WHERE destacado=1");
        if($result && $result->num_rows>0){

            while($array=$result->fetch_assoc()){

                $foro= new Foro($array["id"], $array["titulo"], $array["descripcion"], $array["fecha"], $array["likes"], $array["destacado"]);
                $lista[]=$foro;
            }

            return $lista;
            
            
        }
        return NULL;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
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
