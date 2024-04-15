<?php
namespace es\ucm\fdi\aw\foros;
use es\ucm\fdi\aw\Aplicacion;

class Foro
{
    private $id;
    private $titulo;
    private $descripcion;
    private $fecha;
    private $favoritos;
    private $destacado;

    public function __construct($id, $titulo, $descripcion, $fecha, $favoritos, $destacado)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->fecha = $fecha;
        $this->favoritos = $favoritos;
        $this->destacado = $destacado;
    }

    public static function getForoById($id) {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("La conexión ha fallado" . $conn->connect_error);
        }
    
        $stmt = $conn->prepare("SELECT * FROM foro WHERE id = ?");
        $stmt->bind_param("i", $id); 

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $array = $result->fetch_assoc();
            $foro = new Foro($array["id"], $array["titulo"], $array["descripcion"], $array["fecha"], $array["favoritos"], $array["destacado"]);
            return $foro;
        } else {

            return NULL;
        }
    }
    

    public static function listaDestacados($n) {

        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("La conexión ha fallado" . $conn->connect_error);
        }


        $result = $conn->query("SELECT * FROM foro WHERE destacado>=$n");
        if($result && $result->num_rows>0){

            while($array=$result->fetch_assoc()){

                $foro= new Foro($array["id"], $array["titulo"], $array["descripcion"], $array["fecha"], $array["favoritos"], $array["destacado"]);
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

    public function getfavoritos()
    {
        return $this->favoritos;
    }

    public function getDestacado()
    {
        return $this->destacado;
    }
}
